<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\Simpanan;
use App\Models\Pinjaman;
use App\Models\Angsuran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('super_admin')) {
            return redirect()->route('super.dashboard');
        }

        // 1. Statistik Dasar
        $totalAnggota = Nasabah::count();
        $totalSimpanan = Simpanan::sum('jumlah'); // Netto? Maybe later subtract penarikan
        
        $totalPinjamanDisalurkan = Pinjaman::where('status', '!=', 'rejected')->sum('jumlah_disetujui');
        
        // Pinjaman Outstanding (Yang belum dibayar)
        // Hitung total angsuran yg belum lunas
        $tagihanBelumLunas = Angsuran::where('status', '!=', 'paid')->sum('jumlah_bayar');

        // Statistik Status Anggota
        $anggotaAktif = Nasabah::where('status', 'active')->count();

        // 5 Transaksi Terakhir
        $recentSimpanan = Simpanan::with('nasabah')->latest('tanggal_transaksi')->take(5)->get();

        // Subscription Stats
        $koperasi = auth()->user()->koperasi;
        $package = $koperasi->subscriptionPackage;
        $currentUsers = \App\Models\User::where('koperasi_id', $koperasi->id)->count();
        // $totalAnggota is already $currentMembers

        return view('back.dashboard.index', compact(
            'totalAnggota', 
            'totalSimpanan', 
            'totalPinjamanDisalurkan', 
            'tagihanBelumLunas',
            'anggotaAktif',
            'recentSimpanan',
            'package',
            'currentUsers'
        ));
    }

    public function superAdmin()
    {
        // 1. Basic Counts
        $totalKoperasi = \App\Models\Koperasi::count();
        $totalActiveUsers = \App\Models\User::withoutGlobalScope('koperasi')->count();

        // 2. Revenue Estimation (Monthly)
        $estimatedRevenue = \App\Models\Koperasi::where('status', 'active')
            ->get() // Get collection to sum logic
            ->sum(function($koperasi) {
                return $koperasi->subscriptionPackage->price ?? 0;
            });

        // 3. Tenant Growth (Last 6 Months)
        $growthData = \App\Models\Koperasi::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, count(*) as count")
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');
            
        // Fill missing months with 0
        $labels = [];
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $labels[] = \Carbon\Carbon::parse($month)->format('M Y');
            $data[] = $growthData[$month] ?? 0;
        }

        // 4. Package Distribution
        $packageStats = \App\Models\Koperasi::selectRaw('subscription_package_id, count(*) as count')
            ->groupBy('subscription_package_id')
            ->with('subscriptionPackage')
            ->get();
            
        $pieLabels = $packageStats->map(fn($item) => $item->subscriptionPackage->name ?? 'No Package')->toArray();
        $pieData = $packageStats->pluck('count')->toArray();

        // 5. Recent Activity
        $newKoperasis = \App\Models\Koperasi::latest()->take(5)->get();

        // 6. Support & Helper Stats
        $pendingTickets = \App\Models\SupportTicket::whereIn('status', ['open', 'pending'])->count();
        
        $totalArticles = \App\Models\Article::count();
        $totalArticleViews = \App\Models\Article::sum('view_count');

        return view('saas.dashboard.super_admin', compact(
            'totalKoperasi', 
            'totalActiveUsers', 
            'newKoperasis',
            'estimatedRevenue',
            'labels',
            'data',
            'pieLabels',
            'pieData',
            'pendingTickets',
            'totalArticles',
            'totalArticleViews'
        ));
    }
}
