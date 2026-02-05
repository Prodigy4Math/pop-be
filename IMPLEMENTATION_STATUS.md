# Dokumentasi Implementasi Fitur Admin & Peserta
## Status: Fase 1 Selesai - Struktur Database & Models

### ✅ YANG SUDAH SELESAI:

#### 1. Database Migrations (11 tables):
- `sports` - Daftar jenis olahraga
- `fitness_schedules` - Jadwal latihan kebugaran
- `attendance_records` - Absensi peserta
- `fitness_progress_notes` - Catatan perkembangan kebugaran
- `psychosocial_activities` - Kegiatan pendampingan psikososial
- `psychosocial_notes` - Catatan kondisi psikososial peserta
- `disaster_materials` - Materi edukasi kesiapsiagaan bencana
- `disaster_simulations` - Kegiatan simulasi bencana
- `badges` - Badge/sertifikasi
- `user_badges` - Relasi peserta-badges
- `notifications` - Sistem notifikasi

#### 2. Models Lengkap (12 files):
- Sport.php
- FitnessSchedule.php
- AttendanceRecord.php
- FitnessProgressNote.php
- PsychosocialActivity.php
- PsychosocialNote.php
- DisasterMaterial.php
- DisasterSimulation.php
- Badge.php
- Notification.php
- User.php (updated dengan relationships)

#### 3. Admin Controllers (Partial):
- AdminDashboardController - Dashboard statistik admin
- PesertaManagementController - CRUD peserta
- FitnessModuleController - Manajemen olahraga & jadwal

### ⏳ PERLU DIKERJAKAN:

#### Controllers yang Masih Diperlukan:
1. PsychosocialModuleController - Kegiatan psikososial & catatan
2. DisasterModuleController - Materi & simulasi bencana
3. AttendanceController - Manajemen absensi
4. ReportingController - Laporan kegiatan & perkembangan
5. BadgeController - Manajemen badge/sertifikasi

#### Peserta Controllers:
1. PesertaDashboardController - Dashboard peserta
2. PesertaProfileController - Edit profil peserta
3. FitnessActivityController - Lihat jadwal & riwayat kehadiran
4. PsychosocialEducationController - Konten psikososial
5. DisasterEducationController - Edukasi kesiapsiagaan
6. ProgressTrackingController - Tracking progress peserta

#### Routes yang Perlu Ditambahkan:
```php
// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Peserta Management
    Route::resource('peserta', PesertaManagementController::class, ['names' => 'admin.peserta']);
    
    // Fitness Module
    Route::resource('fitness/sports', FitnessModuleController::class, ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy'], 'names' => 'admin.fitness.sports']);
    Route::resource('fitness/schedules', FitnessModuleController::class, ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy'], 'names' => 'admin.fitness.schedules']);
    
    // Psychosocial Module
    Route::resource('psychosocial/activities', PsychosocialModuleController::class, ['names' => 'admin.psychosocial.activities']);
    Route::resource('psychosocial/notes', PsychosocialNoteController::class, ['names' => 'admin.psychosocial.notes']);
    
    // Disaster Module
    Route::resource('disaster/materials', DisasterModuleController::class, ['names' => 'admin.disaster.materials']);
    Route::resource('disaster/simulations', DisasterSimulationController::class, ['names' => 'admin.disaster.simulations']);
    
    // Attendance
    Route::get('attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::post('attendance/record', [AttendanceController::class, 'record'])->name('admin.attendance.record');
    
    // Reports
    Route::get('reports/activity', [ReportingController::class, 'activityReport'])->name('admin.reports.activity');
    Route::get('reports/progress', [ReportingController::class, 'progressReport'])->name('admin.reports.progress');
    Route::get('reports/export', [ReportingController::class, 'export'])->name('admin.reports.export');
    
    // Badges
    Route::resource('badges', BadgeController::class, ['names' => 'admin.badges']);
});

// Peserta Routes
Route::middleware(['auth', 'peserta'])->prefix('peserta')->group(function () {
    Route::get('dashboard', [PesertaDashboardController::class, 'index'])->name('peserta.dashboard');
    Route::get('profile', [PesertaProfileController::class, 'show'])->name('peserta.profile.show');
    Route::put('profile', [PesertaProfileController::class, 'update'])->name('peserta.profile.update');
    
    // Fitness Activities
    Route::get('fitness/schedules', [FitnessActivityController::class, 'schedules'])->name('peserta.fitness.schedules');
    Route::get('fitness/attendance', [FitnessActivityController::class, 'attendance'])->name('peserta.fitness.attendance');
    Route::get('fitness/progress', [FitnessActivityController::class, 'progress'])->name('peserta.fitness.progress');
    
    // Psychosocial Education
    Route::get('psychosocial/education', [PsychosocialEducationController::class, 'index'])->name('peserta.psychosocial.index');
    Route::get('psychosocial/activities', [PsychosocialEducationController::class, 'activities'])->name('peserta.psychosocial.activities');
    
    // Disaster Education
    Route::get('disaster/materials', [DisasterEducationController::class, 'materials'])->name('peserta.disaster.materials');
    Route::get('disaster/quiz', [DisasterEducationController::class, 'quiz'])->name('peserta.disaster.quiz');
    
    // Progress & Achievements
    Route::get('progress', [ProgressTrackingController::class, 'index'])->name('peserta.progress.index');
    Route::get('badges', [ProgressTrackingController::class, 'badges'])->name('peserta.badges.index');
});
```

