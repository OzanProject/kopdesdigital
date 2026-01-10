<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Nasabah;
use App\Models\Simpanan;
use App\Models\Pinjaman;
use App\Models\Penarikan;

class KoperasiController extends Controller
{
    public function index()
    {
        $koperasis = Koperasi::latest()->paginate(10);
        return view('saas.koperasi.index', compact('koperasis'));
    }

    public function create()
    {
        $packages = \App\Models\SubscriptionPackage::where('is_active', true)->get();
        return view('saas.koperasi.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_badan_hukum' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'kontak' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'subscription_package_id' => 'required|exists:subscription_packages,id',
            'status' => 'required|in:active,inactive,suspended',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Koperasi::create($data);

        return redirect()->route('koperasi.index')->with('success', 'Koperasi baru berhasil ditambahkan.');
    }

    public function edit(Koperasi $koperasi)
    {
        $packages = \App\Models\SubscriptionPackage::where('is_active', true)->get();
        return view('saas.koperasi.edit', compact('koperasi', 'packages'));
    }

    public function update(Request $request, Koperasi $koperasi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_badan_hukum' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'kontak' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'subscription_package_id' => 'required|exists:subscription_packages,id',
            'status' => 'required|in:active,inactive,suspended',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            if ($koperasi->logo) {
                Storage::disk('public')->delete($koperasi->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $koperasi->update($data);

        return redirect()->route('koperasi.index')->with('success', 'Data Koperasi berhasil diperbarui.');
    }

    public function destroy(Koperasi $koperasi)
    {
        try {
            DB::transaction(function () use ($koperasi) {
                // Delete image
                if ($koperasi->logo) {
                    Storage::disk('public')->delete($koperasi->logo);
                }

                // 1. Delete Operational Data
                \App\Models\Angsuran::withoutGlobalScopes()->where('koperasi_id', $koperasi->id)->delete();
                Pinjaman::withoutGlobalScopes()->where('koperasi_id', $koperasi->id)->delete();
                Simpanan::withoutGlobalScopes()->where('koperasi_id', $koperasi->id)->delete();
                Penarikan::withoutGlobalScopes()->where('koperasi_id', $koperasi->id)->delete();
                
                // 2. Delete Members & Users
                Nasabah::withoutGlobalScopes()->where('koperasi_id', $koperasi->id)->delete();
                \App\Models\User::withoutGlobalScopes()->where('koperasi_id', $koperasi->id)->delete();

                // 3. Delete Subscription Data
                \App\Models\SubscriptionTransaction::withoutGlobalScopes()->where('koperasi_id', $koperasi->id)->delete();

                // 4. Finally delete Koperasi
                $koperasi->delete();
            });

            return redirect()->route('koperasi.index')->with('success', 'Koperasi dan seluruh datanya berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus koperasi: ' . $e->getMessage());
        }
    }

    public function resetData(Koperasi $koperasi)
    {
        try {
            DB::transaction(function () use ($koperasi) {
                // Delete Business Data associated with this tenant
                
                // Relation: Simpanan belongsTo Koperasi.
                Simpanan::where('koperasi_id', $koperasi->id)->delete();
                Pinjaman::where('koperasi_id', $koperasi->id)->delete(); 
                Penarikan::where('koperasi_id', $koperasi->id)->delete();
                
                // Finally Delete Members (Nasabah)
                Nasabah::where('koperasi_id', $koperasi->id)->delete();
            });

            return redirect()->route('koperasi.index')->with('success', 'Data nasabah dan transaksi berhasil di-reset.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mereset data: ' . $e->getMessage());
        }
    }
}
