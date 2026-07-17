<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $nasabah = $user->nasabah;

        // If a member doesn't have a nasabah record yet, we might want to handle it or just pass null
        // However, it's safer to ensure they have it or show an error
        abort_if(!$nasabah, 404, 'Data Nasabah tidak ditemukan.');

        return view('member.profile.edit', compact('user', 'nasabah'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $nasabah = $user->nasabah;

        abort_if(!$nasabah, 404, 'Data Nasabah tidak ditemukan.');

        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|max:2048', // Max 2MB
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update Nasabah Profile
        $nasabah->nama = $request->nama;
        $nasabah->telepon = $request->telepon;
        $nasabah->pekerjaan = $request->pekerjaan;
        $nasabah->alamat = $request->alamat;

        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($nasabah->foto) {
                Storage::disk('public')->delete($nasabah->foto);
            }
            $path = $request->file('foto')->store('nasabah-photos', 'public');
            $nasabah->foto = $path;
        }

        $nasabah->save();

        // Update User Account (Name & Password)
        $user->name = $request->nama;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function printCard()
    {
        $nasabah = Auth::user()->nasabah;
        
        abort_if(!$nasabah, 404, 'Data Nasabah tidak ditemukan.');
        
        // reuse the admin print view, wrapping single nasabah in a collection
        $nasabahs = collect([$nasabah]);
        
        return view('back.nasabah.print_card', compact('nasabahs'));
    }
}
