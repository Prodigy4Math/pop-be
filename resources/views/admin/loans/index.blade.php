@extends('layouts.admin')

@section('page-title', 'Peminjaman Alat')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1"><i class="fas fa-hand-holding-heart me-2 text-success"></i>Permintaan Peminjaman</h4>
                <p class="text-muted mb-0">Tinjau kebutuhan alat dari peserta untuk semua olahraga.</p>
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
                            <th>Olahraga</th>
                            <th>Alat</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                            <tr>
                                <td>{{ $req->user->name ?? '-' }}</td>
                                <td>{{ $req->sport->name ?? '-' }}</td>
                                <td class="fw-semibold">{{ $req->item_name }}</td>
                                <td>{{ $req->quantity }}</td>
                                <td>
                                    <div>{{ $req->needed_date->format('d-m-Y') }}</div>
                                    <div class="text-muted small">
                                        Kembali: {{ $req->return_date ? $req->return_date->format('d-m-Y') : '-' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $req->status === 'approved' ? 'success' : ($req->status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($req->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.loans.show', $req) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada permintaan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection
