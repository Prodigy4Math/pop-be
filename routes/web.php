<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PesertaManagementController;
use App\Http\Controllers\Admin\FitnessModuleController;
use App\Http\Controllers\Admin\PsychosocialModuleController;
use App\Http\Controllers\Admin\DisasterModuleController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\BadgeController;
use App\Http\Controllers\Admin\ReportingController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\AchievementSubmissionController as AdminAchievementSubmissionController;
use App\Http\Controllers\Admin\EquipmentLoanController as AdminEquipmentLoanController;
use App\Http\Controllers\Admin\LandingScheduleController;
use App\Http\Controllers\Admin\LandingStandingController;
use App\Http\Controllers\Admin\LandingNewsController;
use App\Http\Controllers\Admin\LandingGalleryController;
use App\Http\Controllers\Peserta\PesertaDashboardController;
use App\Http\Controllers\Peserta\PesertaProfileController;
use App\Http\Controllers\Peserta\FitnessActivityController;
use App\Http\Controllers\Peserta\PsychosocialEducationController;
use App\Http\Controllers\Peserta\DisasterEducationController;
use App\Http\Controllers\Peserta\ProgressTrackingController;
use App\Http\Controllers\Peserta\PesertaBarcodeController;
use App\Http\Controllers\Peserta\AchievementSubmissionController as PesertaAchievementSubmissionController;
use App\Http\Controllers\Peserta\EquipmentLoanController as PesertaEquipmentLoanController;
use App\Http\Controllers\LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Authentication
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout/admin', [AuthController::class, 'logoutAdmin'])->name('logout.admin');
Route::post('logout/peserta', [AuthController::class, 'logoutPeserta'])->name('logout.peserta');

