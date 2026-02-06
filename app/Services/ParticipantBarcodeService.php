<?php

namespace App\Services;

use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ParticipantBarcodeService
{
    public function assign(User $peserta): void
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

    public function refreshIfNeeded(User $peserta): void
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
