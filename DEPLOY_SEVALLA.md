# 🚀 Deploy Fix ke Sevalla Production

## ⚠️ PENTING - Beda Local vs Production

Bug muncul di **Sevalla Production** tapi tidak di local, kemungkinan karena:
1. ❌ Symbolic link belum dibuat di server Sevalla
2. ❌ Permission folders berbeda
3. ❌ Cache config masih pakai setting lama
4. ❌ PHP/Web server configuration berbeda

---

## 📋 Langkah Deploy ke Sevalla

### 1️⃣ **Push Code ke Git/Deploy**
```bash
git add .
git commit -m "Fix: Gambar hilang - update Livewire config & FileUpload persistence"
git push origin main
```

### 2️⃣ **SSH ke Sevalla Server**
Login ke terminal Sevalla via dashboard atau SSH:
```bash
ssh username@your-sevalla-server.com
cd /path/to/dibelajarin
```

### 3️⃣ **Pull Latest Code**
```bash
git pull origin main
```

### 4️⃣ **Install/Update Dependencies** (jika ada)
```bash
composer install --no-dev --optimize-autoloader
```

### 5️⃣ **Clear ALL Cache** (WAJIB!)
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
```

### 6️⃣ **Buat Storage Symbolic Link** (PENTING!)
```bash
php artisan storage:link
```

**Expected Output:**
```
The [public/storage] link has been connected to [storage/app/public].
The links have been created.
```

Jika muncul error "link already exists", hapus dulu:
```bash
rm public/storage
php artisan storage:link
```

### 7️⃣ **Cek Permissions Storage** (Sevalla Specific)
```bash
# Pastikan web server bisa write ke storage
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Atau jika pakai user/group spesifik:
chown -R www-data:www-data storage bootstrap/cache
# ATAU (tergantung Sevalla setup)
chown -R nginx:nginx storage bootstrap/cache
```

### 8️⃣ **Restart Services** (Opsional tapi disarankan)
```bash
# Restart PHP-FPM (jika pakai PHP-FPM)
sudo systemctl restart php8.2-fpm

# Restart web server
sudo systemctl restart nginx
# ATAU
sudo systemctl restart apache2
```

### 9️⃣ **Cek Config di Production**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔍 Verifikasi di Production

### A. Cek Symbolic Link Berhasil
```bash
ls -la public/ | grep storage
```

Output harus seperti:
```
lrwxrwxrwx 1 user user 23 Oct 13 20:41 storage -> ../storage/app/public
```

### B. Cek .env Production
Pastikan di `.env` production:
```env
APP_URL=https://dibelajarin.sevalla.app
FILESYSTEM_DISK=public
```

### C. Cek Folder Structure
```bash
ls -la storage/app/public/
```

Harus ada folders:
- `course-thumbnails/`
- `editor-uploads/`
- `lesson-attachments/`
- `livewire-tmp/`

Jika belum ada, buat manual:
```bash
mkdir -p storage/app/public/course-thumbnails
mkdir -p storage/app/public/editor-uploads
mkdir -p storage/app/public/lesson-attachments
chmod -R 775 storage/app/public
```

### D. Test Upload via Browser
1. Login admin panel: `https://dibelajarin.sevalla.app/admin`
2. Edit course existing
3. Upload thumbnail baru
4. **Cek file langsung di server:**
   ```bash
   ls -lh storage/app/public/course-thumbnails/
   ```
5. **Cek URL bisa diakses:**
   ```
   https://dibelajarin.sevalla.app/storage/course-thumbnails/nama-file.jpg
   ```
6. Tunggu 10-15 menit, refresh halaman
7. ✅ Gambar seharusnya masih ada (tidak 404)

---

## 🐛 Troubleshooting Production

### Error: "The link already exists"
```bash
# Hapus link lama
rm public/storage
# Atau kalau folder biasa:
rm -rf public/storage
# Buat lagi
php artisan storage:link
```

