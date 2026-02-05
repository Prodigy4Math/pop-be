# Platform Penguatan Olahraga & Ketahanan Psikososial
## Dokumentasi Struktur Sistem

---

## 📋 RINGKASAN SISTEM

Aplikasi Laravel untuk Program Penguatan Olahraga dan Ketahanan Psikososial dengan 2 role utama:
- **Admin**: Mengelola peserta, program, jadwal, dan monitoring
- **Peserta**: Mengakses program, melaporkan progress, dan mendapat badge

---

## 🗂️ STRUKTUR FOLDER

```
resources/views/
├── auth/                          # Authentication pages
│   ├── login.blade.php
│   └── register.blade.php
├── layouts/
│   └── app.blade.php              # Master layout (navbar, footer)
├── dashboard/
│   ├── admin.blade.php            # Admin dashboard
│   └── peserta.blade.php          # Peserta dashboard
├── admin/                         # Admin feature views
│   ├── peserta/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   └── fitness/
│       ├── sports/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       └── schedules/
│           ├── index.blade.php
│           ├── create.blade.php
│           └── edit.blade.php
├── peserta/                       # Peserta feature views
│   └── dashboard.blade.php
└── welcome.blade.php              # Landing page
```

```
app/Http/
├── Controllers/
│   ├── AuthController.php         # Login/Register logic
│   ├── Admin/
│   │   ├── AdminDashboardController.php      # Admin stats
│   │   ├── PesertaManagementController.php   # CRUD peserta
│   │   └── FitnessModuleController.php       # Olahraga & jadwal
│   └── Peserta/                   # (siap untuk peserta controllers)
├── Middleware/
│   ├── AdminMiddleware.php        # Cek role admin
│   ├── PesertaMiddleware.php      # Cek role peserta
│   └── Authenticate.php           # Built-in auth middleware
```

```
app/Models/
├── User.php                       # User model dengan relationships
├── Sport.php                      # Jenis olahraga
├── FitnessSchedule.php           # Jadwal latihan
├── AttendanceRecord.php          # Absensi peserta
├── FitnessProgressNote.php       # Catatan progress kebugaran
├── PsychosocialActivity.php      # Kegiatan pendampingan psikososial
├── PsychosocialNote.php          # Catatan hasil pendampingan
├── DisasterMaterial.php          # Materi edukasi bencana
├── DisasterSimulation.php        # Simulasi bencana
├── Badge.php                     # Penghargaan/sertifikat
└── Notification.php              # Notifikasi sistem
```

```
database/
├── migrations/
│   ├── 2014_10_12_000000_create_users_table.php
│   ├── 2014_10_12_100000_create_password_resets_table.php
│   ├── 2019_08_19_000000_create_failed_jobs_table.php
│   ├── 2026_02_01_000003_create_sports_table.php
│   ├── 2026_02_01_000004_create_fitness_schedules_table.php
│   ├── 2026_02_01_000005_create_attendance_records_table.php
│   ├── 2026_02_01_000006_create_fitness_progress_notes_table.php
│   ├── 2026_02_01_000007_create_psychosocial_activities_table.php
│   ├── 2026_02_01_000008_create_psychosocial_notes_table.php
│   ├── 2026_02_01_000009_create_disaster_materials_table.php
│   ├── 2026_02_01_000010_create_disaster_simulations_table.php
│   ├── 2026_02_01_000011_create_badges_table.php
│   ├── 2026_02_01_000012_create_user_badges_table.php
│   └── 2026_02_01_000013_create_notifications_table.php
├── factories/
│   └── UserFactory.php
└── seeders/
    └── DatabaseSeeder.php
```

---

## 🔐 SISTEM AUTENTIKASI

### Login Flow
```
1. User masuk di /login
2. AuthController::login() validasi kredensial
3. Cek is_active, jika false logout
4. Redirect ke admin.dashboard jika isAdmin()
5. Redirect ke peserta.dashboard jika isPeserta()
```

