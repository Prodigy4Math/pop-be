@extends('layouts.admin')

@section('page-title', 'Tambah Olahraga')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h2 class="fw-bold text-dark">
                <i class="fas fa-plus me-2 text-success"></i>Tambah Olahraga Baru
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.fitness.sports.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama Olahraga -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Olahraga</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required
                                   placeholder="Contoh: Badminton, Lari, Voli">
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
                                <option value="tim" {{ old('category') == 'tim' ? 'selected' : '' }}>Tim</option>
                                <option value="individu" {{ old('category') == 'individu' ? 'selected' : '' }}>Individu</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-3" id="categoryHelp">
                                <div class="alert alert-info d-none" data-category="tim">
                                    <h6 class="fw-bold mb-1">Tim</h6>
                                    <p class="small mb-0 text-muted">Olahraga yang dimainkan bersama dalam satu tim. Contoh: sepak bola, voli, basket.</p>
                                </div>
                                <div class="alert alert-success d-none" data-category="individu">
                                    <h6 class="fw-bold mb-1">Individu</h6>
                                    <p class="small mb-0 text-muted">Olahraga yang dilakukan perorangan. Contoh: lari, badminton, renang.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tingkat Kesulitan -->
                        <div class="mb-3">
                            <label for="difficulty_level" class="form-label fw-bold">Tingkat Kesulitan</label>
                            <select class="form-select @error('difficulty_level') is-invalid @enderror" 
                                    id="difficulty_level" name="difficulty_level" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="1" {{ old('difficulty_level') == 1 ? 'selected' : '' }}>1 - Sangat Mudah</option>
                                <option value="2" {{ old('difficulty_level') == 2 ? 'selected' : '' }}>2 - Mudah</option>
                                <option value="3" {{ old('difficulty_level') == 3 ? 'selected' : '' }}>3 - Sedang</option>
                                <option value="4" {{ old('difficulty_level') == 4 ? 'selected' : '' }}>4 - Sulit</option>
                                <option value="5" {{ old('difficulty_level') == 5 ? 'selected' : '' }}>5 - Sangat Sulit</option>
                            </select>
                            @error('difficulty_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-3" id="difficultyHelp">
                                <div class="alert alert-success d-none" data-difficulty="1">
                                    <small class="text-muted">Cocok untuk pemula, intensitas ringan, risiko cedera rendah.</small>
                                </div>
                                <div class="alert alert-success d-none" data-difficulty="2">
                                    <small class="text-muted">Masih ramah pemula, butuh teknik dasar dan pemanasan cukup.</small>
                                </div>
                                <div class="alert alert-warning d-none" data-difficulty="3">
                                    <small class="text-muted">Intensitas sedang, butuh stamina dan kontrol gerak.</small>
                                </div>
                                <div class="alert alert-danger d-none" data-difficulty="4">
                                    <small class="text-muted">Intensitas tinggi, butuh teknik baik dan pengawasan.</small>
                                </div>
                                <div class="alert alert-danger d-none" data-difficulty="5">
                                    <small class="text-muted">Sangat menantang, hanya untuk peserta berpengalaman.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Icon -->
                        <div class="mb-3">
                            <label for="icon" class="form-label fw-bold">Ikon (Gambar)</label>
                            <input type="file" class="form-control @error('icon') is-invalid @enderror" 
                                   id="icon" name="icon" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, atau WEBP. Maks 2MB.</small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Simpan
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
                        <i class="fas fa-info-circle me-2 text-info"></i>Panduan
                    </h5>
                    <div class="alert alert-info" role="alert">
                        <small>
                            <p><strong>Kategori:</strong> Pilih antara Tim atau Individu</p>
                            <p><strong>Tingkat Kesulitan:</strong> Skala 1-5, semakin tinggi semakin sulit</p>
                            <p><strong>Ikon:</strong> Unggah gambar ikon untuk olahraga</p>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const categorySelect = document.getElementById('category');
    const categoryHelp = document.getElementById('categoryHelp');
    const difficultySelect = document.getElementById('difficulty_level');
    const difficultyHelp = document.getElementById('difficultyHelp');

    function updateCategoryHelp() {
        if (!categoryHelp) {
            return;
        }
        const selected = categorySelect.value;
        categoryHelp.querySelectorAll('[data-category]').forEach((item) => {
            if (item.getAttribute('data-category') === selected) {
                item.classList.remove('d-none');
            } else {
                item.classList.add('d-none');
            }
        });
    }

    function updateDifficultyHelp() {
        if (!difficultyHelp) {
            return;
        }
        const selected = difficultySelect.value;
        difficultyHelp.querySelectorAll('[data-difficulty]').forEach((item) => {
            if (item.getAttribute('data-difficulty') === selected) {
                item.classList.remove('d-none');
            } else {
                item.classList.add('d-none');
            }
        });
    }

    categorySelect.addEventListener('change', updateCategoryHelp);
    difficultySelect.addEventListener('change', updateDifficultyHelp);
    updateCategoryHelp();
    updateDifficultyHelp();
</script>
@endpush
