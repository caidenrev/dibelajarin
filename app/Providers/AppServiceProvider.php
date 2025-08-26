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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url'));
            
            // Force all requests to use HTTPS
            if (request()->header('x-forwarded-proto') == 'https') {
                \Illuminate\Support\Facades\URL::forceScheme('https');
                app('request')->server->set('HTTPS', 'on');
            }
        }
    }
}
