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
        
        // Handle Production Toggle (Checkbox doesn't send "0" when unchecked)
        $isProduction = $request->has('midtrans_is_production') ? '1' : '0';
        SaasSetting::updateOrCreate(['key' => 'midtrans_is_production'], ['value' => $isProduction]);

        $data = $request->except(['_token', '_method', 'hero_image', 'seo_og_image', 'midtrans_is_production']);

        foreach ($data as $key => $value) {
            SaasSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan Landing Page berhasil diperbarui.');
    }
}
