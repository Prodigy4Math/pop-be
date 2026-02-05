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
                            <label class="form-label">Tipe Bencana</label>
                            <select name="disaster_type" class="form-select @error('disaster_type') is-invalid @enderror" required>
                                <option value="">Pilih Tipe</option>
                                <option value="Gempa Bumi">Gempa Bumi</option>
                                <option value="Banjir">Banjir</option>
                                <option value="Longsor">Longsor</option>
                                <option value="Tsunami">Tsunami</option>
                                <option value="Angin Puting Beliung">Angin Puting Beliung</option>
                                <option value="Kebakaran">Kebakaran</option>
                            </select>
                            @error('disaster_type')
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
                            <label class="form-label">Konten Materi</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" 
                                rows="6" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">URL File (Opsional)</label>
                            <input type="text" name="file_url" class="form-control @error('file_url') is-invalid @enderror" 
                                value="{{ old('file_url') }}">
                            @error('file_url')
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
                    <h5 class="card-title"><i class="fas fa-info-circle"></i> Tipe Bencana</h5>
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
