<?php

// Script to fix storage issues
$publicPath = __DIR__ . '/public/storage';
$storagePath = __DIR__ . '/storage/app/public';

// Create storage directories if they don't exist
$directories = [
    __DIR__ . '/storage/app/public',
    __DIR__ . '/storage/app/public/course-thumbnails',
    __DIR__ . '/storage/app/public/editor-uploads',
];

foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
        echo "Created directory: $dir\n";
    }
}

// Remove existing symlink if it exists
if (is_link($publicPath)) {
    unlink($publicPath);
    echo "Removed existing symlink\n";
}

// Create new symlink
if (symlink($storagePath, $publicPath)) {
    echo "Created new symlink successfully\n";
} else {
    // If symlink fails, try copying directory
    if (!file_exists($publicPath)) {
        mkdir($publicPath, 0755, true);
    }
    echo "Created storage directory\n";
}

// Set proper permissions
chmod($storagePath, 0755);
echo "Set permissions on storage directory\n";

// Create .htaccess file to handle direct access
$htaccess = __DIR__ . '/public/storage/.htaccess';
file_put_contents($htaccess, "Options +FollowSymLinks\nRewriteEngine On\n");
echo "Created .htaccess file\n";

echo "Storage setup complete!\n";