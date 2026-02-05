@extends('layouts.admin')

@section('page-title', 'Kelola Badge')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2><i class="fas fa-medal"></i> Manajemen Badge</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.badges.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Buat Badge
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse ($badges as $badge)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="{{ $badge->icon ?? 'fas fa-medal' }} fa-3x" style="color: #667eea;"></i>
                        </div>
                        <h5 class="card-title text-center">{{ $badge->name }}</h5>
                        <p class="card-text small text-muted">{{ Str::limit($badge->description, 80) }}</p>
                        <p class="small mb-2"><strong>Tipe:</strong> {{ ucfirst($badge->type) }}</p>
                        <p class="small mb-2"><strong>Target:</strong> {{ $badge->requirement_count }} kegiatan</p>
                        <p class="small">
                            <strong>Peserta:</strong> 
                            <span class="badge bg-info">{{ $badge->users_count }}</span>
                        </p>
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('admin.badges.show', $badge) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.badges.edit', $badge) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.badges.destroy', $badge) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Tidak ada badge</div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $badges->links() }}
    </div>
</div>
@endsection
