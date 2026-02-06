<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Notification;
use App\Services\ParticipantBarcodeService;

class PesertaManagementController extends Controller
{
    private ParticipantBarcodeService $barcodeService;

    public function __construct(ParticipantBarcodeService $barcodeService)
    {
        $this->barcodeService = $barcodeService;
    }

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
            'school' => 'required|string',
            'phone' => 'required|string',
            'guardian_name' => 'required|string',
            'guardian_phone' => 'required|string',
            'bio' => 'nullable|string',
            'sport_interest_id' => 'required|exists:sports,id',
        ]);

        $validated['role'] = 'peserta';
        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true;

        $peserta = User::create($validated);
        $this->barcodeService->assign($peserta);

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
            'school' => 'required|string',
            'phone' => 'required|string',
            'guardian_name' => 'required|string',
            'guardian_phone' => 'required|string',
            'bio' => 'nullable|string',
            'is_active' => 'required|in:0,1',
            'sport_interest_id' => 'required|exists:sports,id',
        ]);

        $validated['is_active'] = (bool) $validated['is_active'];
        $peserta->update($validated);
        $this->barcodeService->refreshIfNeeded($peserta);

        return redirect()->route('admin.peserta.show', $peserta)->with('success', 'Peserta berhasil diperbarui');
    }

    public function destroy(User $peserta)
    {
        $peserta->delete();
        return redirect()->route('admin.peserta.index')->with('success', 'Peserta berhasil dihapus');
    }

    public function downloadBarcodePdf(User $peserta)
    {
        $this->barcodeService->assign($peserta);

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
        $this->barcodeService->assign($peserta);

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
        $this->barcodeService->assign($peserta);

        return redirect()
            ->route('admin.peserta.show', $peserta)
            ->with('success', 'QR Code berhasil diperbarui.');
    }

    public function sendBarcodeToPeserta(User $peserta)
    {
        $this->barcodeService->assign($peserta);

        if (!$peserta->barcode_svg) {
            return redirect()
                ->route('admin.peserta.show', $peserta)
                ->with('error', 'QR Code belum bisa dibuat. Pastikan olahraga peserta sudah diisi.');
        }

        Notification::create([
            'user_id' => $peserta->id,
            'title' => 'Kartu Peserta Siap',
            'message' => 'Admin telah menyiapkan kartu peserta Anda. Silakan buka halaman Kartu Peserta untuk mengunduh barcode dan kartu identitas.',
            'type' => 'success',
            'category' => 'kartu',
            'related_model' => User::class,
            'related_id' => $peserta->id,
        ]);

        return redirect()
            ->route('admin.peserta.show', $peserta)
            ->with('success', 'Kartu peserta berhasil dikirim ke halaman peserta.');
    }
}
