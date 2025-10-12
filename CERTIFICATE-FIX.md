# Certificate Download Fix - Error 503

## 🐛 Masalah
Error 503 "upstream connect error" ketika mengunduh sertifikat penyelesaian course.

## 🔍 Penyebab Umum
1. **File mockup-sertifikat.png tidak ada di production**
2. **File terlalu besar (2MB)** - menyebabkan timeout/memory limit
3. **PHP memory_limit atau max_execution_time terlalu kecil**
4. **DomPDF timeout**
5. **Permission issue pada folder public/images**

## ✅ Solusi yang Sudah Diterapkan

### 1. Error Handling di Controller
- ✅ Check file exists sebelum process
- ✅ Try-catch untuk error handling yang lebih baik
- ✅ Set memory limit ke 256M
- ✅ Error message yang jelas untuk debugging

### 2. File yang Diupdate
- `app/Http/Controllers/CertificateController.php`

## 🚀 Deploy ke Production

### Step 1: Upload File Mockup Sertifikat
**PENTING:** File `mockup-sertifikat.png` HARUS ada di production server!

```bash
# Via SSH
cd /app/public/images
# Upload mockup-sertifikat.png ke folder ini
```

**Via FTP/SFTP:**
- Upload file dari: `F:\lms-aachuu\public\images\mockup-sertifikat.png`
- Ke server: `/app/public/images/mockup-sertifikat.png`

### Step 2: Push Code Changes
```bash
git add .
git commit -m "Add error handling for certificate generation"
git push origin main
```

### Step 3: Pull dan Deploy di Server
```bash
cd /app
git pull origin main
composer install --no-dev
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Step 4: Run Check Script (Optional)
```bash
chmod +x deploy-certificate-fix.sh
./deploy-certificate-fix.sh
```

## 🔧 Optimasi (Recommended)

### Kompres Gambar Mockup
File `mockup-sertifikat.png` saat ini **2MB** - terlalu besar!

**Cara kompres:**
1. Buka di Photoshop/GIMP
2. Save for Web dengan kualitas 70-80%
3. Target size: **< 500KB**

Atau gunakan online tool:
- https://tinypng.com/
- https://compressor.io/

### Increase PHP Limits (di Server)

Edit `php.ini` di production server:
```ini
memory_limit = 256M
max_execution_time = 120
upload_max_filesize = 10M
post_max_size = 10M
```

Restart PHP-FPM setelah edit:
```bash
sudo systemctl restart php8.2-fpm
# atau
sudo service php-fpm restart
```

## 🐞 Debugging

### Check Error Logs
```bash
# Laravel logs
tail -f /app/storage/logs/laravel.log

# Nginx error log
tail -f /var/log/nginx/error.log

# PHP-FPM error log
tail -f /var/log/php8.2-fpm.log
```

### Test Certificate Generation
1. Login sebagai student yang sudah complete course 100%
2. Buka: `https://dibelajarin.sevalla.app/courses/[course-slug]/certificate`
3. Jika masih error, check logs

### Manual Test di Server
```bash
cd /app
php artisan tinker
```

Di tinker console:
```php
$path = public_path('images/mockup-sertifikat.png');
file_exists($path); // harus return true
filesize($path); // check ukuran file
```

## 📋 Checklist Deployment

- [ ] File `mockup-sertifikat.png` sudah ada di `/app/public/images/`
- [ ] File size < 500KB (optional tapi recommended)
- [ ] Code changes sudah di pull di production
- [ ] Cache sudah di clear
- [ ] PHP memory_limit >= 256M
- [ ] PHP max_execution_time >= 120
- [ ] Folder `public/images` permissions 755
- [ ] Test download certificate berhasil

## 🎯 Quick Test

Setelah deploy, test dengan curl:
```bash
curl -I https://dibelajarin.sevalla.app/courses/introduction-cloud-computing/certificate
```

Response yang benar:
- Status: `200 OK` atau `302 Redirect` (jika belum login)
- Bukan: `503 Service Unavailable`

## ⚠️ Troubleshooting

### Masih Error 503
1. **Check file mockup ada:**
   ```bash
   ls -lh /app/public/images/mockup-sertifikat.png
   ```

2. **Check PHP memory:**
   ```bash
   php -i | grep memory_limit
   ```

3. **Test DomPDF manual:**
   ```bash
   cd /app
   php artisan tinker
   ```
   ```php
   $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML('<h1>Test</h1>');
   $pdf->download('test.pdf');
   ```

### Error "Permission Denied"
```bash
chmod 755 /app/public/images
chmod 644 /app/public/images/*
```

### Error "Class Pdf not found"
```bash
composer require barryvdh/laravel-dompdf
php artisan config:clear
```

## 💡 Alternative Solution (Jika Masih Error)

Jika semua cara di atas gagal, gunakan **queue** untuk generate PDF:

```php
// Di controller, dispatch job
GenerateCertificateJob::dispatch($user, $course);

// Buat job baru
php artisan make:job GenerateCertificateJob
```

Atau, simpan PDF ke storage lalu serve sebagai file static.

## 📞 Support

Jika masih error setelah semua langkah:
1. Check semua error logs
2. Pastikan semua checklist di atas sudah ✅
3. Screenshot error message lengkap
4. Check server resource (RAM, CPU) tidak overload
