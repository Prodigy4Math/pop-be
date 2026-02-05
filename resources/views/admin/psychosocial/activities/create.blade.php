@extends('layouts.admin')

@section('page-title', 'Tambah Kegiatan Psikososial')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold text-dark mb-2">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Kegiatan Psikososial Baru
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.psychosocial.activities.index') }}">Kegiatan Psikososial</a></li>
                            <li class="breadcrumb-item active">Tambah Baru</li>
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
                        <i class="fas fa-edit me-2 text-primary"></i>Form Kegiatan Psikososial
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.psychosocial.activities.store') }}" method="POST" id="activityForm">
                        @csrf
                        
                        <!-- Nama Kegiatan -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">
                                Nama Kegiatan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" 
                                   placeholder="Contoh: Workshop Manajemen Stres, Sesi Trauma Healing"
                                   required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Berikan nama yang jelas dan deskriptif untuk kegiatan ini</small>
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
                                <option value="Stres Manajemen" {{ old('category') == 'Stres Manajemen' ? 'selected' : '' }}>
                                    Stres Manajemen
                                </option>
                                <option value="Trauma Healing" {{ old('category') == 'Trauma Healing' ? 'selected' : '' }}>
                                    Trauma Healing
                                </option>
                                <option value="Resiliensi" {{ old('category') == 'Resiliensi' ? 'selected' : '' }}>
                                    Resiliensi
                                </option>
                                <option value="Sosial Emosional" {{ old('category') == 'Sosial Emosional' ? 'selected' : '' }}>
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
                                       value="{{ old('duration_minutes') }}" 
                                       min="15" 
                                       max="180" 
                                       step="15"
                                       placeholder="60"
                                       required>
                                <span class="input-group-text bg-light">menit</span>
                            </div>
                            @error('duration_minutes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Durasi minimal 15 menit, maksimal 180 menit (3 jam)</small>
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
                                      placeholder="Jelaskan detail kegiatan, tujuan, dan manfaat yang akan didapat peserta..."
                                      required>{{ old('description') }}</textarea>
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
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Aktifkan Kegiatan
                                </label>
                            </div>
                            <small class="text-muted d-block mt-2">
                                Kegiatan yang aktif akan terlihat oleh peserta dan dapat digunakan untuk membuat catatan
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-save me-2"></i>Simpan Kegiatan
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
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2"></i>Panduan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-light border mb-3">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-clipboard-list me-2"></i>Panduan Ringkas Kategori
                        </h6>
                        <p class="small text-muted mb-3">Acuan cepat untuk menyusun deskripsi kegiatan.</p>
                        <div class="accordion" id="quickGuideCreate">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="qgCreateStress">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#qgCreateStressBody" aria-expanded="true" aria-controls="qgCreateStressBody">
                                        <span class="badge bg-danger me-2">Stres Manajemen</span>
                                        Fokus coping & relaksasi
                                    </button>
                                </h2>
                                <div id="qgCreateStressBody" class="accordion-collapse collapse show" aria-labelledby="qgCreateStress" data-bs-parent="#quickGuideCreate">
                                    <div class="accordion-body small text-muted">
                                        Tujuan: identifikasi pemicu, teknik napas/relaksasi, rencana coping. 
                                        Indikator: peserta mampu menyebutkan pemicu & strategi.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="qgCreateTrauma">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qgCreateTraumaBody" aria-expanded="false" aria-controls="qgCreateTraumaBody">
                                        <span class="badge bg-warning text-dark me-2">Trauma Healing</span>
                                        Stabilisasi & keamanan
                                    </button>
                                </h2>
                                <div id="qgCreateTraumaBody" class="accordion-collapse collapse" aria-labelledby="qgCreateTrauma" data-bs-parent="#quickGuideCreate">
                                    <div class="accordion-body small text-muted">
                                        Tujuan: rasa aman, regulasi emosi, ekspresi aman. 
                                        Catatan: hindari pemicu berat, siapkan rujukan.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="qgCreateResilience">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qgCreateResilienceBody" aria-expanded="false" aria-controls="qgCreateResilienceBody">
                                        <span class="badge bg-success me-2">Resiliensi</span>
                                        Tujuan & rencana aksi
                                    </button>
                                </h2>
                                <div id="qgCreateResilienceBody" class="accordion-collapse collapse" aria-labelledby="qgCreateResilience" data-bs-parent="#quickGuideCreate">
                                    <div class="accordion-body small text-muted">
                                        Tujuan: daya lenting, problem solving, goal setting. 
                                        Indikator: tujuan & langkah kerja disusun.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="qgCreateSocial">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qgCreateSocialBody" aria-expanded="false" aria-controls="qgCreateSocialBody">
                                        <span class="badge bg-info me-2">Sosial Emosional</span>
                                        Empati & komunikasi
                                    </button>
                                </h2>
                                <div id="qgCreateSocialBody" class="accordion-collapse collapse" aria-labelledby="qgCreateSocial" data-bs-parent="#quickGuideCreate">
                                    <div class="accordion-body small text-muted">
                                        Tujuan: empati, komunikasi asertif, regulasi emosi. 
                                        Indikator: mampu menyampaikan perasaan & bekerja sama.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-light border mb-3">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-magic me-2"></i>Template Cepat
                        </h6>
                        <p class="small text-muted mb-3">Klik untuk mengisi deskripsi sesuai kategori.</p>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-danger btn-sm js-template-btn" data-template="Tujuan: Membantu peserta mengenali pemicu stres dan membuat strategi coping harian.&#10;Langkah inti: edukasi singkat, latihan pernapasan 4-7-8, teknik relaksasi otot, refleksi pemicu.&#10;Metode: latihan terpandu, diskusi kelompok kecil, jurnal singkat.&#10;Indikator keberhasilan: peserta mampu menyebutkan 3 pemicu stres dan 2 strategi coping.&#10;Catatan keamanan: pastikan lingkungan tenang, beri opsi berhenti jika tidak nyaman.">Stres Manajemen</button>
                            <button type="button" class="btn btn-outline-warning btn-sm js-template-btn" data-template="Tujuan: Menciptakan rasa aman dan stabilisasi emosi sebelum pemrosesan trauma.&#10;Langkah inti: grounding 5-4-3-2-1, regulasi napas, kegiatan ekspresif aman (gambar/cerita), penutup dengan rencana dukungan.&#10;Metode: fasilitasi empatik, validasi emosi, aktivitas kreatif.&#10;Indikator keberhasilan: peserta menunjukkan penurunan ketegangan dan mampu menyebutkan strategi grounding.&#10;Catatan keamanan: hindari pemicu berat, siapkan rujukan profesional bila dibutuhkan.">Trauma Healing</button>
                            <button type="button" class="btn btn-outline-success btn-sm js-template-btn" data-template="Tujuan: Menguatkan daya lenting dan kemampuan bangkit dari kesulitan.&#10;Langkah inti: identifikasi kekuatan diri, latihan problem solving, goal setting mingguan.&#10;Metode: studi kasus, refleksi, peer support.&#10;Indikator keberhasilan: peserta menetapkan tujuan realistis dan rencana tindakan.&#10;Catatan keamanan: beri dukungan positif, hindari membandingkan antar peserta.">Resiliensi</button>
                            <button type="button" class="btn btn-outline-info btn-sm js-template-btn" data-template="Tujuan: Mengembangkan keterampilan sosial dan regulasi emosi.&#10;Langkah inti: role-play komunikasi asertif, latihan empati, manajemen konflik ringan.&#10;Metode: permainan peran, diskusi, feedback konstruktif.&#10;Indikator keberhasilan: peserta mampu menyampaikan perasaan dengan kata-kata dan mendengar aktif.&#10;Catatan keamanan: jaga suasana aman dan saling menghormati.">Sosial Emosional</button>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 mb-3">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-lightbulb me-2"></i>Tips Membuat Kegiatan
                        </h6>
                        <ul class="mb-0 small">
                            <li>Gunakan nama yang jelas dan mudah dipahami</li>
                            <li>Pilih kategori yang sesuai dengan tujuan kegiatan</li>
                            <li>Perkirakan durasi dengan realistis</li>
                            <li>Jelaskan manfaat kegiatan secara detail</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold mb-3">Kategori Kegiatan:</h6>
                        <div class="d-flex flex-column gap-2">
                            <div class="p-3 rounded border-start border-4 border-danger bg-danger bg-opacity-5">
                                <strong class="text-danger">Stres Manajemen</strong>
                                <p class="small mb-0 text-muted">Teknik dan strategi untuk mengelola stres</p>
                            </div>
                            <div class="p-3 rounded border-start border-4 border-warning bg-warning bg-opacity-5">
                                <strong class="text-warning">Trauma Healing</strong>
                                <p class="small mb-0 text-muted">Pemulihan dari pengalaman traumatis</p>
                            </div>
                            <div class="p-3 rounded border-start border-4 border-success bg-success bg-opacity-5">
                                <strong class="text-success">Resiliensi</strong>
                                <p class="small mb-0 text-muted">Membangun ketahanan mental dan emosional</p>
                            </div>
                            <div class="p-3 rounded border-start border-4 border-info bg-info bg-opacity-5">
                                <strong class="text-info">Sosial Emosional</strong>
                                <p class="small mb-0 text-muted">Pengembangan keterampilan sosial dan emosional</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Form validation
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
