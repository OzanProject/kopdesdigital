<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $koperasi = Koperasi::findOrFail(Auth::user()->koperasi_id);
        return view('back.setting.index', compact('koperasi'));
    }

    public function update(Request $request)
    {
        $koperasi = Koperasi::findOrFail(Auth::user()->koperasi_id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_badan_hukum' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'kontak' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'timezone' => 'required|string|in:Asia/Jakarta,Asia/Makassar,Asia/Jayapura', // Timezone Validation
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['logo', '_token', '_method']);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($koperasi->logo && Storage::disk('public')->exists($koperasi->logo)) {
                Storage::disk('public')->delete($koperasi->logo);
            }
            
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        }

        // Update Koperasi
        $koperasi->update($data);

        // Handle Settings (Tenor Options)
        // Handle Settings (Tenor Options)
        if ($request->has('tenor_options')) {
            $settings = $koperasi->settings ?? [];
            
            // Tenor Options Logic
            $tenors = array_filter(array_map('trim', explode(',', $request->tenor_options)));
            $tenors = array_map('intval', $tenors);
            sort($tenors);
            $settings['tenor_options'] = $tenors;

            // Default Interest Rate Logic
            if ($request->has('default_bunga_persen')) {
                $settings['default_bunga_persen'] = $request->default_bunga_persen;
            }

            $data['settings'] = $settings;
        }

        $koperasi->update($data);

        return redirect()->route('setting.index')->with('success', 'Pengaturan koperasi berhasil diperbarui.');
    }
}
