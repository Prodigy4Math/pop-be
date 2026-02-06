@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1"><i class="fas fa-hand-holding-heart me-2 text-success"></i>Peminjaman Alat</h3>
                        <p class="text-muted mb-0">Ajukan kebutuhan alat sesuai olahraga yang Anda ikuti.</p>
                    </div>
                    <a href="{{ route('peserta.loans.create') }}" class="btn btn-primary mt-3 mt-lg-0">
                        <i class="fas fa-plus me-2"></i>Ajukan Peminjaman
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
                                    <th>Olahraga</th>
                                    <th>Alat</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Catatan Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $req)
                                    <tr>
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
                                        <td class="text-muted small">{{ $req->admin_comment ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Belum ada pengajuan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
