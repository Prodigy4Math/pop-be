# Panduan Migration Database

## Migration yang Perlu Dijalankan

### 1. Migration Update Psychosocial Activities
File: `database/migrations/2026_02_02_000001_update_psychosocial_activities_table.php`

Migration ini akan:
- Menghapus kolom lama: `title`, `activity_date`, `start_time`, `end_time`, `location`, `type`, `max_participants`, `facilitator_notes`
- Menambahkan kolom baru: `name`, `category`, `duration_minutes`

### 2. Migration Update Psychosocial Notes
File: `database/migrations/2026_02_02_000002_update_psychosocial_notes_table.php`

Migration ini akan:
- Menghapus kolom lama: `activity_id`, `note_date`, `observations`, `emotional_state`, `coping_ability`, `recommendations`, `facilitator_name`
- Menambahkan kolom baru: `psychosocial_activity_id`, `notes`, `mood`

## Cara Menjalankan Migration

### Jika Database Masih Kosong (Fresh Install)
```bash
php artisan migrate:fresh
```

### Jika Database Sudah Ada Data
**PERINGATAN**: Migration ini akan menghapus kolom lama. Pastikan backup database terlebih dahulu!

```bash
# Backup database terlebih dahulu
# Kemudian jalankan migration
php artisan migrate
```

### Jika Ingin Rollback
```bash
php artisan migrate:rollback --step=2
```

## Struktur Database Setelah Migration

### Table: psychosocial_activities
```sql
- id
- name (string)
- description (text)
- category (string) - Stres Manajemen, Trauma Healing, Resiliensi, Sosial Emosional
- duration_minutes (integer)
- is_active (boolean)
- created_at
- updated_at
- deleted_at (soft delete)
```

### Table: psychosocial_notes
```sql
- id
- user_id (foreign key)
- psychosocial_activity_id (foreign key, nullable)
- notes (text)
- resilience_score (integer) - 1-10
- mood (string) - Sangat Baik, Baik, Normal, Sedih, Sangat Sedih
- created_at
- updated_at
```

## Catatan Penting

1. **Backup Database**: Selalu backup database sebelum menjalankan migration
2. **Data Migration**: Jika ada data lama, perlu dibuat script untuk migrasi data dari struktur lama ke baru
3. **Testing**: Setelah migration, pastikan semua fitur berfungsi dengan baik

## Troubleshooting

### Error: Column already exists
Jika kolom sudah ada, migration akan skip otomatis karena menggunakan `Schema::hasColumn()`

### Error: Foreign key constraint
Pastikan tabel `psychosocial_activities` sudah ada sebelum menjalankan migration notes

### Error: Could not find driver
Pastikan extension PDO MySQL sudah aktif di PHP:
```bash
# Cek extension
php -m | grep pdo_mysql

# Aktifkan di php.ini jika belum
extension=pdo_mysql
```

