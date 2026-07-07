# Fix untuk Error 403 Forbidden saat Upload Foto

## Masalah
Error 403 Forbidden muncul ketika menyimpan data sekolah yang memiliki foto di website yang sudah di-hosting.

## Penyebab
Terdapat beberapa penyebab yang memungkinkan:

1. **CSRF Protection tidak aktif** - Filter CSRF dinonaktifkan di konfigurasi global
2. **Token CSRF regenerasi** - Token CSRF yang regenerasi setiap submit menyebabkan mismatch
3. **Upload directory tidak memiliki .htaccess** - Direktori upload tidak memiliki konfigurasi akses yang benar
4. **Cookie CSRF tidak memiliki path yang benar** - Cookie CSRF hanya berlaku untuk path tertentu

## Solusi yang Telah Diterapkan

### 1. Mengaktifkan CSRF Filter Global
**File:** `app/Config/Filters.php`

CSRF filter telah diaktifkan secara global untuk melindungi semua POST request:

```php
public array $globals = [
    'before' => [
        // 'honeypot',
        'csrf',  // CSRF filter diaktifkan
        // 'invalidchars',
    ],
    ...
];
```

### 2. Menonaktifkan Regenerasi Token CSRF
**File:** `app/Config/Security.php`

Regenerasi token dinonaktifkan untuk mencegah token mismatch:

```php
public bool $regenerate = false;
```

### 3. Menambahkan Cookie Path untuk CSRF
**File:** `app/Config/Security.php`

Cookie path diatur agar berlaku untuk seluruh aplikasi:

```php
public string $cookiePath = '/';
```

### 4. Membuat .htaccess untuk Direktori Upload
**File:** `public/uploads/sekolah/.htaccess` (BARU)

File ini dibuat untuk mengizinkan akses publik ke file yang diupload:

```apache
# Allow access to uploaded images
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

## Langkah-langkah Deployment ke Hosting

### 1. Upload File yang Diubah
Upload file-file berikut ke hosting Anda:

- `app/Config/Filters.php`
- `app/Config/Security.php`
- `public/uploads/sekolah/.htaccess` (file baru)

### 2. Buat Direktori Upload (jika belum ada)
Pastikan direktori `public/uploads/sekolah/` ada di hosting. Jika belum, buat melalui FTP atau File Manager.

### 3. Set Permission Direktori
Set permission untuk direktori upload:

```bash
# Via FTP/File Manager, set permission ke:
public/uploads/ = 755 atau 775
public/uploads/sekolah/ = 755 atau 775
```

### 4. Clear Cache (jika perlu)
Jika menggunakan caching, clear cache setelah deploy:

```bash
# Via terminal/SSH
php spark cache:clear
```

### 5. Test Upload Foto
1. Login ke admin panel
2. Buka menu "Data Sekolah"
3. Klik "Tambah Sekolah Baru"
4. Isi form termasuk upload foto
5. Klik "Simpan Data"

## Troubleshooting

### Jika masih muncul error 403:

1. **Cek error logs** di hosting untuk melihat pesan error yang detail
2. **Pastikan mod_rewrite aktif** di Apache
3. **Cek cookie browser** - pastikan cookie `csrf_cookie_name` tersimpan
4. **Cek file permissions** - pastikan direktori `writable/` memiliki permission yang benar (755/775)
5. **Cek session driver** - pastikan session menggunakan database (sesuai .env)

### Jika foto tidak bisa diupload:

1. **Cek disk quota** - pastikan ada ruang disk yang cukup
2. **Cek upload_max_filesize** di php.ini hosting (minimal 5M)
3. **Cek post_max_size** di php.ini hosting (minimal 5M)

## Catatan Keamanan

- File `.htaccess` di `public/uploads/sekolah/` mencegah eksekusi file PHP di direktori upload
- CSRF protection aktif untuk mencegah serangan Cross-Site Request Forgery
- Token CSRF tidak diregenerasi untuk menghindari mismatch pada form dengan upload file

## Kontak Support

Jika masalah masih berlanjut, periksa:
1. Error logs di `writable/logs/`
2. Browser console untuk error JavaScript
3. Network tab di Developer Tools untuk melihat response dari server