<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckFilamentAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek 1: Apakah pengguna sudah login?
        if (! Auth::check()) {
            // Jika belum, lempar ke halaman login.
            return redirect('/login');
        }

        // Cek 2: Apakah peran pengguna yang login adalah admin atau instruktur?
        if (! in_array(Auth::user()->role, ['admin', 'instructor'])) {
            // Jika bukan, tolak dengan 403 Forbidden.
            abort(403);
        }

        // Jika semua pemeriksaan lolos, izinkan masuk.
        return $next($request);
    }
}
