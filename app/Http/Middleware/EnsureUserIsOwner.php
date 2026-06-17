<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['role_error' => 'Harap login terlebih dahulu untuk mengakses halaman ini.']);
        }

        if (auth()->user()->role !== 'owner') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk pemilik (Owner).');
        }

        return $next($request);
    }
}
