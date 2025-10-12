#!/bin/bash

# Certificate Fix Deployment Script
# Run this on production server

echo "=== Certificate Fix Deployment ==="
echo ""

# Check if mockup-sertifikat.png exists
if [ ! -f "public/images/mockup-sertifikat.png" ]; then
    echo "❌ ERROR: mockup-sertifikat.png NOT FOUND!"
    echo "   File ini harus ada di: public/images/mockup-sertifikat.png"
    echo "   Silakan upload file tersebut ke server."
    echo ""
    echo "   Ukuran file yang disarankan: < 500KB (saat ini 2MB terlalu besar)"
    exit 1
else
    echo "✅ mockup-sertifikat.png found"
    
    # Check file size
    FILE_SIZE=$(stat -f%z "public/images/mockup-sertifikat.png" 2>/dev/null || stat -c%s "public/images/mockup-sertifikat.png" 2>/dev/null)
    FILE_SIZE_MB=$((FILE_SIZE / 1024 / 1024))
    
    echo "   File size: ${FILE_SIZE_MB}MB"
    
    if [ $FILE_SIZE_MB -gt 1 ]; then
        echo "   ⚠️  WARNING: File terlalu besar, bisa menyebabkan timeout!"
        echo "   Disarankan untuk mengompres gambar ke < 500KB"
    fi
fi

echo ""
echo "Checking certificates template..."

if [ ! -f "resources/views/certificates/template.blade.php" ]; then
    echo "❌ ERROR: template.blade.php NOT FOUND!"
    exit 1
else
    echo "✅ template.blade.php found"
fi

echo ""
echo "Clearing cache..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo ""
echo "✅ Certificate deployment check complete!"
echo ""
echo "Test URL: https://dibelajarin.sevalla.app/courses/[course-slug]/certificate"
echo ""
echo "Jika masih error 503:"
echo "1. Check logs: tail -f storage/logs/laravel.log"
echo "2. Check web server error logs"
echo "3. Increase PHP memory_limit in php.ini (minimal 256M)"
echo "4. Increase max_execution_time in php.ini (minimal 120 detik)"
