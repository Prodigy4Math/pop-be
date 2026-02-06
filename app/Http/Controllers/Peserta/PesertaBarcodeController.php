<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Services\ParticipantBarcodeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PesertaBarcodeController extends Controller
{
    private ParticipantBarcodeService $barcodeService;

    public function __construct(ParticipantBarcodeService $barcodeService)
    {
        $this->barcodeService = $barcodeService;
    }

    public function show()
    {
        $user = auth('peserta')->user();
        $this->barcodeService->assign($user);
        $user->loadMissing('sportInterest');

        return view('peserta.barcode.show', [
            'peserta' => $user,
            'barcodeSvg' => $user->barcode_svg,
        ]);
    }

    public function downloadBarcodePdf()
    {
        $user = auth('peserta')->user();
        $this->barcodeService->assign($user);
        $user->loadMissing('sportInterest');

        if (!$user->barcode_svg) {
            return redirect()
                ->route('peserta.barcode.show')
                ->with('error', 'QR Code belum tersedia. Hubungi admin untuk melengkapi data olahraga.');
        }

        $pdf = Pdf::loadView('admin.peserta.barcode-pdf', [
            'peserta' => $user,
            'barcodeSvg' => $user->barcode_svg,
        ])->setPaper('a4', 'portrait');

        $filename = 'barcode-' . $user->participant_code . '.pdf';

        return $pdf->download($filename);
    }

    public function downloadBarcodeCardPdf()
    {
        $user = auth('peserta')->user();
        $this->barcodeService->assign($user);
        $user->loadMissing('sportInterest');

        if (!$user->barcode_svg) {
            return redirect()
                ->route('peserta.barcode.show')
                ->with('error', 'QR Code belum tersedia. Hubungi admin untuk melengkapi data olahraga.');
        }

        $pdf = Pdf::loadView('admin.peserta.barcode-card-pdf', [
            'peserta' => $user,
            'barcodeSvg' => $user->barcode_svg,
        ])->setPaper([0, 0, 243, 153], 'portrait');

        $filename = 'kartu-' . $user->participant_code . '.pdf';

        return $pdf->download($filename);
    }

    public function requestBarcode(Request $request)
    {
        $user = auth('peserta')->user();

        Notification::create([
            'user_id' => null,
            'title' => 'Permintaan Kartu Peserta',
            'message' => 'Peserta ' . $user->name . ' meminta kartu identitas/barcode.',
            'type' => 'info',
            'category' => 'kartu-request',
            'related_model' => User::class,
            'related_id' => $user->id,
        ]);

        return redirect()
            ->route('peserta.barcode.show')
            ->with('success', 'Permintaan kartu sudah dikirim ke admin.');
    }
}
