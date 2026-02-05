@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-chart-bar"></i> Tracking Progress Saya</h2>

    <div class="row mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary">{{ $totalAttendance }}</h3>
                    <small class="text-muted">Total Kehadiran</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-success">{{ $presentAttendance }}</h3>
                    <small class="text-muted">Hadir</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-warning">{{ $attendancePercentage }}%</h3>
                    <small class="text-muted">Persentase Kehadiran</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-info">{{ round($averageResilience, 1) }}</h3>
                    <small class="text-muted">Resiliensi Rata-rata</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Catatan Perkembangan</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Olahraga</th>
                        <th>Tanggal</th>
                        <th>Progress</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($progressNotes as $note)
                        <tr>
                            <td><strong>{{ $note->sport->name }}</strong></td>
                            <td>{{ $note->created_at->format('d-m-Y') }}</td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" style="width: {{ $note->progress_percentage }}%">
                                        {{ $note->progress_percentage }}%
                                    </div>
                                </div>
                            </td>
                            <td>{{ Str::limit($note->notes, 40) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Belum ada catatan perkembangan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $progressNotes->links() }}
    </div>
</div>
@endsection
