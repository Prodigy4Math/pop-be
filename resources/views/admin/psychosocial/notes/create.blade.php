@extends('layouts.admin')

@section('page-title', 'Tambah Catatan Psikososial')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold text-dark mb-2">
                        <i class="fas fa-plus-circle me-2 text-info"></i>Tambah Catatan Psikososial
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.psychosocial.notes.index') }}">Catatan Psikososial</a></li>
                            <li class="breadcrumb-item active">Tambah Baru</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.psychosocial.notes.index') }}" class="btn btn-outline-secondary">
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
                        <i class="fas fa-edit me-2 text-info"></i>Form Catatan Psikososial
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.psychosocial.notes.store') }}" method="POST" id="noteForm">
                        @csrf
                        
                        <!-- Peserta -->
                        <div class="mb-4">
                            <label for="user_id" class="form-label fw-bold">
                                Peserta <span class="text-danger">*</span>
                            </label>
                            <select name="user_id" 
                                    id="user_id"
                                    class="form-select form-select-lg @error('user_id') is-invalid @enderror" 
                                    required>
                                <option value="">-- Pilih Peserta --</option>
                                @foreach ($peserta as $p)
                                    <option value="{{ $p->id }}" {{ old('user_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }} ({{ $p->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kegiatan Psikososial -->
                        <div class="mb-4">
                            <label for="psychosocial_activity_id" class="form-label fw-bold">
                                Kegiatan Psikososial <span class="text-danger">*</span>
                            </label>
                            <select name="psychosocial_activity_id" 
                                    id="psychosocial_activity_id"
                                    class="form-select form-select-lg @error('psychosocial_activity_id') is-invalid @enderror" 
                                    required>
                                <option value="">-- Pilih Kegiatan --</option>
                                @foreach ($activities as $activity)
                                    <option value="{{ $activity->id }}" {{ old('psychosocial_activity_id') == $activity->id ? 'selected' : '' }}>
                                        {{ $activity->name }} 
                                        <small class="text-muted">({{ $activity->category }})</small>
                                    </option>
                                @endforeach
                            </select>
                            @error('psychosocial_activity_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Hanya kegiatan yang aktif yang ditampilkan</small>
                        </div>

                        <!-- Skor Resiliensi -->
                        <div class="mb-4">
                            <label for="resilience_score" class="form-label fw-bold">
                                Skor Resiliensi (1-10) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-chart-line text-primary"></i>
                                </span>
                                <input type="number" 
                                       name="resilience_score" 
                                       id="resilience_score"
                                       class="form-control @error('resilience_score') is-invalid @enderror" 
                                       value="{{ old('resilience_score') }}" 
                                       min="1" 
                                       max="10" 
                                       required>
                                <span class="input-group-text bg-light">/ 10</span>
                            </div>
                            @error('resilience_score')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar" id="scoreBar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted">
                                    <span id="scoreLabel">Pilih skor untuk melihat indikator</span>
                                </small>
                            </div>
                        </div>

                        <!-- Mood -->
                        <div class="mb-4">
                            <label for="mood" class="form-label fw-bold">
                                Mood / Kondisi Emosional <span class="text-danger">*</span>
                            </label>
                            <select name="mood" 
                                    id="mood"
                                    class="form-select form-select-lg @error('mood') is-invalid @enderror" 
                                    required>
                                <option value="">-- Pilih Mood --</option>
                                <option value="Sangat Baik" {{ old('mood') === 'Sangat Baik' ? 'selected' : '' }}>
                                    😊 Sangat Baik
                                </option>
                                <option value="Baik" {{ old('mood') === 'Baik' ? 'selected' : '' }}>
                                    🙂 Baik
                                </option>
                                <option value="Normal" {{ old('mood') === 'Normal' ? 'selected' : '' }}>
                                    😐 Normal
                                </option>
                                <option value="Sedih" {{ old('mood') === 'Sedih' ? 'selected' : '' }}>
                                    😔 Sedih
                                </option>
                                <option value="Sangat Sedih" {{ old('mood') === 'Sangat Sedih' ? 'selected' : '' }}>
                                    😢 Sangat Sedih
                                </option>
                            </select>
                            @error('mood')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold">
                                Catatan Observasi <span class="text-danger">*</span>
                            </label>
                            <textarea name="notes" 
                                      id="notes"
                                      class="form-control @error('notes') is-invalid @enderror" 
                                      rows="6" 
                                      placeholder="Tuliskan observasi, perkembangan, atau catatan penting tentang peserta..."
                                      required>{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Jelaskan kondisi, perkembangan, atau hal penting yang perlu dicatat</small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 pt-3 border-top">
                            <button type="submit" class="btn btn-info btn-lg px-5">
                                <i class="fas fa-save me-2"></i>Simpan Catatan
                            </button>
                            <a href="{{ route('admin.psychosocial.notes.index') }}" class="btn btn-outline-secondary btn-lg px-4">
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
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2"></i>Panduan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0 mb-3">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-lightbulb me-2"></i>Tips Membuat Catatan
                        </h6>
                        <ul class="mb-0 small">
                            <li>Pilih peserta yang tepat</li>
                            <li>Pilih kegiatan yang relevan</li>
                            <li>Berikan skor resiliensi yang objektif</li>
                            <li>Tulis catatan yang jelas dan detail</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold mb-3">Skor Resiliensi:</h6>
                        <div class="d-flex flex-column gap-2">
                            <div class="p-3 rounded border-start border-4 border-danger bg-danger bg-opacity-5">
                                <strong class="text-danger">1-3: Sangat Rendah</strong>
                                <p class="small mb-0 text-muted">Perlu perhatian khusus dan intervensi intensif</p>
                            </div>
                            <div class="p-3 rounded border-start border-4 border-warning bg-warning bg-opacity-5">
                                <strong class="text-warning">4-6: Sedang</strong>
                                <p class="small mb-0 text-muted">Perlu dukungan dan monitoring rutin</p>
                            </div>
                            <div class="p-3 rounded border-start border-4 border-success bg-success bg-opacity-5">
                                <strong class="text-success">7-10: Tinggi</strong>
                                <p class="small mb-0 text-muted">Kondisi baik, tetap perlu dukungan</p>
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
    // Score bar update
    const scoreInput = document.getElementById('resilience_score');
    const scoreBar = document.getElementById('scoreBar');
    const scoreLabel = document.getElementById('scoreLabel');
    
    function updateScoreBar() {
        const score = parseInt(scoreInput.value) || 0;
        const percentage = (score / 10) * 100;
        
        scoreBar.style.width = percentage + '%';
        scoreBar.setAttribute('aria-valuenow', score);
        
        if (score >= 1 && score <= 10) {
            let label = '';
            let color = '';
            if (score >= 7) {
                label = 'Tinggi - Kondisi baik';
                color = 'bg-success';
            } else if (score >= 4) {
                label = 'Sedang - Perlu monitoring';
                color = 'bg-warning';
            } else {
                label = 'Rendah - Perlu perhatian khusus';
                color = 'bg-danger';
            }
            scoreBar.className = 'progress-bar ' + color;
            scoreLabel.textContent = label;
        } else {
            scoreLabel.textContent = 'Pilih skor untuk melihat indikator';
        }
    }
    
    scoreInput.addEventListener('input', updateScoreBar);
    updateScoreBar();
</script>
@endpush
@endsection
