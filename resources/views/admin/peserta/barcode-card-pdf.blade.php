<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Peserta</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #111827;
        }
        .card {
            width: 100%;
            height: 100%;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }
        .header {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #4b5563;
        }
        .name {
            font-size: 14px;
            font-weight: 700;
            margin-top: 6px;
        }
        .code {
            font-family: "Courier New", Courier, monospace;
            font-size: 11px;
            margin-top: 2px;
            color: #374151;
        }
        .meta {
            font-size: 10px;
            color: #4b5563;
            margin-top: 2px;
        }
        .qr-wrap {
            margin-top: 10px;
            width: 90px;
            height: 90px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 6px;
        }
        .qr-wrap svg {
            width: 78px;
            height: 78px;
        }
        .footer {
            font-size: 9px;
            color: #6b7280;
            margin-top: 6px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">Kartu Peserta</div>
        <div class="name">{{ $peserta->name }}</div>
        <div class="code">{{ $peserta->participant_code }}</div>
        <div class="meta">Umur: {{ $peserta->age ?? '-' }} th · Olahraga: {{ $peserta->sportInterest?->name ?? '-' }}</div>
        <div class="qr-wrap">
            {!! $barcodeSvg !!}
        </div>
        <div class="footer">Scan untuk verifikasi kehadiran</div>
    </div>
</body>
</html>
