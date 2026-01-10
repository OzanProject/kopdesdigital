<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinjamanController extends Controller
{
    public function index()
    {
        $nasabah = Auth::user()->nasabah;
        
        $pinjamans = $nasabah->pinjamans()
                             ->with('angsurans')
                             ->latest('tanggal_pengajuan')
                             ->paginate(10);

        // Calculate summary if needed
        $totalPinjaman = $pinjamans->sum('jumlah_pinjaman');
        $totalTerbayar = 0; // Logic for paid amount across all loans

        return view('member.pinjaman.index', compact('pinjamans'));
    }
    public function create()
    {
        return view('member.pinjaman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:100000',
            'tenor' => 'required|integer|min:1|max:60', // Max 5 years example
            'keterangan' => 'nullable|string|max:255',
        ]);

        $nasabah = Auth::user()->nasabah;
        
        // Check if there is an active pending loan? Optional constraint.
        // For now allow multiple pending.

        // Check if there is an active pending loan? Optional constraint.
        // For now allow multiple pending.

        \App\Models\Pinjaman::create([
            'koperasi_id' => $nasabah->koperasi_id,
            'nasabah_id' => $nasabah->id,
            'kode_pinjaman' => \App\Models\Pinjaman::generateKode($nasabah->koperasi_id),
            'jumlah_pinjaman' => $request->jumlah,
            'tenor_bulan' => $request->tenor,
            'bunga_persen' => 0, // Laravel cast will handle this
            'status' => 'pending',
            'tanggal_pengajuan' => now(), // Laravel cast will handle this
            'keterangan' => $request->keterangan,
            'total_jumlah' => $request->jumlah,
            'sisa_tagihan' => $request->jumlah,
        ]);

        return redirect()->route('member.pinjaman.index')->with('success', 'Pengajuan pinjaman berhasil dikirim. Harap menunggu persetujuan admin.');
    }
}

