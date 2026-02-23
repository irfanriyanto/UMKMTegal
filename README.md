# 🏪 UMKM Lokal — Platform Digital UMKM Kota Tegal

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/Livewire-3-FB70A9?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire 3">
  <img src="https://img.shields.io/badge/TailwindCSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS 3">
  <img src="https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL 8">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
</p>

**UMKM Lokal** adalah platform digital berbasis web yang dirancang untuk mendukung dan mempromosikan Usaha Mikro, Kecil, dan Menengah (UMKM) di Kota Tegal, Jawa Tengah. Platform ini menyediakan ruang bagi pelaku UMKM untuk memamerkan profil usaha dan produk mereka, sekaligus menjadi sumber informasi bagi masyarakat mengenai UMKM lokal.

---

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Struktur Project](#-struktur-project)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi & Setup](#-instalasi--setup)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Struktur Database](#-struktur-database)
- [Sistem Peran Pengguna](#-sistem-peran-pengguna)
- [Deployment](#-deployment)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## ✨ Fitur Utama

### 🌐 Halaman Publik
- **Beranda** — Menampilkan UMKM unggulan, produk populer, artikel terbaru, dan event mendatang
- **Katalog Produk** — Jelajahi produk UMKM dengan fitur pencarian dan filter kategori
- **Direktori UMKM** — Daftar semua UMKM terdaftar beserta profil lengkapnya
- **Artikel & Blog** — Berita dan artikel seputar UMKM Kota Tegal
- **Event** — Informasi event & kegiatan yang melibatkan UMKM
- **Kontak** — Formulir pesan kontak untuk pengunjung
- **Halaman Tentang** — Informasi tentang platform UMKM Lokal
- **Dukung Kami** — Halaman ajakan dukungan untuk UMKM lokal

### 👤 Dashboard UMKM (Pemilik Usaha)
- **Manajemen Profil** — Kelola profil usaha lengkap (deskripsi, alamat, foto, kontak)
- **Manajemen Produk** — CRUD produk (nama, deskripsi, harga, gambar produk)
- **Statistik** — Lihat statistik kunjungan profil dan produk
- **Dashboard** — Ringkasan data usaha

### 🛡️ Dashboard Admin
- **Manajemen UMKM** — Verifikasi, kelola, dan pantau semua UMKM terdaftar
- **Manajemen Produk** — Pengawasan seluruh produk di platform
- **Manajemen Artikel** — Buat, edit, dan publikasi artikel
- **Manajemen Event** — Buat dan kelola event UMKM
- **Pesan Masuk** — Kelola pesan kontak dari pengunjung
- **Dashboard Statistik** — Overview data platform secara keseluruhan

### 🔐 Autentikasi & Keamanan
- Registrasi dengan verifikasi OTP
- Login/Logout dengan role-based access
- Middleware perlindungan route berdasarkan peran
- Session encryption dan CSRF protection

---

## 🛠️ Tech Stack

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| **PHP** | 8.2+ | Backend runtime |
| **Laravel** | 12 | Framework backend |
| **Livewire** | 3.x | Komponen interaktif tanpa JavaScript |
| **Livewire Volt** | 1.x | Single-file Livewire components |
| **Laravel Breeze** | 2.x | Scaffolding autentikasi |
| **TailwindCSS** | 3.x | Utility-first CSS framework |
| **MySQL** | 8.0 | Database |
| **Vite** | 7.x | Build tool frontend |
| **Docker** | - | Containerized development & deployment |

---

## 📁 Struktur Project

```
umkm/
├── app/
│   ├── Enums/              # Enum classes (UserRole)
│   ├── Http/               # Controllers & Middleware
│   ├── Livewire/           # Livewire Components
│   │   ├── Actions/        # Reusable actions (Logout)
│   │   ├── Admin/          # Admin dashboard components
│   │   ├── Articles/       # Artikel listing & detail
│   │   ├── Contact/        # Kontak form & listing
│   │   ├── Events/         # Event listing & detail
│   │   ├── Forms/          # Reusable form components
│   │   ├── Home/           # Homepage sections
│   │   ├── Products/       # Produk listing & detail
│   │   └── Umkm/           # UMKM dashboard components
│   ├── Mail/               # Mailable classes
│   ├── Models/             # Eloquent models (13 models)
│   ├── Policies/           # Authorization policies
│   ├── Providers/          # Service providers
│   ├── Traits/             # Reusable traits
│   └── View/               # View components
├── config/                 # Konfigurasi aplikasi
├── database/
│   ├── factories/          # Model factories
│   ├── migrations/         # Database migrations (19 files)
│   └── seeders/            # Database seeders
├── docker/                 # Docker configuration
│   ├── nginx/              # Nginx config
│   └── php/                # PHP Dockerfile & config
├── public/                 # Public assets
├── resources/
│   ├── css/                # Stylesheet
│   ├── js/                 # JavaScript
│   └── views/              # Blade templates
│       ├── admin/          # Admin dashboard views
│       ├── components/     # Reusable Blade components
│       ├── emails/         # Email templates
│       ├── layouts/        # Layout templates
│       ├── livewire/       # Livewire Blade views
│       ├── pages/          # Public page views
│       └── umkm/           # UMKM dashboard views
├── routes/
│   ├── web.php             # Web routes
│   ├── api.php             # API routes
│   └── auth.php            # Authentication routes
├── storage/                # File storage & logs
├── docker-compose.yml      # Docker Compose config
├── composer.json           # PHP dependencies
├── package.json            # Node.js dependencies
├── tailwind.config.js      # TailwindCSS config
└── vite.config.js          # Vite config
```

---

## 💻 Persyaratan Sistem

- **PHP** >= 8.2 dengan ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`
- **Composer** >= 2.x
- **Node.js** >= 18.x & **NPM** >= 9.x
- **MySQL** >= 8.0
- **Git**

Atau cukup gunakan **Docker** & **Docker Compose** untuk menjalankan semua dependensi secara otomatis.

---

## 🚀 Instalasi & Setup

### Metode 1: Setup Manual

```bash
# 1. Clone repository
git clone https://github.com/irfanriyanto/UMKMTegal.git
cd UMKMTegal

# 2. Install dependencies PHP
composer install

# 3. Install dependencies Node.js
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi database di file .env
# Sesuaikan DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 7. Jalankan migrasi database
php artisan migrate

# 8. (Opsional) Jalankan seeder untuk data awal
php artisan db:seed

# 9. Buat symbolic link untuk storage
php artisan storage:link

# 10. Build assets frontend
npm run build
```

### Metode 2: Docker (Rekomendasi)

```bash
# 1. Clone repository
git clone https://github.com/irfanriyanto/UMKMTegal.git
cd UMKMTegal

# 2. Salin file environment
cp .env.example .env

# 3. Jalankan seluruh service dengan Docker Compose
docker-compose up -d

# 4. Install dependencies di dalam container
docker exec umkm_app composer install
docker exec umkm_app php artisan key:generate
docker exec umkm_app php artisan migrate --seed
docker exec umkm_app php artisan storage:link

# 5. Build frontend assets
docker exec umkm_node npm install
docker exec umkm_node npm run build
```

---

## ▶️ Menjalankan Aplikasi

### Development Server (Manual)

```bash
# Jalankan semua service sekaligus (server, queue, logs, vite)
composer dev
```

Atau jalankan secara terpisah:

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server (hot reload)
npm run dev
```

Akses aplikasi di: **http://localhost:8000**

### Docker

```bash
docker-compose up -d
```

Akses aplikasi di: **http://localhost:8000**

---

## 🗄️ Struktur Database

Aplikasi ini menggunakan **19 tabel migrasi** dengan relasi sebagai berikut:

```
users
├── umkm_profiles (1:1)
│   ├── umkm_photos (1:N)
│   ├── products (1:N)
│   │   ├── product_images (1:N)
│   │   └── product_views (1:N)
│   ├── profile_views (1:N)
│   └── event_umkm (N:N pivot)
├── otp_codes (1:N)
└── articles (1:N) [admin only]

categories
└── products (1:N)

events
└── event_umkm (N:N pivot)

articles (standalone)
contact_messages (standalone)
faqs (standalone)
```

### Tabel Utama

| Tabel | Deskripsi |
|-------|-----------|
| `users` | Data pengguna (admin & pemilik UMKM) |
| `umkm_profiles` | Profil lengkap usaha UMKM |
| `umkm_photos` | Foto-foto galeri UMKM |
| `products` | Data produk UMKM |
| `product_images` | Gambar produk (multiple) |
| `categories` | Kategori produk |
| `articles` | Artikel/blog |
| `events` | Data event & kegiatan |
| `event_umkm` | Pivot UMKM-Event (many-to-many) |
| `contact_messages` | Pesan kontak dari pengunjung |
| `profile_views` | Tracking kunjungan profil UMKM |
| `product_views` | Tracking kunjungan produk |
| `faqs` | Frequently Asked Questions |
| `otp_codes` | Kode OTP untuk verifikasi |

---

## 👥 Sistem Peran Pengguna

Aplikasi menggunakan **role-based access control** dengan dua peran:

| Peran | Akses | Prefix Route |
|-------|-------|--------------|
| **Admin** | Full access — kelola seluruh konten platform | `/admin/*` |
| **UMKM** | Kelola profil, produk, dan statistik usaha sendiri | `/umkm-dashboard/*` |

### Akun Default (Seeder)

Setelah menjalankan `php artisan db:seed`, tersedia akun berikut:

| Peran | Akses Via |
|-------|-----------|
| Admin | Sesuai data di `AdminUserSeeder` |
| UMKM | Sesuai data di `UmkmUserSeeder` |

> ⚠️ **Penting:** Ganti password default setelah login pertama kali!

---

## 🌍 Deployment

Untuk deployment ke production, gunakan file `.env.production.example` sebagai referensi:

```bash
cp .env.production.example .env
```

### Checklist Production

- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY` sudah di-generate
- [ ] `APP_URL` menggunakan HTTPS
- [ ] `SESSION_ENCRYPT=true`
- [ ] `SESSION_SECURE_COOKIE=true`
- [ ] Database credentials yang aman
- [ ] `LOG_LEVEL=warning` atau `error`
- [ ] SSL certificate terpasang
- [ ] File permissions benar (`storage/`, `bootstrap/cache/`)

### Optimasi Production

```bash
# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build assets
npm run build

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

---

## 🤝 Kontribusi

Kontribusi sangat terbuka! Berikut langkah-langkahnya:

1. **Fork** repository ini
2. Buat **branch** fitur baru (`git checkout -b fitur/fitur-baru`)
3. **Commit** perubahan (`git commit -m 'Menambahkan fitur baru'`)
4. **Push** ke branch (`git push origin fitur/fitur-baru`)
5. Buat **Pull Request**

### Panduan Kontribusi

- Pastikan kode mengikuti code style Laravel (gunakan `./vendor/bin/pint` untuk formatting)
- Tulis commit message yang deskriptif dalam Bahasa Indonesia
- Sertakan screenshot jika ada perubahan UI

---

## 📄 Lisensi

Project ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

---

<p align="center">
  Dibuat dengan ❤️ untuk UMKM Kota Tegal
</p>
