<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->koperasi_id) {
            $koperasi = $user->koperasi;

            // Allow access to payment routes and dashboard (so they can see the alert)
            if ($request->routeIs('payment.*') || $request->routeIs('dashboard') || $request->is('admin/payment*')) {
                return $next($request);
            }

            if ($koperasi->status !== 'active') { // Assuming 'active' is the valid status
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['message' => 'Akun Koperasi Anda belum aktif. Silakan selesaikan pembayaran.'], 403);
                }
                
                return redirect()->route('dashboard')->with('error', 'Akses dibatasi! Silakan selesaikan pembayaran langganan Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}
