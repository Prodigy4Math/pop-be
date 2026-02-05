@extends('layouts.admin')

@section('page-title', 'Jadwal Latihan')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold text-dark">
                    <i class="fas fa-calendar me-2 text-info"></i>Jadwal Latihan
                </h2>
                <a href="{{ route('admin.fitness.schedules.create') }}" class="btn btn-info">
                    <i class="fas fa-plus me-2"></i>Buat Jadwal
                </a>
            </div>
        </div>
    </div>

    <!-- Schedules List -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    @if($schedules->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Olahraga</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Lokasi</th>
                                        <th>Kuota</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules as $schedule)
                                    <tr>
                                        <td>
                                            <strong>{{ $schedule->sport->name ?? '-' }}</strong>
                                        </td>
                                        <td>
                                            {{ $schedule->schedule_date ? $schedule->schedule_date->format('d M Y') : '-' }}
                                        </td>
                                        <td>
                                            <small>{{ $schedule->start_time }} - {{ $schedule->end_time }}</small>
                                        </td>
                                        <td>{{ $schedule->location ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $schedule->max_participants ?? 0 }} orang</span>
                                        </td>
                                        <td>
                                            @if($schedule->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.fitness.schedules.edit', $schedule) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.fitness.schedules.destroy', $schedule) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $schedules->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-3">Belum ada jadwal latihan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Link ke Olahraga -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <a href="{{ route('admin.fitness.sports.index') }}" class="btn btn-success">
                <i class="fas fa-dumbbell me-2"></i>Kelola Olahraga
            </a>
        </div>
    </div>
</div>
@endsection
