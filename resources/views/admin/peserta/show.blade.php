@extends('layouts.admin')

@section('page-title', 'Detail Peserta')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold text-dark">
                    <i class="fas fa-user me-2 text-primary"></i>Profil Peserta: {{ $peserta->name }}
                </h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.peserta.edit', $peserta) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.peserta.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Info -->
        <div class="col-lg-8">
            <!-- Personal Info -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-user me-2"></i>Informasi Pribadi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <p class="form-control-plaintext">{{ $peserta->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <p class="form-control-plaintext">{{ $peserta->email }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Umur</label>
                            <p class="form-control-plaintext">{{ $peserta->age ?? '-' }} tahun</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Jenis Kelamin</label>
                            <p class="form-control-plaintext">{{ $peserta->gender ?? '-' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <p class="form-control-plaintext">
                                @if($peserta->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Asal Sekolah</label>
                            <p class="form-control-plaintext">{{ $peserta->school ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nomor Telepon</label>
                            <p class="form-control-plaintext">{{ $peserta->phone ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Olahraga Diminati</label>
                            <p class="form-control-plaintext">{{ $peserta->sportInterest?->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">ID Peserta</label>
                            <p class="form-control-plaintext">
                                <code>{{ $peserta->participant_code ?? '-' }}</code>
                            </p>
                        </div>
                    </div>

                    @if($peserta->bio)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Biodata Singkat</label>
                        <p class="form-control-plaintext">{{ $peserta->bio }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Guardian Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-users me-2"></i>Data Wali/Orang Tua
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Wali</label>
                            <p class="form-control-plaintext">{{ $peserta->guardian_name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nomor Telepon Wali</label>
                            <p class="form-control-plaintext">{{ $peserta->guardian_phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Account Info -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-lock me-2"></i>Informasi Akun
                    </h5>
                </div>
                <div class="card-body">
                    <p>
                        <strong>Role:</strong><br>
                        <span class="badge bg-primary">{{ ucfirst($peserta->role) }}</span>
                    </p>
                    <p>
                        <strong>ID Peserta:</strong><br>
                        <code>{{ $peserta->participant_code ?? $peserta->id }}</code>
                    </p>
                </div>
            </div>

            <!-- Barcode -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-qrcode me-2"></i>QR Code Peserta
                    </h5>
                </div>
                <div class="card-body text-center">
                    @if($peserta->barcode_svg)
                        <div class="mb-3" style="display: inline-block; background: #fff; padding: 12px; border-radius: 10px; border: 1px solid #eee;">
                            {!! $peserta->barcode_svg !!}
                        </div>
                        <div class="text-start mb-3">
                            <div class="fw-semibold">{{ $peserta->name }}</div>
                            <div class="text-muted small">
                                Umur: {{ $peserta->age ?? '-' }} tahun · Olahraga: {{ $peserta->sportInterest?->name ?? '-' }}
                            </div>
                            <div class="text-muted small">ID: {{ $peserta->participant_code ?? '-' }}</div>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.peserta.barcode.card', $peserta) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-id-card me-2"></i>Cetak Kartu
                            </a>
                            <form action="{{ route('admin.peserta.barcode.regenerate', $peserta) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-rotate me-2"></i>Regenerate QR
                                </button>
                            </form>
                        </div>
                    @else
                        <p class="text-muted mb-2">QR Code belum tersedia.</p>
                        <form action="{{ route('admin.peserta.barcode.regenerate', $peserta) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-rotate me-2"></i>Regenerate QR
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Activity Info -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-history me-2"></i>Riwayat
                    </h5>
                </div>
                <div class="card-body">
                    <p>
                        <strong>Terdaftar:</strong><br>
                        <small>{{ $peserta->created_at->format('d F Y H:i') }}</small>
                    </p>
                    <p>
                        <strong>Terakhir Diubah:</strong><br>
                        <small>{{ $peserta->updated_at->format('d F Y H:i') }}</small>
                    </p>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistik
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div style="font-size: 2rem; font-weight: bold; color: #667eea;">0</div>
                        <small class="text-muted">Aktivitas Selesai</small>
                    </div>
                    <div class="mb-3">
                        <div style="font-size: 2rem; font-weight: bold; color: #28a745;">0</div>
                        <small class="text-muted">Total Poin</small>
                    </div>
                    <div>
                        <div style="font-size: 2rem; font-weight: bold; color: #17a2b8;">0%</div>
                        <small class="text-muted">Tingkat Kehadiran</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
