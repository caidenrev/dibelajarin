#!/bin/bash

# Fix Thumbnail Storage - Ensure Permanent Storage
# Run this on production server

echo "=== Thumbnail Storage Fix ==="
echo ""

# 1. Check and create storage link
echo "Checking storage link..."
if [ ! -L "public/storage" ]; then
    echo "Creating storage link..."
    php artisan storage:link --force
    echo "✅ Storage link created"
else
    echo "✅ Storage link already exists"
fi

# 2. Create course-thumbnails directory
echo ""
echo "Creating course-thumbnails directory..."
mkdir -p storage/app/public/course-thumbnails
chmod 775 storage/app/public/course-thumbnails
echo "✅ Directory created"

# 3. Check permissions
echo ""
echo "Setting permissions..."
chmod -R 775 storage/app/public
chown -R www-data:www-data storage/app/public 2>/dev/null || chown -R nginx:nginx storage/app/public 2>/dev/null
echo "✅ Permissions set"

# 4. Clear cache
echo ""
echo "Clearing cache..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan filament:cache-components

echo ""
echo "✅ Thumbnail storage fix complete!"
echo ""
echo "Storage structure:"
echo "  storage/app/public/course-thumbnails/"
echo "  public/storage -> storage/app/public (symlink)"
echo ""
echo "Test upload:"
echo "1. Edit a course"
echo "2. Upload thumbnail"
echo "3. Check: ls -lh storage/app/public/course-thumbnails/"
echo "4. Access: https://dibelajarin.sevalla.app/storage/course-thumbnails/[filename]"
