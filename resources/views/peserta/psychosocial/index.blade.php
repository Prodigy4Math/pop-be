@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-heart"></i> Kegiatan Psikososial</h2>

    <div class="row">
        @forelse ($activities as $activity)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $activity->name }}</h5>
                        <p class="small">
                            <span class="badge bg-info">{{ $activity->category }}</span>
                        </p>
                        <p class="card-text small text-muted">{{ Str::limit($activity->description, 80) }}</p>
                        <p class="small"><strong>Durasi:</strong> {{ $activity->duration_minutes }} menit</p>
                        <a href="{{ route('peserta.psychosocial.show', $activity) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Tidak ada kegiatan psikososial tersedia</div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $activities->links() }}
    </div>
</div>
@endsection
