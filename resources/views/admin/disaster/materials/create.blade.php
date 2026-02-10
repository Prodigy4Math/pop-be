@extends('layouts.admin')

@section('page-title', 'Tambah Materi Bencana')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-plus"></i> Buat Materi Bencana</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.disaster.materials.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori Bencana</label>
                            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Gempa Bumi" @selected(old('category') === 'Gempa Bumi')>Gempa Bumi</option>
                                <option value="Banjir" @selected(old('category') === 'Banjir')>Banjir</option>
                                <option value="Longsor" @selected(old('category') === 'Longsor')>Longsor</option>
                                <option value="Tsunami" @selected(old('category') === 'Tsunami')>Tsunami</option>
                                <option value="Angin Puting Beliung" @selected(old('category') === 'Angin Puting Beliung')>Angin Puting Beliung</option>
                                <option value="Kebakaran" @selected(old('category') === 'Kebakaran')>Kebakaran</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Singkat</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                rows="2" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipe Konten</label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="teks" @selected(old('type') === 'teks')>Teks</option>
                                <option value="video" @selected(old('type') === 'video')>Video</option>
                                <option value="infografis" @selected(old('type') === 'infografis')>Infografis</option>
                                <option value="pdf" @selected(old('type') === 'pdf')>PDF</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konten Teks (Opsional)</label>
                            <textarea name="content_text" class="form-control @error('content_text') is-invalid @enderror" 
                                rows="6">{{ old('content_text') }}</textarea>
                            @error('content_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">URL Konten (Opsional)</label>
                            <input type="text" name="content_url" class="form-control @error('content_url') is-invalid @enderror" 
                                value="{{ old('content_url') }}">
                            @error('content_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tingkat Kesulitan (1-5)</label>
                            <input type="number" name="difficulty_level" class="form-control @error('difficulty_level') is-invalid @enderror" 
                                value="{{ old('difficulty_level', 1) }}" min="1" max="5" required>
                            @error('difficulty_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
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
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-info-circle"></i> Kategori Bencana</h5>
                    <ul class="small">
                        <li>Gempa Bumi</li>
                        <li>Banjir</li>
                        <li>Longsor</li>
                        <li>Tsunami</li>
                        <li>Angin Puting Beliung</li>
                        <li>Kebakaran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
