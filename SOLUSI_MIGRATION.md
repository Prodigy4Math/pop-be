# Solusi Error Migration - "Could not find driver"

## 🔴 Error yang Terjadi
```
could not find driver (Connection: mysql)
PDOException::("could not find driver")
```

## ✅ Solusi Lengkap

### **Cara 1: Aktifkan PDO MySQL Extension (Recommended)**

#### Untuk Laragon:

1. **Buka PHP Configuration:**
   - Klik kanan icon Laragon di system tray (bawah kanan)
   - Pilih **"PHP"** → **"php.ini"**

2. **Aktifkan Extension:**
   - Tekan `Ctrl + F` untuk mencari
   - Cari: `;extension=pdo_mysql`
   - Hapus tanda `;` di depan:
     ```ini
     extension=pdo_mysql
     ```

3. **Aktifkan Extension Lainnya (jika perlu):**
   ```ini
   extension=mysqli
   extension=mbstring
   extension=openssl
   ```

4. **Simpan file** (`Ctrl + S`)

5. **Restart Laragon:**
   - Klik kanan icon Laragon
   - **"Stop All"**
   - **"Start All"**

6. **Verifikasi:**
   ```bash
   php -m | findstr pdo
   ```
   Harus muncul: `pdo_mysql`

### **Cara 2: Cek Konfigurasi Database**

1. **Buka file `.env`** di root project

2. **Pastikan konfigurasi MySQL benar:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=penguatan_olahraga
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Buat Database (jika belum ada):**
   - Buka **phpMyAdmin** di Laragon
   - Atau buka terminal MySQL:
     ```sql
     CREATE DATABASE penguatan_olahraga CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
     ```

### **Cara 3: Jalankan Migration**

Setelah extension aktif dan database siap:

```bash
php artisan migrate
```

## 🔄 Alternatif: Gunakan SQLite (Jika MySQL Masih Bermasalah)

Jika masih error dengan MySQL, bisa pakai SQLite:

1. **Ubah `.env`:**
   ```env
   DB_CONNECTION=sqlite
   # Hapus atau comment baris MySQL:
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=penguatan_olahraga
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

2. **Buat file database:**
   ```bash
   # Di Windows PowerShell:
   New-Item -Path database\database.sqlite -ItemType File -Force
   
   # Atau manual: buat file kosong di folder database/database.sqlite
   ```

3. **Jalankan migration:**
   ```bash
   php artisan migrate
   ```

## 📋 Checklist Sebelum Migration

- [ ] Extension `pdo_mysql` sudah aktif di `php.ini`
- [ ] Laragon sudah di-restart
- [ ] Database `penguatan_olahraga` sudah dibuat
- [ ] File `.env` sudah dikonfigurasi dengan benar
- [ ] MySQL service berjalan di Laragon

## 🛠️ Troubleshooting

### Error: "Extension tidak ditemukan"
- Pastikan path extension benar di `php.ini`:
  ```ini
  extension_dir = "ext"
  ```
- Cek apakah file `php_pdo_mysql.dll` ada di folder `ext`

### Error: "Access denied for user"
- Pastikan username dan password MySQL benar
- Default Laragon: `root` dengan password kosong

### Error: "Unknown database"
- Buat database terlebih dahulu di phpMyAdmin atau MySQL

## 📝 Catatan Migration

Migration yang akan dijalankan:
1. ✅ `2026_02_02_000001_update_psychosocial_activities_table.php`
   - Update struktur tabel activities
   
2. ✅ `2026_02_02_000002_update_psychosocial_notes_table.php`
   - Update struktur tabel notes

Migration sudah dibuat dengan pengecekan yang aman, jadi tidak akan error jika kolom sudah ada atau tidak ada.

