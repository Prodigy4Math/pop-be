@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-user"></i> Profil Saya</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Nama</dt>
                        <dd class="col-sm-9">{{ auth('peserta')->user()->name }}</dd>

                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9">{{ auth('peserta')->user()->email }}</dd>

                        <dt class="col-sm-3">Umur</dt>
                        <dd class="col-sm-9">{{ auth('peserta')->user()->age }} tahun</dd>

                        <dt class="col-sm-3">Jenis Kelamin</dt>
                        <dd class="col-sm-9">{{ auth('peserta')->user()->gender }}</dd>

                        <dt class="col-sm-3">Sekolah</dt>
                        <dd class="col-sm-9">{{ auth('peserta')->user()->school ?? '-' }}</dd>

                        <dt class="col-sm-3">Nomor HP</dt>
                        <dd class="col-sm-9">{{ auth('peserta')->user()->phone ?? '-' }}</dd>

                        <dt class="col-sm-3">Nama Wali</dt>
                        <dd class="col-sm-9">{{ auth('peserta')->user()->guardian_name ?? '-' }}</dd>

                        <dt class="col-sm-3">HP Wali</dt>
                        <dd class="col-sm-9">{{ auth('peserta')->user()->guardian_phone ?? '-' }}</dd>

                        <dt class="col-sm-3">Bergabung</dt>
                        <dd class="col-sm-9">{{ auth('peserta')->user()->created_at->format('d-m-Y') }}</dd>
                    </dl>

                    <div class="mt-4">
                        <a href="{{ route('peserta.profile.edit') }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h5><i class="fas fa-award"></i> Statistik</h5>
                    <hr>
                    <p class="small">
                        <strong>Total Kehadiran:</strong> 
                        <span class="badge bg-primary">{{ auth('peserta')->user()->attendance()->count() }}</span>
                    </p>
                    <p class="small">
                        <strong>Badge Diterima:</strong>
                        <span class="badge bg-warning">{{ auth('peserta')->user()->badges()->count() }}</span>
                    </p>
                    <hr>
                    <div class="d-grid">
                        <a href="{{ route('peserta.barcode.show') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-id-card me-2"></i>Lihat Kartu Peserta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
