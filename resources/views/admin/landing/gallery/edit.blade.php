@extends('layouts.admin')

@section('page-title', 'Edit Galeri')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.landing.gallery.update', $gallery) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $gallery->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Tipe</label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="photo" @selected(old('type', $gallery->type) === 'photo')>Foto</option>
                            <option value="video" @selected(old('type', $gallery->type) === 'video')>Video</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" @selected(old('is_active', $gallery->is_active ? '1' : '0') === '1')>Aktif</option>
                            <option value="0" @selected(old('is_active', $gallery->is_active ? '1' : '0') === '0')>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Media URL</label>
                    <input type="url" name="media_url" class="form-control @error('media_url') is-invalid @enderror" value="{{ old('media_url', $gallery->media_url) }}" required>
                    @error('media_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Thumbnail URL (Opsional)</label>
                    <input type="url" name="thumbnail_url" class="form-control @error('thumbnail_url') is-invalid @enderror" value="{{ old('thumbnail_url', $gallery->thumbnail_url) }}">
                    @error('thumbnail_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.landing.gallery.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
