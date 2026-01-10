#!/bin/bash

# Script Deployment Otomatis untuk KopDes Digital
# Usage: ./deploy.sh

echo "🚀 Memulai Deployment..."

# 1. Masuk ke Maintenance Mode
echo "⏸️  Mengaktifkan Maintenance Mode..."
php artisan down || true

# 2. Pull Kode Terbaru dari Git
echo "📥 Mengambil update dari Git..."
git pull origin main

# 3. Install/Update Dependencies PHP
echo "📦 Menginstall dependencies Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# 4. Install/Update Dependencies Frontend (Optional jika build di server)
echo "🎨 Membuild aset Frontend..."
npm install
npm run build

# 5. Jalankan Migrasi Database
echo "🗄️  Migrasi Database..."
php artisan migrate --force

# 6. Clear & Cache Config
echo "🧹 Membersihkan Cache..."
php artisan optimize:clear
php artisan optimize

# 7. Restart Queue Worker (Penting untuk Supervisor)
echo "🔄 Restart Queue..."
php artisan queue:restart

# 8. Keluar dari Maintenance Mode
echo "▶️  Mematikan Maintenance Mode..."
php artisan up

echo "✅ Deployment Selesai! Aplikasi sudah live dengan versi terbaru."
