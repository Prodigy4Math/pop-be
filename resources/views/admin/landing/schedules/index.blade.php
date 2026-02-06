@extends('layouts.admin')

@section('page-title', 'Jadwal Landing')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Jadwal Pertandingan</h4>
        <a href="{{ route('admin.landing.schedules.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Jadwal
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Cabang</th>
                            <th>Pertandingan</th>
                            <th>Status</th>
                            <th>Skor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->match_date->format('d M Y H:i') }}</td>
                                <td>{{ $schedule->sport->name ?? '-' }}</td>
                                <td>
                                    @if($schedule->team_home || $schedule->team_away)
                                        {{ $schedule->team_home ?? '-' }} vs {{ $schedule->team_away ?? '-' }}
                                    @else
                                        {{ $schedule->title ?? '-' }}
                                    @endif
                                </td>
                                <td class="text-capitalize">{{ $schedule->status }}</td>
                                <td>{{ $schedule->score_home ?? '-' }} : {{ $schedule->score_away ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.landing.schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.landing.schedules.destroy', $schedule) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada jadwal.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $schedules->links() }}
        </div>
    </div>
</div>
@endsection
