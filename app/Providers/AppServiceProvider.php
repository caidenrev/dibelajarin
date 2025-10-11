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
        // Memaksa skema menjadi https jika env adalah production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url'));
            
            if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' || request()->server('HTTPS') === 'on') {
                request()->server->set('HTTPS', 'on');
                // Force asset URLs to use HTTPS
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

        // Ensure storage directory exists and is writable
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0775, true);
        }
        chmod($storagePath, 0775);

        // Ensure public storage directory exists and is writable
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0775, true);
        }
        chmod($publicPath, 0775);

        // Create storage link if it doesn't exist
        if (!file_exists(public_path('storage'))) {
            try {
                \Illuminate\Support\Facades\Artisan::call('storage:link');
            } catch (\Exception $e) {
                \Log::error('Failed to create storage link: ' . $e->getMessage());
            }
        }
    }
}
