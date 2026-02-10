@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-quiz"></i> Kuis Kesiapsiagaan Bencana</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('peserta.disaster.quiz.submit') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <h5>Pertanyaan 1: Apa yang harus dilakukan saat terjadi gempa bumi?</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="q1" id="q1a" value="a">
                        <label class="form-check-label" for="q1a">
                            Keluar rumah dengan cepat
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="q1" id="q1b" value="b" checked>
                        <label class="form-check-label" for="q1b">
                            Berlindung di bawah meja atau tempat kuat
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="q1" id="q1c" value="c">
                        <label class="form-check-label" for="q1c">
                            Naik ke lantai atas
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <h5>Pertanyaan 2: Berapa lama sebaiknya latihan simulasi bencana dilakukan?</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="q2" id="q2a" value="a">
                        <label class="form-check-label" for="q2a">
                            1 bulan sekali
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="q2" id="q2b" value="b" checked>
                        <label class="form-check-label" for="q2b">
                            3-6 bulan sekali
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="q2" id="q2c" value="c">
                        <label class="form-check-label" for="q2c">
                            1 tahun sekali
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <h5>Pertanyaan 3: Apa yang harus disiapkan untuk menghadapi bencana?</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="q3[]" id="q3a" value="a">
                        <label class="form-check-label" for="q3a">
                            Tas darurat dengan dokumen penting
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="q3[]" id="q3b" value="b">
                        <label class="form-check-label" for="q3b">
                            Air minum dan makanan cadangan
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="q3[]" id="q3c" value="c">
                        <label class="form-check-label" for="q3c">
                            P3K dan obat-obatan
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Kirim Jawaban
                    </button>
                    <a href="{{ route('peserta.disaster.materials') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
