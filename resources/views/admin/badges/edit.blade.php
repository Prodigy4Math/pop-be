@extends('layouts.admin')

@section('page-title', 'Edit Badge')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="mb-0"><i class="fas fa-medal"></i> Edit Badge</h2>
        <a href="{{ route('admin.badges.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.badges.update', $badge) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Badge</label>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $badge->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $badge->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label fw-semibold">Tipe</label>
                        <select name="type" id="type"
                                class="form-select @error('type') is-invalid @enderror" required>
                            @foreach(['kehadiran','kebugaran','psikososial','kesiapsiagaan'] as $type)
                                <option value="{{ $type }}" {{ old('type', $badge->type) === $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="requirement_count" class="form-label fw-semibold">Target (jumlah kegiatan)</label>
                        <input type="number" name="requirement_count" id="requirement_count" min="1"
                               class="form-control @error('requirement_count') is-invalid @enderror"
                               value="{{ old('requirement_count', $badge->requirement_count) }}" required>
                        @error('requirement_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="icon" class="form-label fw-semibold">Icon (FontAwesome class)</label>
                    <input type="text" name="icon" id="icon"
                           class="form-control @error('icon') is-invalid @enderror"
                           value="{{ old('icon', $badge->icon ?? 'fas fa-medal') }}">
                    <div class="form-text">Contoh: <code>fas fa-medal</code></div>
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
