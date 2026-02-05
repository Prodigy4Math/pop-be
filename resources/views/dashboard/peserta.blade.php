@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 15px;">
                <div class="card-body text-white p-4">
                    <h1 class="fw-bold mb-2">
                        <i class="fas fa-user-circle me-3"></i>Dashboard Peserta
                    </h1>
                    <p class="mb-0 opacity-90">Pantau progres kebugaran, kesehatan psikososial, dan kesiapsiagaan bencana Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #28a745; border-radius: 10px;">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check text-success mb-3" style="font-size: 2rem;"></i>
                    <h6 class="text-muted text-uppercase fw-bold">Kehadiran</h6>
                    <h3 class="fw-bold mb-0">{{ round(($presentAttendance ?? 0) / max($totalAttendance ?? 1, 1) * 100) }}%</h3>
                    <small class="text-muted">{{ $presentAttendance ?? 0 }} dari {{ $totalAttendance ?? 0 }}</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #17a2b8; border-radius: 10px;">
                <div class="card-body text-center">
                    <i class="fas fa-brain text-info mb-3" style="font-size: 2rem;"></i>
                    <h6 class="text-muted text-uppercase fw-bold">Skor Resiliensi</h6>
                    <h3 class="fw-bold mb-0">{{ $averageResilience ?? 0 }}/10</h3>
                    <small class="text-muted">Rata-rata</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #ffc107; border-radius: 10px;">
                <div class="card-body text-center">
                    <i class="fas fa-award text-warning mb-3" style="font-size: 2rem;"></i>
                    <h6 class="text-muted text-uppercase fw-bold">Badge Diterima</h6>
                    <h3 class="fw-bold mb-0">{{ $badgeCount ?? 0 }}</h3>
                    <small class="text-muted">Penghargaan</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #dc3545; border-radius: 10px;">
                <div class="card-body text-center">
                    <i class="fas fa-fire text-danger mb-3" style="font-size: 2rem;"></i>
                    <h6 class="text-muted text-uppercase fw-bold">Aktivitas Terbaru</h6>
                    <h3 class="fw-bold mb-0">{{ count($recentActivities ?? []) }}</h3>
                    <small class="text-muted">5 hari terakhir</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Section -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <h4 class="fw-bold"><i class="fas fa-th me-2"></i>Fitur Saya</h4>
        </div>

        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow" style="transition: all 0.3s ease;">
                <div class="card-body">
                    <div style="font-size: 2.5rem; color: #28a745; margin-bottom: 15px;">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Profil Saya</h5>
                    <p class="text-muted small mb-3">Lihat dan edit profil pribadi Anda</p>
                    <a href="{{ route('peserta.profile.show') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-arrow-right me-1"></i>Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow" style="transition: all 0.3s ease;">
                <div class="card-body">
                    <div style="font-size: 2.5rem; color: #667eea; margin-bottom: 15px;">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Aktivitas Kebugaran</h5>
                    <p class="text-muted small mb-3">Lihat jadwal dan pantau kehadiran latihan</p>
                    <a href="{{ route('peserta.fitness.schedules') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-right me-1"></i>Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow" style="transition: all 0.3s ease;">
                <div class="card-body">
                    <div style="font-size: 2.5rem; color: #17a2b8; margin-bottom: 15px;">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Psikososial</h5>
                    <p class="text-muted small mb-3">Pelajari manajemen stres dan resiliensi</p>
                    <a href="{{ route('peserta.psychosocial.index') }}" class="btn btn-sm btn-info">
                        <i class="fas fa-arrow-right me-1"></i>Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow" style="transition: all 0.3s ease;">
                <div class="card-body">
                    <div style="font-size: 2.5rem; color: #fd7e14; margin-bottom: 15px;">
                        <i class="fas fa-warning"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Edukasi Bencana</h5>
                    <p class="text-muted small mb-3">Pelajari kesiapsiagaan dan prosedur keselamatan</p>
                    <a href="{{ route('peserta.disaster.materials') }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-arrow-right me-1"></i>Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow" style="transition: all 0.3s ease;">
                <div class="card-body">
                    <div style="font-size: 2.5rem; color: #ffc107; margin-bottom: 15px;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Progres Saya</h5>
                    <p class="text-muted small mb-3">Lihat perkembangan dan catatan aktivitas</p>
                    <a href="{{ route('peserta.progress.index') }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-arrow-right me-1"></i>Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow" style="transition: all 0.3s ease;">
                <div class="card-body">
                    <div style="font-size: 2.5rem; color: #dc3545; margin-bottom: 15px;">
                        <i class="fas fa-award"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Badge Saya</h5>
                    <p class="text-muted small mb-3">Lihat penghargaan yang telah Anda raih</p>
                    <a href="{{ route('peserta.badges.index') }}" class="btn btn-sm btn-danger">
                        <i class="fas fa-arrow-right me-1"></i>Buka
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-5px);
    }
</style>
@endsection
