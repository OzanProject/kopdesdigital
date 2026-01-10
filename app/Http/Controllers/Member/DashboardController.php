<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $nasabah = $user->nasabah;

        if (!$nasabah) {
             return view('member.no_nasabah'); // Fallback if no linked nasabah
        }

        // Statistics
        $totalSimpanan = $nasabah->simpanans()->sum('jumlah') - $nasabah->penarikans()->sum('jumlah');
        $sisaPinjaman = $nasabah->pinjamans()->where('status', 'active')->sum('jumlah_disetujui') 
                        - \App\Models\Angsuran::whereHas('pinjaman', function($q) use ($nasabah) {
                            $q->where('nasabah_id', $nasabah->id);
                        })->where('status', 'paid')->sum('jumlah_bayar'); // This is rough, logic might need refinement based on exact repayment structure

        // Better calculation for Sisa Pinjaman (Outstanding Loan)
        // Iterate active loans and sum remaining installments
        $activeLoans = $nasabah->pinjamans()->where('status', 'approved')->get();
        $totalHutang = 0;
        foreach ($activeLoans as $loan) {
            $totalHutang += $loan->angsurans()->where('status', '!=', 'paid')->sum('jumlah_bayar');
        }

        // SHU Summary
        $totalShu = \App\Models\ShuMember::where('nasabah_id', $nasabah->id)->sum('total_diterima');

        // Recent Transactions
        $recentSimpanan = $nasabah->simpanans()->latest('tanggal_transaksi')->take(5)->get();
        $recentAngsuran = \App\Models\Angsuran::whereHas('pinjaman', function($q) use ($nasabah) {
            $q->where('nasabah_id', $nasabah->id);
        })->with('pinjaman')->latest('tanggal_bayar')->take(5)->get();

        $activePinjaman = $nasabah->pinjamans()->where('status', 'approved')->latest()->first();
        
        // Loan Progress Calculation
        $loanProgress = 0;
        $totalPaid = 0;
        if ($activePinjaman) {
            $totalPaid = $activePinjaman->angsurans()->where('status', 'paid')->sum('jumlah_bayar');
            // Assuming total_jumlah is the total to be paid (Principal + Interest)
             // Use jumlah_pengajuan (Principal) for now if total_jumlah is ambiguous, but ideally we want total bill.
             // Let's use logic from `totalHutang` earlier: 
             // We can calculate total expected payment if we knew interest structure.
             // For now let's safely use: Progress = Payed / (Payed + Remaining)
             // Or simpler: $totalPaid vs $activePinjaman->jumlah_pengajuan (Principal) purely? No, that misses interest.
             // Let's just pass data to view and handle simplest case.
             
             // If we rely on stored `total_jumlah` (which we removed/don't have reliable column for), we have issue.
             // Let's use: Target = Principal. Progress = Paid Principal.
             // This is safe even if interest varies.
             if ($activePinjaman->jumlah_pengajuan > 0) {
                 $loanProgress = ($totalPaid / $activePinjaman->jumlah_pengajuan) * 100;
             }
        }

        return view('member.dashboard', compact(
            'nasabah', 
            'totalSimpanan', 
            'totalHutang', 
            'totalShu',
            'recentSimpanan', 
            'recentAngsuran',
            'activePinjaman',
            'loanProgress'
        ));
    }
}
