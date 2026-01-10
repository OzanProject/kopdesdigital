<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\SaasSetting;
use Illuminate\Http\Request;

class SaasSettingController extends Controller
{
    public function index()
    {
        $settings = SaasSetting::all()->pluck('value', 'key');
        return view('saas.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method', 'app_logo']);

        // Handle File Upload
        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('saas_logos', 'public');
            SaasSetting::updateOrCreate(['key' => 'app_logo'], ['value' => $path]);
        }

        foreach ($data as $key => $value) {
            SaasSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('saas-settings.index')->with('success', 'Pengaturan global berhasil diperbarui.');
    }
}
