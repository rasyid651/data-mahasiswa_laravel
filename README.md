# 🚀 CRUD Laravel — Migrasi PHP Native ke Laravel 13

> Project Praktik Kerja Lapangan (PKL) — Migrasi aplikasi CRUD berbasis web dari **PHP Native (prosedural)** ke framework **Laravel 13** dengan seluruh fitur tetap berfungsi, plus deployment ke hosting publik.

🌐 **Live Demo:** [https://crud-rasyid.infinityfree.me](https://crud-rasyid.infinityfree.me)

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql)
![AdminLTE](https://img.shields.io/badge/UI-AdminLTE%203-007BFF?style=flat-square&logo=bootstrap)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

---

## 📖 Tentang Project

Project ini merupakan **migrasi penuh** dari aplikasi CRUD yang sebelumnya dibangun dengan PHP Native (query `mysqli` prosedural, session `$_SESSION`, dan file terpisah per halaman) menjadi aplikasi **Laravel 13** dengan arsitektur MVC modern:

| PHP Native (Sebelum) | Laravel 13 (Sesudah) |
|---|---|
| `mysqli_query()` manual | **Eloquent ORM** (`Barang::all()`, `where()`, `paginate()`) |
| `$_SESSION['login']` | **Authentication** `Auth::attempt()` + `Auth::user()` |
| Pengecekan level manual di tiap file | **Custom Middleware** `check.level` |
| `header("Location: ...")` | **Routing** + `redirect()->route()` |
| `password_hash()` manual | **`Hash::make()`** (bcrypt otomatis) |
| PHPMailer manual | **Laravel Mail** (SMTP Gmail) |
| Include `header.php` / `footer.php` | **Blade Template** (`@extends`, `@section`, `@push`) |
| Proteksi `strip_tags()` | **CSRF Protection** + **Validation** |

---

## ✨ Fitur Lengkap

### 🔐 Autentikasi & Autorisasi
- Login username + password dengan **Google reCAPTCHA v2** (bisa di-enable/disable via `.env`)
- **3 level hak akses** dengan custom middleware `check.level`
- Redirect cerdas setelah login sesuai level user
- Logout aman dengan CSRF (form POST)

### 📦 Data Barang (Level 1 & 2)
- CRUD lengkap (Tambah, Ubah, Hapus)
- **Filter rentang tanggal**
- **Pagination** (3 data per halaman)
- **Grafik harga barang** dengan Chart.js
- **Auto-generate barcode** dengan JsBarcode

### 👥 Data Pegawai (Level 1 & 3)
- Tampilan data **read-only** (sesuai kebutuhan bisnis)
- **Realtime update** tanpa refresh via AJAX polling setiap 2 detik

### 🎓 Data Mahasiswa (Level 1 & 3)
- CRUD lengkap dengan **upload foto + preview gambar**
- **DataTables server-side** (search, sorting, pagination dari server)
- Halaman detail mahasiswa
- **Download Excel** (`.xlsx` — maatwebsite/excel)
- **Download PDF** (barryvdh/laravel-dompdf)

### 👤 Data Akun (Semua Level)
- CRUD akun dengan **Bootstrap Modal**
- Admin melihat semua akun; user biasa hanya melihat akunnya sendiri
- Dropdown level hanya untuk admin
- Password ter-enkripsi **bcrypt**

### 📧 Kirim Email (Semua Level)
- Form kirim email dengan **Laravel Mail** via SMTP Gmail
- Validasi input + flash message sukses/gagal

---

## 🛠️ Tech Stack

| Kategori | Teknologi |
|---|---|
| Backend | Laravel 13, PHP 8.3 |
| Database | MySQL (Eloquent ORM) |
| Frontend | AdminLTE 3, Bootstrap 4, jQuery |
| Tabel | DataTables (server-side processing) |
| Grafik | Chart.js |
| Barcode | JsBarcode |
| Export | maatwebsite/excel, barryvdh/laravel-dompdf |
| Keamanan | Google reCAPTCHA v2, CSRF, bcrypt |
| Email | Laravel Mail (SMTP Gmail) |
| Hosting | InfinityFree (Apache, PHP 8.3) |

---

## 👥 Level Hak Akses

| Level | Role | Akses |
|---|---|---|
| 1 | Admin | Semua halaman (barang, mahasiswa, pegawai, akun, email) |
| 2 | Operator Barang | Barang, Akun, Email |
| 3 | Operator Mahasiswa | Mahasiswa, Pegawai, Akun, Email |

### 🔑 Akun Default

| Username | Password | Level |
|---|---|---|
| `admin` | `admin123` | 1 (Admin) |
| `opnbarang` | `operator123` | 2 (Operator Barang) |
| `opnmahasiswa` | `operator123` | 3 (Operator Mahasiswa) |

---

## 🗄️ Struktur Database

Database: `crud-php` (4 tabel)

```sql
akun       → id_akun, nama, username, email, password, level
barang     → id_barang, nama, jumlah, harga, barcode, tanggal
pegawai    → id_pegawai, nama, jabatan, email, telepon, alamat
mahasiswa  → id_mahasiswa, nama, prodi, jk, telepon, alamat, email, foto
```

---

## 📁 Struktur Project

```
crud-laravel/
├── app/
│   ├── Exports/
│   │   └── MahasiswaExport.php        # Export Excel
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/LoginController.php
│   │   │   ├── AkunController.php
│   │   │   ├── BarangController.php
│   │   │   ├── EmailController.php
│   │   │   ├── MahasiswaController.php
│   │   │   └── PegawaiController.php
│   │   └── Middleware/
│   │       └── CheckLevel.php          # Middleware hak akses
│   ├── Models/
│   │   ├── Akun.php
│   │   ├── Barang.php
│   │   ├── Mahasiswa.php
│   │   └── Pegawai.php
│   └── Rules/
│       └── Recaptcha.php               # Validasi reCAPTCHA
├── resources/views/
│   ├── auth/login.blade.php
│   ├── barang/ (index, create, edit)
│   ├── pegawai/ (index, live)
│   ├── mahasiswa/ (index, create, edit, show, pdf)
│   ├── akun/index.blade.php
│   ├── email/index.blade.php
│   └── layouts/app.blade.php           # Layout master AdminLTE
└── routes/web.php
```

---

## 🚀 Instalasi & Menjalankan di Lokal

### Prasyarat
- PHP ≥ 8.2 & Composer
- MySQL (Laragon / XAMPP)
- Extension PHP: `pdo_mysql`, `zip`, `gd`

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/USERNAME/crud-laravel.git
cd crud-laravel

# 2. Install dependencies
composer install

# 3. Salin & konfigurasi environment
copy .env.example .env        # Windows
# cp .env.example .env        # Linux/Mac
php artisan key:generate

# 4. Import database
#    - Buat database `crud-php` di phpMyAdmin
#    - Import file SQL yang tersedia di folder /database

# 5. Sesuaikan .env (DB, mail, recaptcha) lalu jalankan
php artisan serve
```

Buka `http://127.0.0.1:8000` dan login dengan akun default.

### Konfigurasi `.env` Penting

```env
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crud-php
DB_USERNAME=root
DB_PASSWORD=

# Session & cache pakai file (tanpa tabel tambahan)
SESSION_DRIVER=file
CACHE_STORE=file

# reCAPTCHA (false saat development di localhost)
RECAPTCHA_ENABLED=false
RECAPTCHA_SITE_KEY=site_key_kamu
RECAPTCHA_SECRET_KEY=secret_key_kamu

# Email SMTP Gmail (gunakan App Password)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=email_kamu@gmail.com
MAIL_PASSWORD=app_password_kamu
MAIL_ENCRYPTION=ssl
```

---

## 🌐 Deployment (InfinityFree)

Project ini sudah di-deploy dan live di **crud-rasyid.infinityfree.me**. Poin penting deployment di shared hosting tanpa SSH:

1. Upload seluruh project ke `htdocs` (kecuali `.env` lokal).
2. Buat `.htaccess` di root `htdocs` untuk mengarahkan request ke folder `public/`:
   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteRule ^(.*)$ public/$1 [L]
   </IfModule>
   Options -Indexes
   <FilesMatch "^\.">
       Require all denied
   </FilesMatch>
   ```
3. Buat `.env` production manual (`APP_DEBUG=false`, `CACHE_STORE=file`, `QUEUE_CONNECTION=sync`).
4. Import database via phpMyAdmin hosting.
5. Chmod 777: `storage/`, `bootstrap/cache/`, `public/assets/img/`.
6. Daftarkan domain hosting ke Google reCAPTCHA admin.

---

## 📸 Screenshots

| Login | Dashboard Barang |
|---|---|
| ![Login](screenshots/login.png) | ![Barang](screenshots/barang.png) |

| Data Mahasiswa | Export Excel/PDF |
|---|---|
| ![Mahasiswa](screenshots/mahasiswa.png) | ![Export](screenshots/export.png) |

> *Tambahkan folder `screenshots/` di repository lalu isi dengan gambar aplikasi.*

---

## 📝 Dokumentasi PKL

Project ini dibuat sebagai tugas **Praktik Kerja Lapangan (PKL)**:

- **Nama Peserta Didik:** Muhammad Al Rasyid
- **Instansi:** SMK Telkom Lampung
- **Pekerjaan/Proyek:** Migrasi & Deployment Aplikasi CRUD PHP Native ke Laravel 13

### Pembelajaran Utama Selama PKL
1. Migrasi arsitektur prosedural → MVC (Model, View, Controller)
2. Penerapan ORM, middleware, validation, dan security best-practice
3. Integrasi package pihak ketiga (Excel, PDF, reCAPTCHA, Mail)
4. Deployment aplikasi Laravel ke shared hosting production
5. Debugging perbedaan environment (case-sensitivity Windows vs Linux)

---

## 🙏 Credits

- Template UI: [AdminLTE 3](https://adminlte.io)
- Framework: [Laravel](https://laravel.com)
- Package: [Laravel Excel](https://laravel-excel.com), [laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)

---

## 📄 License

Project ini dibuat untuk tujuan pembelajaran PKL. © 2026 Rasyid Teknologi.
