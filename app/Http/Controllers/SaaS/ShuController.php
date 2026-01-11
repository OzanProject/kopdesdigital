<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\Shu;
use App\Models\ShuMember;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShuController extends Controller
{
    public function index()
    {
        $koperasi_id = Auth::user()->koperasi_id;
        $shus = Shu::where('koperasi_id', $koperasi_id)->latest('tahun')->paginate(10);
        return view('back.shu.index', compact('shus'));
    }

    public function create()
    {
        return view('back.shu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|numeric|min:2000|max:'.(date('Y')+1),
            'total_shu' => 'required|numeric|min:0',
            'persentase_anggota' => 'required|numeric|min:0|max:100',
            'persentase_modal' => 'required|numeric|min:0|max:100',
            'persentase_usaha' => 'required|numeric|min:0|max:100',
        ]);

        $koperasi_id = Auth::user()->koperasi_id;

        // Formula Logic
        // 1. Total Member Share
        $total_dibagikan = $request->total_shu * ($request->persentase_anggota / 100);

        // 2. Pools
        $pool_modal = $total_dibagikan * ($request->persentase_modal / 100);
        $pool_usaha = $total_dibagikan * ($request->persentase_usaha / 100);

        // 3. Totals for ratios
        // 3. Totals for ratios
        $total_simpanan_koperasi = \App\Models\Simpanan::whereHas('nasabah', function($q) use ($koperasi_id) {
            $q->where('koperasi_id', $koperasi_id);
        })->sum('jumlah') - \App\Models\Penarikan::whereHas('nasabah', function($q) use ($koperasi_id) {
            $q->where('koperasi_id', $koperasi_id);
        })->sum('jumlah');

        // Total Pinjaman (Approximation for Jasa Usaha base)
        $total_pinjaman_koperasi = \App\Models\Pinjaman::where('koperasi_id', $koperasi_id)->sum('jumlah_pengajuan');

        DB::beginTransaction();
        try {
            $shu = Shu::create([
                'koperasi_id' => $koperasi_id,
                'tahun' => $request->tahun,
                'total_shu' => $request->total_shu,
                'persentase_anggota' => $request->persentase_anggota,
                'persentase_modal' => $request->persentase_modal,
                'persentase_usaha' => $request->persentase_usaha,
                'total_dibagikan' => $total_dibagikan,
                'status' => 'draft',
            ]);

            $nasabahs = Nasabah::where('koperasi_id', $koperasi_id)->get();

            foreach ($nasabahs as $nasabah) {
                // Member specific data
                $saldo_simpanan = $nasabah->simpanans()->sum('jumlah') - $nasabah->penarikans()->sum('jumlah');
                $total_pinjaman_member = $nasabah->pinjamans()->sum('jumlah_pengajuan');

                // Calculate portions
                $jasa_modal = 0;
                if ($total_simpanan_koperasi > 0) {
                    $jasa_modal = ($saldo_simpanan / $total_simpanan_koperasi) * $pool_modal;
                }

                $jasa_usaha = 0;
                if ($total_pinjaman_koperasi > 0) {
                    $jasa_usaha = ($total_pinjaman_member / $total_pinjaman_koperasi) * $pool_usaha;
                }

                $total_diterima = $jasa_modal + $jasa_usaha;

                if ($total_diterima > 0) {
                    ShuMember::create([
                        'shu_id' => $shu->id,
                        'nasabah_id' => $nasabah->id,
                        'shu_modal' => $jasa_modal,
                        'shu_usaha' => $jasa_usaha,
                        'total_diterima' => $total_diterima,
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('shu.index')->with('success', 'Perhitungan SHU berhasil dibuat (Draft).');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghitung SHU: ' . $e->getMessage());
        }
    }

    public function show(Shu $shu)
    {
        if ($shu->koperasi_id != Auth::user()->koperasi_id) abort(403);
        $shu->load('members.nasabah');
        return view('back.shu.show', compact('shu'));
    }

    public function publish(Shu $shu)
    {
        if ($shu->koperasi_id != Auth::user()->koperasi_id) abort(403);
        $shu->update(['status' => 'published']);
        return back()->with('success', 'SHU berhasil dipublikasikan ke anggota.');
    }
    public function destroy(Shu $shu)
    {
        if ($shu->koperasi_id != Auth::user()->koperasi_id) abort(403);
        
        // Delete related members first if not cascade (explicit is safer)
        $shu->members()->delete();
        $shu->delete();

        return redirect()->route('shu.index')->with('success', 'Data SHU berhasil dihapus.');
    }
}
