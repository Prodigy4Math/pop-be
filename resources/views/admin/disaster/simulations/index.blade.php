@extends('layouts.admin')

@section('page-title', 'Simulasi Bencana')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2><i class="fas fa-fire"></i> Simulasi Bencana</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.disaster.simulations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Simulasi
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
                        <th>Judul Simulasi</th>
                        <th>Tipe Bencana</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($simulations as $sim)
                        <tr>
                            <td><strong>{{ $sim->title }}</strong></td>
                            <td><span class="badge bg-danger">{{ $sim->disaster_type }}</span></td>
                            <td>{{ $sim->location }}</td>
                            <td>{{ $sim->simulation_date->format('d-m-Y') }} <span class="text-muted small">({{ $sim->start_time }} - {{ $sim->end_time }})</span></td>
                            <td>
                                @if ($sim->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.disaster.simulations.edit', $sim) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.disaster.simulations.destroy', $sim) }}" method="POST" style="display:inline">
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
                            <td colspan="6" class="text-center text-muted py-3">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $simulations->links() }}
    </div>
</div>
@endsection
