# 🔧 Perbaikan Bug Gambar Hilang

## Masalah yang Diperbaiki
- ❌ Gambar thumbnail dan gambar di RichEditor hilang setelah beberapa saat
- ❌ Error 404 "upstream connect error" saat load gambar
- ❌ File upload tidak di-persist secara permanen

## Akar Masalah
1. **Livewire Temporary Upload Cleanup** - File temporary di-cleanup otomatis setelah 24 jam
2. **Max Upload Time Terlalu Pendek** - Hanya 5 menit sebelum upload dinyatakan invalid
3. **File Tidak Dipindahkan** - File masih di folder `livewire-tmp` dan tidak dipindahkan ke lokasi permanen
4. **Missing Symbolic Link** - Link dari `public/storage` ke `storage/app/public` belum dibuat

## Perubahan yang Dilakukan

### 1. ✅ Konfigurasi Livewire (`config/livewire.php`)
```php
'temporary_file_upload' => [
    'max_upload_time' => 30,  // Dari 5 menit jadi 30 menit
    'cleanup' => false,       // Disable auto cleanup
],
```

### 2. ✅ FileUpload di CourseResource
- Tambah `->moveFiles()` - Memindahkan file dari temporary ke permanent
- Tambah `->preserveFilenames()` - Mempertahankan nama file original
- Tambah `->visibility('public')` - Memastikan file bisa diakses public
- Naikkan `maxSize` dari 2MB ke 5MB

### 3. ✅ RichEditor di CourseResource & LessonsRelationManager
- Tambah `->fileAttachmentsVisibility('public')` - File attachment bisa diakses public
- Pastikan `->fileAttachmentsDisk('public')` dan `->fileAttachmentsDirectory('editor-uploads')`

### 4. ✅ Hapus Logic Delete Manual
- Hapus logic `mutateFormDataBeforeSave` di `EditCourse.php`
- Filament dengan `moveFiles()` akan handle delete old file secara otomatis

## ⚠️ LANGKAH WAJIB SETELAH UPDATE

### 1. Jalankan Storage Link
```bash
php artisan storage:link
```
Command ini akan membuat symbolic link dari `public/storage` ke `storage/app/public`.

**Catatan Windows**: Jika gagal, jalankan CMD/PowerShell sebagai Administrator:
```cmd
cd f:\lms-aachuu
php artisan storage:link
```

### 2. Bersihkan Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 3. Cek Permissions (Opsional - Untuk Production)
Pastikan folder storage bisa ditulis:
```bash
# Linux/Mac
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Windows - biasanya tidak perlu, tapi pastikan folder tidak read-only
```

### 4. Test Upload Gambar
1. Login ke admin panel
2. Edit course yang ada atau buat course baru
3. Upload thumbnail baru
4. Tambahkan gambar di description (RichEditor)
5. Save dan refresh halaman
6. ✅ Gambar seharusnya tetap muncul (tidak hilang)

## 🔍 Cara Verifikasi Fix Berhasil

### Cek Symbolic Link
```bash
# Windows (CMD)
dir public\storage

# Windows (PowerShell)
ls public\storage

# Harus muncul <JUNCTION> atau <SYMLINK> pointing ke storage\app\public
```

### Cek File Tersimpan di Lokasi yang Benar
Setelah upload, file harus ada di:
- **Thumbnail**: `storage/app/public/course-thumbnails/`
- **Editor Images**: `storage/app/public/editor-uploads/`
- **Lesson Attachments**: `storage/app/public/lesson-attachments/`

### Cek URL Gambar
Gambar harus bisa diakses via URL:
- Format: `https://domain.com/storage/course-thumbnails/nama-file.jpg`
- Bukan: `https://domain.com/livewire-tmp/...` (ini temporary)

## 📝 Catatan Tambahan

### Jika Masih Ada Masalah

1. **Cek .env**
   ```env
   APP_URL=https://dibelajarin.sevalla.app
   FILESYSTEM_DISK=public
   ```

2. **Cek Symbolic Link**
   ```bash
   # Hapus link lama jika ada error
   rm public/storage  # Linux/Mac
   rmdir public\storage  # Windows

   # Buat lagi
   php artisan storage:link
   ```

3. **Clear Browser Cache**
   - Hard refresh: `Ctrl+Shift+R` (Windows) atau `Cmd+Shift+R` (Mac)
   - Atau buka incognito/private window

4. **Cek Error Log**
   ```bash
   tail -f storage/logs/laravel.log
   ```

### File yang Sudah Di-Upload Sebelumnya
File lama yang sudah hilang tidak bisa dikembalikan. Kamu perlu:
1. Re-upload thumbnail course yang hilang
2. Re-upload gambar di content yang hilang

### Maintenance Storage
Karena `cleanup => false`, kamu perlu manual cleanup temporary files secara berkala:
```bash
# Bersihkan file temporary yang > 7 hari
php artisan livewire:clear-cache
```

Atau buat schedule di `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('livewire:clear-cache')->weekly();
}
```

## ✨ Result
Setelah fix ini, gambar akan:
- ✅ Tersimpan permanent di `storage/app/public/`
- ✅ Tidak hilang setelah beberapa saat
- ✅ Bisa diakses via public URL
- ✅ Tidak ada error 404 atau "upstream connect"

---

**Dibuat pada**: 13 Oktober 2025
**Status**: ✅ Ready to Test
