<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimpananController extends Controller
{
    public function index()
    {
        $simpanans = Simpanan::with('nasabah')->latest('tanggal_transaksi')->paginate(10);
        return view('back.simpanan.index', compact('simpanans'));
    }

    public function create()
    {
        // In real app, nasabah list might be huge. Use select2 or search via AJAX.
        // For MVP/Starter, we'll pass all nasabahs restricted by tenant scope
        $nasabahs = Nasabah::where('status', 'active')->orderBy('nama')->get();
        return view('back.simpanan.create', compact('nasabahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'jenis' => 'required|in:pokok,wajib,sukarela',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        Simpanan::create([
            'koperasi_id' => Auth::user()->koperasi_id,
            'nasabah_id' => $request->nasabah_id,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('simpanan.index')->with('success', 'Transaksi Simpanan Berhasil dicatat.');
    }
    public function edit(Simpanan $simpanan)
    {
        $nasabahs = Nasabah::where('status', 'active')->orderBy('nama')->get();
        return view('back.simpanan.edit', compact('simpanan', 'nasabahs'));
    }

    public function update(Request $request, Simpanan $simpanan)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'jenis' => 'required|in:pokok,wajib,sukarela',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $simpanan->update([
            'nasabah_id' => $request->nasabah_id,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('simpanan.index')->with('success', 'Transaksi Simpanan Berhasil diperbarui.');
    }

    public function destroy(Simpanan $simpanan)
    {
        $simpanan->delete();
        return redirect()->route('simpanan.index')->with('success', 'Transaksi Simpanan Berhasil dihapus.');
    }
}