### Register Flow
```
1. Hanya untuk role PESERTA
2. User daftar di /register
3. AuthController::register() buat user baru dengan role='peserta'
4. Auto-login & redirect ke peserta.dashboard
```

### Middleware Protection
```
Route Admin:     middleware(['auth', 'admin'])     → AdminMiddleware
Route Peserta:   middleware(['auth', 'peserta'])   → PesertaMiddleware
```

---

## 👨‍💼 FITUR ADMIN

### 1. Dashboard Admin (`/admin`)
- **Controller**: AdminDashboardController@index
- **View**: dashboard/admin.blade.php
- **Stats**: 
  - Total Peserta
  - Peserta Aktif
  - Total Kehadiran
  - Rata-rata Kehadiran %
  - Riwayat kehadiran terbaru

### 2. Manajemen Peserta (`/admin/peserta`)
- **Controller**: PesertaManagementController
- **Methods**: index, create, store, show, edit, update, destroy
- **Validasi**:
  - name (required)
  - email (unique)
  - password (min:6, confirmed)
  - age (5-30)
  - gender (Laki-laki/Perempuan)
  - school, phone, guardian_name, guardian_phone (optional)
  - is_active (boolean)

### 3. Modul Kebugaran
#### a) Kelola Olahraga (`/admin/fitness/sports`)
- **Controller**: FitnessModuleController@indexSports, createSport, storeSport, editSport, updateSport, destroySport
- **Fields**:
  - name (required)
  - category (Individual/Tim/Peran)
  - difficulty_level (1-5)
  - icon (Font Awesome)
  - description

#### b) Jadwal Latihan (`/admin/fitness/schedules`)
- **Controller**: FitnessModuleController@indexSchedules, createSchedule, storeSchedule, editSchedule, updateSchedule, destroySchedule
- **Fields**:
  - sport_id (FK)
  - schedule_date
  - start_time, end_time
  - location
  - max_participants
  - description (optional)
  - is_active

---

## 👤 FITUR PESERTA

### 1. Dashboard Peserta (`/peserta`)
- **View**: peserta/dashboard.blade.php
- **Stats**:
  - Aktivitas Selesai
  - Total Poin
  - Tingkat Resiliensi %
  - Tingkat Kehadiran %
  - Riwayat aktivitas terbaru

### 2. Fitur Modul (Siap dikembangkan)
- Modul Kebugaran (lihat jadwal, catat kehadiran)
- Resiliensi Psikososial (ikuti sesi pendampingan)
- Kesiapsiagaan Bencana (pelajari materi edukasi)
- Asesmen & Feedback (lihat progress report)

---

## 🗄️ DATABASE SCHEMA

### Table: users
```
id, name, email, password, role (admin/peserta), age, gender
school, phone, guardian_name, guardian_phone, bio
is_active, created_at, updated_at
```

### Table: sports
```
id, name, description, category, difficulty_level, icon
created_at, updated_at
```

### Table: fitness_schedules
```
id, sport_id, schedule_date, start_time, end_time, location
description, max_participants, is_active, created_at, updated_at
```

### Table: attendance_records
```
id, user_id, fitness_schedule_id, status (present/absent/late/excused)
notes, created_at, updated_at
UNIQUE(user_id, fitness_schedule_id)
```

### Table: fitness_progress_notes
```
id, user_id, sport_id, note_date, progress_notes
performance_level, endurance_level, strength_level, recommendations
created_at, updated_at
```

### Table: psychosocial_activities
```
id, title, description, activity_date, start_time, end_time, location
type (konseling/workshop/grup_diskusi/aktivitas_kreatif)
max_participants, facilitator_notes, is_active, created_at, updated_at
```

### Table: psychosocial_notes
```
id, user_id, activity_id, note_date, observations, emotional_state
resilience_score, coping_ability, recommendations, facilitator_name
created_at, updated_at
```

### Table: disaster_materials
```
id, title, description, type (teks/video/infografis/pdf)
content_url, content_text, category, difficulty_level, is_active
created_at, updated_at, deleted_at
```

