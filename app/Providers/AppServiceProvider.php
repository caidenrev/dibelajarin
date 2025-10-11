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
        }

        // Konfigurasi asset URL untuk HTTPS
        if (config('app.env') === 'production') {
            $this->app['url']->macro('asset', function ($path) {
                $path = trim($path, '/');
                return str_replace('http://', 'https://', url($path));
            });
        }
    }
}
