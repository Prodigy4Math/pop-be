@extends('layouts.admin')

@section('page-title', 'Edit Kegiatan Psikososial')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold text-dark mb-2">
                        <i class="fas fa-edit me-2 text-warning"></i>Edit Kegiatan: {{ $activity->name }}
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.psychosocial.activities.index') }}">Kegiatan Psikososial</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.psychosocial.activities.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-edit me-2 text-warning"></i>Form Edit Kegiatan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.psychosocial.activities.update', $activity) }}" method="POST" id="activityForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nama Kegiatan -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">
                                Nama Kegiatan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $activity->name) }}" 
                                   placeholder="Contoh: Workshop Manajemen Stres, Sesi Trauma Healing"
                                   required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4">
                            <label for="category" class="form-label fw-bold">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select name="category" 
                                    id="category"
                                    class="form-select form-select-lg @error('category') is-invalid @enderror" 
                                    required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Stres Manajemen" {{ old('category', $activity->category) == 'Stres Manajemen' ? 'selected' : '' }}>
                                    Stres Manajemen
                                </option>
                                <option value="Trauma Healing" {{ old('category', $activity->category) == 'Trauma Healing' ? 'selected' : '' }}>
                                    Trauma Healing
                                </option>
                                <option value="Resiliensi" {{ old('category', $activity->category) == 'Resiliensi' ? 'selected' : '' }}>
                                    Resiliensi
                                </option>
                                <option value="Sosial Emosional" {{ old('category', $activity->category) == 'Sosial Emosional' ? 'selected' : '' }}>
                                    Sosial Emosional
                                </option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="mt-3" id="categoryHelp">
                                <div class="alert alert-danger d-none" data-category="Stres Manajemen">
                                    <h6 class="fw-bold mb-2">Stres Manajemen</h6>
                                    <p class="small mb-2 text-muted">Fokus pada identifikasi pemicu, teknik relaksasi, dan rencana coping harian.</p>
                                    <ul class="small text-muted mb-0">
                                        <li>Contoh: napas 4-7-8, relaksasi otot, jurnal pemicu</li>
                                        <li>Indikator: peserta menyebutkan pemicu & strategi coping</li>
                                    </ul>
                                </div>
                                <div class="alert alert-warning d-none" data-category="Trauma Healing">
                                    <h6 class="fw-bold mb-2">Trauma Healing</h6>
                                    <p class="small mb-2 text-muted">Stabilisasi emosi, rasa aman, dan ekspresi aman tanpa memicu ulang.</p>
                                    <ul class="small text-muted mb-0">
                                        <li>Contoh: grounding 5-4-3-2-1, body scan ringan</li>
                                        <li>Catatan: hindari pemicu berat, siapkan rujukan</li>
                                    </ul>
                                </div>
                                <div class="alert alert-success d-none" data-category="Resiliensi">
                                    <h6 class="fw-bold mb-2">Resiliensi</h6>
                                    <p class="small mb-2 text-muted">Menguatkan daya lenting, problem solving, dan goal setting realistis.</p>
                                    <ul class="small text-muted mb-0">
                                        <li>Contoh: latihan kekuatan diri, studi kasus, rencana aksi</li>
                                        <li>Indikator: tujuan & langkah kerja disusun</li>
                                    </ul>
                                </div>
                                <div class="alert alert-info d-none" data-category="Sosial Emosional">
                                    <h6 class="fw-bold mb-2">Sosial Emosional</h6>
                                    <p class="small mb-2 text-muted">Empati, komunikasi asertif, dan regulasi emosi dalam interaksi.</p>
                                    <ul class="small text-muted mb-0">
                                        <li>Contoh: role-play, mendengar aktif, kartu emosi</li>
                                        <li>Indikator: mampu menyampaikan perasaan & bekerja sama</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Durasi -->
                        <div class="mb-4">
                            <label for="duration_minutes" class="form-label fw-bold">
                                Durasi (Menit) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-clock text-primary"></i>
                                </span>
                                <input type="number" 
                                       name="duration_minutes" 
                                       id="duration_minutes"
                                       class="form-control @error('duration_minutes') is-invalid @enderror" 
                                       value="{{ old('duration_minutes', $activity->duration_minutes) }}" 
                                       min="15" 
                                       max="180" 
                                       step="15"
                                       required>
                                <span class="input-group-text bg-light">menit</span>
                            </div>
                            @error('duration_minutes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                Deskripsi Kegiatan <span class="text-danger">*</span>
                            </label>
                            <textarea name="description" 
                                      id="description"
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="6" 
                                      required>{{ old('description', $activity->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Gunakan format: tujuan, langkah inti, metode, indikator keberhasilan, dan catatan keamanan</small>
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-4">
                            <div class="form-check form-switch form-switch-lg">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="is_active" 
                                       id="is_active" 
                                       value="1"
                                       {{ old('is_active', $activity->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Aktifkan Kegiatan
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 pt-3 border-top">
                            <button type="submit" class="btn btn-warning btn-lg px-5">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.psychosocial.activities.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-bottom py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-clipboard-list me-2 text-primary"></i>Panduan Ringkas Kategori
                    </h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="quickGuideEdit">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="qgEditStress">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#qgEditStressBody" aria-expanded="true" aria-controls="qgEditStressBody">
                                    <span class="badge bg-danger me-2">Stres Manajemen</span>
                                    Fokus coping & relaksasi
                                </button>
                            </h2>
                            <div id="qgEditStressBody" class="accordion-collapse collapse show" aria-labelledby="qgEditStress" data-bs-parent="#quickGuideEdit">
                                <div class="accordion-body small text-muted">
                                    Tujuan: identifikasi pemicu, teknik napas/relaksasi, rencana coping. 
                                    Indikator: peserta mampu menyebutkan pemicu & strategi.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="qgEditTrauma">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qgEditTraumaBody" aria-expanded="false" aria-controls="qgEditTraumaBody">
                                    <span class="badge bg-warning text-dark me-2">Trauma Healing</span>
                                    Stabilisasi & keamanan
                                </button>
                            </h2>
                            <div id="qgEditTraumaBody" class="accordion-collapse collapse" aria-labelledby="qgEditTrauma" data-bs-parent="#quickGuideEdit">
                                <div class="accordion-body small text-muted">
                                    Tujuan: rasa aman, regulasi emosi, ekspresi aman. 
                                    Catatan: hindari pemicu berat, siapkan rujukan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="qgEditResilience">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qgEditResilienceBody" aria-expanded="false" aria-controls="qgEditResilienceBody">
                                    <span class="badge bg-success me-2">Resiliensi</span>
                                    Tujuan & rencana aksi
                                </button>
                            </h2>
                            <div id="qgEditResilienceBody" class="accordion-collapse collapse" aria-labelledby="qgEditResilience" data-bs-parent="#quickGuideEdit">
                                <div class="accordion-body small text-muted">
                                    Tujuan: daya lenting, problem solving, goal setting. 
                                    Indikator: tujuan & langkah kerja disusun.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="qgEditSocial">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qgEditSocialBody" aria-expanded="false" aria-controls="qgEditSocialBody">
                                    <span class="badge bg-info me-2">Sosial Emosional</span>
                                    Empati & komunikasi
                                </button>
                            </h2>
                            <div id="qgEditSocialBody" class="accordion-collapse collapse" aria-labelledby="qgEditSocial" data-bs-parent="#quickGuideEdit">
                                <div class="accordion-body small text-muted">
                                    Tujuan: empati, komunikasi asertif, regulasi emosi. 
                                    Indikator: mampu menyampaikan perasaan & bekerja sama.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2"></i>Informasi Kegiatan
                    </h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Dibuat:</dt>
                        <dd class="col-sm-7">{{ $activity->created_at->format('d-m-Y H:i') }}</dd>
                        <dt class="col-sm-5">Diperbarui:</dt>
                        <dd class="col-sm-7">{{ $activity->updated_at->format('d-m-Y H:i') }}</dd>
                        <dt class="col-sm-5">Total Catatan:</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-primary">{{ $activity->notes()->count() }}</span>
                        </dd>
                    </dl>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>Peringatan
                    </h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-0">
                        Mengubah atau menonaktifkan kegiatan ini tidak akan menghapus catatan yang sudah dibuat sebelumnya. 
                        Pastikan perubahan yang Anda lakukan tidak mengganggu kegiatan yang sedang berlangsung.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('activityForm').addEventListener('submit', function(e) {
        const duration = parseInt(document.getElementById('duration_minutes').value);
        if (duration < 15 || duration > 180) {
            e.preventDefault();
            alert('Durasi harus antara 15-180 menit');
            return false;
        }
    });

    const descriptionField = document.getElementById('description');
    document.querySelectorAll('.js-template-btn').forEach((button) => {
        button.addEventListener('click', () => {
            const template = button.getAttribute('data-template');
            if (!template) {
                return;
            }
            if (descriptionField.value.trim().length > 0) {
                const shouldReplace = confirm('Deskripsi sudah terisi. Ganti dengan template ini?');
                if (!shouldReplace) {
                    return;
                }
            }
            descriptionField.value = template;
            descriptionField.focus();
        });
    });

    const categorySelect = document.getElementById('category');
    const categoryHelp = document.getElementById('categoryHelp');

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

    categorySelect.addEventListener('change', updateCategoryHelp);
    updateCategoryHelp();
</script>
@endpush
@endsection
