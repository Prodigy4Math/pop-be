@extends('layouts.admin')

@section('page-title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="fw-bold mb-2">
                                <i class="fas fa-shield-alt me-3"></i>Dashboard Admin
                            </h1>
                            <p class="mb-0 opacity-90">Selamat datang, {{ Auth::guard('admin')->user()->name }}! Pantau semua aktivitas dan progress program.</p>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-black bg-opacity-20 px-3 py-2">
                                <i class="fas fa-calendar me-2"></i>{{ now()->format('d F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card primary">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">Total Peserta</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalUsers ?? 0 }}</h2>
                        <small class="text-success">
                            <i class="fas fa-check-circle"></i> {{ $activeUsers ?? 0 }} aktif
                        </small>
                        @if($newUsersThisMonth > 0)
                        <div class="mt-1">
                            <small class="text-info">
                                <i class="fas fa-user-plus"></i> +{{ $newUsersThisMonth }} bulan ini
                            </small>
                        </div>
                        @endif
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-users text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">Kehadiran</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalAttendance ?? 0 }}</h2>
                        <small class="text-success">
                            <i class="fas fa-percentage"></i> {{ $averageAttendance ?? 0 }}% hadir
                        </small>
                        <div class="mt-1">
                            <small class="text-info">
                                <i class="fas fa-calendar-week"></i> {{ $weeklyAttendance ?? 0 }} minggu ini
                            </small>
                        </div>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-clipboard-check text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card info">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">Skor Resiliensi</h6>
                        <h2 class="mb-0 fw-bold">{{ number_format($averageResilience ?? 0, 1) }}/10</h2>
                        <small class="text-info">
                            <i class="fas fa-chart-line"></i> {{ $totalNotes ?? 0 }} catatan
                        </small>
                        <div class="mt-1">
                            <small class="text-primary">
                                <i class="fas fa-calendar-week"></i> {{ $weeklyNotes ?? 0 }} minggu ini
                            </small>
                        </div>
                    </div>
                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-heartbeat text-info fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card warning">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">Aktivitas</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalActivities ?? 0 }}</h2>
                        <small class="text-success">
                            <i class="fas fa-check"></i> {{ $activeActivities ?? 0 }} aktif
                        </small>
                        <div class="mt-1">
                            <small class="text-muted">
                                <i class="fas fa-dumbbell"></i> {{ $totalSports ?? 0 }} olahraga
                            </small>
                        </div>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-tasks text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Charts Section -->
        <div class="col-lg-8">
            <!-- Monthly Trends Chart -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-chart-line me-2 text-primary"></i>Trend 6 Bulan Terakhir
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyTrendChart" height="80"></canvas>
                </div>
            </div>

            <!-- Distribution Charts -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="mb-0 fw-bold">Distribusi Status Kehadiran</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="attendanceStatusChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="mb-0 fw-bold">Distribusi Skor Resiliensi</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="resilienceChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="mb-0 fw-bold">Distribusi Mood</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="moodChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="col-lg-4">
            <!-- Barcode Requests -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-id-card me-2 text-primary"></i>Permintaan Kartu Peserta
                    </h6>
                </div>
                <div class="card-body p-0">
                    @forelse($barcodeRequests ?? [] as $request)
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-bold">{{ $request->title }}</h6>
                                <small class="text-muted d-block">{{ $request->message }}</small>
                                @if($request->related_id)
                                    <a href="{{ route('admin.peserta.show', $request->related_id) }}" class="btn btn-sm btn-outline-primary mt-2">
                                        Lihat Peserta
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-3 text-center text-muted">
                        <i class="fas fa-inbox fs-3 mb-2"></i>
                        <p class="mb-0 small">Belum ada permintaan kartu</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming Schedules -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-calendar-alt me-2 text-info"></i>Jadwal Mendatang (7 Hari)
                    </h6>
                </div>
                <div class="card-body p-0">
                    @forelse($upcomingSchedules ?? [] as $schedule)
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-info bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-dumbbell text-info"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-bold">{{ $schedule->sport->name ?? '-' }}</h6>
                                <small class="text-muted d-block">
                                    <i class="fas fa-calendar me-1"></i>{{ $schedule->schedule_date->format('d M Y') }}
                                </small>
                                <small class="text-muted d-block">
                                    <i class="fas fa-clock me-1"></i>{{ $schedule->start_time }} - {{ $schedule->end_time }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-3 text-center text-muted">
                        <i class="fas fa-calendar-times fs-3 mb-2"></i>
                        <p class="mb-0 small">Tidak ada jadwal mendatang</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Attendance -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-clipboard-check me-2 text-success"></i>Kehadiran Terbaru
                    </h6>
                </div>
                <div class="card-body p-0">
                    @forelse($recentAttendance ?? [] as $attendance)
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'late' ? 'warning' : 'danger') }} bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-{{ $attendance->status === 'present' ? 'check' : ($attendance->status === 'late' ? 'clock' : 'times') }} text-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'late' ? 'warning' : 'danger') }}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-bold">{{ $attendance->user->name ?? '-' }}</h6>
                                <small class="text-muted d-block">{{ $attendance->schedule->sport->name ?? '-' }}</small>
                                <small class="text-muted">{{ $attendance->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-3 text-center text-muted">
                        <i class="fas fa-inbox fs-3 mb-2"></i>
                        <p class="mb-0 small">Belum ada data kehadiran</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Psychosocial Activities -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-heartbeat me-2 text-primary"></i>Kegiatan Psikososial Terbaru
                    </h6>
                </div>
                <div class="card-body p-0">
                    @forelse($recentActivities ?? [] as $activity)
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-heart text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-bold">{{ $activity->name }}</h6>
                                <small class="text-muted">{{ $activity->category ?? '-' }}</small>
                                <div class="mt-1">
                                    @if($activity->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-3 text-center text-muted">
                        <i class="fas fa-inbox fs-3 mb-2"></i>
                        <p class="mb-0 small">Belum ada kegiatan</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Notes -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-sticky-note me-2 text-primary"></i>Catatan Terbaru
                    </h6>
                </div>
                <div class="card-body p-0">
                    @forelse($recentNotes ?? [] as $note)
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-bold">{{ $note->user->name ?? '-' }}</h6>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="badge bg-{{ $note->resilience_score >= 7 ? 'success' : ($note->resilience_score >= 4 ? 'warning' : 'danger') }}">
                                        Skor: {{ $note->resilience_score }}/10
                                    </span>
                                </div>
                                <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-3 text-center text-muted">
                        <i class="fas fa-inbox fs-3 mb-2"></i>
                        <p class="mb-0 small">Belum ada catatan</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Top Participants -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-trophy me-2 text-warning"></i>Peserta Teraktif
                    </h6>
                </div>
                <div class="card-body p-0">
                    @forelse($topParticipants ?? [] as $index => $participant)
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <span class="fw-bold text-warning">#{{ $index + 1 }}</span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 fw-bold">{{ $participant->name }}</h6>
                                <small class="text-muted">{{ $participant->psychosocial_notes_count ?? 0 }} catatan</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-3 text-center text-muted">
                        <i class="fas fa-inbox fs-3 mb-2"></i>
                        <p class="mb-0 small">Belum ada data</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Monthly Trend Chart
    const monthlyCtx = document.getElementById('monthlyTrendChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyAttendance->pluck('month')) !!},
            datasets: [{
                label: 'Kehadiran',
                data: {!! json_encode($monthlyAttendance->pluck('count')) !!},
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y'
            }, {
                label: 'Rata-rata Skor Resiliensi',
                data: {!! json_encode($monthlyResilience->pluck('avg_score')) !!},
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Kehadiran'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    max: 10,
                    title: {
                        display: true,
                        text: 'Skor Resiliensi'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });

    // Attendance Status Chart
    const attendanceCtx = document.getElementById('attendanceStatusChart').getContext('2d');
    const attendanceData = {!! json_encode($attendanceStatus) !!};
    new Chart(attendanceCtx, {
        type: 'doughnut',
        data: {
            labels: attendanceData.map(item => {
                const labels = {
                    'present': 'Hadir',
                    'absent': 'Tidak Hadir',
                    'late': 'Terlambat',
                    'excused': 'Izin'
                };
                return labels[item.status] || item.status;
            }),
            datasets: [{
                data: attendanceData.map(item => item.count),
                backgroundColor: ['#28a745', '#dc3545', '#ffc107', '#17a2b8']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });

    // Resilience Distribution Chart
    const resilienceCtx = document.getElementById('resilienceChart').getContext('2d');
    const resilienceData = {!! json_encode($resilienceDistribution) !!};
    new Chart(resilienceCtx, {
        type: 'doughnut',
        data: {
            labels: resilienceData.map(item => item.category),
            datasets: [{
                data: resilienceData.map(item => item.count),
                backgroundColor: ['#28a745', '#ffc107', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });

    // Mood Distribution Chart
    const moodCtx = document.getElementById('moodChart').getContext('2d');
    const moodData = {!! json_encode($moodDistribution) !!};
    new Chart(moodCtx, {
        type: 'bar',
        data: {
            labels: moodData.map(item => item.mood),
            datasets: [{
                label: 'Jumlah',
                data: moodData.map(item => item.count),
                backgroundColor: [
                    '#28a745',
                    '#17a2b8',
                    '#6c757d',
                    '#ffc107',
                    '#dc3545'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
@endsection
