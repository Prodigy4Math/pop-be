@extends('layouts.admin')

@section('page-title', 'Manajemen Peserta')

@section('content')
<style>
    .qr-mini svg {
        width: 100% !important;
        height: 100% !important;
    }
</style>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold text-dark">
                    <i class="fas fa-users me-2 text-primary"></i>Kelola Peserta
                </h2>
                <a href="{{ route('admin.peserta.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Peserta
                </a>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari peserta..." 
                               value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Cari
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Peserta List -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    @if($peserta->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>ID Peserta</th>
                                        <th>QR</th>
                                        <th>Email</th>
                                        <th>Sekolah</th>
                                        <th>Umur</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peserta as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->name }}</strong>
                                        </td>
                                        <td>
                                            <code>{{ $item->participant_code ?? '-' }}</code>
                                        </td>
                                        <td>
                                            @if($item->barcode_svg)
                                                <div class="qr-mini" style="width: 56px; height: 56px; background: #fff; border: 1px solid #eee; border-radius: 6px; padding: 4px; display: inline-flex; align-items: center; justify-content: center;">
                                                    {!! $item->barcode_svg !!}
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->school ?? '-' }}</td>
                                        <td>{{ $item->age ?? '-' }} tahun</td>
                                        <td>
                                            @if($item->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.peserta.show', $item) }}" class="btn btn-sm btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($item->barcode_svg)
                                                <a href="{{ route('admin.peserta.barcode.card', $item) }}" class="btn btn-sm btn-outline-primary" title="Cetak Kartu">
                                                    <i class="fas fa-id-card"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.peserta.edit', $item) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.peserta.barcode.regenerate', $item) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Regenerate QR">
                                                    <i class="fas fa-rotate"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.peserta.destroy', $item) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Yakin hapus peserta ini?')">
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
                            {{ $peserta->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-3">Tidak ada peserta terdaftar</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
