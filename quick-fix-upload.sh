#!/bin/bash

# Quick Fix untuk Upload Thumbnail Error
# Run di production server via SSH

echo "=== Quick Fix Upload Thumbnail ==="
echo ""

# 1. Create directory
echo "Creating course-thumbnails directory..."
mkdir -p storage/app/public/course-thumbnails
mkdir -p storage/app/public/livewire-tmp
mkdir -p storage/app/public/editor-uploads

# 2. Set permissions
echo "Setting permissions..."
chmod -R 777 storage/app/public
chmod -R 777 storage/framework

# 3. Create storage link
echo "Creating storage link..."
php artisan storage:link --force

# 4. Clear cache
echo "Clearing cache..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan filament:cache-components

echo ""
echo "✅ Quick fix complete!"
echo ""
echo "Directories created:"
echo "  storage/app/public/course-thumbnails/"
echo "  storage/app/public/livewire-tmp/"
echo "  storage/app/public/editor-uploads/"
echo ""
echo "Now try uploading thumbnail again!"
