@extends('layouts.admin')

@section('page-title', 'Detail Peminjaman Alat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold text-dark">
                    <i class="fas fa-hand-holding-heart me-2 text-success"></i>{{ $loan->item_name }}
                </h2>
                <a href="{{ route('admin.loans.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="fw-bold mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Peminjaman</h5>
                </div>
                <div class="card-body">
                    <p><strong>Peserta:</strong> {{ $loan->user->name ?? '-' }}</p>
                    <p><strong>Olahraga:</strong> {{ $loan->sport->name ?? '-' }}</p>
                    <p><strong>Jumlah:</strong> {{ $loan->quantity }}</p>
                    <p><strong>Tanggal Dibutuhkan:</strong> {{ $loan->needed_date->format('d-m-Y') }}</p>
                    <p><strong>Tanggal Pengembalian:</strong> {{ $loan->return_date ? $loan->return_date->format('d-m-Y') : '-' }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-{{ $loan->status === 'approved' ? 'success' : ($loan->status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </p>
                    <p><strong>Keperluan:</strong></p>
                    <p class="text-muted">{{ $loan->purpose }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="fw-bold mb-0"><i class="fas fa-check-circle me-2 text-success"></i>Persetujuan Admin</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.loans.approve', $loan) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Komentar Admin (Opsional)</label>
                            <textarea name="admin_comment" rows="3" class="form-control">{{ old('admin_comment') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check me-2"></i>Setujui
                        </button>
                    </form>

                    <form action="{{ route('admin.loans.reject', $loan) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Komentar Penolakan</label>
                            <textarea name="admin_comment" rows="3" class="form-control @error('admin_comment') is-invalid @enderror" required>{{ old('admin_comment') }}</textarea>
                            @error('admin_comment')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-times me-2"></i>Tolak
                        </button>
                    </form>
                </div>
            </div>

            @if($loan->admin_comment)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-comment me-2"></i>Catatan Admin Terakhir</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">{{ $loan->admin_comment }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
