<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\Penarikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenarikanController extends Controller
{
    public function index()
    {
        $penarikans = Penarikan::with('nasabah')->latest('tanggal_penarikan')->paginate(10);
        return view('back.penarikan.index', compact('penarikans'));
    }

    public function create()
    {
        $nasabahs = Nasabah::where('status', 'active')->orderBy('nama')->get();
        return view('back.penarikan.create', compact('nasabahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'jumlah' => 'required|numeric|min:5000',
            'tanggal_penarikan' => 'required|date',
        ]);

        $nasabah = Nasabah::findOrFail($request->nasabah_id);
        
        // Cek Saldo
        if ($request->jumlah > $nasabah->saldo_sukarela) {
            return back()
                ->withInput()
                ->withErrors(['jumlah' => 'Saldo Simpanan Sukarela tidak mencukupi! Saldo saat ini: Rp ' . number_format($nasabah->saldo_sukarela, 0, ',', '.')]);
        }

        Penarikan::create([
            'koperasi_id' => Auth::user()->koperasi_id,
            'nasabah_id' => $request->nasabah_id,
            'jumlah' => $request->jumlah,
            'tanggal_penarikan' => $request->tanggal_penarikan,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('penarikan.index')->with('success', 'Penarikan berhasil diproses.');
    }
}
