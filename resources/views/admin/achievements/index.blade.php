@extends('layouts.admin')

@section('page-title', 'Prestasi & Proposal')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1"><i class="fas fa-trophy me-2 text-warning"></i>Daftar Prestasi/Proposal</h4>
                <p class="text-muted mb-0">Tinjau pengajuan dari peserta dan berikan keputusan.</p>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Peserta</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $submission)
                            <tr>
                                <td>{{ $submission->user->name ?? '-' }}</td>
                                <td class="fw-semibold">{{ $submission->title }}</td>
                                <td class="text-capitalize">{{ $submission->category }}</td>
                                <td>{{ $submission->event_date->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $submission->status === 'approved' ? 'success' : ($submission->status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.achievements.show', $submission) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada pengajuan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $submissions->links() }}
        </div>
    </div>
</div>
@endsection
