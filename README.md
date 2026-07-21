# WebGIS Pencarian Sekolah

## Deskripsi Proyek

WebGIS Pencarian Sekolah adalah aplikasi web berbasis CodeIgniter 4 yang dikembangkan untuk memetakan dan mengelola data lokasi sekolah di wilayah Kabupaten Tanah Datar. Aplikasi ini menyediakan fitur visualisasi peta interaktif berbasis Leaflet, manajemen data sekolah, dan integrasi layer GeoJSON untuk menampilkan batas-batas wilayah administratif.

### Tujuan
- Menyediakan platform pencarian dan visualisasi lokasi sekolah secara geospasial
- Memudahkan pengelolaan data sekolah dengan tampilan peta interaktif
- Mengintegrasikan data batas wilayah administratif dalam format GeoJSON
- Memberikan akses terstruktur untuk Admin dan Superadmin

### Cakupan
- Pencarian sekolah berdasarkan kriteria geografis
- CRUD data sekolah dengan koordinat GPS
- Manajemen layer GeoJSON wilayah
- Pelacakan aktivitas pengguna (audit trail)
- Pencarian dan pembersihan otomatis file GeoJSON

---

## Fitur Utama

### 1. Fitur Publik
| Fitur | Deskripsi | Route |
|-------|-----------|-------|
| Peta Interaktif | Visualisasi lokasi sekolah dengan marker | `/maps` |
| Peta Fullscreen | Tampilan peta layar penuh | `/fullmaps` |
| Detail Sekolah | Informasi lengkap sekolah dengan lokasi | `/sekolah/{id}` |

### 2. Fitur Admin
| Fitur | Deskripsi | Route |
|-------|-----------|-------|
| Dashboard | Ringkasan statistik sekolah | `/admin/dashboard` |
| Manajemen Sekolah | Tambah, edit, hapus, lihat daftar sekolah | `/admin/sekolah` |
| Upload Foto | Upload dan kelola foto sekolah | `/admin/sekolah/tambah` |

### 3. Fitur Superadmin
| Fitur | Deskripsi | Route |
|-------|-----------|-------|
| Dashboard | Ringkasan sistem dan aktivitas | `/superadmin/dashboard` |
| Manajemen Admin | Kelola akun admin (CRUD) | `/superadmin/admin` |
| Manajemen GeoJSON | Scan, edit, toggle, hapus layer GeoJSON | `/superadmin/geojson` |
| Activity Logs | Lihat dan kelola log aktivitas | `/superadmin/logs` |

---

## Arsitektur Teknis

### Teknologi Stack
- **Framework**: CodeIgniter 4
- **Bahasa**: PHP 8.2+
- **Database**: MySQL
- **Frontend**: HTML, CSS (AdminLTE), JavaScript, Leaflet.js
- **Mapping**: Leaflet.js dengan tiles OpenStreetMap

### Komponen Utama
```
pbl-kelompok-3/
├── app/
│   ├── Config/
│   │   └── Routes.php           # Definisi routing
│   ├── Controllers/
│   │   ├── Home.php             # Controller publik
│   │   ├── Auth.php             # Autentikasi
│   │   ├── Admin/
│   │   │   └── Sekolah.php      # Manajemen data sekolah
│   │   └── Superadmin/
│   │       ├── Admin.php        # Manajemen akun admin
│   │       ├── ActivityLog.php  # Log aktivitas
│   │       ├── Geojson.php      # Manajemen GeoJSON
│   │       └── Dashboard.php    # Dashboard superadmin
│   ├── Models/
│   │   ├── SekolahModel.php     # Model tabel sekolah
│   │   ├── GeojsonModel.php     # Model tabel geojson
│   │   └── ...
│   └── Views/
│       ├── maps.php             # Halaman peta publik
│       ├── detail.php           # Detail sekolah
│       ├── admin/sekolah/       # View manajemen sekolah
│       └── superadmin/          # View panel superadmin
├── public/
│   ├── assets/
│   │   └── geojson/             # File GeoJSON batas wilayah
│   ├── uploads/sekolah/         # Foto sekolah
│   └── marker/                  # Custom marker peta
├── writable/
│   ├── sekolah_data.json        # Cache data sekolah
│   └── ...
└── composer.json
```

---

## Struktur Database

