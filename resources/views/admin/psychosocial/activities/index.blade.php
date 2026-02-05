@extends('layouts.admin')

@section('page-title', 'Kegiatan Psikososial')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="fw-bold text-dark mb-2">
                        <i class="fas fa-heartbeat me-2 text-primary"></i>Manajemen Kegiatan Psikososial
                    </h2>
                    <p class="text-muted mb-0">Kelola kegiatan psikososial untuk mendukung kesejahteraan mental peserta</p>
                </div>
                <a href="{{ route('admin.psychosocial.activities.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Kegiatan Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-tasks text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Total Kegiatan</h6>
                            <h3 class="mb-0 fw-bold">{{ $activities->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Aktif</h6>
                            <h3 class="mb-0 fw-bold">{{ $activities->where('is_active', true)->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-clock text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Rata-rata Durasi</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($activities->avg('duration_minutes') ?? 0, 0) }} min</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-layer-group text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Kategori</h6>
                            <h3 class="mb-0 fw-bold">{{ $activities->pluck('category')->unique()->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activities Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2 text-primary"></i>Daftar Kegiatan
                </h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.psychosocial.notes.index') }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-sticky-note me-1"></i>Lihat Catatan
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($activities->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nama Kegiatan</th>
                                <th>Kategori</th>
                                <th>Durasi</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                                <i class="fas fa-heart text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0 fw-bold">{{ $activity->name }}</h6>
                                            <small class="text-muted">ID: {{ $activity->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2
                                        @if($activity->category === 'Stres Manajemen') bg-danger bg-opacity-10 text-danger
                                        @elseif($activity->category === 'Trauma Healing') bg-warning bg-opacity-10 text-warning
                                        @elseif($activity->category === 'Resiliensi') bg-success bg-opacity-10 text-success
                                        @else bg-info bg-opacity-10 text-info
                                        @endif">
                                        <i class="fas fa-tag me-1"></i>{{ $activity->category }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock text-muted me-2"></i>
                                        <span class="fw-semibold">{{ $activity->duration_minutes }} menit</span>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 text-muted" style="max-width: 300px;">
                                        {{ Str::limit($activity->description, 80) }}
                                    </p>
                                </td>
                                <td>
                                    @if ($activity->is_active)
                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">
                                            <i class="fas fa-times-circle me-1"></i>Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.psychosocial.activities.edit', $activity) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.psychosocial.activities.destroy', $activity) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-inbox" style="font-size: 4rem; color: #dee2e6;"></i>
                    </div>
                    <h5 class="text-muted mb-2">Belum ada kegiatan psikososial</h5>
                    <p class="text-muted mb-4">Mulai dengan menambahkan kegiatan psikososial pertama Anda</p>
                    <a href="{{ route('admin.psychosocial.activities.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Kegiatan Pertama
                    </a>
                </div>
            @endif
        </div>
        @if($activities->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-center">
                {{ $activities->links() }}
            </div>
        </div>
        @endif
    </div>

    <!-- Panduan Lengkap Psikososial -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-clipboard-list me-2 text-primary"></i>Panduan Lengkap Kategori Kegiatan
                </h5>
                <small class="text-muted">Rangkuman standar isi, alur, dan keamanan untuk setiap kategori</small>
            </div>
        </div>
        <div class="card-body">
            <div class="accordion" id="psychosocialGuide">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingStress">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStress" aria-expanded="true" aria-controls="collapseStress">
                            <span class="badge bg-danger me-3">Stres Manajemen</span>
                            Tujuan, alur, dan indikator keberhasilan
                        </button>
                    </h2>
                    <div id="collapseStress" class="accordion-collapse collapse show" aria-labelledby="headingStress" data-bs-parent="#psychosocialGuide">
                        <div class="accordion-body">
                            <div class="row g-3">
                                <div class="col-lg-4">
                                    <h6 class="fw-bold text-danger mb-2">Tujuan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Mengidentifikasi pemicu stres utama</li>
                                        <li>Menguasai teknik relaksasi sederhana</li>
                                        <li>Membangun rutinitas coping harian</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="fw-bold text-danger mb-2">Alur Kegiatan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Pembukaan & asesmen ringan (5–10 mnt)</li>
                                        <li>Latihan napas/relaksasi (10–15 mnt)</li>
                                        <li>Diskusi pemicu & strategi (15–20 mnt)</li>
                                        <li>Rencana coping pribadi (10 mnt)</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="fw-bold text-danger mb-2">Contoh Aktivitas</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Napas 4-7-8 & grounding</li>
                                        <li>Relaksasi otot progresif</li>
                                        <li>Jurnal pemicu stres</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="fw-bold text-danger mb-2 mt-3">Indikator Keberhasilan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Peserta dapat menyebutkan 3 pemicu stres</li>
                                        <li>Peserta mampu menerapkan 2 strategi coping</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="fw-bold text-danger mb-2 mt-3">Catatan Keamanan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Jaga suasana tenang & tidak menghakimi</li>
                                        <li>Berikan opsi berhenti kapan pun</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTrauma">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTrauma" aria-expanded="false" aria-controls="collapseTrauma">
                            <span class="badge bg-warning text-dark me-3">Trauma Healing</span>
                            Stabilisasi, regulasi, dan rujukan aman
                        </button>
                    </h2>
                    <div id="collapseTrauma" class="accordion-collapse collapse" aria-labelledby="headingTrauma" data-bs-parent="#psychosocialGuide">
                        <div class="accordion-body">
                            <div class="row g-3">
                                <div class="col-lg-4">
                                    <h6 class="fw-bold text-warning mb-2">Tujuan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Membangun rasa aman & stabilisasi emosi</li>
                                        <li>Melatih regulasi diri</li>
                                        <li>Mendorong ekspresi aman</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="fw-bold text-warning mb-2">Alur Kegiatan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Check-in & kesepakatan aman (5–10 mnt)</li>
                                        <li>Grounding & regulasi napas (10–15 mnt)</li>
                                        <li>Aktivitas ekspresif (15–25 mnt)</li>
                                        <li>Penutup & dukungan lanjutan (10 mnt)</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="fw-bold text-warning mb-2">Contoh Aktivitas</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Grounding 5-4-3-2-1</li>
                                        <li>Body scan ringan</li>
                                        <li>Ekspresi kreatif (gambar/cerita)</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="fw-bold text-warning mb-2 mt-3">Indikator Keberhasilan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Penurunan ketegangan setelah sesi</li>
                                        <li>Peserta mampu memakai teknik grounding</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="fw-bold text-warning mb-2 mt-3">Catatan Keamanan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Hindari detail traumatik sebagai pemicu</li>
                                        <li>Siapkan jalur rujukan profesional</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingResilience">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseResilience" aria-expanded="false" aria-controls="collapseResilience">
                            <span class="badge bg-success me-3">Resiliensi</span>
                            Ketahanan mental, tujuan, dan rencana aksi
                        </button>
                    </h2>
                    <div id="collapseResilience" class="accordion-collapse collapse" aria-labelledby="headingResilience" data-bs-parent="#psychosocialGuide">
                        <div class="accordion-body">
                            <div class="row g-3">
                                <div class="col-lg-4">
                                    <h6 class="fw-bold text-success mb-2">Tujuan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Memperkuat daya lenting</li>
                                        <li>Mengasah problem solving</li>
                                        <li>Menetapkan tujuan realistis</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="fw-bold text-success mb-2">Alur Kegiatan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Refleksi kekuatan diri (10 mnt)</li>
                                        <li>Studi kasus & solusi (15–20 mnt)</li>
                                        <li>Goal setting mingguan (10–15 mnt)</li>
                                        <li>Komitmen tindak lanjut (5 mnt)</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="fw-bold text-success mb-2">Contoh Aktivitas</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Latihan “kekuatan diri”</li>
                                        <li>Problem solving berkelompok</li>
                                        <li>Jurnal kemajuan</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="fw-bold text-success mb-2 mt-3">Indikator Keberhasilan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Peserta menyusun tujuan & langkah kerja</li>
                                        <li>Peserta mengenali dukungan yang dibutuhkan</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="fw-bold text-success mb-2 mt-3">Catatan Keamanan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Hindari perbandingan antar peserta</li>
                                        <li>Fokus pada progres, bukan kesempurnaan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSocial">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSocial" aria-expanded="false" aria-controls="collapseSocial">
                            <span class="badge bg-info me-3">Sosial Emosional</span>
                            Empati, komunikasi, dan kerja sama
                        </button>
                    </h2>
                    <div id="collapseSocial" class="accordion-collapse collapse" aria-labelledby="headingSocial" data-bs-parent="#psychosocialGuide">
                        <div class="accordion-body">
                            <div class="row g-3">
                                <div class="col-lg-4">
                                    <h6 class="fw-bold text-info mb-2">Tujuan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Meningkatkan empati dan komunikasi</li>
                                        <li>Menguatkan regulasi emosi</li>
                                        <li>Mendorong dukungan sosial</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="fw-bold text-info mb-2">Alur Kegiatan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Pemanasan & ice breaking (5–10 mnt)</li>
                                        <li>Role-play komunikasi (15–20 mnt)</li>
                                        <li>Refleksi emosi (10–15 mnt)</li>
                                        <li>Umpan balik & penutup (5–10 mnt)</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="fw-bold text-info mb-2">Contoh Aktivitas</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Latihan mendengar aktif</li>
                                        <li>Permainan kerja tim</li>
                                        <li>Kartu emosi & refleksi</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="fw-bold text-info mb-2 mt-3">Indikator Keberhasilan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Peserta menyampaikan perasaan dengan kata-kata</li>
                                        <li>Kerja sama kelompok meningkat</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="fw-bold text-info mb-2 mt-3">Catatan Keamanan</h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Pastikan aturan saling menghormati</li>
                                        <li>Fasilitator menjaga konflik tetap ringan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
