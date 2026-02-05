@extends('layouts.admin')

@section('page-title', 'Detail Badge')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="mb-0"><i class="fas fa-medal"></i> Detail Badge</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.badges.edit', $badge) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.badges.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="{{ $badge->icon ?? 'fas fa-medal' }} fa-4x mb-3" style="color: #667eea;"></i>
                    <h4 class="fw-bold">{{ $badge->name }}</h4>
                    <p class="text-muted">{{ $badge->description }}</p>
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <span class="badge bg-primary">Tipe: {{ ucfirst($badge->type) }}</span>
                        <span class="badge bg-info">Target: {{ $badge->requirement_count }}</span>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-secondary">Total Penerima: {{ $badge->users->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-user-plus me-2 text-success"></i>Berikan Badge
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.badges.award', $badge) }}" method="POST">
                        @csrf
                        <div class="row g-2 align-items-end">
                            <div class="col-md-9">
                                <label class="form-label">Pilih Peserta</label>
                                @php
                                    $awardedIds = $badge->users->pluck('id')->all();
                                @endphp
                                <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Peserta --</option>
                                    @foreach($peserta as $user)
                                        <option value="{{ $user->id }}" {{ in_array($user->id, $awardedIds, true) ? 'disabled' : '' }}>
                                            {{ $user->name }} ({{ $user->email }}){{ in_array($user->id, $awardedIds, true) ? ' - sudah dapat' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 d-grid">
                                <button class="btn btn-success">
                                    <i class="fas fa-award"></i> Berikan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-users me-2 text-primary"></i>Penerima Badge
                    </h6>
                </div>
                <div class="card-body p-0">
                    @forelse($badge->users as $user)
                        <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-semibold">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <div class="text-end">
                                @php
                                    $earnedDate = $user->pivot->earned_date
                                        ? \Carbon\Carbon::parse($user->pivot->earned_date)->format('d-m-Y')
                                        : '-';
                                @endphp
                                <span class="badge bg-light text-dark">Diterima: {{ $earnedDate }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-3 text-center text-muted">
                            <i class="fas fa-inbox fs-3 mb-2"></i>
                            <p class="mb-0 small">Belum ada penerima badge</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
