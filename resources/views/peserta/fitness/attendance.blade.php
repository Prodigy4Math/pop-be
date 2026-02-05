@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-list-check"></i> Riwayat Kehadiran</h2>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Olahraga</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendance as $record)
                        <tr>
                            <td><strong>{{ $record->schedule->sport->name }}</strong></td>
                            <td>{{ $record->schedule->schedule_date }}</td>
                            <td>{{ $record->schedule->start_time }} - {{ $record->schedule->end_time }}</td>
                            <td>{{ $record->schedule->location }}</td>
                            <td>
                                <span class="badge @if($record->status === 'present') bg-success @elseif($record->status === 'late') bg-warning @else bg-danger @endif">
                                    @if($record->status === 'present') Hadir
                                    @elseif($record->status === 'late') Terlambat
                                    @else Tidak Hadir @endif
                                </span>
                            </td>
                            <td>{{ $record->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Tidak ada data kehadiran</td>
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
