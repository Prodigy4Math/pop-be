@extends('layouts.admin')

@section('page-title', 'Detail Prestasi/Proposal')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold text-dark">
                    <i class="fas fa-trophy me-2 text-warning"></i>{{ $submission->title }}
                </h2>
                <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="fw-bold mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Pengajuan</h5>
                </div>
                <div class="card-body">
                    <p><strong>Peserta:</strong> {{ $submission->user->name ?? '-' }}</p>
                    <p><strong>Kategori:</strong> <span class="text-capitalize">{{ $submission->category }}</span></p>
                    <p><strong>Tanggal:</strong> {{ $submission->event_date->format('d-m-Y') }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-{{ $submission->status === 'approved' ? 'success' : ($submission->status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($submission->status) }}
                        </span>
                    </p>
                    <p><strong>Deskripsi:</strong></p>
                    <p class="text-muted">{{ $submission->description }}</p>

                    @if($submission->attachment_path)
                        <a href="{{ route('admin.achievements.download', $submission) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-download me-2"></i>Unduh Lampiran
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="fw-bold mb-0"><i class="fas fa-check-circle me-2 text-success"></i>Verifikasi Admin</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.achievements.approve', $submission) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Komentar Admin (Opsional)</label>
                            <textarea name="admin_comment" rows="3" class="form-control">{{ old('admin_comment') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Berikan Badge (Opsional)</label>
                            <select name="badge_id" class="form-control">
                                <option value="">-- Pilih Badge --</option>
                                @foreach($badges as $badge)
                                    <option value="{{ $badge->id }}">{{ $badge->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check me-2"></i>Setujui
                        </button>
                    </form>

                    <form action="{{ route('admin.achievements.reject', $submission) }}" method="POST">
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

            @if($submission->admin_comment)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-comment me-2"></i>Catatan Admin Terakhir</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">{{ $submission->admin_comment }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
