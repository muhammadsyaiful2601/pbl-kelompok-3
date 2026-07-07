#!/usr/bin/env bash

# ==============================================================================
# Script: setup_githooks.sh
# Deskripsi: Mengonfigurasi git repositori lokal/remote agar menggunakan folder 
#           .githooks/ sebagai lokasi script hooks.
# ==============================================================================

# Warna output
GREEN='\033[0;32m'
NC='\033[0m'
YELLOW='\033[1;33m'

echo -e "${YELLOW}=== Mengonfigurasi Git Hooks ===${NC}"

# Tentukan lokasi script
ROOT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$ROOT_DIR" || exit 1

# Konfigurasi path hooks di git config
git config core.hooksPath .githooks

# Buat hook post-merge dan script fix_permissions.sh executable
if [ -f ".githooks/post-merge" ]; then
    chmod +x .githooks/post-merge
    echo "✔ File .githooks/post-merge sekarang executable!"
fi

if [ -f "fix_permissions.sh" ]; then
    chmod +x fix_permissions.sh
    echo "✔ File fix_permissions.sh sekarang executable!"
fi

echo -e "${GREEN}✔ Konfigurasi Git Hooks berhasil disetup!${NC}"
echo -e "${GREEN}Setiap kali Anda melakukan 'git pull' atau 'git merge', permission folder dan cache akan otomatis diperbaiki.${NC}"
