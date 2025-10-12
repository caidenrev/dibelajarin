#!/bin/bash

# EMERGENCY FIX - Server 503 & Missing Images
# Run immediately on production server

echo "=== EMERGENCY FIX - START ==="
echo ""

# 1. Check PHP-FPM status
echo "1. Checking PHP-FPM..."
if systemctl is-active --quiet php8.2-fpm 2>/dev/null || systemctl is-active --quiet php-fpm 2>/dev/null; then
    echo "✅ PHP-FPM is running"
else
    echo "❌ PHP-FPM is DOWN! Restarting..."
    sudo systemctl restart php8.2-fpm 2>/dev/null || sudo systemctl restart php-fpm 2>/dev/null || sudo service php-fpm restart
fi

# 2. Check nginx/apache
echo ""
echo "2. Checking web server..."
if systemctl is-active --quiet nginx 2>/dev/null; then
    echo "✅ Nginx is running"
    sudo systemctl reload nginx 2>/dev/null
elif systemctl is-active --quiet apache2 2>/dev/null; then
    echo "✅ Apache is running"
    sudo systemctl reload apache2 2>/dev/null
else
    echo "⚠️  Could not check web server status"
fi

# 3. Fix storage directories & permissions
echo ""
echo "3. Fixing storage directories..."
cd /app || exit 1

mkdir -p storage/app/public/course-thumbnails
mkdir -p storage/app/public/editor-uploads
mkdir -p storage/app/public/livewire-tmp
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/views
mkdir -p storage/framework/sessions
mkdir -p storage/logs

echo "✅ Directories created"

# 4. Fix permissions (aggressive for emergency)
echo ""
echo "4. Fixing permissions (this may take a moment)..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || chown -R nginx:nginx storage bootstrap/cache 2>/dev/null

echo "✅ Permissions fixed"

# 5. Recreate storage link
echo ""
echo "5. Recreating storage link..."
rm -f public/storage 2>/dev/null
php artisan storage:link --force

if [ -L "public/storage" ]; then
    echo "✅ Storage link created"
else
    echo "❌ Failed to create storage link"
fi

# 6. Clear all caches
echo ""
echo "6. Clearing all caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear

echo "✅ Caches cleared"

# 7. Check disk space
echo ""
echo "7. Checking disk space..."
df -h | grep -E "Filesystem|/dev/"

# 8. Check memory
echo ""
echo "8. Checking memory..."
free -h

# 9. Check recent errors
echo ""
echo "9. Last 20 errors from Laravel log:"
if [ -f "storage/logs/laravel.log" ]; then
    tail -n 20 storage/logs/laravel.log | grep -i error
else
    echo "No log file found"
fi

echo ""
echo "=== EMERGENCY FIX - COMPLETE ==="
echo ""
echo "🔍 Next steps:"
echo "1. Try accessing the site now"
echo "2. If still 503, check: tail -f /var/log/nginx/error.log"
echo "3. If still 503, check: tail -f /var/log/php8.2-fpm.log"
echo "4. Check PHP memory_limit: php -i | grep memory_limit"
echo ""
echo "📊 Storage structure:"
ls -lah storage/app/public/
echo ""
ls -lah public/storage
