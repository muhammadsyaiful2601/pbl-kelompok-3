# Panduan Deployment - Perbaikan Error 403 Forbidden

## Ringkasan Perbaikan

Dokumen ini menjelaskan perbaikan yang telah dilakukan untuk mengatasi error **403 Forbidden** pada saat upload foto sekolah dan foto profil.

## Masalah yang Ditemukan

### 1. CSRF Cookie Domain Terbatas
**File:** `app/Config/Security.php`
- **Masalah:** CSRF cookie domain di-hardcode ke `.sisteminformasiduaa.my.id`
- **Dampak:** Cookie CSRF tidak bekerja pada domain hosting lain
- **Perbaikan:** Diubah menjadi `null` agar menggunakan domain otomatis

### 2. Path Upload File Tidak Absolut
**File:** `app/Controllers/Admin/Sekolah.php` dan `app/Controllers/Profile.php`
- **Masalah:** Menggunakan path relatif (`uploads/sekolah/`, `uploads/user/`)
- **Dampak:** File tidak terupload dengan benar di hosting
- **Perbaikan:** Menggunakan `FCPATH` untuk path absolut

### 3. Missing Directory Creation
**File:** `app/Controllers/Admin/Sekolah.php` dan `app/Controllers/Profile.php`
- **Masalah:** Tidak ada pengecekan dan pembuatan direktori upload
- **Dampak:** Upload gagal jika direktori belum ada
- **Perbaikan:** Menambahkan `mkdir()` jika direktori belum ada

## Langkah-langkah Deployment

### 1. Upload File ke Hosting

Upload semua file dan folder proyek ke hosting, pastikan struktur folder tetap sama:

```
public_html/ (atau www/ atau htdocs/)
├── app/
├── public/
│   ├── uploads/
│   │   ├── sekolah/
│   │   │   └── .htaccess
│   │   ├── user/
│   │   │   └── .htaccess
│   │   └── .htaccess
│   ├── assets/
│   ├── gambar/
│   └── index.php
├── writable/
├── .env
└── [file-file lainnya]
```

### 2. Set Permission Folder

Jalankan perintah berikut via SSH atau File Manager:

```bash
# Set permission untuk folder uploads (penting!)
chmod 755 public/uploads
chmod 755 public/uploads/sekolah
chmod 755 public/uploads/user

# Set permission untuk folder writable
chmod 755 writable
chmod 755 writable/cache
chmod 755 writable/logs
chmod 755 writable/session
chmod 755 writable/uploads

# Jika menggunakan shared hosting, kadang perlu 775 atau 777
# Coba 755 terlebih dahulu, jika gagal naikkan ke 775
```

### 3. Konfigurasi .env

Edit file `.env` sesuai dengan konfigurasi hosting:

```env
CI_ENVIRONMENT = production

app.baseURL = 'https://domain-anda.com/'  # Ganti dengan domain Anda

database.default.hostname = localhost
database.default.database = nama_database
database.default.username = username_db
database.default.password = password_db
database.default.DBDriver = MySQLi
database.default.port = 3306

# Session configuration
session.driver = 'CodeIgniter\Session\Handlers\DatabaseHandler'
session.savePath = 'ci_sessions'
session.cookieName = 'ci_session'
session.expiration = 7200
session.matchIP = false
session.timeToUpdate = 300

# Encryption (generate dengan: php spark key:generate)
encryption.key = 'GENERATE_KEY_DISINI'
```

**PENTING:** Generate encryption key dengan menjalankan:
```bash
php spark key:generate
```

### 4. Konfigurasi Database

Import database dari file SQL yang disediakan. Pastikan tabel `ci_sessions` sudah dibuat untuk session handler.

### 5. Verifikasi .htaccess

Pastikan file `.htaccess` di folder uploads sudah benar:

**public/uploads/.htaccess:**
```apache
# Allow access to files in uploads directory
<IfModule mod_authz_core_module>
    Require all granted
</IfModule>
<IfModule !mod_authz_core_module>
    Order Allow,Deny
    Allow from all
</IfModule>

# Prevent PHP execution in uploads directory
<FilesMatch "\.php$">
    <IfModule mod_authz_core_module>
        Require all denied
    </IfModule>
    <IfModule !mod_authz_core_module>
        Order Allow,Deny
        Deny from all
    </IfModule>
</FilesMatch>
```

### 6. Cek Konfigurasi PHP

Pastikan PHP di hosting memiliki konfigurasi berikut (cek di `php.ini` atau `.htaccess`):

```ini
upload_max_filesize = 10M
post_max_size = 12M
max_execution_time = 300
max_input_time = 300
```

Jika tidak bisa mengedit `php.ini`, tambahkan di `.htaccess`:

```apache
php_value upload_max_filesize 10M
php_value post_max_size 12M
php_value max_execution_time 300
```

### 7. Testing

Setelah deployment, test fitur-fitur berikut:

1. **Upload Foto Sekolah:**
   - Login sebagai admin
   - Buka menu "Data Sekolah"
   - Klik "Tambah Sekolah" atau "Edit" pada sekolah yang ada
   - Upload foto dengan format JPG/JPEG/PNG (maks 5MB)
   - Klik "Simpan Data"
   - **Expected:** Foto berhasil diupload dan ditampilkan

2. **Upload Foto Profil:**
   - Login sebagai admin/superadmin
   - Buka menu "Profil Saya"
   - Upload foto profil
   - Klik "Simpan Perubahan"
   - **Expected:** Foto profil berhasil diupdate

3. **Akses File Upload:**
   - Setelah upload, coba akses file melalui browser:
   - `https://domain-anda.com/uploads/sekolah/nama-file.jpg`
   - `https://domain-anda.com/uploads/user/nama-file.jpg`
   - **Expected:** File dapat diakses (tidak ada error 403)

## Troubleshooting

### Error 403 masih muncul?

1. **Cek permission folder:**
   ```bash
   ls -la public/uploads/
   # Pastikan permission adalah 755 atau 775
   ```

2. **Cek ownership:**
   ```bash
   # Pastikan folder dimiliki oleh user yang sama dengan web server
   chown -R www-data:www-data public/uploads/
   ```

3. **Cek .htaccess:**
   - Pastikan `AllowOverride All` aktif di konfigurasi Apache
   - Cek error log Apache untuk detail error

4. **Cek error log:**
   ```bash
   # Lokasi error log biasanya di:
   /var/log/apache2/error.log
   # atau
   /var/log/httpd/error_log
   ```

### File tidak bisa diupload?

1. Cek `upload_max_filesize` dan `post_max_size` di phpinfo()
2. Pastikan folder uploads memiliki permission write
3. Cek error log PHP untuk detail error

### CSRF Token Mismatch?

1. Pastikan cookie di browser aktif
2. Cek apakah domain cookie sesuai dengan domain website
3. Clear cache dan cookies browser

## File yang Telah Diperbaiki

1. ✅ `app/Config/Security.php` - CSRF cookie domain diubah ke null
2. ✅ `app/Controllers/Admin/Sekolah.php` - Path upload menggunakan FCPATH
3. ✅ `app/Controllers/Profile.php` - Path upload menggunakan FCPATH

## Kontak Support

Jika masih mengalami masalah, periksa:
- Error log Apache/Nginx
- Error log PHP
- Browser console (F12) untuk error JavaScript
- Network tab untuk melihat response dari server

## Catatan Penting

- Selalu backup file dan database sebelum deployment
- Test di localhost terlebih dahulu sebelum upload ke hosting
- Gunakan HTTPS di production untuk keamanan
- Jangan gunakan permission 777 kecuali sangat diperlukan (risiko keamanan)