<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\Simpanan;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        return view('back.laporan.index');
    }

    public function print(Request $request)
    {
        $request->validate([
            'jenis_laporan' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data = null;
        $title = '';
        $jenis = $request->jenis_laporan;
        $koperasi_id = Auth::user()->koperasi_id;

        if ($jenis == 'simpanan') {
            $data = Simpanan::with('nasabah')
                ->whereHas('nasabah', fn($q) => $q->where('koperasi_id', $koperasi_id))
                ->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date])
                ->latest('tanggal_transaksi')
                ->get();
            $title = 'Laporan Transaksi Simpanan';
        } elseif ($jenis == 'pinjaman') {
            $query = Pinjaman::with('nasabah')
                ->whereHas('nasabah', fn($q) => $q->where('koperasi_id', $koperasi_id))
                ->whereBetween('tanggal_pengajuan', [$request->start_date, $request->end_date]);
            
            if ($request->has('status') && $request->status != 'all') {
                $query->where('status', $request->status);
            }

            $data = $query->latest('tanggal_pengajuan')->get();
            $title = 'Laporan Pengajuan Pinjaman';
        } elseif ($jenis == 'anggota') {
            $data = \App\Models\Nasabah::where('koperasi_id', $koperasi_id)
                ->withCount(['simpanans as total_simpanan' => function($q) {
                    $q->select(\Illuminate\Support\Facades\DB::raw('sum(jumlah)'));
                }])
                ->get();
            $title = 'Laporan Data Anggota';
        } elseif ($jenis == 'shu') {
            $data = \App\Models\Shu::where('koperasi_id', $koperasi_id)
                ->whereBetween('created_at', [$request->start_date, $request->end_date . ' 23:59:59'])
                ->get();
            $title = 'Laporan Pembagian SHU';
        } elseif ($jenis == 'cashflow') {
            // Complex Query: Combine Simpanan (IN), Angsuran (IN), Pinjaman (OUT), Penarikan (OUT)
            // For simplicity, we fetch collections and merge
            $simpanan = Simpanan::with('nasabah')->whereHas('nasabah', fn($q) => $q->where('koperasi_id', $koperasi_id))
                        ->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date])->get()
                        ->map(fn($item) => ['date' => $item->tanggal_transaksi, 'type' => 'Masuk', 'source' => 'Simpanan', 'amount' => $item->jumlah, 'desc' => $item->nasabah->nama . ' - ' . $item->jenis]);
            
            $penarikan = \App\Models\Penarikan::with('nasabah')->whereHas('nasabah', fn($q) => $q->where('koperasi_id', $koperasi_id))
                        ->whereBetween('tanggal_penarikan', [$request->start_date, $request->end_date])->get()
                        ->map(fn($item) => ['date' => $item->tanggal_penarikan, 'type' => 'Keluar', 'source' => 'Penarikan', 'amount' => $item->jumlah, 'desc' => $item->nasabah->nama]);

            $pinjaman = Pinjaman::with('nasabah')->whereHas('nasabah', fn($q) => $q->where('koperasi_id', $koperasi_id))
                        ->where('status', 'approved') // Only approved loans imply money out
                        ->whereBetween('tanggal_disetujui', [$request->start_date, $request->end_date])->get()
                        ->map(fn($item) => ['date' => $item->tanggal_disetujui, 'type' => 'Keluar', 'source' => 'Pencairan Pinjaman', 'amount' => $item->jumlah_disetujui ?? $item->jumlah_pengajuan, 'desc' => $item->nasabah->nama]);

            $angsuran = \App\Models\Angsuran::with(['pinjaman.nasabah'])->whereHas('pinjaman', fn($q) => $q->where('koperasi_id', $koperasi_id))
                        ->where('status', 'paid')
                        ->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date])->get()
                        ->map(fn($item) => ['date' => $item->tanggal_bayar, 'type' => 'Masuk', 'source' => 'Angsuran Pinjaman', 'amount' => $item->jumlah_bayar, 'desc' => $item->pinjaman->nasabah->nama]);

            $data = $simpanan->merge($penarikan)->merge($pinjaman)->merge($angsuran)->sortBy('date');
            $title = 'Laporan Arus Kas (Cashflow)';
        }

        return view('back.laporan.print', [
            'data' => $data,
            'title' => $title,
            'jenis' => $jenis,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'koperasi' => \App\Models\Koperasi::find($koperasi_id)
        ]);
    }
}
