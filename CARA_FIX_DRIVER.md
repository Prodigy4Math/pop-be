# 🚀 Cara Cepat Fix Error "Could not find driver"

## ⚡ Solusi Cepat (Laragon)

### **Langkah 1: Aktifkan PDO MySQL**

1. **Buka Laragon** → Klik kanan icon di system tray
2. **Pilih "PHP" → "php.ini"**
3. **Cari** (Ctrl+F): `;extension=pdo_mysql`
4. **Hapus tanda `;`** menjadi: `extension=pdo_mysql`
5. **Simpan** (Ctrl+S)
6. **Restart Laragon**: Stop All → Start All

### **Langkah 2: Buat Database**

1. Buka **phpMyAdmin** di Laragon
2. Buat database: `penguatan_olahraga`
3. Atau jalankan SQL:
   ```sql
   CREATE DATABASE penguatan_olahraga;
   ```

### **Langkah 3: Cek File .env**

Pastikan di file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=penguatan_olahraga
DB_USERNAME=root
DB_PASSWORD=
```

### **Langkah 4: Jalankan Migration**

```bash
php artisan migrate
```

## ✅ Verifikasi

Cek extension sudah aktif:
```bash
php -m | findstr pdo_mysql
```

Harus muncul: `pdo_mysql`

## 🔄 Alternatif: SQLite

Jika MySQL masih error, gunakan SQLite:

1. **Ubah `.env`:**
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=database/database.sqlite
   ```

2. **Buat file database:**
   ```bash
   # PowerShell:
   New-Item database\database.sqlite -ItemType File
   ```

3. **Jalankan migration:**
   ```bash
   php artisan migrate
   ```

---

**Setelah migration berhasil, semua fitur admin siap digunakan!** 🎉

