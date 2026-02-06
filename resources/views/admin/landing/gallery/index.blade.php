@extends('layouts.admin')

@section('page-title', 'Galeri Landing')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Galeri Foto/Video</h4>
        <a href="{{ route('admin.landing.gallery.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Galeri
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Judul</th>
                            <th>Type</th>
                            <th>Media URL</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gallery as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->title ?? '-' }}</td>
                                <td class="text-capitalize">{{ $item->type }}</td>
                                <td class="text-truncate" style="max-width: 220px;">{{ $item->media_url }}</td>
                                <td>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                                <td>
                                    <a href="{{ route('admin.landing.gallery.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.landing.gallery.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus galeri ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada galeri.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $gallery->links() }}
        </div>
    </div>
</div>
@endsection
