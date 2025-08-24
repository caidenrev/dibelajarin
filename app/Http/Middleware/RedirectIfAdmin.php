<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah ada pengguna yang sedang login
        // DAN apakah perannya adalah 'admin' atau 'instruktur'
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'instruktur'])) {
            // Jika ya, alihkan ke dasbor admin
            return redirect('/admin');
        }

        // Jika tidak (pengguna adalah tamu atau klien biasa), lanjutkan ke halaman tujuan
        return $next($request);
    }
}