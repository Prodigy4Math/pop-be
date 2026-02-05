@extends('layouts.admin')

@section('page-title', 'Buat Jadwal Latihan')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h2 class="fw-bold text-dark">
                <i class="fas fa-calendar-plus me-2 text-info"></i>Buat Jadwal Latihan
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.fitness.schedules.store') }}" method="POST">
                        @csrf

                        <!-- Pilih Olahraga -->
                        <div class="mb-3">
                            <label for="sport_id" class="form-label fw-bold">Olahraga</label>
                            <select class="form-select @error('sport_id') is-invalid @enderror" 
                                    id="sport_id" name="sport_id" required>
                                <option value="">Pilih Olahraga</option>
                                @foreach($sports as $sport)
                                    <option value="{{ $sport->id }}" {{ old('sport_id') == $sport->id ? 'selected' : '' }}>
                                        {{ $sport->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sport_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label for="schedule_date" class="form-label fw-bold">Tanggal</label>
                            <input type="date" class="form-control @error('schedule_date') is-invalid @enderror" 
                                   id="schedule_date" name="schedule_date" value="{{ old('schedule_date') }}" required>
                            @error('schedule_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Waktu Mulai -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label fw-bold">Waktu Mulai</label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                       id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Waktu Selesai -->
                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label fw-bold">Waktu Selesai</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                       id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="mb-3">
                            <label for="location" class="form-label fw-bold">Lokasi</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location') }}"
                                   placeholder="Contoh: Lapangan Sekolah, Gym Utama">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Max Peserta -->
                        <div class="mb-3">
                            <label for="max_participants" class="form-label fw-bold">Kuota Peserta</label>
                            <input type="number" class="form-control @error('max_participants') is-invalid @enderror" 
                                   id="max_participants" name="max_participants" value="{{ old('max_participants') }}" 
                                   min="1" required>
                            @error('max_participants')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Deskripsi (Opsional)</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-3">
                            <label for="is_active" class="form-label fw-bold">Status</label>
                            <select class="form-select @error('is_active') is-invalid @enderror" 
                                    id="is_active" name="is_active" required>
                                <option value="1" selected>Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="{{ route('admin.fitness.schedules.index') }}" class="btn btn-secondary">
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
                            <p><strong>Olahraga:</strong> Pilih jenis olahraga dari daftar yang sudah ada</p>
                            <p><strong>Tanggal & Waktu:</strong> Pastikan tidak bentrok dengan jadwal lain</p>
                            <p><strong>Lokasi:</strong> Jelaskan lokasi dengan detail</p>
                            <p><strong>Kuota:</strong> Jumlah peserta maksimal yang dapat hadir</p>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
