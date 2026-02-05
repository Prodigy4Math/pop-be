@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-chart-line"></i> Perkembangan Kebugaran</h2>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Olahraga</th>
                        <th>Tanggal</th>
                        <th>Progress</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($progressNotes as $note)
                        <tr>
                            <td><strong>{{ $note->sport->name }}</strong></td>
                            <td>{{ $note->created_at->format('d-m-Y') }}</td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" style="width: {{ $note->progress_percentage }}%">
                                        {{ $note->progress_percentage }}%
                                    </div>
                                </div>
                            </td>
                            <td>{{ Str::limit($note->notes, 50) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Belum ada catatan perkembangan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $progressNotes->links() }}
    </div>
</div>
@endsection
