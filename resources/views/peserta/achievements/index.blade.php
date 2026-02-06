@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1"><i class="fas fa-trophy me-2 text-warning"></i>Prestasi & Proposal</h3>
                        <p class="text-muted mb-0">Kirim prestasi atau proposal Anda untuk diverifikasi admin.</p>
                    </div>
                    <a href="{{ route('peserta.achievements.create') }}" class="btn btn-primary mt-3 mt-lg-0">
                        <i class="fas fa-plus me-2"></i>Tambah Pengajuan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Catatan Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($submissions as $submission)
                                    <tr>
                                        <td class="fw-semibold">{{ $submission->title }}</td>
                                        <td class="text-capitalize">{{ $submission->category }}</td>
                                        <td>{{ $submission->event_date->format('d-m-Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $submission->status === 'approved' ? 'success' : ($submission->status === 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($submission->status) }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">
                                            {{ $submission->admin_comment ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada pengajuan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $submissions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