### Tabel: `user`
Menyimpan data pengguna (Admin dan Superadmin)
- `id_user` (PK, Auto Increment)
- `username` (Unique)
- `nama_lengkap`
- `password` (Hashed)
- `role` (ENUM: superadmin, admin)
- `foto` (Path foto profil)

### Tabel: `sekolah`
Menyimpan informasi lengkap sekolah
- `id_sekolah` (PK, Auto Increment)
- `nama_sekolah`
- `npsn` (Nomor Pokok Sekolah Nasional)
- `jenjang` (SD/SMP/SMA/SMK)
- `kategori` (Negeri/Swasta)
- `foto`
- `alamat`
- `kurikulum`
- `deskripsi_sekolah`
- `website`
- `latitude`, `longitude` (Koordinat GPS)
- `tipe_objek`
- `koordinat_polygon` (JSON)
- `akreditasi` (ENUM: A, B, C, Belum Terakreditasi, Tidak Diketahui)
- `kepala_sekolah`
- `kontak`
- `tahun_berdiri`
- `visi`, `misi`

### Tabel: `geojson`
Menyimpan konfigurasi layer batas wilayah
- `id_geojson` (PK, Auto Increment)
- `nama_geojson` (Nama layer)
- `file_geojson` (Path file .geojson)
- `warna_geojson` (Kode hex, default: #3388ff)
- `opacity_geojson` (Nilai 0-1, default: 0.70)
- `is_active` (Boolean, default: 1)
- `style_geojson` (JSON custom style)
- `created_at`, `updated_at`

### Tabel: `activity_logs`
Audit trail pengguna
- `id` (PK, Auto Increment)
- `id_user`, `username`, `nama_lengkap`, `role`
- `action` (ENUM: tambah, ubah, hapus)
- `target_table`, `target_id`
- `description`
- `ip_address`
- `created_at`
- `retention_days` (Default: 30 hari)

### Tabel: `log_retention_settings`
Konfigurasi retensi log
- `id` (PK)
- `key` (Unique, nama setting)
- `value` (Nilai retensi)
- `updated_at`

### Tabel: `ci_sessions`
Sesi database CodeIgniter (default)

---

## Role & Permission

### Admin
- Login ke sistem
- Melihat dashboard
- CRUD data sekolah (tambah, edit, hapus)
- Upload dan kelola foto sekolah
- Melihat detail sekolah

### Superadmin
- Semua akses Admin
- Manajemen akun admin
- Manajemen layer GeoJSON (scan, activate/deactivate, edit style, hapus)
- Melihat dan membersihkan log aktivitas

---

## Alur Penggunaan

### Alur Publik (Pengunjung)
1. Akses halaman `/maps` untuk melihat peta interaktif
2. Klik marker sekolah untuk melihat info singkat
3. Klik "Detail" untuk melihat informasi lengkap sekolah
4. Akses `/fullmaps` untuk tampilan peta layar penuh

### Alur Admin
1. Login ke `/login`
2. Dashboard menampilkan ringkasan data sekolah
3. Kelola data sekolah:
   - Tambah sekolah baru dengan koordinat GPS
   - Edit data sekolah yang ada
   - Hapus data sekolah (beserta foto)
   - Upload foto sekolah (maks. 10MB, format JPG/JPEG/PNG)
4. Sistem mencatat semua perubahan ke activity log

### Alur Superadmin
1. Login dan akses panel `/superadmin/dashboard`
2. Manajemen Admin:
   - Tambah akun admin baru
   - Edit data admin
   - Hapus akun admin
3. Manajemen GeoJSON:
   - **Scan**: Otomatis memindai direktori `public/assets/geojson/id1305_tanah_datar/` untuk file baru
   - **Edit**: Ubah nama, warna, dan opacity layer
   - **Toggle**: Aktifkan/nonaktifkan layer
   - **Hapus**: Hapus satu atau multiple layer
   - **Clean**: Bersihkan nama layer dari format ID (e.g., "id1305 ..." → "...")
4. Activity Logs:
   - Lihat semua aktivitas pengguna
   - Hapus log tertentu atau bersihkan semua log

---

## Instalasi & Setup

### Prerequisites
- PHP 8.2 atau lebih tinggi
- MySQL 5.7+ atau MariaDB
- Composer
- Web server (Apache dengan mod_rewrite atau Nginx)

### Dependencies PHP
- intl
- mbstring
- mysqlnd (untuk MySQL)
- libcurl (untuk HTTP requests)
- json (default)
- fileinfo (upload foto)

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/muhammadsyaiful2601/pbl-kelompok-3.git
cd pbl-kelompok-3
```

2. **Install Dependencies**
```bash
composer install
```

3. **Konfigurasi Environment**
```bash
# Copy file environment
cp env .env

# Edit .env sesuai setting:
# - app.baseURL = 'http://localhost/pbl-kelompok-3/public/'
# - database.default.hostname = localhost
# - database.default.database = pbl_kel3
# - database.default.username = root
# - database.default.password =
```

4. **Setup Database**
```bash
# Buat database MySQL bernama 'pbl_kel3'
# Jalankan migrasi
php spark migrate
```

5. **Seed Data** (Opsional - untuk GeoJSON)
```bash
# Jika ingin menambahkan data GeoJSON awal
php spark db:seed SekolahSeeder
```

6. **Konfigurasi Web Server**

Pastikan document root mengarah ke folder `public/`.  
Contoh konfigurasi Apache `.htaccess`:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

7. **Folder Permissions** (Linux/Mac)
```bash
chmod -R 755 writable/
mkdir -p public/uploads/sekolah
chmod -R 755 public/uploads/
```

8. **Akses Aplikasi**
```
http://localhost/pbl-kelompok-3/public/
```

---

## Konfigurasi Awal

### Akun Default
Setelah migrasi, buat akun admin pertama:
```bash
php spark make:controller Auth
# Lalu akses /register (jika fitur register tersedia)
# Atau insert manual ke tabel 'user' dengan password hash
```

### File GeoJSON
Letakkan file GeoJSON di direktori:
```
public/assets/geojson/id1305_tanah_datar/
```

Format nama file yang didukung:
- `id1305_<nama_wilayah>.geojson`
- File akan otomatis di-scan oleh fitur Superadmin

### Marker Peta
Custom marker tersedia di:
```
public/marker/Logo smk.png
```

---

## API & Integrasi

### Leaflet.js
Digunakan untuk rendering peta interaktif:
- Tiles: OpenStreetMap
- Custom markers
- Overlay GeoJSON layers
- Popup informasi sekolah

### GeoJSON Layer
- Mendukung polygon, multipolygon
- Style customizable (warna, opacity)
- Toggle visibility
- Z-index management

---

## Script Pendukung

### Seeders
- `app/Database/Seeds/SekolahSeeder.php` - Seed data sekolah contoh

### Migrations
- `app/Database/Migrations/2026-07-04-000000_ConsolidatedMigrations.php` - Semua tabel
- Migrasi One-Click untuk deployment

### Assets
- `public/assets/js/script-publik.js` - Script peta publik
- `public/assets/api/api_maps.js` - Helper API maps

---

## Testing

### Unit Tests
```
tests/
├── unit/                      # Unit tests
├── database/                 # Database tests
├── session/                  # Session tests
└── _support/                 # Test helpers
```

Jalankan test:
```bash
php spark test
```
Atau menggunakan PHPUnit:
```bash
vendor/bin/phpunit
```

---

## Deployment

### Database Setup untuk Production
```bash
# Migrasi
php spark migrate

# Opsional: Seed data
php spark db:seed SekolahSeeder
```

### Folder yang Harus Writable Berizin
- `writable/cache/`
- `writable/logs/`
- `writable/session/`
- `writable/uploads/sekolah/`
- `public/uploads/sekolah/`

### Environment Production
Pastikan di `.env`:
```ini
CI_ENVIRONMENT = production
app.debug = false
app.logThreshold = 1
```

---

## Kontributor

- Muhammad Syaiful (muhammadsyaiful2601)
- Tim PBL Kelompok 3

---

## Lisensi

Proyek ini dilisensikan under [MIT License](LICENSE).

---

## Kontak

**Repository**: https://github.com/muhammadsyaiful2601/pbl-kelompok-3

**Issues**: Gunakan GitHub Issues untuk melaporkan bug atau request fitur.

---

## Changelog

### v2.0 (2026-07-04)
- Integrasi GeoJSON layer untuk batas wilayah
- Sistem audit trail activity logs
- Fitur scan dan clean GeoJSON otomatis
- Multi-user role (Admin & Superadmin)
- Upload foto sekolah
- Database schema redesign

### v1.0 (Awal)
- CRUD sekolah dasar
- Peta interaktif dasar