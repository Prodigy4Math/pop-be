@extends('layouts.admin')

@section('page-title', 'Absensi')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2><i class="fas fa-clipboard-check"></i> Manajemen Absensi</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.attendance.record') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Catat Absensi
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Peserta</th>
                        <th>Olahraga</th>
                        <th>Jadwal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendance as $record)
                        <tr>
                            <td><strong>{{ $record->user->name }}</strong></td>
                            <td>{{ $record->schedule->sport->name }}</td>
                            <td>{{ $record->schedule->schedule_date }}</td>
                            <td>{{ $record->schedule->start_time }} - {{ $record->schedule->end_time }}</td>
                            <td>
                                <span class="badge @if($record->status === 'present') bg-success @elseif($record->status === 'late') bg-warning @else bg-danger @endif">
                                    {{ ucfirst($record->status) }}
                                </span>
                            </td>
                            <td>{{ $record->notes ? Str::limit($record->notes, 30) : '-' }}</td>
                            <td>
                                <form action="{{ route('admin.attendance.destroy', $record) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $attendance->links() }}
    </div>
</div>
@endsection
