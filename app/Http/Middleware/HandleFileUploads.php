<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleFileUploads
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('X-Filament')) {
            // Set maximum execution time to 5 minutes for file uploads
            set_time_limit(300);
            
            // Increase memory limit for large file uploads
            ini_set('memory_limit', '256M');
            
            // Force HTTPS for file uploads in production
            if (app()->environment('production')) {
                $request->headers->set('X-Forwarded-Proto', 'https');
                $request->server->set('HTTPS', 'on');
            }
        }

        return $next($request);
    }
}