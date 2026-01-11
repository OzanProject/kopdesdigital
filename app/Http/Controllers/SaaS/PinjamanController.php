<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinjamanController extends Controller
{
    public function index()
    {
        $pinjamans = Pinjaman::with('nasabah')->latest('tanggal_pengajuan')->paginate(10);
        return view('back.pinjaman.index', compact('pinjamans'));
    }

    public function create()
    {
        $nasabahs = Nasabah::where('status', 'active')->orderBy('nama')->get();
        return view('back.pinjaman.create', compact('nasabahs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'jumlah_pengajuan' => 'required|numeric|min:50000',
            'tenor_bulan' => 'required|integer|min:1|max:60',
            'bunga_persen' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $validated['koperasi_id'] = Auth::user()->koperasi_id;
        $validated['status'] = 'pending';
        $validated['tanggal_pengajuan'] = now();
        $validated['kode_pinjaman'] = \App\Models\Pinjaman::generateKode(Auth::user()->koperasi_id);

        Pinjaman::create($validated);

        return redirect()->route('pinjaman.index')->with('success', 'Pengajuan pinjaman berhasil dibuat.');
    }

    public function show(Pinjaman $pinjaman)
    {
        $pinjaman->load(['nasabah', 'angsurans', 'approver']);
        return view('back.pinjaman.show', compact('pinjaman'));
    }

    public function edit(Pinjaman $pinjaman)
    {
        return view('back.pinjaman.edit', compact('pinjaman'));
    }

    public function update(Request $request, Pinjaman $pinjaman)
    {
        // Approval Logic
        if ($request->has('approve')) {
            $approvedAmount = $request->jumlah_disetujui ?? $pinjaman->jumlah_pengajuan;
            $bungaPersen = $pinjaman->bunga_persen;
            $tenor = $pinjaman->tenor_bulan;

            // Simple Flat Interest Calculation
            $totalBunga = $approvedAmount * ($bungaPersen / 100) * $tenor;
            $totalBayar = $approvedAmount + $totalBunga;
            $angsuranPerBulan = $totalBayar / $tenor;

            $pinjaman->update([
                'status' => 'approved',
                'tanggal_disetujui' => now(),
                'jumlah_disetujui' => $approvedAmount,
                 // Maybe add total_bunga or total_tagihan column later if needed
                'approved_by' => Auth::id(),
            ]);

            // Generate Installments
            for ($i = 1; $i <= $tenor; $i++) {
                \App\Models\Angsuran::create([
                    'koperasi_id' => $pinjaman->koperasi_id,
                    'pinjaman_id' => $pinjaman->id,
                    'angsuran_ke' => $i,
                    'jatuh_tempo' => now()->addMonths($i),
                    'jumlah_bayar' => $angsuranPerBulan,
                    'status' => 'unpaid',
                ]);
            }

            return redirect()->route('pinjaman.index')->with('success', 'Pinjaman disetujui & Jadwal Angsuran dibuat.');
        }

        if ($request->has('reject')) {
            $pinjaman->update([
                'status' => 'rejected',
                'approved_by' => Auth::id(),
            ]);
            return redirect()->route('pinjaman.index')->with('success', 'Pinjaman ditolak.');
        }

        return back();
    }
    public function destroy(Pinjaman $pinjaman)
    {
        $pinjaman->delete();
        return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil dihapus.');
    }
}