#### Views yang Perlu Dibuat:

**Admin Views:**
- admin/dashboard.blade.php (updated)
- admin/peserta/index.blade.php
- admin/peserta/create.blade.php
- admin/peserta/edit.blade.php
- admin/peserta/show.blade.php
- admin/fitness/sports/index.blade.php
- admin/fitness/sports/create.blade.php
- admin/fitness/sports/edit.blade.php
- admin/fitness/schedules/index.blade.php
- admin/fitness/schedules/create.blade.php
- admin/fitness/schedules/edit.blade.php
- admin/psychosocial/activities/index.blade.php
- admin/psychosocial/activities/create.blade.php
- admin/psychosocial/activities/edit.blade.php
- admin/psychosocial/notes/index.blade.php
- admin/psychosocial/notes/create.blade.php
- admin/disaster/materials/index.blade.php
- admin/disaster/materials/create.blade.php
- admin/disaster/simulations/index.blade.php
- admin/disaster/simulations/create.blade.php
- admin/attendance/index.blade.php
- admin/attendance/record.blade.php
- admin/reports/activity.blade.php
- admin/reports/progress.blade.php
- admin/badges/index.blade.php

**Peserta Views:**
- peserta/dashboard.blade.php (updated)
- peserta/profile/show.blade.php
- peserta/profile/edit.blade.php
- peserta/fitness/schedules.blade.php
- peserta/fitness/attendance.blade.php
- peserta/fitness/progress.blade.php
- peserta/psychosocial/index.blade.php
- peserta/psychosocial/activities.blade.php
- peserta/disaster/materials.blade.php
- peserta/disaster/quiz.blade.php
- peserta/progress/index.blade.php
- peserta/badges/index.blade.php

### Middleware yang Perlu Dibuat:
1. `AdminMiddleware` - Memastikan user adalah admin
2. `PesertaMiddleware` - Memastikan user adalah peserta

### Fitur Utama per Role:

**ADMIN:**
✅ Dashboard dengan statistik
✅ Struktur untuk CRUD peserta
✅ Struktur untuk manajemen olahraga & jadwal
⏳ Manajemen aktivitas psikososial
⏳ Manajemen materi bencana
⏳ Pencatatan absensi
⏳ Laporan & export
⏳ Manajemen badge

**PESERTA:**
⏳ Dashboard dengan info program
⏳ Lihat jadwal & riwayat kehadiran
⏳ Tracking progress kebugaran
⏳ Akses edukasi psikososial
⏳ Akses edukasi kesiapsiagaan
⏳ Lihat progress & badge

### Langkah Selanjutnya:
1. Buat middleware untuk role checking
2. Buat remaining controllers
3. Buat semua views dengan desain yang konsisten
4. Test semua fitur
5. Tambahkan validasi & error handling
6. Implementasi notifikasi
