@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-calendar-check"></i> Jadwal Kebugaran</h2>

    <div class="row">
        @forelse ($schedules as $schedule)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $schedule->sport->name }}</h5>
                        <p class="small text-muted mb-2">
                            <i class="fas fa-calendar"></i> {{ $schedule->schedule_date }}
                        </p>
                        <p class="small text-muted mb-2">
                            <i class="fas fa-clock"></i> {{ $schedule->start_time }} - {{ $schedule->end_time }}
                        </p>
                        <p class="small text-muted mb-2">
                            <i class="fas fa-map-marker-alt"></i> {{ $schedule->location }}
                        </p>
                        <p class="small">
                            <strong>Peserta:</strong> {{ $schedule->current_participants ?? 0 }}/{{ $schedule->max_participants }}
                        </p>
                        @if($schedule->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Tidak ada jadwal kebugaran tersedia</div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $schedules->links() }}
    </div>
</div>
@endsection
