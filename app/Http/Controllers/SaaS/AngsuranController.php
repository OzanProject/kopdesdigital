<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\Angsuran;
use Illuminate\Http\Request;

class AngsuranController extends Controller
{
    // Hanya perlu edit (Form Bayar) dan Update (Proses Bayar)
    
    public function edit(Angsuran $angsuran)
    {
        if ($angsuran->status == 'paid') {
            return back()->with('error', 'Angsuran ini sudah lunas.');
        }

        return view('back.angsuran.edit', compact('angsuran'));
    }

    public function update(Request $request, Angsuran $angsuran)
    {
        $request->validate([
            'jumlah_dibayar' => 'required|numeric|min:' . $angsuran->jumlah_bayar,
            'tanggal_bayar' => 'required|date',
            'denda' => 'nullable|numeric|min:0',
        ]);

        $angsuran->update([
            'status' => 'paid',
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah_dibayar' => $request->jumlah_dibayar,
            'denda' => $request->denda ?? 0,
            'keterangan' => $request->keterangan,
        ]);

        // Cek apakah semua angsuran pinjaman ini sudah lunas
        $pinjaman = $angsuran->pinjaman;
        if ($pinjaman->angsurans()->where('status', '!=', 'paid')->count() == 0) {
            $pinjaman->update(['status' => 'lunas']);
            return redirect()->route('pinjaman.show', $pinjaman->id)->with('success', 'Pembayaran berhasil. PINJAMAN LUNAS!');
        }

        return redirect()->route('pinjaman.show', $pinjaman->id)->with('success', 'Pembayaran angsuran berhasil dicatat.');
    }
}