// Admin Routes
Route::middleware(['auth:admin', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Peserta Management
    Route::resource('peserta', PesertaManagementController::class, [
        'names' => 'admin.peserta',
        'except' => ['show']
    ])->parameters(['peserta' => 'peserta']);
    Route::get('peserta/{peserta}', [PesertaManagementController::class, 'show'])->name('admin.peserta.show');
    Route::get('peserta/{peserta}/barcode', [PesertaManagementController::class, 'downloadBarcodePdf'])
        ->name('admin.peserta.barcode.pdf');
    Route::get('peserta/{peserta}/barcode-card', [PesertaManagementController::class, 'downloadBarcodeCardPdf'])
        ->name('admin.peserta.barcode.card');
    Route::post('peserta/{peserta}/barcode/send', [PesertaManagementController::class, 'sendBarcodeToPeserta'])
        ->name('admin.peserta.barcode.send');
    Route::post('peserta/{peserta}/barcode/regenerate', [PesertaManagementController::class, 'regenerateBarcode'])
        ->name('admin.peserta.barcode.regenerate');
    
    // Fitness Module - Sports
    Route::get('fitness/sports', [FitnessModuleController::class, 'indexSports'])->name('admin.fitness.sports.index');
    Route::get('fitness/sports/create', [FitnessModuleController::class, 'createSport'])->name('admin.fitness.sports.create');
    Route::post('fitness/sports', [FitnessModuleController::class, 'storeSport'])->name('admin.fitness.sports.store');
    Route::get('fitness/sports/{sport}/edit', [FitnessModuleController::class, 'editSport'])->name('admin.fitness.sports.edit');
    Route::put('fitness/sports/{sport}', [FitnessModuleController::class, 'updateSport'])->name('admin.fitness.sports.update');
    Route::delete('fitness/sports/{sport}', [FitnessModuleController::class, 'destroySport'])->name('admin.fitness.sports.destroy');
    
    // Fitness Module - Schedules
    Route::get('fitness/schedules', [FitnessModuleController::class, 'indexSchedules'])->name('admin.fitness.schedules.index');
    Route::get('fitness/schedules/create', [FitnessModuleController::class, 'createSchedule'])->name('admin.fitness.schedules.create');
    Route::post('fitness/schedules', [FitnessModuleController::class, 'storeSchedule'])->name('admin.fitness.schedules.store');
    Route::get('fitness/schedules/{schedule}/edit', [FitnessModuleController::class, 'editSchedule'])->name('admin.fitness.schedules.edit');
    Route::put('fitness/schedules/{schedule}', [FitnessModuleController::class, 'updateSchedule'])->name('admin.fitness.schedules.update');
    Route::delete('fitness/schedules/{schedule}', [FitnessModuleController::class, 'destroySchedule'])->name('admin.fitness.schedules.destroy');
    
    // Psychosocial Module - Activities
    Route::get('psychosocial/activities', [PsychosocialModuleController::class, 'indexActivities'])->name('admin.psychosocial.activities.index');
    Route::get('psychosocial/activities/create', [PsychosocialModuleController::class, 'createActivity'])->name('admin.psychosocial.activities.create');
    Route::post('psychosocial/activities', [PsychosocialModuleController::class, 'storeActivity'])->name('admin.psychosocial.activities.store');
    Route::get('psychosocial/activities/{activity}/edit', [PsychosocialModuleController::class, 'editActivity'])->name('admin.psychosocial.activities.edit');
    Route::put('psychosocial/activities/{activity}', [PsychosocialModuleController::class, 'updateActivity'])->name('admin.psychosocial.activities.update');
    Route::delete('psychosocial/activities/{activity}', [PsychosocialModuleController::class, 'destroyActivity'])->name('admin.psychosocial.activities.destroy');
    
    // Psychosocial Module - Notes
    Route::get('psychosocial/notes', [PsychosocialModuleController::class, 'indexNotes'])->name('admin.psychosocial.notes.index');
    Route::get('psychosocial/notes/create', [PsychosocialModuleController::class, 'createNote'])->name('admin.psychosocial.notes.create');
    Route::post('psychosocial/notes', [PsychosocialModuleController::class, 'storeNote'])->name('admin.psychosocial.notes.store');
    Route::get('psychosocial/notes/{note}/edit', [PsychosocialModuleController::class, 'editNote'])->name('admin.psychosocial.notes.edit');
    Route::put('psychosocial/notes/{note}', [PsychosocialModuleController::class, 'updateNote'])->name('admin.psychosocial.notes.update');
    Route::delete('psychosocial/notes/{note}', [PsychosocialModuleController::class, 'destroyNote'])->name('admin.psychosocial.notes.destroy');
    
    // Disaster Module - Materials
    Route::get('disaster/materials', [DisasterModuleController::class, 'indexMaterials'])->name('admin.disaster.materials.index');
    Route::get('disaster/materials/create', [DisasterModuleController::class, 'createMaterial'])->name('admin.disaster.materials.create');
    Route::post('disaster/materials', [DisasterModuleController::class, 'storeMaterial'])->name('admin.disaster.materials.store');
    Route::get('disaster/materials/{material}/edit', [DisasterModuleController::class, 'editMaterial'])->name('admin.disaster.materials.edit');
    Route::put('disaster/materials/{material}', [DisasterModuleController::class, 'updateMaterial'])->name('admin.disaster.materials.update');
    Route::delete('disaster/materials/{material}', [DisasterModuleController::class, 'destroyMaterial'])->name('admin.disaster.materials.destroy');
    
    // Disaster Module - Simulations
    Route::get('disaster/simulations', [DisasterModuleController::class, 'indexSimulations'])->name('admin.disaster.simulations.index');
    Route::get('disaster/simulations/create', [DisasterModuleController::class, 'createSimulation'])->name('admin.disaster.simulations.create');
    Route::post('disaster/simulations', [DisasterModuleController::class, 'storeSimulation'])->name('admin.disaster.simulations.store');
    Route::get('disaster/simulations/{simulation}/edit', [DisasterModuleController::class, 'editSimulation'])->name('admin.disaster.simulations.edit');
    Route::put('disaster/simulations/{simulation}', [DisasterModuleController::class, 'updateSimulation'])->name('admin.disaster.simulations.update');
    Route::delete('disaster/simulations/{simulation}', [DisasterModuleController::class, 'destroySimulation'])->name('admin.disaster.simulations.destroy');
    
    // Attendance Module
    Route::get('attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::get('attendance/record', [AttendanceController::class, 'record'])->name('admin.attendance.record');
    Route::get('attendance/scan-page', [AttendanceController::class, 'scanPage'])->name('admin.attendance.scan.page');
    Route::post('attendance', [AttendanceController::class, 'store'])->name('admin.attendance.store');
    Route::post('attendance/scan', [AttendanceController::class, 'scan'])->name('admin.attendance.scan');
    Route::delete('attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('admin.attendance.destroy');
    
    // Badge Module
    Route::resource('badges', BadgeController::class, ['names' => 'admin.badges']);
    Route::post('badges/{badge}/award', [BadgeController::class, 'awardBadge'])->name('admin.badges.award');

    // Prestasi & Proposal Peserta
    Route::get('achievements', [AdminAchievementSubmissionController::class, 'index'])->name('admin.achievements.index');
    Route::get('achievements/{submission}', [AdminAchievementSubmissionController::class, 'show'])->name('admin.achievements.show');
    Route::get('achievements/{submission}/download', [AdminAchievementSubmissionController::class, 'download'])->name('admin.achievements.download');
    Route::post('achievements/{submission}/approve', [AdminAchievementSubmissionController::class, 'approve'])->name('admin.achievements.approve');
    Route::post('achievements/{submission}/reject', [AdminAchievementSubmissionController::class, 'reject'])->name('admin.achievements.reject');

    // Peminjaman Alat
    Route::get('loans', [AdminEquipmentLoanController::class, 'index'])->name('admin.loans.index');
    Route::get('loans/{loan}', [AdminEquipmentLoanController::class, 'show'])->name('admin.loans.show');
    Route::post('loans/{loan}/approve', [AdminEquipmentLoanController::class, 'approve'])->name('admin.loans.approve');
    Route::post('loans/{loan}/reject', [AdminEquipmentLoanController::class, 'reject'])->name('admin.loans.reject');

    // Landing Page Content
    Route::get('landing/schedules', [LandingScheduleController::class, 'index'])->name('admin.landing.schedules.index');
    Route::get('landing/schedules/create', [LandingScheduleController::class, 'create'])->name('admin.landing.schedules.create');
    Route::post('landing/schedules', [LandingScheduleController::class, 'store'])->name('admin.landing.schedules.store');
    Route::get('landing/schedules/{schedule}/edit', [LandingScheduleController::class, 'edit'])->name('admin.landing.schedules.edit');
    Route::put('landing/schedules/{schedule}', [LandingScheduleController::class, 'update'])->name('admin.landing.schedules.update');
    Route::delete('landing/schedules/{schedule}', [LandingScheduleController::class, 'destroy'])->name('admin.landing.schedules.destroy');

    Route::get('landing/standings', [LandingStandingController::class, 'index'])->name('admin.landing.standings.index');
    Route::get('landing/standings/create', [LandingStandingController::class, 'create'])->name('admin.landing.standings.create');
    Route::post('landing/standings', [LandingStandingController::class, 'store'])->name('admin.landing.standings.store');
    Route::get('landing/standings/{standing}/edit', [LandingStandingController::class, 'edit'])->name('admin.landing.standings.edit');
    Route::put('landing/standings/{standing}', [LandingStandingController::class, 'update'])->name('admin.landing.standings.update');
    Route::delete('landing/standings/{standing}', [LandingStandingController::class, 'destroy'])->name('admin.landing.standings.destroy');

    Route::get('landing/news', [LandingNewsController::class, 'index'])->name('admin.landing.news.index');
    Route::get('landing/news/create', [LandingNewsController::class, 'create'])->name('admin.landing.news.create');
    Route::post('landing/news', [LandingNewsController::class, 'store'])->name('admin.landing.news.store');
    Route::get('landing/news/{news}/edit', [LandingNewsController::class, 'edit'])->name('admin.landing.news.edit');
    Route::put('landing/news/{news}', [LandingNewsController::class, 'update'])->name('admin.landing.news.update');
    Route::delete('landing/news/{news}', [LandingNewsController::class, 'destroy'])->name('admin.landing.news.destroy');

    Route::get('landing/gallery', [LandingGalleryController::class, 'index'])->name('admin.landing.gallery.index');
    Route::get('landing/gallery/create', [LandingGalleryController::class, 'create'])->name('admin.landing.gallery.create');
    Route::post('landing/gallery', [LandingGalleryController::class, 'store'])->name('admin.landing.gallery.store');
    Route::get('landing/gallery/{gallery}/edit', [LandingGalleryController::class, 'edit'])->name('admin.landing.gallery.edit');
    Route::put('landing/gallery/{gallery}', [LandingGalleryController::class, 'update'])->name('admin.landing.gallery.update');
    Route::delete('landing/gallery/{gallery}', [LandingGalleryController::class, 'destroy'])->name('admin.landing.gallery.destroy');
    
    // Reporting Module
    Route::get('reports/activity', [ReportingController::class, 'activityReport'])->name('admin.reports.activity');
    Route::get('reports/progress', [ReportingController::class, 'progressReport'])->name('admin.reports.progress');
    Route::get('reports/export', [ReportingController::class, 'export'])->name('admin.reports.export');

    Route::get('notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
    Route::post('notifications/read-all', [AdminNotificationController::class, 'markAllRead'])->name('admin.notifications.readAll');
    Route::post('notifications/{notification}/read', [AdminNotificationController::class, 'markRead'])->name('admin.notifications.read');
});

// Peserta Routes
Route::middleware(['auth:peserta', 'peserta'])->prefix('peserta')->group(function () {
    Route::get('/', [PesertaDashboardController::class, 'index'])->name('peserta.dashboard');
    
    // Profile Management
    Route::get('profile', [PesertaProfileController::class, 'show'])->name('peserta.profile.show');
    Route::get('profile/edit', [PesertaProfileController::class, 'edit'])->name('peserta.profile.edit');
    Route::put('profile', [PesertaProfileController::class, 'update'])->name('peserta.profile.update');
    
    // Fitness Activities
    Route::get('fitness/schedules', [FitnessActivityController::class, 'schedules'])->name('peserta.fitness.schedules');
    Route::get('fitness/attendance', [FitnessActivityController::class, 'attendance'])->name('peserta.fitness.attendance');
    Route::get('fitness/progress', [FitnessActivityController::class, 'progress'])->name('peserta.fitness.progress');
    
    // Psychosocial Education
    Route::get('psychosocial', [PsychosocialEducationController::class, 'index'])->name('peserta.psychosocial.index');
    Route::get('psychosocial/{activity}', [PsychosocialEducationController::class, 'show'])->name('peserta.psychosocial.show');
    Route::get('psychosocial-resources', [PsychosocialEducationController::class, 'resources'])->name('peserta.psychosocial.resources');
    
    // Disaster Education
    Route::get('disaster/materials', [DisasterEducationController::class, 'materials'])->name('peserta.disaster.materials');
    Route::get('disaster/quiz', [DisasterEducationController::class, 'quiz'])->name('peserta.disaster.quiz');
    Route::post('disaster/quiz', [DisasterEducationController::class, 'submitQuiz'])->name('peserta.disaster.quiz.submit');
    Route::get('disaster/{material}', [DisasterEducationController::class, 'show'])->name('peserta.disaster.show');
    
    // Progress & Achievements
    Route::get('progress', [ProgressTrackingController::class, 'index'])->name('peserta.progress.index');
    Route::get('badges', [ProgressTrackingController::class, 'badges'])->name('peserta.badges.index');

    // Barcode & Kartu Peserta
    Route::get('barcode', [PesertaBarcodeController::class, 'show'])->name('peserta.barcode.show');
    Route::get('barcode/pdf', [PesertaBarcodeController::class, 'downloadBarcodePdf'])->name('peserta.barcode.pdf');
    Route::get('barcode/card', [PesertaBarcodeController::class, 'downloadBarcodeCardPdf'])->name('peserta.barcode.card');
    Route::post('barcode/request', [PesertaBarcodeController::class, 'requestBarcode'])->name('peserta.barcode.request');

    // Prestasi & Proposal
    Route::get('achievements', [PesertaAchievementSubmissionController::class, 'index'])->name('peserta.achievements.index');
    Route::get('achievements/create', [PesertaAchievementSubmissionController::class, 'create'])->name('peserta.achievements.create');
    Route::post('achievements', [PesertaAchievementSubmissionController::class, 'store'])->name('peserta.achievements.store');

    // Peminjaman Alat
    Route::get('loans', [PesertaEquipmentLoanController::class, 'index'])->name('peserta.loans.index');
    Route::get('loans/create', [PesertaEquipmentLoanController::class, 'create'])->name('peserta.loans.create');
    Route::post('loans', [PesertaEquipmentLoanController::class, 'store'])->name('peserta.loans.store');
});

// Fallback for old dashboard routes
Route::middleware('auth:admin')->group(function () {
    Route::get('dashboard/admin', function () {
        return redirect()->route('admin.dashboard');
    });
});

Route::middleware('auth:peserta')->group(function () {
    Route::get('dashboard/peserta', function () {
        return redirect()->route('peserta.dashboard');
    });
});
