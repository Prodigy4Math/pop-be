@extends('layouts.admin')

@section('page-title', 'Edit Jadwal')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.landing.schedules.update', $schedule) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold">Cabang Olahraga</label>
                    <select name="sport_id" class="form-select @error('sport_id') is-invalid @enderror" required>
                        @foreach($sports as $sport)
                            <option value="{{ $sport->id }}" {{ old('sport_id', $schedule->sport_id) == $sport->id ? 'selected' : '' }}>{{ $sport->name }}</option>
                        @endforeach
                    </select>
                    @error('sport_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tim/Tujuan Utama</label>
                        <input type="text" name="team_home" class="form-control @error('team_home') is-invalid @enderror" value="{{ old('team_home', $schedule->team_home) }}">
                        @error('team_home')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tim Lawan</label>
                        <input type="text" name="team_away" class="form-control @error('team_away') is-invalid @enderror" value="{{ old('team_away', $schedule->team_away) }}">
                        @error('team_away')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul (Opsional)</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $schedule->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal & Waktu</label>
                        <input type="datetime-local" name="match_date" class="form-control @error('match_date') is-invalid @enderror"
                               value="{{ old('match_date', $schedule->match_date->format('Y-m-d\\TH:i')) }}" required>
                        @error('match_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Lokasi</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $schedule->location) }}">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="scheduled" @selected(old('status', $schedule->status) === 'scheduled')>Scheduled</option>
                            <option value="live" @selected(old('status', $schedule->status) === 'live')>Live</option>
                            <option value="finished" @selected(old('status', $schedule->status) === 'finished')>Finished</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Skor Home</label>
                        <input type="number" name="score_home" class="form-control @error('score_home') is-invalid @enderror" value="{{ old('score_home', $schedule->score_home) }}" min="0">
                        @error('score_home')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Skor Away</label>
                        <input type="number" name="score_away" class="form-control @error('score_away') is-invalid @enderror" value="{{ old('score_away', $schedule->score_away) }}" min="0">
                        @error('score_away')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $schedule->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">Tampilkan sebagai highlight</label>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.landing.schedules.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
