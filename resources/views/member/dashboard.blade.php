@extends('layouts.admin')

@section('title', 'Dashboard Anggota')

@section('content')
<style>
    /* Member Specific Styling */
    .member-stat-card {
        border: none;
        border-radius: 20px;
        transition: transform 0.3s ease;
    }
    .member-stat-card:hover { transform: translateY(-5px); }
    
    .quick-action-btn {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 15px;
        text-align: center;
        transition: all 0.3s;
        width: 100%;
        display: block;
        color: #475569;
    }
    .quick-action-btn:hover {
        background: #f8fafc;
        border-color: #0d6efd;
        color: #0d6efd;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .quick-action-btn i { font-size: 24px; margin-bottom: 8px; display: block; }
    
    .progress-finance { height: 10px; border-radius: 10px; background: #e2e8f0; }
    
    .profile-banner {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 20px;
        color: white;
        padding: 30px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }
    .profile-banner::after {
        content: ""; position: absolute; top: -50px; right: -50px;
        width: 150px; height: 150px; background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
</style>

<div class="profile-banner shadow-sm">
    <div class="row align-items-center">
        <div class="col-md-8 d-flex align-items-center">
            <img class="img-circle elevation-2 border border-white" 
                 src="{{ $nasabah->foto ? asset('storage/' . $nasabah->foto) : asset('adminlte3/dist/img/user2-160x160.jpg') }}" 
                 alt="User Avatar" style="width:80px; height:80px; object-fit: cover;">
            <div class="ml-4">
                <h3 class="font-weight-bold mb-1">Selamat Datang, {{ $nasabah->nama }}!</h3>
                <p class="mb-0 opacity-75"><i class="fas fa-id-badge mr-1"></i> No. Anggota: <strong>{{ $nasabah->no_anggota }}</strong></p>
            </div>
        </div>
        <div class="col-md-4 text-md-right mt-3 mt-md-0">
            <a href="{{ route('member.profile.card') }}" target="_blank" class="btn btn-light rounded-pill px-4 font-weight-bold">
                <i class="fas fa-id-card mr-2"></i> Kartu Anggota Digital
            </a>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-4 col-sm-6 mb-3">
        <div class="card member-stat-card bg-success shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg text-white"><i class="fas fa-wallet fa-lg"></i></div>
                    <span class="text-white-50 small">Total Tabungan</span>
                </div>
                <h3 class="font-weight-bold text-white mb-0">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</h3>
                <a href="{{ route('member.simpanan.index') }}" class="text-white-50 small mt-2 d-block">Lihat Mutasi <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6 mb-3">
        <div class="card member-stat-card bg-danger shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg text-white"><i class="fas fa-hand-holding-usd fa-lg"></i></div>
                    <span class="text-white-50 small">Sisa Kewajiban</span>
                </div>
                <h3 class="font-weight-bold text-white mb-0">Rp {{ number_format($totalHutang, 0, ',', '.') }}</h3>
                <a href="{{ route('member.pinjaman.index') }}" class="text-white-50 small mt-2 d-block">Detail Tagihan <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12 mb-3">
        <div class="card member-stat-card bg-info shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg text-white"><i class="fas fa-chart-line fa-lg"></i></div>
                    <span class="text-white-50 small">Dividen (SHU)</span>
                </div>
                <h3 class="font-weight-bold text-white mb-0">Rp {{ number_format($totalShu, 0, ',', '.') }}</h3>
                <a href="{{ route('member.shu.index') }}" class="text-white-50 small mt-2 d-block">Laporan Tahunan <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-lg-5 mb-4">
        <div class="card border-0 shadow-sm rounded-lg mb-4">
            <div class="card-header bg-white py-3"><h6 class="mb-0 font-weight-bold">Layanan Mandiri</h6></div>
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-6 mb-3">
                        <a href="{{ route('member.pinjaman.create') }}" class="quick-action-btn text-decoration-none">
                            <i class="fas fa-file-signature text-primary"></i> <span class="small font-weight-bold">Ajukan Dana</span>
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="{{ route('member.pinjaman.index') }}" class="quick-action-btn text-decoration-none">
                            <i class="fas fa-receipt text-warning"></i> <span class="small font-weight-bold">Riwayat</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('member.shu.index') }}" class="quick-action-btn text-decoration-none">
                            <i class="fas fa-piggy-bank text-success"></i> <span class="small font-weight-bold">SHU Saya</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('knowledge-base.index') }}" class="quick-action-btn text-decoration-none">
                            <i class="fas fa-info-circle text-info"></i> <span class="small font-weight-bold">Pusat Bantuan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-white py-3"><h6 class="mb-0 font-weight-bold">Status Pinjaman Aktif</h6></div>
            <div class="card-body">
                @if($activePinjaman)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Pokok Pinjaman</span>
                        <span class="font-weight-bold">Rp {{ number_format($activePinjaman->jumlah_pengajuan, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small">Progres Pelunasan</span>
                            <span class="small font-weight-bold text-success">{{ number_format($loanProgress, 0) }}%</span>
                        </div>
                        <div class="progress progress-finance"><div class="progress-bar bg-success" style="width: {{ $loanProgress }}%"></div></div>
                    </div>
                    <div class="bg-light p-3 rounded-lg d-flex align-items-center">
                        <i class="fas fa-calendar-day text-muted mr-3"></i>
                        <div>
                            <small class="d-block text-muted">Jatuh Tempo Berikutnya</small>
                            <span class="font-weight-bold">{{ \Carbon\Carbon::parse($activePinjaman->created_at)->addMonths(1)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="text-muted opacity-25 mb-2"><i class="fas fa-check-circle fa-3x"></i></div>
                        <p class="text-muted small mb-0">Tidak ada kewajiban pinjaman yang tertunggak.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-white p-0">
                <ul class="nav nav-tabs nav-fill border-0" id="activityTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active py-3 border-0 font-weight-bold" id="simpanan-tab" data-toggle="tab" href="#simpanan" role="tab">Aktivitas Simpanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-3 border-0 font-weight-bold" id="angsuran-tab" data-toggle="tab" href="#angsuran" role="tab">Bayar Angsuran</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="tab-content" id="activityTabContent">
                    <div class="tab-pane fade show active" id="simpanan" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr class="bg-light"><th class="border-0 px-4">Tanggal</th><th class="border-0">Jenis</th><th class="border-0 text-right px-4">Jumlah</th></tr>
                                </thead>
                                <tbody>
                                    @forelse($recentSimpanan as $item)
                                    <tr>
                                        <td class="align-middle px-4 small font-weight-bold text-muted">{{ $item->tanggal_transaksi->format('d M Y') }}</td>
                                        <td class="align-middle"><span class="badge badge-light border px-2 py-1">{{ ucfirst($item->jenis) }}</span></td>
                                        <td class="align-middle text-right px-4 font-weight-bold text-success">+ Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="text-center py-5 text-muted">Belum ada aktivitas terekam.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="angsuran" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr class="bg-light"><th class="border-0 px-4">Tgl Bayar</th><th class="border-0">Ref Pinjaman</th><th class="border-0 text-right px-4">Jumlah</th></tr>
                                </thead>
                                <tbody>
                                    @forelse($recentAngsuran as $item)
                                    <tr>
                                        <td class="align-middle px-4 small font-weight-bold text-muted">{{ $item->tanggal_bayar ? $item->tanggal_bayar->format('d M Y') : '-' }}</td>
                                        <td class="align-middle font-weight-bold">{{ $item->pinjaman->kode_pinjaman ?? 'L-'.$item->pinjaman_id }}</td>
                                        <td class="align-middle text-right px-4 font-weight-bold text-danger">- Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="text-center py-5 text-muted">Belum ada pembayaran angsuran.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 text-center pb-4">
                <a href="{{ route('member.simpanan.index') }}" class="small font-weight-bold text-uppercase">Lihat Seluruh Riwayat</a>
            </div>
        </div>
    </div>
</div>
@endsection