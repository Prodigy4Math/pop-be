@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1"><i class="fas fa-trophy me-2 text-warning"></i>Tambah Prestasi</h3>
                        <p class="text-muted mb-0">Lengkapi data untuk dikirim ke admin.</p>
                    </div>
                    <a href="{{ route('peserta.achievements.index') }}" class="btn btn-outline-secondary mt-3 mt-lg-0">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('peserta.achievements.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kategori</label>
                                <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="prestasi" {{ old('category') === 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                                    <option value="proposal" {{ old('category') === 'proposal' ? 'selected' : '' }}>Proposal</option>
                                </select>
                                @error('category')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal</label>
                                <input type="date" name="event_date" class="form-control @error('event_date') is-invalid @enderror" value="{{ old('event_date') }}" required>
                                @error('event_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Lampiran (PDF/JPG/PNG, max 2MB)</label>
                            <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror">
                            @error('attachment')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2 text-info"></i>Catatan</h6>
                </div>
                <div class="card-body">
                    <ul class="small text-muted mb-0">
                        <li>Pastikan data sesuai dengan kegiatan olahraga.</li>
                        <li>Admin akan memverifikasi dan memberi status.</li>
                        <li>Lampiran bersifat opsional.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
