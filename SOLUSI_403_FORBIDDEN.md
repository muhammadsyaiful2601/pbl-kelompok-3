# Solusi Error 403 Forbidden saat Upload Foto

## Masalah
Saat upload foto (sekolah atau profil) di server hosting, muncul error:
```
403 Forbidden
Access to this resource on the server is denied!
Proudly powered by LiteSpeed Web Server
```

## Penyebab
Error 403 saat upload **bukan** masalah kode PHP, melainkan **permission folder** di server. Folder uploads tidak memiliki permission write untuk web server.

## Solusi Langkah demi Langkah

### Opsi 1: Menggunakan Script Otomatis (Paling Mudah)

1. **Upload file `fix_permissions.php`** ke root folder website (public_html/)
2. **Akses via browser:** `https://domain-anda.com/fix_permissions.php`
3. **Pilih permission 755** (recommended) atau 775 jika 755 gagal
4. **Klik "Apply Permissions"**
5. **Test upload** menggunakan form di halaman tersebut
6. **DELETE file `fix_permissions.php`** setelah selesai (penting untuk keamanan!)

### Opsi 2: Manual via cPanel File Manager

1. Login ke cPanel
2. Buka **File Manager**
3. Navigasi ke folder `public_html/uploads/`
4. Klik kanan pada folder `uploads` → **Change Permissions**
5. Set permission ke **755** (atau 775 jika perlu)
6. Checklist "Recurse into subdirectories" (jika ada)
7. Klik **Change Permissions**
8. Ulangi untuk folder:
   - `uploads/sekolah/`
   - `uploads/user/`
   - `writable/`
   - `writable/cache/`
   - `writable/logs/`
   - `writable/session/`
   - `writable/uploads/`

### Opsi 3: Manual via SSH

```bash
# Masuk ke folder public_html
cd ~/public_html

# Set permission 755 untuk semua folder uploads
chmod 755 uploads
chmod 755 uploads/sekolah
chmod 755 uploads/user

# Set permission 755 untuk folder writable
chmod 755 writable
chmod 755 writable/cache
chmod 755 writable/logs
chmod 755 writable/session
chmod 755 writable/uploads

# Jika 755 tidak bekerja, coba 775
chmod 775 uploads uploads/sekolah uploads/user
chmod 775 writable writable/cache writable/logs writable/session writable/uploads

# Jika masih tidak bekerja (last resort), gunakan 777
chmod 777 uploads uploads/sekolah uploads/user
chmod 777 writable writable/cache writable/logs writable/session writable/uploads
```

### Opsi 4: Via FTP Client (FileZilla/WinSCP)

1. Connect ke server via FTP
2. Navigasi ke folder `public_html/`
3. Klik kanan folder `uploads` → **File permissions**
4. Set permission ke **755** atau **775**
5. Checklist "Recurse into subdirectories"
6. Klik **OK**
7. Ulangi untuk folder `writable/` dan subfolders

## Verifikasi

Setelah mengubah permission, test upload:

1. Login sebagai admin
2. Buka menu **Data Sekolah** → **Tambah Sekolah**
3. Upload foto dengan format JPG/JPEG/PNG (maks 5MB)
4. Klik **Simpan Data**
5. **Expected:** Foto berhasil diupload tanpa error 403

Atau test via diagnostic script:

1. Upload file `diagnose_upload.php` ke root folder
2. Akses: `https://domain-anda.com/diagnose_upload.php`
3. Script akan menampilkan status permission semua folder
4. DELETE file setelah selesai!

## Troubleshooting Lanjutan

### Jika 403 masih muncul setelah mengubah permission:

#### 1. Cek LiteSpeed Security
LiteSpeed Web Server memiliki security tambahan:
- Login ke **LiteSpeed WebAdmin**
- Buka **Security** → **AllowOverride**
- Pastikan setting untuk folder `uploads/` adalah **All**
- Cek **mod_security** rules yang mungkin memblokir upload

#### 2. Cek PHP open_basedir
Buat file `phpinfo.php`:
```php
<?php phpinfo(); ?>
```
Akses via browser dan cari `open_basedir`. Pastikan path uploads ada dalam daftar.

#### 3. Cek File Ownership
```bash
# Via SSH
ls -la public_html/uploads/
# Pastikan owner adalah user yang sama dengan web server (biasanya 'nobody' atau 'www-data')

# Jika salah, ganti ownership:
chown -R www-data:www-data public_html/uploads/
chown -R www-data:www-data public_html/writable/
```

#### 4. Cek SELinux (jika menggunakan VPS)
```bash
# Cek SELinux status
sestatus

# Jika aktif, set permission:
chcon -R -t httpd_sys_rw_content_t public_html/uploads/
chcon -R -t httpd_sys_rw_content_t public_html/writable/
```

#### 5. Cek Error Log
```bash
# Lokasi error log biasanya:
/var/log/apache2/error.log
# atau
/var/log/httpd/error_log
# atau via cPanel: Metrics → Errors
```

## File yang Telah Dibuat

1. **`fix_permissions.php`** - Script untuk otomatis mengatur permission folder
2. **`diagnose_upload.php`** - Script untuk diagnose permission dan test upload

## PENTING: Keamanan

**Setelah selesai menggunakan script, DELETE file tersebut!**
```bash
# Via File Manager: Delete file
# Via SSH:
rm fix_permissions.php
rm diagnose_upload.php
rm phpinfo.php  # jika ada
```

File-file ini menampilkan informasi sensitif tentang server dan bisa menjadi celah keamanan jika dibiarkan.

## Catatan Penting

- **Permission 755** adalah yang paling aman dan seharusnya bekerja di sebagian besar server
- **Permission 775** kadang diperlukan di shared hosting
- **Permission 777** hanya gunakan sebagai last resort (risiko keamanan tinggi)
- Selalu backup file dan database sebelum mengubah permission
- Test upload setelah mengubah permission untuk memastikan masalah teratasi

## Referensi

- CodeIgniter 4 Documentation: https://codeigniter.com/user_guide/
- DEPLOYMENT_FIX.md - Panduan deployment yang sudah ada
- .htaccess files sudah dikonfigurasi dengan benar untuk mengizinkan akses ke folder uploads

## Kontak Support

Jika masih mengalami masalah:
1. Hubungi hosting provider untuk memastikan permission sudah benar
2. Cek error log Apache/Nginx dan PHP
3. Pastikan tidak ada mod_security rule yang memblokir upload
4. Test di localhost terlebih dahulu untuk memastikan kode berfungsi