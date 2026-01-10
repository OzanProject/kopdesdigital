<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\SaasSetting;
use Illuminate\Http\Request;

class LandingSettingController extends Controller
{
    public function index()
    {
        $settings = SaasSetting::all()->pluck('value', 'key');
        return view('saas.landing.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // Handle File Upload for Hero Image
        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('landing', 'public');
            SaasSetting::updateOrCreate(['key' => 'hero_image'], ['value' => $path]);
        }
        
        // Handle File Upload for SEO OG Image
        if ($request->hasFile('seo_og_image')) {
            $path = $request->file('seo_og_image')->store('landing', 'public');
            SaasSetting::updateOrCreate(['key' => 'seo_og_image'], ['value' => $path]);
        }

        // Handle Branding Files
        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('branding', 'public');
            SaasSetting::updateOrCreate(['key' => 'app_logo'], ['value' => $path]);
        }
        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('branding', 'public');
            SaasSetting::updateOrCreate(['key' => 'favicon'], ['value' => $path]);
        }
        
        // Handle Production Toggle (Checkbox doesn't send "0" when unchecked)
        $isProduction = $request->has('midtrans_is_production') ? '1' : '0';
        SaasSetting::updateOrCreate(['key' => 'midtrans_is_production'], ['value' => $isProduction]);

        SaasSetting::updateOrCreate(['key' => 'midtrans_is_production'], ['value' => $isProduction]);

        $data = $request->except(['_token', '_method', 'hero_image', 'seo_og_image', 'midtrans_is_production', 'app_logo', 'favicon']);

        foreach ($data as $key => $value) {
            SaasSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan Landing Page berhasil diperbarui.');
    }

    public function testEmail(Request $request)
    {
        $request->validate(['test_email_to' => 'required|email']);

        try {
            // Force reload config from DB to ensure latest settings are used
            $settings = SaasSetting::pluck('value', 'key');
            if (isset($settings['mail_host'])) {
                config([
                    'mail.mailers.smtp.host' => $settings['mail_host'],
                    'mail.mailers.smtp.port' => $settings['mail_port'] ?? 587,
                    'mail.mailers.smtp.encryption' => $settings['mail_encryption'] ?? 'tls',
                    'mail.mailers.smtp.username' => $settings['mail_username'],
                    'mail.mailers.smtp.password' => $settings['mail_password'],
                    'mail.from.address' => $settings['mail_from_address'] ?? 'noreply@koperasi.com',
                    'mail.from.name' => $settings['mail_from_name'] ?? 'KopDes Digital',
                ]);
            }

            \Mail::raw('Ini adalah email percobaan tes koneksi SMTP dari sistem Koperasi SaaS.', function ($message) use ($request) {
                $message->to($request->test_email_to)
                        ->subject('Test Koneksi SMTP Berhasil!');
            });

            return back()->with('success', 'Email berhasil dikirim ke ' . $request->test_email_to . '. Koneksi SMTP Aman!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal kirim email: ' . $e->getMessage());
        }
    }

    public function clearCache()
    {
        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
        return back()->with('success', 'Cache sistem berhasil dibersihkan!');
    }
}
