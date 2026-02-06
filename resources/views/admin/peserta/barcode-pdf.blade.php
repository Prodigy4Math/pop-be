<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Peserta</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #1f2937;
        }
        .wrap {
            width: 100%;
            text-align: center;
            padding: 40px 24px;
        }
        .card {
            display: inline-block;
            border: 1px solid #e5e7eb;
            padding: 24px;
            border-radius: 12px;
        }
        .title {
            font-size: 18px;
            margin-bottom: 12px;
            font-weight: 700;
        }
        .code {
            font-family: "Courier New", Courier, monospace;
            font-size: 14px;
            margin-bottom: 12px;
            letter-spacing: 1px;
        }
        .label {
            margin-top: 12px;
            font-size: 12px;
            color: #6b7280;
        }
        .meta {
            margin-top: 8px;
            font-size: 12px;
            color: #374151;
        }
        svg {
            width: 200px;
            height: 200px;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="title">{{ $peserta->name }}</div>
            <div class="code">{{ $peserta->participant_code }}</div>
            <div class="meta">Umur: {{ $peserta->age ?? '-' }} tahun &middot; Olahraga: {{ $peserta->sportInterest?->name ?? '-' }}</div>
            <div>{!! $barcodeSvg !!}</div>
            <div class="label">Scan untuk verifikasi kehadiran</div>
        </div>
    </div>
</body>
</html>
