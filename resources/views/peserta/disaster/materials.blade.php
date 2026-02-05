@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-book"></i> Materi Kesiapsiagaan Bencana</h2>

    <div class="row g-3">
        @forelse ($materials as $material)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $material->title }}</h5>
                        <p class="small text-muted mb-2">
                            <i class="fas fa-tag"></i> {{ $material->disaster_type }}
                        </p>
                        <p class="card-text small">{{ Str::limit($material->description, 80) }}</p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('peserta.disaster.show', $material) }}" class="btn btn-sm btn-primary w-100">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted py-5">Belum ada materi bencana</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $materials->links() }}
    </div>
</div>
@endsection
