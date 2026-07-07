#!/usr/bin/env bash

# ==============================================================================
# Script: fix_permissions.sh
# Deskripsi: Otomatis memperbaiki permission folder/file dan membersihkan cache.
#           Sangat berguna setelah melakukan git pull/git merge di hosting.
# ==============================================================================

# Warna output
GREEN='\033[0;32m'
NC='\033[0m' # No Color
YELLOW='\033[1;33m'
RED='\033[0;31m'

echo -e "${YELLOW}=== Memulai Proses Perbaikan Permission & Cache ===${NC}"

# Tentukan direktori root absolut dari script ini
ROOT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$ROOT_DIR" || exit 1

# List direktori wajib yang memerlukan permission write
WRITABLE_DIRS=(
    "writable"
    "writable/cache"
    "writable/logs"
    "writable/session"
    "writable/uploads"
    "writable/debugbar"
    "public/uploads"
    "public/uploads/sekolah"
    "public/uploads/user"
)

# 1. Pastikan folder-folder di atas ada
echo "Memeriksa dan membuat direktori jika belum ada..."
for dir in "${WRITABLE_DIRS[@]}"; do
    if [ ! -d "$ROOT_DIR/$dir" ]; then
        echo "Membuat folder: $dir"
        mkdir -p "$ROOT_DIR/$dir"
    fi
done

# 2. Atur Permission Folder ke 755 (atau 775 jika diperlukan)
echo "Mengatur permissions folder ke 755 (atau 775 jika diperlukan)..."
# Pertama coba 755 untuk folder-folder target
for dir in "${WRITABLE_DIRS[@]}"; do
    if [ -d "$ROOT_DIR/$dir" ]; then
        chmod 755 "$ROOT_DIR/$dir" 2>/dev/null || chmod 775 "$ROOT_DIR/$dir" 2>/dev/null
    fi
done

# Menyetel semua subfolder di public/uploads dan writable ke 755/775
find "$ROOT_DIR/public/uploads" -type d -exec chmod 755 {} \; 2>/dev/null || find "$ROOT_DIR/public/uploads" -type d -exec chmod 775 {} \; 2>/dev/null
find "$ROOT_DIR/writable" -type d -exec chmod 755 {} \; 2>/dev/null || find "$ROOT_DIR/writable" -type d -exec chmod 775 {} \; 2>/dev/null

# 3. Atur Permission File ke 644 (atau 664 jika diperlukan)
echo "Mengatur permissions file ke 644..."
find "$ROOT_DIR/public/uploads" -type f -exec chmod 644 {} \; 2>/dev/null || find "$ROOT_DIR/public/uploads" -type f -exec chmod 664 {} \; 2>/dev/null
find "$ROOT_DIR/writable" -type f -exec chmod 644 {} \; 2>/dev/null || find "$ROOT_DIR/writable" -type f -exec chmod 664 {} \; 2>/dev/null

# 4. Pembersihan Cache CodeIgniter 4
echo "Melakukan pembersihan cache..."

# Cara 1: Menggunakan command php spark
if [ -f "$ROOT_DIR/spark" ] && command -v php &> /dev/null; then
    echo "Menjalankan php spark cache:clear..."
    php spark cache:clear 2>/dev/null
fi

# Cara 2: Menghapus cache secara langsung via file system (Fallback/Pelengkap)
CACHE_DIR="$ROOT_DIR/writable/cache"
if [ -d "$CACHE_DIR" ]; then
    echo "Menghapus file cache langsung di $CACHE_DIR..."
    # Hapus semua file di writable/cache kecuali .gitignore dan index.html
    find "$CACHE_DIR" -type f ! -name ".gitignore" ! -name "index.html" -delete 2>/dev/null
    echo -e "${GREEN}Cache berhasil dibersihkan!${NC}"
else
    echo -e "${RED}Folder cache tidak ditemukan!${NC}"
fi

# 5. Verifikasi Keberhasilan Permission
echo "Memverifikasi apakah folder uploads dan writable dapat ditulis oleh server..."
if [ -w "$ROOT_DIR/public/uploads" ] && [ -w "$ROOT_DIR/writable" ]; then
    echo -e "${GREEN}✔ SUKSES: Folder writable dan public/uploads siap digunakan!${NC}"
else
    echo -e "${YELLOW}⚠ PERINGATAN: Beberapa folder mungkin masih tidak writable oleh user saat ini.${NC}"
    echo -e "${YELLOW}Jika error 403 masih berlanjut, hubungi penyedia hosting atau jalankan chmod -R 777 writable public/uploads via SSH sebagai last resort.${NC}"
fi

echo -e "${GREEN}=== Selesai ===${NC}"
