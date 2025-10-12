# Storage Error Fix - Deployment Guide

## Problem
When uploading thumbnails in course edit, you get this error:
```
file_put_contents(/app/storage/framework/cache/facade-xxx.php): 
Failed to open stream: No such file or directory
```

## Root Cause
The storage directories on the production server don't exist or lack proper write permissions. Laravel needs these directories to cache facades and other temporary files.

## Solutions

### Option 1: Run Artisan Command (Recommended)
SSH into your production server and run:
```bash
php artisan storage:fix --clear
```

This will:
- Create all necessary storage directories
- Set proper permissions (on Linux/Mac)
- Clear all caches

### Option 2: Run Shell Script (Linux/Mac)
```bash
chmod +x fix-storage.sh
./fix-storage.sh
```

### Option 3: Run Batch File (Windows Server)
```batch
fix-storage.bat
```

### Option 4: Manual Fix
SSH into your production server and run:
```bash
# Navigate to your application directory
cd /path/to/your/app

# Create directories
mkdir -p storage/framework/cache
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/testing
mkdir -p storage/app/livewire-tmp
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions (adjust www-data to your web server user)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## For Sevalla Hosting

If you're using Sevalla (as indicated by your error), you can:

1. **Via SSH:**
   ```bash
   php artisan storage:fix --clear
   ```

2. **Via Deployment Script:**
   Add this to your deployment pipeline:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan storage:fix
   php artisan migrate --force
   php artisan optimize
   ```

## Prevention

The `storage:fix` command has been added to `composer.json` in the `post-autoload-dump` script, so it will run automatically on future deployments when you run:
```bash
composer install
```

## Verification

After fixing, test the thumbnail upload again. You should no longer see the error.

## Additional Notes

- **File Uploads:** Make sure `storage/app/livewire-tmp` exists for Livewire file uploads
- **Symlink:** The `storage:link` command creates a symlink from `public/storage` to `storage/app/public`
- **Permissions:** On Linux/Mac, storage directories need 775 permissions and correct ownership
- **Windows:** Permission changes are skipped on Windows servers as they use different permission systems

## Support

If the issue persists after trying all solutions:
1. Check web server error logs
2. Verify the web server user has write access to storage directories
3. Check if SELinux or similar security modules are blocking writes (Linux)
4. Ensure disk space is available
