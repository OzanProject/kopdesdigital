<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetTenantTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $timezone = 'Asia/Jakarta'; // Default fallback

            if (Auth::user()->koperasi) {
                // Tenant Timezone
                $timezone = Auth::user()->koperasi->timezone ?? 'Asia/Jakarta';
            } elseif (Auth::user()->hasRole('super_admin')) {
                // Super Admin Timezone from SaasSettings
                $setting = \App\Models\SaasSetting::where('key', 'app_timezone')->first();
                $timezone = $setting ? $setting->value : 'Asia/Jakarta';
            }
            
            // Set timezone for this request
            config(['app.timezone' => $timezone]);
            date_default_timezone_set($timezone);
        }

        return $next($request);
    }
}
