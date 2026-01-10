<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class TenantScope
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->koperasi_id) {
            $koperasi = Auth::user()->koperasi;

            if ($koperasi && $koperasi->status === 'suspended') {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')->withErrors(['email' => 'Akun Koperasi ini sedang DIBEKUKAN (Suspended). Silakan hubungi Administrator.']);
            }

            // Share koperasi data globally to all views for tenant users
            View::share('koperasi', $koperasi);
        }

        return $next($request);
    }
}