### Error: "Permission denied"
```bash
# Fix permissions
sudo chown -R $USER:www-data storage
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
```

### Gambar Masih 404
1. **Cek web server config** - pastikan serve static files dari `/storage`
2. **Cek .htaccess** (jika Apache) - pastikan tidak block `/storage`
3. **Cek nginx config** (jika Nginx) - pastikan ada rule untuk serve `/storage`

**Nginx Example:**
```nginx
location /storage {
    alias /path/to/app/storage/app/public;
    expires 30d;
    access_log off;
}
```

**Apache .htaccess** (biasanya sudah ada):
```apache
RewriteRule ^storage/(.*)$ /storage/$1 [L]
```

### Gambar Masih Hilang Setelah Beberapa Saat
Kemungkinan:
1. ❌ Config cache belum di-clear: `php artisan config:clear`
2. ❌ Sevalla ada auto-cleanup script yang hapus files
3. ❌ Symbolic link rusak/hilang
4. ❌ CDN/Caching layer di Sevalla

**Solusi:**
```bash
# Re-deploy complete
php artisan down
git pull
composer install --no-dev
php artisan config:clear
php artisan cache:clear
php artisan storage:link
php artisan config:cache
php artisan up
```

---

## 📊 Monitoring di Production

### Cek File Count Growth
```bash
# Count files di course-thumbnails
ls storage/app/public/course-thumbnails/ | wc -l

# Cek total size
du -sh storage/app/public/
```

### Cleanup Temporary Files (Manual)
Karena sekarang `cleanup => false`, kamu perlu manual cleanup:
```bash
# Hapus file temporary yang > 7 hari
find storage/app/public/livewire-tmp -type f -mtime +7 -delete
```

Atau tambahkan ke cron job di Sevalla:
```bash
# Edit crontab
crontab -e

# Tambahkan line ini (cleanup setiap minggu)
0 2 * * 0 cd /path/to/app && php artisan livewire:clear-cache
```

---

## 🎯 Checklist Final

Setelah deploy, pastikan semua ini ✅:

- [ ] Code sudah di-push dan pull di server
- [ ] `composer install` berhasil
- [ ] `php artisan storage:link` berhasil (cek dengan `ls -la public/storage`)
- [ ] Permissions storage sudah 775
- [ ] Cache sudah di-clear semua (`config`, `cache`, `view`, `route`)
- [ ] `.env` production sudah benar (APP_URL, FILESYSTEM_DISK)
- [ ] Upload thumbnail baru → file muncul di `storage/app/public/course-thumbnails/`
- [ ] URL gambar bisa diakses di browser
- [ ] Tunggu 15-30 menit → gambar masih muncul (tidak 404)
- [ ] Insert gambar di RichEditor → gambar tersimpan dan tidak hilang

---

## 📞 Kontak Sevalla Support

Jika masih ada masalah setelah semua langkah di atas:
1. Kemungkinan ada **restriction khusus** di Sevalla hosting
2. Mungkin ada **auto-cleanup scheduler** yang perlu di-disable
3. Mungkin perlu **adjust PHP-FPM timeout** untuk upload files

Hubungi Sevalla support dan tanyakan:
- "Apakah ada auto-cleanup untuk storage files?"
- "Apakah symbolic links diperbolehkan?"
- "Apakah ada limit untuk file storage di storage/app/public?"
- "Berapa max execution time untuk PHP?"

---

## ✅ Setelah Deploy Sukses

File gambar akan:
- ✅ Tersimpan permanent di `storage/app/public/` di server Sevalla
- ✅ Bisa diakses via `https://dibelajarin.sevalla.app/storage/...`
- ✅ TIDAK hilang setelah beberapa saat
- ✅ TIDAK ada error 404 atau "upstream connect error"

---

**Good luck dengan testing! 🚀**

Kalau ada error atau masalah saat deploy, screenshot aja error nya dan kasih tau saya ya!
