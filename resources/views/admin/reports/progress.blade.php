@extends('layouts.admin')

@section('page-title', 'Laporan Progress')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-chart-line"></i> Laporan Progress Peserta</h2>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Peserta</th>
                        <th>Total Progress</th>
                        <th>Rata-rata Progress</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peserta as $p)
                        <tr>
                            <td>
                                <strong>{{ $p->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $p->email }}</small>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $p->progressNotes->count() }}</span>
                            </td>
                            <td>
                                @php
                                    $avgProgress = $p->progressNotes->avg('progress_percentage') ?? 0;
                                @endphp
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar {{ $avgProgress >= 70 ? 'bg-success' : ($avgProgress >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                        style="width: {{ $avgProgress }}%">
                                        {{ round($avgProgress, 1) }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.peserta.show', $p) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Tidak ada peserta</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $peserta->links() }}
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.reports.export', ['type' => 'progress']) }}" class="btn btn-success">
            <i class="fas fa-download"></i> Export Progress
        </a>
        <a href="{{ route('admin.reports.activity') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
