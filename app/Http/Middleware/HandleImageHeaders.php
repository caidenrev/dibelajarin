<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleImageHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Jika request mengarah ke file gambar
        if ($this->isImageRequest($request)) {
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Methods', 'GET');
            $response->header('Cache-Control', 'public, max-age=31536000');
            $response->header('X-Content-Type-Options', 'nosniff');
        }

        return $response;
    }

    protected function isImageRequest(Request $request)
    {
        $path = $request->path();
        return strpos($path, 'storage/course-thumbnails') !== false ||
               strpos($path, 'storage/editor-uploads') !== false ||
               preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $path);
    }
}