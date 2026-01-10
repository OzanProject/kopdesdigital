<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimpananController extends Controller
{
    public function index()
    {
        $nasabah = Auth::user()->nasabah;
        
        $simpanans = $nasabah->simpanans()
                             ->latest('tanggal_transaksi')
                             ->paginate(10);
                             
        $totalSimpanan = $nasabah->simpanans()->sum('jumlah');
        $totalPenarikan = $nasabah->penarikans()->sum('jumlah');
        $saldoAkhir = $totalSimpanan - $totalPenarikan;

        return view('member.simpanan.index', compact('simpanans', 'saldoAkhir', 'totalSimpanan', 'totalPenarikan'));
    }
}