### Table: disaster_simulations
```
id, title, description, simulation_date, start_time, end_time, location
disaster_type, max_participants, evaluation_notes, is_active
created_at, updated_at, deleted_at
```

### Table: badges
```
id, name, description, icon, type (kehadiran/kebugaran/psikososial/kesiapsiagaan)
requirement_count, created_at, updated_at
```

### Table: user_badges
```
id, user_id, badge_id, earned_date, created_at, updated_at
UNIQUE(user_id, badge_id)
```

### Table: notifications
```
id, user_id, title, message, type (info/warning/success/error)
category, related_model, related_id, is_read, read_at
created_at, updated_at
```

---

## 🛣️ RUTE APLIKASI

### Public Routes
```
GET  /              # Welcome page
GET  /login         # Login form
POST /login         # Process login
GET  /register      # Register form
POST /register      # Process register
POST /logout        # Logout
```

### Admin Routes (middleware: auth, admin)
```
GET    /admin                           # Dashboard
GET    /admin/peserta                   # List peserta
GET    /admin/peserta/create            # Form create peserta
POST   /admin/peserta                   # Store peserta
GET    /admin/peserta/{id}              # Show peserta
GET    /admin/peserta/{id}/edit         # Form edit peserta
PUT    /admin/peserta/{id}              # Update peserta
DELETE /admin/peserta/{id}              # Delete peserta

GET    /admin/fitness/sports            # List olahraga
GET    /admin/fitness/sports/create     # Form create olahraga
POST   /admin/fitness/sports            # Store olahraga
GET    /admin/fitness/sports/{id}/edit  # Form edit olahraga
PUT    /admin/fitness/sports/{id}       # Update olahraga
DELETE /admin/fitness/sports/{id}       # Delete olahraga

GET    /admin/fitness/schedules         # List jadwal
GET    /admin/fitness/schedules/create  # Form create jadwal
POST   /admin/fitness/schedules         # Store jadwal
GET    /admin/fitness/schedules/{id}/edit  # Form edit jadwal
PUT    /admin/fitness/schedules/{id}    # Update jadwal
DELETE /admin/fitness/schedules/{id}    # Delete jadwal
```

### Peserta Routes (middleware: auth, peserta)
```
GET /peserta              # Dashboard
```

---

## 🎯 NEXT STEPS (Roadmap)

### Controllers Needed
- [ ] PsychosocialModuleController
- [ ] DisasterModuleController
- [ ] AttendanceController
- [ ] BadgeController
- [ ] ReportingController
- [ ] PesertaProfileController
- [ ] PesertaActivityController

### Views Needed (Admin)
- [ ] 6 views untuk psychosocial management
- [ ] 6 views untuk disaster management
- [ ] Attendance tracking views
- [ ] Report & export views
- [ ] Badge management views

### Views Needed (Peserta)
- [ ] Profile management views
- [ ] Activity detail views
- [ ] Progress report views
- [ ] Badge collection views
- [ ] Notification center

### Features to Implement
- [ ] Activity booking system
- [ ] Automatic badge distribution logic
- [ ] Progress calculation algorithms
- [ ] Email notifications
- [ ] Export to PDF/Excel
- [ ] Admin reporting dashboard

---

## 🔧 TESTING CREDENTIALS

### Admin Account
- Email: admin@example.com
- Password: password
- Role: admin

### Test Peserta
- Email: peserta@example.com
- Password: password
- Role: peserta

> Buat akun baru melalui register untuk mendapat role peserta otomatis

---

## 📝 NOTES

1. **Validasi Gender**: Gunakan "Laki-laki" dan "Perempuan" (capital L & P)
2. **Password Hash**: Semua password di-hash menggunakan bcrypt
3. **Soft Deletes**: Disaster materials dan simulations menggunakan soft delete
4. **Timestamps**: Semua table memiliki created_at & updated_at
5. **Middleware**: Daftar di bootstrap/app.php dalam alias middleware
6. **View Inheritance**: Semua views extends layouts/app.blade.php (kecuali auth)

---

Generated: 2026-02-01
Last Updated: File Organization & Cleanup
