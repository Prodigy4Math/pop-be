@extends('layouts.admin')

@section('page-title', 'Edit Materi Bencana')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-edit"></i> Edit Materi Bencana</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.disaster.materials.update', $material) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                value="{{ old('title', $material->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipe Bencana</label>
                            <select name="disaster_type" class="form-select @error('disaster_type') is-invalid @enderror" required>
                                <option value="Gempa Bumi" @selected(old('disaster_type', $material->disaster_type) === 'Gempa Bumi')>Gempa Bumi</option>
                                <option value="Banjir" @selected(old('disaster_type', $material->disaster_type) === 'Banjir')>Banjir</option>
                                <option value="Longsor" @selected(old('disaster_type', $material->disaster_type) === 'Longsor')>Longsor</option>
                                <option value="Tsunami" @selected(old('disaster_type', $material->disaster_type) === 'Tsunami')>Tsunami</option>
                                <option value="Angin Puting Beliung" @selected(old('disaster_type', $material->disaster_type) === 'Angin Puting Beliung')>Angin Puting Beliung</option>
                                <option value="Kebakaran" @selected(old('disaster_type', $material->disaster_type) === 'Kebakaran')>Kebakaran</option>
                            </select>
                            @error('disaster_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Singkat</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                rows="2" required>{{ old('description', $material->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konten Materi</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" 
                                rows="6" required>{{ old('content', $material->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">URL File (Opsional)</label>
                            <input type="text" name="file_url" class="form-control @error('file_url') is-invalid @enderror" 
                                value="{{ old('file_url', $material->file_url) }}">
                            @error('file_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" 
                                @checked(old('is_active', $material->is_active))>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="{{ route('admin.disaster.materials.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi</h5>
                    <dl class="row small">
                        <dt class="col-sm-5">Dibuat:</dt>
                        <dd class="col-sm-7">{{ $material->created_at->format('d-m-Y') }}</dd>
                        <dt class="col-sm-5">Diperbarui:</dt>
                        <dd class="col-sm-7">{{ $material->updated_at->format('d-m-Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
