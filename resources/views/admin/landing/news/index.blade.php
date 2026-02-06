@extends('layouts.admin')

@section('page-title', 'Berita Landing')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Berita & Pengumuman</h4>
        <a href="{{ route('admin.landing.news.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Berita
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->title }}</td>
                                <td>{{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}</td>
                                <td>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                                <td>
                                    <a href="{{ route('admin.landing.news.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.landing.news.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada berita.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection
