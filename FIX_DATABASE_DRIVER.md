# Solusi Error "Could not find driver" - PDO MySQL

## Masalah
Saat menjalankan `php artisan migrate`, muncul error:
```
could not find driver (Connection: mysql)
```

## Penyebab
Extension PDO MySQL belum diaktifkan di PHP.

## Solusi untuk Laragon

### Langkah 1: Aktifkan Extension PDO MySQL

1. Buka file `php.ini` Laragon:
   - Buka Laragon
   - Klik kanan pada icon Laragon di system tray
   - Pilih "PHP" → "php.ini"

2. Cari baris berikut (gunakan Ctrl+F):
   ```ini
   ;extension=pdo_mysql
   ```

3. Hapus tanda `;` di depan untuk mengaktifkan:
   ```ini
   extension=pdo_mysql
   ```

4. Pastikan juga extension ini aktif:
   ```ini
   extension=mysqli
   extension=mbstring
   ```

5. Simpan file `php.ini`

6. Restart Laragon:
   - Klik kanan icon Laragon
   - Pilih "Stop All"
   - Kemudian "Start All"

### Langkah 2: Verifikasi Extension

Jalankan di terminal:
```bash
php -m | findstr pdo
```

Harus muncul:
- pdo_mysql
- pdo_sqlite

### Langkah 3: Cek Konfigurasi Database

Pastikan file `.env` sudah dikonfigurasi dengan benar:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=penguatan_olahraga
DB_USERNAME=root
DB_PASSWORD=
```

### Langkah 4: Buat Database (jika belum ada)

1. Buka phpMyAdmin di Laragon
2. Buat database baru dengan nama: `penguatan_olahraga`
3. Atau jalankan di MySQL:
   ```sql
   CREATE DATABASE penguatan_olahraga CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

### Langkah 5: Jalankan Migration

Setelah semua siap, jalankan:
```bash
php artisan migrate
```

## Alternatif: Gunakan SQLite (Jika MySQL Bermasalah)

Jika masih bermasalah dengan MySQL, bisa menggunakan SQLite:

1. Ubah `.env`:
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=database/database.sqlite
   ```

2. Buat file database:
   ```bash
   touch database/database.sqlite
   ```

3. Jalankan migration:
   ```bash
   php artisan migrate
   ```

## Troubleshooting

### Error: Extension tidak ditemukan
- Pastikan menggunakan PHP versi yang sama dengan yang digunakan Laragon
- Cek path extension di `php.ini`:
  ```ini
  extension_dir = "ext"
  ```

### Error: Database tidak ditemukan
- Pastikan database sudah dibuat di MySQL
- Cek kredensial di `.env`

### Error: Access denied
- Pastikan username dan password MySQL benar
- Default Laragon: username `root`, password kosong

