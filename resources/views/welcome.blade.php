@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@300;400;600;700;800&display=swap');

    :root {
        --brand-blue: #1d6fe8;
        --brand-blue-dark: #0f3f8c;
        --brand-sky: #36a3ff;
        --brand-ink: #121826;
        --brand-sand: #f3f1ee;
        --brand-gray: #6b7280;
    }

    .landing {
        font-family: 'Manrope', sans-serif;
        color: var(--brand-ink);
        background: #f7f7f7;
    }

    .hero-banner {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at 20% 20%, rgba(0, 0, 0, 0.04) 0, rgba(0, 0, 0, 0.04) 2px, transparent 2px),
            radial-gradient(circle at 80% 10%, rgba(0, 0, 0, 0.04) 0, rgba(0, 0, 0, 0.04) 2px, transparent 2px),
            var(--brand-sand);
        background-size: 48px 48px;
        padding: 80px 0 60px;
    }

    .hero-banner::after {
        content: "";
        position: absolute;
        right: -120px;
        top: -80px;
        width: 520px;
        height: 520px;
        background: radial-gradient(circle at 30% 30%, #4fb2ff 0%, #1b7fe4 55%, #0c4aa4 100%);
        clip-path: polygon(40% 0, 100% 0, 100% 70%, 65% 100%, 20% 70%);
        opacity: 0.95;
    }

    .hero-banner::before {
        content: "";
        position: absolute;
        left: -120px;
        bottom: -140px;
        width: 360px;
        height: 360px;
        background: radial-gradient(circle at 60% 60%, #4fb2ff 0%, #1b7fe4 70%, #0c4aa4 100%);
        clip-path: polygon(0 15%, 55% 0, 100% 60%, 45% 100%, 0 70%);
        opacity: 0.75;
    }

    .hero-inner {
        position: relative;
        z-index: 2;
    }

    .logo-strip {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
    }

    .logo-img {
        max-height: 48px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 999px;
        padding: 8px 14px;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
    }

    .hero-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 4rem;
        letter-spacing: 1px;
        line-height: 0.95;
        margin-bottom: 12px;
        color: #0e0e0e;
        text-transform: uppercase;
    }

    .hero-subtitle {
        font-size: 1.05rem;
        color: #343a40;
        max-width: 640px;
        margin: 0 auto 16px;
        text-align: center;
        font-weight: 600;
    }

    .hero-campus {
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 1.1rem;
        margin-bottom: 24px;
    }

    .date-stack {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .date-card {
        background: linear-gradient(145deg, #2a86f3, #1a63c7);
        color: white;
        border-radius: 18px;
        padding: 18px;
        text-align: center;
        box-shadow: 0 12px 30px rgba(13, 78, 158, 0.3);
    }

    .date-card span {
        display: block;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .date-card strong {
        font-size: 2.6rem;
        line-height: 1;
    }

    .location-card {
        background: #0f65cf;
        color: white;
        border-radius: 18px;
        padding: 18px;
        margin-top: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        text-align: center;
    }

    .hero-cta {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 18px;
        flex-wrap: wrap;
    }

    .btn-hero {
        padding: 0.85rem 1.8rem;
        border-radius: 999px;
        font-weight: 700;
        text-decoration: none;
        border: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-hero-primary {
        background: #0f65cf;
        color: white;
        box-shadow: 0 12px 24px rgba(15, 101, 207, 0.25);
    }

    .btn-hero-secondary {
        background: white;
        color: #0f65cf;
        border: 2px solid #0f65cf;
    }

    .section {
        padding: 70px 0;
    }

    .section-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.4rem;
        letter-spacing: 1px;
        margin-bottom: 16px;
    }

    .card-clean {
        background: white;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        height: 100%;
    }

    .pill-tag {
        display: inline-block;
        background: #e8f1ff;
        color: #0f65cf;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 0.8rem;
        margin-bottom: 12px;
    }

    .timeline {
        border-left: 2px dashed #d1d5db;
        padding-left: 18px;
    }

    .timeline-item {
        margin-bottom: 18px;
    }

    .timeline-item h6 {
        font-weight: 800;
        margin-bottom: 6px;
    }

    .cta-band {
        background: linear-gradient(140deg, #0f65cf, #2f9bff);
        color: white;
        border-radius: 24px;
        padding: 36px;
    }

    .footer-note {
        color: var(--brand-gray);
        font-size: 0.9rem;
    }

    @media (max-width: 992px) {
        .hero-title {
            font-size: 3rem;
        }
        .date-stack {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.4rem;
        }
        .hero-subtitle {
            font-size: 0.95rem;
        }
    }
</style>

<div class="landing">
    <section class="hero-banner">
        <div class="container hero-inner text-center">
            <div class="logo-strip">
                <img class="logo-img" src="{{ asset('images/logos/IACBE-Member-with-Accredited-Programs-New-Logo-2024.png') }}" alt="IACBE">
                <img class="logo-img" src="{{ asset('images/logos/logo-bima-21.09.2022.11.56.32.png') }}" alt="BiMA">
                <img class="logo-img" src="{{ asset('images/logos/diktisaintek-berdampak.a30b8719.png') }}" alt="Diktisaintek Berdampak">
                <img class="logo-img" src="{{ asset('images/logos/unimal.png') }}" alt="Universitas Malikussaleh">
                <img class="logo-img" src="{{ asset('images/logos/Logo%20BLU%20Speed.png') }}" alt="BLU">
                <img class="logo-img" src="{{ asset('images/logos/tut-wuri-handayani-logo-with-white-text-png-b461.png') }}" alt="Kemendikbud">
            </div>

            <h1 class="hero-title">Program Mahasiswa Berdampak Pendanaan Diktisaintek</h1>
            <p class="hero-subtitle">
                Penguatan Kebugaran, Resiliensi Psikososial, dan Kesiapsiagaan Bencana melalui Program Pembinaan Olahraga
                bagi Anak–Remaja Pascabencana
            </p>
            <div class="hero-campus">Universitas Malikussaleh</div>

            <div class="row justify-content-center align-items-center g-4">
                <div class="col-lg-7">
                    <div class="card-clean text-start">
                        <div class="pill-tag">Program Inti</div>
                        <h3 class="section-title mb-2">Fokus Intervensi</h3>
                        <p class="text-muted mb-4">
                            Program terpadu untuk membangun kebugaran fisik, kesehatan mental, serta kesiapsiagaan bencana
                            dengan pendekatan latihan olahraga yang aman, adaptif, dan terukur.
                        </p>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card-clean">
                                    <div class="fw-bold mb-2"><i class="fas fa-dumbbell me-2 text-primary"></i>Kebugaran</div>
                                    <div class="text-muted small">Latihan terstruktur, monitoring progres.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-clean">
                                    <div class="fw-bold mb-2"><i class="fas fa-heart me-2 text-danger"></i>Psikososial</div>
                                    <div class="text-muted small">Pemulihan trauma, regulasi emosi.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-clean">
                                    <div class="fw-bold mb-2"><i class="fas fa-shield-alt me-2 text-success"></i>Kesiapsiagaan</div>
                                    <div class="text-muted small">Edukasi bencana dan simulasi aman.</div>
                                </div>
                            </div>
                        </div>

                        <div class="hero-cta">
                            <a href="{{ route('login') }}" class="btn-hero btn-hero-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Masuk
                            </a>
                            <a href="{{ route('register') }}" class="btn-hero btn-hero-secondary">
                                <i class="fas fa-user-plus me-2"></i>Daftar
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="date-stack">
                        <div class="date-card">
                            <strong>28</strong>
                            <span>Januari</span>
                            <span>2026</span>
                        </div>
                        <div class="date-card">
                            <strong>28</strong>
                            <span>Februari</span>
                            <span>2026</span>
                        </div>
                    </div>
                    <div class="location-card mt-3">
                        Desa Jongok Meluem<br>
                        Kebayakan, Aceh Tengah
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-6">
                    <div class="card-clean h-100">
                        <div class="pill-tag">Tentang Program</div>
                        <h3 class="section-title">Menguatkan Anak–Remaja Pascabencana</h3>
                        <p class="text-muted">
                            Program ini menekankan pendampingan berkelanjutan melalui pelatihan olahraga, pemulihan psikososial,
                            dan edukasi kesiapsiagaan bencana. Setiap peserta mendapat modul, pendampingan, dan pelaporan progres.
                        </p>
                        <div class="timeline">
                            <div class="timeline-item">
                                <h6>Fase 1: Pemetaan & Rekrutmen</h6>
                                <div class="text-muted small">Identifikasi kebutuhan, pendaftaran peserta, dan baseline.</div>
                            </div>
                            <div class="timeline-item">
                                <h6>Fase 2: Intervensi Terstruktur</h6>
                                <div class="text-muted small">Latihan kebugaran, resiliensi, dan edukasi kebencanaan.</div>
                            </div>
                            <div class="timeline-item">
                                <h6>Fase 3: Evaluasi & Apresiasi</h6>
                                <div class="text-muted small">Pengukuran hasil, umpan balik, dan sertifikasi capaian.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-clean h-100">
                        <div class="pill-tag">Layanan Utama</div>
                        <h3 class="section-title">Fitur Landing Page</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card-clean">
                                    <div class="fw-bold mb-2"><i class="fas fa-calendar-check me-2 text-primary"></i>Jadwal Terbuka</div>
                                    <div class="text-muted small">Akses jadwal dan lokasi kegiatan terbaru.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-clean">
                                    <div class="fw-bold mb-2"><i class="fas fa-user-shield me-2 text-success"></i>Registrasi Aman</div>
                                    <div class="text-muted small">Form pendaftaran peserta dan wali.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-clean">
                                    <div class="fw-bold mb-2"><i class="fas fa-chart-line me-2 text-info"></i>Laporan Progres</div>
                                    <div class="text-muted small">Dashboard ringkas capaian program.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-clean">
                                    <div class="fw-bold mb-2"><i class="fas fa-id-card me-2 text-warning"></i>Kartu Peserta</div>
                                    <div class="text-muted small">QR code untuk kehadiran cepat.</div>
                                </div>
                            </div>
                        </div>
                        <div class="cta-band mt-4">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <div class="fw-bold fs-5">Siap bergabung?</div>
                                    <div class="small">Daftarkan peserta dan pantau kegiatan dengan mudah.</div>
                                </div>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('register') }}" class="btn btn-light btn-sm px-3">
                                        Daftar Peserta
                                    </a>
                                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-3">
                                        Masuk Admin
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="footer-note mt-3">
                            Info resmi:
                            <a href="https://www.instagram.com/gerakuntukpulih.id?igsh=MWh4eGhicnJhdnQ3cw==" target="_blank" rel="noopener noreferrer">
                                <strong>@gerakuntukpulih.id</strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
