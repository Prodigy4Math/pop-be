@extends('layouts.admin')

@section('page-title', 'Edit Olahraga')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h2 class="fw-bold text-dark">
                <i class="fas fa-edit me-2 text-success"></i>Edit Olahraga: {{ $sport->name }}
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.fitness.sports.update', $sport) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama Olahraga -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Olahraga</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $sport->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="category" class="form-label fw-bold">Kategori</label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="tim" {{ old('category', $sport->category) == 'tim' ? 'selected' : '' }}>Tim</option>
                                <option value="individu" {{ old('category', $sport->category) == 'individu' ? 'selected' : '' }}>Individu</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tingkat Kesulitan -->
                        <div class="mb-3">
                            <label for="difficulty_level" class="form-label fw-bold">Tingkat Kesulitan</label>
                            <select class="form-select @error('difficulty_level') is-invalid @enderror" 
                                    id="difficulty_level" name="difficulty_level" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="1" {{ old('difficulty_level', $sport->difficulty_level) == 1 ? 'selected' : '' }}>1 - Sangat Mudah</option>
                                <option value="2" {{ old('difficulty_level', $sport->difficulty_level) == 2 ? 'selected' : '' }}>2 - Mudah</option>
                                <option value="3" {{ old('difficulty_level', $sport->difficulty_level) == 3 ? 'selected' : '' }}>3 - Sedang</option>
                                <option value="4" {{ old('difficulty_level', $sport->difficulty_level) == 4 ? 'selected' : '' }}>4 - Sulit</option>
                                <option value="5" {{ old('difficulty_level', $sport->difficulty_level) == 5 ? 'selected' : '' }}>5 - Sangat Sulit</option>
                            </select>
                            @error('difficulty_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Icon -->
                        <div class="mb-3">
                            <label for="icon" class="form-label fw-bold">Ikon (Gambar)</label>
                            <input type="file" class="form-control @error('icon') is-invalid @enderror" 
                                   id="icon" name="icon" accept="image/*">
                            @if($sport->icon)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $sport->icon) }}" alt="{{ $sport->name }}" style="height: 48px; width: 48px; object-fit: cover;">
                                </div>
                            @endif
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $sport->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.fitness.sports.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-info-circle me-2 text-info"></i>Informasi
                    </h5>
                    <div class="alert alert-info" role="alert">
                        <small>
                            <p><strong>Dibuat:</strong> {{ $sport->created_at->format('d-m-Y H:i') }}</p>
                            <p><strong>Terakhir Diubah:</strong> {{ $sport->updated_at->format('d-m-Y H:i') }}</p>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
