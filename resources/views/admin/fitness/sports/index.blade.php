@extends('layouts.admin')

@section('page-title', 'Kelola Olahraga')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold text-dark">
                    <i class="fas fa-dumbbell me-2 text-success"></i>Kelola Olahraga
                </h2>
                <a href="{{ route('admin.fitness.sports.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Tambah Olahraga
                </a>
            </div>
        </div>
    </div>

    <!-- Sports List -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    @if($sports->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Icon</th>
                                        <th>Nama Olahraga</th>
                                        <th>Kategori</th>
                                        <th>Tingkat Kesulitan</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sports as $sport)
                                    <tr>
                                        <td>
                                            <i class="fas fa-{{ $sport->icon ?? 'star' }}" style="font-size: 1.5rem; color: #28a745;"></i>
                                        </td>
                                        <td>
                                            <strong>{{ $sport->name }}</strong>
                                        </td>
                                        <td>{{ $sport->category ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-warning">Level {{ $sport->difficulty_level ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <small>{{ substr($sport->description ?? '-', 0, 50) }}...</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.fitness.sports.edit', $sport) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.fitness.sports.destroy', $sport) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Yakin hapus olahraga ini?')">
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
                            {{ $sports->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-3">Belum ada data olahraga</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Latihan Link -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <a href="{{ route('admin.fitness.schedules.index') }}" class="btn btn-info">
                <i class="fas fa-calendar me-2"></i>Lihat Jadwal Latihan
            </a>
        </div>
    </div>
</div>
@endsection
