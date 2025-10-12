# Thumbnail Storage Fix - Permanent Storage

## 🐛 Masalah
Thumbnail course hilang setelah di-update atau tidak tersimpan permanen.

## 🔍 Penyebab
1. **Storage link tidak dibuat** - File tersimpan tapi tidak accessible
2. **Old file tidak dihapus** - Menumpuk file lama
3. **File path berubah-rubah** - Karena preserveFilenames atau naming conflict
4. **Livewire temp files** - File di `livewire-tmp` tidak dipindahkan

## ✅ Solusi yang Sudah Diterapkan

### 1. Update `EditCourse.php`
- ✅ Hapus old thumbnail saat upload baru
- ✅ Prevent file menumpuk
- ✅ Storage cleanup otomatis

### 2. Update `CourseResource.php`
- ✅ Remove `preserveFilenames()` - Pakai hash filename otomatis
- ✅ Add `imageEditor()` - Editor gambar built-in
- ✅ Add aspect ratio options
- ✅ Make thumbnail required

### 3. Storage Configuration
- ✅ Disk: `public`
- ✅ Directory: `course-thumbnails`
- ✅ Visibility: `public`
- ✅ Path: `storage/app/public/course-thumbnails/`

## 🚀 Deploy ke Production

### Step 1: Commit & Push
```bash
git add .
git commit -m "Fix thumbnail storage - permanent storage dengan cleanup"
git push origin main
```

### Step 2: Pull di Production
```bash
cd /app
git pull origin main
composer install --no-dev
```

### Step 3: Create Storage Link
```bash
php artisan storage:link --force
```

**PENTING:** Ini HARUS dijalankan! Ini membuat symlink dari `public/storage` ke `storage/app/public`

### Step 4: Create Directory & Set Permissions
```bash
mkdir -p storage/app/public/course-thumbnails
chmod -R 775 storage/app/public
chown -R www-data:www-data storage/app/public
```

Atau jalankan script otomatis:
```bash
chmod +x fix-thumbnail-storage.sh
./fix-thumbnail-storage.sh
```

### Step 5: Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan filament:cache-components
```

## 📁 Storage Structure

```
/app/
├── public/
│   └── storage/          <- Symlink ke storage/app/public
├── storage/
│   └── app/
│       └── public/
│           └── course-thumbnails/    <- File tersimpan di sini
│               ├── abc123.jpg
│               ├── def456.png
│               └── ...
```

## 🔗 Akses File

Setelah setup:
- **Storage path**: `course-thumbnails/abc123.jpg`
- **Public URL**: `https://dibelajarin.sevalla.app/storage/course-thumbnails/abc123.jpg`

Di blade template:
```blade
<img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}">
```

atau:
```blade
<img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}">
```

## 🧪 Testing

### 1. Check Storage Link
```bash
ls -la /app/public/storage
# Output: public/storage -> /app/storage/app/public
```

### 2. Test Upload
1. Login ke admin panel
2. Edit course
3. Upload thumbnail baru
4. Save

### 3. Verify File Saved
```bash
ls -lh /app/storage/app/public/course-thumbnails/
# Should see uploaded file
```

### 4. Check Database
```bash
php artisan tinker
```
```php
$course = App\Models\Course::find(1);
echo $course->thumbnail;
// Output: course-thumbnails/abc123hash.jpg
```

### 5. Access via URL
Buka di browser:
```
https://dibelajarin.sevalla.app/storage/course-thumbnails/[filename]
```

## 🐞 Troubleshooting

### File Upload Tapi Tidak Kelihatan

**Check storage link:**
```bash
ls -la public/storage
```

Jika tidak ada atau broken:
```bash
rm public/storage  # Hapus jika ada
php artisan storage:link --force
```

### Permission Denied

```bash
chmod -R 775 storage/app/public
chown -R www-data:www-data storage/app/public
```

Atau kalau pakai nginx:
```bash
chown -R nginx:nginx storage/app/public
```

### File Hilang Setelah Update

Ini sudah di-fix di `EditCourse.php`. Pastikan code terbaru sudah di-pull.

### Old Files Menumpuk

Manual cleanup:
```bash
php artisan tinker
```
```php
// List semua courses dan thumbnails mereka
$courses = App\Models\Course::all();
$usedFiles = $courses->pluck('thumbnail')->filter()->toArray();

// List semua files di storage
$allFiles = Storage::disk('public')->files('course-thumbnails');

// Find unused files
$unusedFiles = array_diff($allFiles, $usedFiles);

// Delete unused files (HATI-HATI!)
foreach ($unusedFiles as $file) {
    Storage::disk('public')->delete($file);
    echo "Deleted: $file\n";
}
```

### URL 404 Not Found

1. **Check .htaccess di public:**
   ```apache
   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteRule ^ index.php [L]
   ```

2. **Check nginx config:**
   ```nginx
   location /storage {
       alias /app/storage/app/public;
   }
   ```

3. **Check APP_URL di .env:**
   ```env
   APP_URL=https://dibelajarin.sevalla.app
   ```

## 🔒 Security Notes

1. **Jangan simpan sensitive files di `public` disk**
2. **Validate file types** - Sudah ada di FileUpload config
3. **Limit file size** - Sudah set 2MB max
4. **Sanitize filenames** - Laravel auto handle dengan hash

## 📊 Storage Cleanup Command (Optional)

Buat command untuk cleanup unused thumbnails:

```bash
php artisan make:command CleanupUnusedThumbnails
```

```php
// In the command
public function handle()
{
    $usedThumbnails = Course::pluck('thumbnail')->filter()->toArray();
    $allFiles = Storage::disk('public')->files('course-thumbnails');
    
    $deleted = 0;
    foreach ($allFiles as $file) {
        if (!in_array($file, $usedThumbnails)) {
            Storage::disk('public')->delete($file);
            $deleted++;
        }
    }
    
    $this->info("Deleted {$deleted} unused thumbnail(s)");
}
```

Jalankan manual atau schedule di `app/Console/Kernel.php`:
```php
$schedule->command('cleanup:unused-thumbnails')->weekly();
```

## ✅ Checklist

- [ ] Code changes sudah di-pull di production
- [ ] `php artisan storage:link --force` sudah dijalankan
- [ ] Directory `storage/app/public/course-thumbnails` sudah dibuat
- [ ] Permissions 775 pada storage/app/public
- [ ] Ownership www-data:www-data (atau nginx:nginx)
- [ ] Cache sudah di-clear
- [ ] Test upload thumbnail - berhasil save
- [ ] Test akses via URL - gambar muncul
- [ ] Test update thumbnail - old file terhapus
- [ ] Test edit course lagi - thumbnail masih ada (permanen)

## 🎯 Expected Behavior

**Setelah fix:**
1. ✅ Upload thumbnail → tersimpan di `storage/app/public/course-thumbnails/`
2. ✅ Akses via `/storage/course-thumbnails/[file]` → gambar muncul
3. ✅ Update thumbnail → old file otomatis dihapus
4. ✅ Refresh page → thumbnail masih ada (permanen)
5. ✅ Edit course lain hari → thumbnail masih ada

**Database `courses.thumbnail` berisi:**
```
course-thumbnails/abc123hash.jpg
```

**Bukan:**
```
livewire-tmp/abc123.jpg  ❌ (temporary)
```
