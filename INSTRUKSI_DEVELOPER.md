# ⚠️ PENTING - LANGKAH LENGKAP UNTUK FIX ERROR 403

## Error yang Muncul:
1. "Cannot assign null to property Config\Security::$cookiePath of type string"
2. Environment masih "development" (seharusnya "production")
3. Cache masih menyimpan data lama (regenerate => true)

## Penyebab:
File **Security.php** yang ada di hosting masih versi LAMA (sebelum diperbaiki). Anda harus upload ulang file yang sudah diperbaiki.

---

## LANGKAH-LENGKAH UNTUK PERBAIKI:

### 1. Download/Ambil File dari Komputer Lokal:

Ambil 3 file ini dari komputer Anda (yang sudah diperbaiki):

```
✅ app/Config/Security.php  (VERSI TERBARU - cookiePath sudah nullable)
✅ app/Config/Filters.php   (CSRF sudah aktif)
✅ .env                      (sudah production mode)
```

### 2. Upload ke Hosting:

Upload 3 file di atas **MENGANTIKAN** file yang lama di hosting.

**Penting:** File `Security.php` yang ada di hosting harus diganti dengan yang baru (yang sudah ada `?string` untuk cookiePath).

### 3. Buat File .htaccess Baru:

Buat 3 file baru di hosting:

```
📄 public/uploads/.htaccess
📄 public/uploads/sekolah/.htaccess
📄 public/uploads/user/.htaccess
```

Isi dengan kode yang ada di file lokal.

### 4. HAPUS CACHE (SANGAT PENTING!):

Ini adalah penyebab utama error yang terus muncul!

**Cara 1 - Via FTP/File Manager (PALING MUDAH):**
1. Buka FTP atau File Manager hosting
2. Masuk ke folder: `writable/cache/`
3. **HAPUS SEMUA FILE** yang ada di folder tersebut
4. File yang penting dihapus: `FactoriesCache_config`

**Cara 2 - Via Browser (jika ada akses terminal):**
```
https://webgiskel3.sisteminformasiduaa.my.id/cache/clear
```

### 5. Test Lagi:

1. Tutup browser sepenuhnya
2. Buka kembali website
3. Login ke admin
4. Coba submit form dengan foto

---

## CEKLIST VERIFIKASI:

Pastikan semua ini sudah dilakukan:

- [ ] File `Security.php` yang diupload adalah yang **BARU** (dengan `?string $cookiePath`)
- [ ] File `.env` sudah diupload (environment = production)
- [ ] File `Filters.php` sudah diupload (CSRF aktif)
- [ ] 3 file `.htaccess` sudah dibuat di folder uploads
- [ ] Cache di `writable/cache/` sudah **DIHAPUS SEMUA**
- [ ] Browser sudah di-refresh (Ctrl+Shift+R)

---

## Jika Error Masih Muncul:

**Kemungkinan besar: Cache belum di-clear!**

1. Cek kembali folder `writable/cache/` - harusnya KOSONG
2. Jika masih ada file, hapus lagi
3. Cek apakah file `Security.php` yang diupload adalah yang benar (buka file dan pastikan ada `?string` di baris cookiePath)

---

## File yang Sudah Diperbaiki di Komputer Lokal:

Semua file sudah diperbaiki dan siap diupload:
- ✅ Security.php - cookieDomain dan cookiePath sekarang nullable (`?string`)
- ✅ Filters.php - CSRF aktif
- ✅ .env - production mode
- ✅ 3 file .htaccess untuk uploads

**Yang perlu Anda lakukan hanyalah: UPLOAD + CLEAR CACHE**

---

## Butuh Bantuan?

Jika masih error setelah mengikuti langkah di atas:
1. Screenshot error message
2. Screenshot isi folder `writable/cache/` (harusnya kosong)
3. Screenshot isi file `Security.php` yang ada di hosting (baris 54-58)