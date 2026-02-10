@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header with Gradient -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 15px;">
                <div class="card-body text-white p-4">
                    <h1 class="fw-bold mb-2">
                        <i class="fas fa-user-circle me-3"></i>Halo, {{ Auth::guard('peserta')->user()->name }}!
                    </h1>
                    <p class="mb-0 opacity-90">Selamat datang di Platform POP-BE dan Ketahanan Psikososial</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Card -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm border-start border-5" style="border-color: #ffc107;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-alt text-warning me-3" style="font-size: 2rem;"></i>
                        <div>
                            <h5 class="mb-0">Info Terbaru</h5>
                            <p class="text-muted mb-0">Pantau jadwal latihan dan notifikasi terbaru di bawah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #28a745; border-radius: 10px;">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle text-success mb-3" style="font-size: 2rem;"></i>
                    <h6 class="text-muted text-uppercase fw-bold">Aktivitas Selesai</h6>
                    <h3 class="fw-bold mb-0">{{ $presentAttendance ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #ffc107; border-radius: 10px;">
                <div class="card-body text-center">
                    <i class="fas fa-star text-warning mb-3" style="font-size: 2rem;"></i>
                    <h6 class="text-muted text-uppercase fw-bold">Badge Diterima</h6>
                    <h3 class="fw-bold mb-0">{{ $badgeCount ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #17a2b8; border-radius: 10px;">
                <div class="card-body text-center">
                    <i class="fas fa-heart text-info mb-3" style="font-size: 2rem;"></i>
                    <h6 class="text-muted text-uppercase fw-bold">Tingkat Resiliensi</h6>
                    <h3 class="fw-bold mb-0">{{ number_format($averageResilience ?? 0, 1) }}/10</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #dc3545; border-radius: 10px;">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check text-danger mb-3" style="font-size: 2rem;"></i>
                    <h6 class="text-muted text-uppercase fw-bold">Kehadiran</h6>
                    <h3 class="fw-bold mb-0">{{ $attendancePercentage ?? 0 }}%</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Barcode Card -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1"><i class="fas fa-id-card me-2 text-primary"></i>Kartu Peserta</h5>
                        <p class="text-muted mb-0">
                            ID: <code>{{ Auth::guard('peserta')->user()->participant_code ?? '-' }}</code>
                        </p>
                    </div>
                    <a href="{{ route('peserta.barcode.show') }}" class="btn btn-outline-primary mt-3 mt-lg-0">
                        <i class="fas fa-qrcode me-2"></i>Lihat Barcode
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="row">
        <div class="col-lg-12 mb-3">
            <h5 class="fw-bold text-dark">Modul & Fitur</h5>
        </div>

        <!-- Fitness Module -->
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('peserta.fitness.schedules') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 transition-all" style="border-radius: 12px; cursor: pointer; transition: all 0.3s ease;">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-dumbbell" style="font-size: 3rem; color: #28a745;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Modul Kebugaran</h5>
                        <p class="text-muted small mb-0">Catat aktivitas olahraga dan pantau perkembangan fitness Anda</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Psychosocial Module -->
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('peserta.psychosocial.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 transition-all" style="border-radius: 12px; cursor: pointer; transition: all 0.3s ease;">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-brain" style="font-size: 3rem; color: #6f42c1;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Resiliensi Psikososial</h5>
                        <p class="text-muted small mb-0">Ikuti sesi pendampingan untuk meningkatkan ketahanan mental</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Disaster Preparedness -->
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('peserta.disaster.materials') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 transition-all" style="border-radius: 12px; cursor: pointer; transition: all 0.3s ease;">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #fd7e14;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Kesiapsiagaan Bencana</h5>
                        <p class="text-muted small mb-0">Pelajari tindakan mitigasi dan kesiapsiagaan bencana</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Assessment & Feedback -->
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('peserta.progress.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 transition-all" style="border-radius: 12px; cursor: pointer; transition: all 0.3s ease;">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-chart-bar" style="font-size: 3rem; color: #17a2b8;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Asesmen & Feedback</h5>
                        <p class="text-muted small mb-0">Lihat laporan perkembangan dan feedback dari instruktur</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Achievements & Proposals -->
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('peserta.achievements.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 transition-all" style="border-radius: 12px; cursor: pointer; transition: all 0.3s ease;">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-trophy" style="font-size: 3rem; color: #f4a261;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Prestasi/Proposal</h5>
                        <p class="text-muted small mb-0">Kirim prestasi dan proposal kegiatan olahraga</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Equipment Loan -->
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('peserta.loans.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 transition-all" style="border-radius: 12px; cursor: pointer; transition: all 0.3s ease;">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-hand-holding-heart" style="font-size: 3rem; color: #2a9d8f;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Peminjaman Alat</h5>
                        <p class="text-muted small mb-0">Ajukan kebutuhan alat untuk latihan Anda</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Notifications -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-bell me-2 text-muted"></i>Notifikasi Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if(($notifications ?? collect())->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($notifications as $note)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fw-semibold">{{ $note->title }}</div>
                                            <div class="text-muted small">{{ $note->message }}</div>
                                            <div class="text-muted small mt-1">{{ $note->created_at->diffForHumans() }}</div>
                                        </div>
                                        @if($note->category === 'kartu')
                                            <a href="{{ route('peserta.barcode.show') }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-id-card me-1"></i>Buka Kartu
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">Belum ada notifikasi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-history me-2 text-muted"></i>Aktivitas Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Aktivitas</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $activity)
                                    <tr>
                                        <td><small>{{ $activity->created_at->format('d-m-Y') }}</small></td>
                                        <td>{{ $activity->schedule?->sport?->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $activity->status === 'present' ? 'success' : ($activity->status === 'late' ? 'warning' : ($activity->status === 'excused' ? 'info' : 'danger')) }}">
                                                {{ ucfirst($activity->status) }}
                                            </span>
                                        </td>
                                        <td><small class="text-muted">Absensi tercatat</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada aktivitas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-all:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1rem !important;
        }
    }
</style>
@endsection
