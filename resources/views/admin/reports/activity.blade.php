@extends('layouts.admin')

@section('page-title', 'Laporan Aktivitas')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-chart-bar"></i> Laporan Aktivitas</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-primary">{{ $totalActivities }}</h3>
                    <p class="text-muted">Total Aktivitas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-success">{{ $pesertaCount }}</h3>
                    <p class="text-muted">Total Peserta</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-info">{{ round($totalActivities / max($pesertaCount, 1), 2) }}</h3>
                    <p class="text-muted">Rata-rata/Peserta</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-warning">{{ $topSports->count() }}</h3>
                    <p class="text-muted">Top Olahraga</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Olahraga Paling Populer</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Olahraga</th>
                                <th>Partisipasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topSports as $sport)
                                <tr>
                                    <td>{{ $sport->name }}</td>
                                    <td><span class="badge bg-primary">{{ $sport->progress_notes_count }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Aktivitas per Bulan</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendanceByMonth as $month)
                                <tr>
                                    <td>Bulan {{ $month->month }}</td>
                                    <td><span class="badge bg-success">{{ $month->total }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.reports.export', ['type' => 'attendance']) }}" class="btn btn-success">
            <i class="fas fa-download"></i> Export Absensi
        </a>
        <a href="{{ route('admin.reports.progress') }}" class="btn btn-info">
            <i class="fas fa-chart-line"></i> Laporan Progress
        </a>
    </div>
</div>
@endsection
