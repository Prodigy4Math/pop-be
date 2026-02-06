@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1"><i class="fas fa-id-card me-2 text-primary"></i>Kartu Peserta</h3>
                        <p class="text-muted mb-0">Barcode identitas Anda untuk kehadiran dan verifikasi.</p>
                    </div>
                    <div class="d-flex gap-2 mt-3 mt-lg-0">
                        <a href="{{ route('peserta.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <form action="{{ route('peserta.barcode.request') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-paper-plane me-2"></i>Minta Kartu
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    @if($barcodeSvg)
                        <div class="d-flex flex-wrap gap-4 align-items-center">
                            <div style="display: inline-flex; background: #fff; padding: 16px; border-radius: 12px; border: 1px solid #eee;">
                                {!! $barcodeSvg !!}
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">{{ $peserta->name }}</h5>
                                <div class="text-muted">ID Peserta: <code>{{ $peserta->participant_code }}</code></div>
                                <div class="text-muted small mt-1">
                                    Umur: {{ $peserta->age ?? '-' }} tahun &middot; Olahraga: {{ $peserta->sportInterest?->name ?? '-' }}
                                </div>
                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    <a href="{{ route('peserta.barcode.pdf') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-file-pdf me-2"></i>Unduh Barcode PDF
                                    </a>
                                    <a href="{{ route('peserta.barcode.card') }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-id-card me-2"></i>Unduh Kartu PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-qrcode text-muted" style="font-size: 3rem;"></i>
                            <h5 class="mt-3">QR Code belum tersedia</h5>
                            <p class="text-muted mb-3">
                                Lengkapi data olahraga atau hubungi admin untuk pembuatan kartu peserta.
                            </p>
                            <form action="{{ route('peserta.barcode.request') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Permintaan
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2 text-info"></i>Petunjuk</h6>
                </div>
                <div class="card-body">
                    <ul class="small text-muted mb-0">
                        <li>Tunjukkan QR saat absensi kegiatan.</li>
                        <li>Simpan file PDF untuk dicetak kapan saja.</li>
                        <li>Jika data belum lengkap, admin akan menghubungi Anda.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
