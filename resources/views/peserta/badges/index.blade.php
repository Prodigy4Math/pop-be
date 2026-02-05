@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-medal"></i> Badge & Pencapaian</h2>

    <div class="row">
        @forelse ($badges as $badge)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="{{ $badge->icon ?? 'fas fa-medal' }} fa-3x mb-3" style="color: #667eea;"></i>
                        <h5 class="card-title">{{ $badge->name }}</h5>
                        <p class="card-text small text-muted">{{ $badge->description }}</p>
                        <small class="text-success">
                            Diterima:
                            {{ $badge->pivot->earned_date ? \Carbon\Carbon::parse($badge->pivot->earned_date)->format('d-m-Y') : '-' }}
                        </small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Belum ada badge yang diterima. Terus ikuti kegiatan untuk mendapatkan badge!
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $badges->links() }}
    </div>
</div>
@endsection
