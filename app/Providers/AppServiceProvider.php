<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production and handle asset/storage URLs
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            
            // Ensure proper root URL is set
            $rootUrl = rtrim(config('app.url'), '/');
            URL::forceRootUrl($rootUrl);
            
            // Handle assets and storage URLs
            if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' || request()->server('HTTPS') === 'on') {
                request()->server->set('HTTPS', 'on');
                
                // Update storage URL for production
                config(['filesystems.disks.public.url' => $rootUrl . '/storage']);
                $this->app['request']->server->set('HTTPS', true);
            }

            // Set proper permissions for storage directories
            $this->setupStoragePermissions();
        }

        // Konfigurasi asset URL untuk HTTPS
        if (config('app.env') === 'production') {
            $this->app['url']->macro('asset', function ($path) {
                $path = trim($path, '/');
                return str_replace('http://', 'https://', url($path));
            });
        }
    }

    protected function setupStoragePermissions()
    {
        $storagePath = storage_path();
        $publicPath = public_path('storage');

        // Ensure storage directory exists
        if (!file_exists($storagePath)) {
            try {
                mkdir($storagePath, 0755, true);
            } catch (\Exception $e) {
                \Log::error('Failed to create storage directory: ' . $e->getMessage());
            }
        }

        // Ensure public storage directory exists
        if (!file_exists($publicPath)) {
            try {
                mkdir($publicPath, 0755, true);
            } catch (\Exception $e) {
                \Log::error('Failed to create public storage directory: ' . $e->getMessage());
            }
        }

        // Create storage link if it doesn't exist
        if (!file_exists(public_path('storage'))) {
            try {
                if (file_exists(storage_path('app/public')) && !file_exists(public_path('storage'))) {
                    symlink(storage_path('app/public'), public_path('storage'));
                }
            } catch (\Exception $e) {
                \Log::error('Failed to create storage link: ' . $e->getMessage());
            }
        }
    }
}
