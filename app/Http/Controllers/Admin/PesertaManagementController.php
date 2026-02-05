<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class PesertaManagementController extends Controller
{
    public function index()
    {
        $peserta = User::where('role', 'peserta')
            ->with('sportInterest')
            ->paginate(15);
        return view('admin.peserta.index', compact('peserta'));
    }

    public function create()
    {
        $sports = Sport::orderBy('name')->get();
        return view('admin.peserta.create', compact('sports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'age' => 'required|integer|min:5|max:30',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'school' => 'nullable|string',
            'phone' => 'nullable|string',
            'guardian_name' => 'nullable|string',
            'guardian_phone' => 'nullable|string',
            'bio' => 'nullable|string',
            'sport_interest_id' => 'required|exists:sports,id',
        ]);

        $validated['role'] = 'peserta';
        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true;

        $peserta = User::create($validated);
        $this->assignParticipantCodeAndBarcode($peserta);

        return redirect()->route('admin.peserta.index')->with('success', 'Peserta berhasil ditambahkan');
    }

    public function show(User $peserta)
    {
        $peserta->load('sportInterest');
        return view('admin.peserta.show', compact('peserta'));
    }

    public function edit(User $peserta)
    {
        $sports = Sport::orderBy('name')->get();
        return view('admin.peserta.edit', compact('peserta', 'sports'));
    }

    public function update(Request $request, User $peserta)
    {
        $request->merge([
            'age' => $request->input('age') === '' ? null : $request->input('age'),
            'gender' => $request->input('gender') === '' ? null : $request->input('gender'),
            'sport_interest_id' => $request->input('sport_interest_id') === '' ? null : $request->input('sport_interest_id'),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:5|max:30',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'school' => 'nullable|string',
            'phone' => 'nullable|string',
            'guardian_name' => 'nullable|string',
            'guardian_phone' => 'nullable|string',
            'bio' => 'nullable|string',
            'is_active' => 'required|in:0,1',
            'sport_interest_id' => 'nullable|exists:sports,id',
        ]);

        $validated['is_active'] = (bool) $validated['is_active'];
        $peserta->update($validated);
        $this->refreshParticipantCodeAndBarcodeIfNeeded($peserta);

        return redirect()->route('admin.peserta.show', $peserta)->with('success', 'Peserta berhasil diperbarui');
    }

    public function destroy(User $peserta)
    {
        $peserta->delete();
        return redirect()->route('admin.peserta.index')->with('success', 'Peserta berhasil dihapus');
    }

    public function downloadBarcodePdf(User $peserta)
    {
        $this->assignParticipantCodeAndBarcode($peserta);

        $barcodeSvg = $peserta->barcode_svg;

        $pdf = Pdf::loadView('admin.peserta.barcode-pdf', [
            'peserta' => $peserta,
            'barcodeSvg' => $barcodeSvg,
        ])->setPaper('a4', 'portrait');

        $filename = 'barcode-' . $peserta->participant_code . '.pdf';

        return $pdf->download($filename);
    }

    public function downloadBarcodeCardPdf(User $peserta)
    {
        $this->assignParticipantCodeAndBarcode($peserta);

        $barcodeSvg = $peserta->barcode_svg;

        $pdf = Pdf::loadView('admin.peserta.barcode-card-pdf', [
            'peserta' => $peserta,
            'barcodeSvg' => $barcodeSvg,
        ])->setPaper([0, 0, 243, 153], 'portrait');

        $filename = 'kartu-' . $peserta->participant_code . '.pdf';

        return $pdf->download($filename);
    }

    public function regenerateBarcode(User $peserta)
    {
        $this->assignParticipantCodeAndBarcode($peserta);

        return redirect()
            ->route('admin.peserta.show', $peserta)
            ->with('success', 'QR Code berhasil diperbarui.');
    }

    private function assignParticipantCodeAndBarcode(User $peserta): void
    {
        if (!$peserta->sport_interest_id) {
            return;
        }

        $peserta->loadMissing('sportInterest');

        $participantCode = $this->generateParticipantCode($peserta);
        $payload = $this->buildQrPayload($peserta, $participantCode);
        $barcodeSvg = $this->generateBarcodeSvg($payload);

        $peserta->participant_code = $participantCode;
        $peserta->barcode_svg = $barcodeSvg;
        $peserta->save();
    }

    private function refreshParticipantCodeAndBarcodeIfNeeded(User $peserta): void
    {
        if (!$peserta->sport_interest_id) {
            return;
        }

        $peserta->loadMissing('sportInterest');
        $newCode = $this->generateParticipantCode($peserta);
        $payload = $this->buildQrPayload($peserta, $newCode);

        if ($peserta->participant_code !== $newCode || $peserta->wasChanged(['name', 'age', 'sport_interest_id'])) {
            $peserta->participant_code = $newCode;
            $peserta->barcode_svg = $this->generateBarcodeSvg($payload);
            $peserta->save();
        }
    }

    private function generateParticipantCode(User $peserta): string
    {
        $initials = $this->makeInitials($peserta->name, 3);
        $year = now()->format('Y');
        $number = str_pad((string) $peserta->id, 5, '0', STR_PAD_LEFT);
        $sportCode = $this->makeInitials($peserta->sportInterest?->name ?? 'Sport', 4);

        return $initials . '-' . $year . '-' . $number . '-' . $sportCode;
    }

    private function makeInitials(string $value, int $max): string
    {
        $value = trim($value);
        if ($value === '') {
            return 'X';
        }

        $words = preg_split('/\s+/', $value) ?: [];
        $initials = '';
        foreach ($words as $word) {
            if ($word === '') {
                continue;
            }
            $initials .= strtoupper(substr($word, 0, 1));
        }

        $initials = preg_replace('/[^A-Z0-9]/', '', $initials) ?? '';

        if ($initials === '') {
            return 'X';
        }

        return substr($initials, 0, $max);
    }

    private function buildQrPayload(User $peserta, string $participantCode): string
    {
        $name = $this->sanitizePayloadValue($peserta->name);
        $age = $peserta->age !== null ? (string) $peserta->age : '-';
        $sport = $this->sanitizePayloadValue($peserta->sportInterest?->name ?? '-');

        $payload = 'ID=' . $participantCode . ';NAMA=' . $name . ';UMUR=' . $age . ';OLAH=' . $sport;

        return url('/admin/attendance/scan-page') . '?payload=' . rawurlencode($payload);
    }

    private function sanitizePayloadValue(string $value): string
    {
        $value = str_replace([';', "\n", "\r"], [',', ' ', ' '], $value);
        return trim($value);
    }

    private function generateBarcodeSvg(string $payload): string
    {
        return QrCode::format('svg')
            ->size(300)
            ->margin(2)
            ->generate($payload);
    }
}
