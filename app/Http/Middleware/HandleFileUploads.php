<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class HandleFileUploads
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('X-Filament')) {
            // Set maximum execution time to 2 minutes for file uploads (Sevalla limitation)
            set_time_limit(120);
            
            // Set memory limit for uploads
            ini_set('memory_limit', '128M');
            
            // Adjust upload limits for Sevalla
            ini_set('upload_max_filesize', '2M');
            ini_set('post_max_size', '8M');
            
            // Force HTTPS for file uploads in production
            if (app()->environment('production')) {
                $request->headers->set('X-Forwarded-Proto', 'https');
                $request->server->set('HTTPS', 'on');
                
                // Ensure proper URL scheme in production
                config(['app.url' => url('')]); 
            }

            // Ensure storage directories exist and are writable
            $this->ensureStorageDirectoriesExist();
        }

        return $next($request);
    }

    protected function ensureStorageDirectoriesExist()
    {
        $directories = [
            'app/public',
            'app/public/course-thumbnails',
            'app/public/editor-uploads',
            'framework/views',
            'framework/cache',
            'framework/sessions',
            'logs'
        ];

        foreach ($directories as $directory) {
            $path = storage_path($directory);
            if (!file_exists($path)) {
                try {
                    if (!mkdir($path, 0777, true) && !is_dir($path)) {
                        throw new \RuntimeException(sprintf('Directory "%s" could not be created', $path));
                    }
                } catch (\Exception $e) {
                    \Log::error("Failed to create directory {$directory}: " . $e->getMessage());
                }
            }
        }

        // Ensure storage link exists
        $publicPath = public_path('storage');
        if (!file_exists($publicPath)) {
            try {
                if (!file_exists(storage_path('app/public'))) {
                    mkdir(storage_path('app/public'), 0755, true);
                }
                if (file_exists(storage_path('app/public')) && !file_exists(public_path('storage'))) {
                    symlink(storage_path('app/public'), public_path('storage'));
                }
            } catch (\Exception $e) {
                \Log::error('Failed to create storage link: ' . $e->getMessage());
            }
        }
    }
}