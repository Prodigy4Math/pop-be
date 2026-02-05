@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header with Gradient -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 15px;">
                <div class="card-body text-white p-4">
                    <h1 class="fw-bold mb-2">
                        <i class="fas fa-user-circle me-3"></i>Halo, {{ Auth::user()->name }}!
                    </h1>
                    <p class="mb-0 opacity-90">Selamat datang di Platform Penguatan Olahraga dan Ketahanan Psikososial</p>
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
                            <h5 class="mb-0">Jadwal Mendatang</h5>
                            <p class="text-muted mb-0">Anda memiliki 3 kegiatan yang akan datang minggu ini</p>
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
                    <h3 class="fw-bold mb-0">12</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #ffc107; border-radius: 10px;">
                <div class="card-body text-center">
                    <i class="fas fa-star text-warning mb-3" style="font-size: 2rem;"></i>
                    <h6 class="text-muted text-uppercase fw-bold">Total Poin</h6>
                    <h3 class="fw-bold mb-0">245</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #17a2b8; border-radius: 10px;">
                <div class="card-body text-center">
                    <i class="fas fa-heart text-info mb-3" style="font-size: 2rem;"></i>
                    <h6 class="text-muted text-uppercase fw-bold">Tingkat Resiliensi</h6>
                    <h3 class="fw-bold mb-0">78%</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #dc3545; border-radius: 10px;">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check text-danger mb-3" style="font-size: 2rem;"></i>
                    <h6 class="text-muted text-uppercase fw-bold">Kehadiran</h6>
                    <h3 class="fw-bold mb-0">92%</h3>
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
            <a href="javascript:void(0)" class="text-decoration-none">
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
            <a href="javascript:void(0)" class="text-decoration-none">
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
            <a href="javascript:void(0)" class="text-decoration-none">
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
            <a href="javascript:void(0)" class="text-decoration-none">
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
                                <tr>
                                    <td><small>2024-02-15</small></td>
                                    <td>Latihan Badminton</td>
                                    <td><span class="badge bg-success">Hadir</span></td>
                                    <td><small class="text-muted">Performa baik, konsistensi meningkat</small></td>
                                </tr>
                                <tr>
                                    <td><small>2024-02-14</small></td>
                                    <td>Workshop Manajemen Stres</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                    <td><small class="text-muted">Sangat aktif berpartisipasi</small></td>
                                </tr>
                                <tr>
                                    <td><small>2024-02-13</small></td>
                                    <td>Latihan Lari</td>
                                    <td><span class="badge bg-success">Hadir</span></td>
                                    <td><small class="text-muted">Daya tahan meningkat 5%</small></td>
                                </tr>
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
