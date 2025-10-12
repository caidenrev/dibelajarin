#!/bin/bash

# Fix Storage Permissions and Directories for Laravel
# Run this script on your production server

echo "Creating storage directories..."

# Create all necessary storage directories
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/testing
mkdir -p storage/framework/cache/data
mkdir -p storage/app/public
mkdir -p storage/app/private
mkdir -p storage/app/livewire-tmp
mkdir -p storage/logs

# Set proper permissions (775 for directories, 664 for files)
echo "Setting permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Set ownership (adjust www-data to your web server user if different)
echo "Setting ownership..."
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache

echo "Storage setup complete!"
echo ""
echo "Additional commands to run:"
echo "php artisan cache:clear"
echo "php artisan config:clear"
echo "php artisan view:clear"
echo "php artisan route:clear"
