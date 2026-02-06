@extends('layouts.admin')

@section('page-title', 'Klasemen Landing')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Klasemen & Ranking</h4>
        <a href="{{ route('admin.landing.standings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Klasemen
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Cabang</th>
                            <th>Pos</th>
                            <th>Tim</th>
                            <th>Main</th>
                            <th>W</th>
                            <th>D</th>
                            <th>L</th>
                            <th>GF</th>
                            <th>GA</th>
                            <th>Poin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($standings as $standing)
                            <tr>
                                <td>{{ $standing->sport->name ?? '-' }}</td>
                                <td>{{ $standing->position }}</td>
                                <td class="fw-semibold">{{ $standing->team_name }}</td>
                                <td>{{ $standing->played }}</td>
                                <td>{{ $standing->wins }}</td>
                                <td>{{ $standing->draws }}</td>
                                <td>{{ $standing->losses }}</td>
                                <td>{{ $standing->goals_for }}</td>
                                <td>{{ $standing->goals_against }}</td>
                                <td>{{ $standing->points }}</td>
                                <td>
                                    <a href="{{ route('admin.landing.standings.edit', $standing) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.landing.standings.destroy', $standing) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data klasemen ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $standings->links() }}
        </div>
    </div>
</div>
@endsection
