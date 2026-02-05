@extends('layouts.admin')

@section('page-title', 'Scan Kehadiran')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-lg-12">
            <h2 class="fw-bold text-dark">
                <i class="fas fa-qrcode me-2 text-primary"></i>Konfirmasi Kehadiran
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    @if($participant)
                        <div class="mb-3">
                            <div class="fw-semibold">{{ $participant->name }}</div>
                            <div class="text-muted">
                                Umur: {{ $participant->age ?? '-' }} tahun ·
                                Olahraga: {{ $participant->sportInterest?->name ?? '-' }}
                            </div>
                            <div class="text-muted">ID: {{ $participant->participant_code }}</div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            Data peserta tidak ditemukan dari QR. Pastikan QR valid.
                        </div>
                    @endif

                    <form action="{{ route('admin.attendance.scan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="payload" value="{{ $payload }}">

                        <div class="mb-3">
                            <label class="form-label">Jadwal Kebugaran</label>
                            <select name="fitness_schedule_id" class="form-select" required>
                                <option value="">Pilih Jadwal</option>
                                @foreach ($schedules as $schedule)
                                    <option value="{{ $schedule->id }}">
                                        {{ $schedule->sport->name }} - {{ $schedule->schedule_date }}
                                        ({{ $schedule->start_time }}-{{ $schedule->end_time }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="present">Hadir</option>
                                <option value="late">Terlambat</option>
                                <option value="absent">Tidak Hadir</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" @disabled(!$participant)>
                                <i class="fas fa-check me-2"></i>Hadir
                            </button>
                            <a href="{{ route('admin.attendance.record') }}" class="btn btn-secondary">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-info-circle me-2 text-info"></i>Petunjuk
                    </h5>
                    <ul class="text-muted small mb-0">
                        <li>Scan QR menggunakan kamera/scaner.</li>
                        <li>Halaman ini akan terbuka otomatis.</li>
                        <li>Pilih jadwal lalu klik Hadir.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
