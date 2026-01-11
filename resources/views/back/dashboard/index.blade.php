@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan')

@section('content')
@php
    $currentKoperasi = auth()->user()->koperasi;
    $pendingTrans = \App\Models\SubscriptionTransaction::where('koperasi_id', $currentKoperasi->id)->where('status', 'pending')->latest()->first();
@endphp

<style>
    /* Custom Modern Dashboard Style */
    .stat-card {
        border: none;
        border-radius: 16px;
        transition: transform 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .icon-shape {
        width: 48px;
        height: 48px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .clock-card {
        background: #1e293b;
        border-radius: 16px;
        color: white;
    }
    .table-modern thead th {
        background: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        border: none;
    }
    .badge-soft-info { background: #e0f2fe; color: #0369a1; }
    .progress-modern { height: 8px; border-radius: 10px; background: rgba(255,255,255,0.15); }
</style>

@if($currentKoperasi && $currentKoperasi->status == 'pending_payment' && $pendingTrans)
    <div class="row">
        <div class="col-12">
            <div class="alert {{ isset($pendingTrans->payment_type) && str_contains($pendingTrans->payment_type, 'manual') ? 'alert-warning' : 'alert-danger' }} border-0 shadow-sm rounded-lg p-4 mb-4">
                <div class="d-flex align-items-center">
                    <div class="mr-3 fs-1"><i class="fas {{ isset($pendingTrans->payment_type) && str_contains($pendingTrans->payment_type, 'manual') ? 'fa-clock' : 'fa-exclamation-circle' }}"></i></div>
                    <div>
                        <h5 class="font-weight-bold mb-1">
                            {{ isset($pendingTrans->payment_type) && str_contains($pendingTrans->payment_type, 'manual') ? 'Pembayaran Sedang Diverifikasi' : 'Menunggu Pembayaran' }}
                        </h5>
                        <p class="mb-0 opacity-75">Selesaikan administrasi paket agar fitur koperasi Anda terbuka sepenuhnya.</p>
                    </div>
                    <div class="ml-auto">
                        @if(isset($pendingTrans->payment_type) && str_contains($pendingTrans->payment_type, 'manual'))
                            @php
                                $adminWa = preg_replace('/[^0-9]/', '', \App\Models\SaasSetting::where('key', 'app_wa')->value('value') ?? '6281321794279');
                            @endphp
                            <a href="https://wa.me/{{ $adminWa }}" target="_blank" class="btn btn-light font-weight-bold px-4">Hubungi Admin</a>
                        @else
                            <a href="{{ route('payment.show', $pendingTrans->order_id) }}" class="btn btn-light font-weight-bold px-4">Bayar Sekarang</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row mb-4">
    <div class="col-12">
        <div class="card clock-card border-0 shadow-sm">
            <div class="card-body py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="bg-primary p-2 rounded mr-3"><i class="fas fa-calendar-alt text-white"></i></div>
                    <div>
                        <h6 class="mb-0 font-weight-bold text-white">Ringkasan Operasional</h6>
                        <small class="text-white-50">{{ now()->translatedFormat('l, d F Y') }}</small>
                    </div>
                </div>
                <div class="text-right">
                    <span class="d-block small text-white-50">Waktu Server ({{ config('app.timezone') }})</span>
                    <h4 class="mb-0 font-weight-bold" id="server-clock">{{ now()->translatedFormat('H:i:s') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-3 col-sm-6 mb-3">
        <div class="card stat-card bg-info shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="icon-shape"><i class="fas fa-users"></i></div>
                    <a href="{{ route('nasabah.index') }}" class="text-white opacity-50"><i class="fas fa-chevron-right"></i></a>
                </div>
                <h3 class="font-weight-bold text-white mb-0">{{ $totalAnggota }}</h3>
                <p class="text-white-50 small mb-0">Total Anggota Terdaftar</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-3">
        <div class="card stat-card bg-success shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="icon-shape"><i class="fas fa-wallet"></i></div>
                    <a href="{{ route('simpanan.index') }}" class="text-white opacity-50"><i class="fas fa-chevron-right"></i></a>
                </div>
                <h3 class="font-weight-bold text-white mb-0">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</h3>
                <p class="text-white-50 small mb-0">Total Simpanan Masuk</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-3">
        <div class="card stat-card bg-primary shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="icon-shape"><i class="fas fa-hand-holding-usd"></i></div>
                    <a href="{{ route('pinjaman.index') }}" class="text-white opacity-50"><i class="fas fa-chevron-right"></i></a>
                </div>
                <h3 class="font-weight-bold text-white mb-0">Rp {{ number_format($totalPinjamanDisalurkan, 0, ',', '.') }}</h3>
                <p class="text-white-50 small mb-0">Pinjaman Disalurkan</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-3">
        <div class="card stat-card bg-danger shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="icon-shape"><i class="fas fa-exclamation-triangle"></i></div>
                    <a href="{{ route('pinjaman.index') }}" class="text-white opacity-50"><i class="fas fa-chevron-right"></i></a>
                </div>
                <h3 class="font-weight-bold text-white mb-0">Rp {{ number_format($tagihanBelumLunas, 0, ',', '.') }}</h3>
                <p class="text-white-50 small mb-0">Total Piutang Berjalan</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-8 mb-4">
        <div class="card border-0 shadow-sm rounded-lg h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-history mr-2 text-primary"></i> Transaksi Simpanan Terakhir</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern m-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Anggota</th>
                                <th>Jenis</th>
                                <th class="text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSimpanan as $simpanan)
                            <tr>
                                <td class="align-middle small font-weight-bold text-muted">{{ $simpanan->tanggal_transaksi->format('d M Y') }}</td>
                                <td class="align-middle font-weight-bold">{{ $simpanan->nasabah->nama }}</td>
                                <td class="align-middle"><span class="badge badge-soft-info px-2 py-1 rounded">{{ ucfirst($simpanan->jenis) }}</span></td>
                                <td class="align-middle text-right font-weight-bold text-primary">Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted small">Belum ada transaksi terekam.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white text-center">
                <a href="{{ route('simpanan.index') }}" class="small font-weight-bold text-decoration-none">LIHAT SEMUA TRANSAKSI <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-gradient-dark border-0 shadow-sm rounded-lg mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-shape bg-primary mr-3 text-white"><i class="fas fa-crown"></i></div>
                    <div>
                        <h6 class="mb-0 font-weight-bold">{{ $package->name ?? 'Free Tier' }}</h6>
                        <span class="badge {{ $currentKoperasi->status == 'active' ? 'badge-success' : 'badge-warning' }}">{{ $currentKoperasi->status == 'active' ? 'Langganan Aktif' : 'Menunggu' }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Kuota Anggota</span>
                        <span class="font-weight-bold">{{ $totalAnggota }}/{{ $package->max_members ?? '∞' }}</span>
                    </div>
                    @php $memberPercent = ($package && $package->max_members > 0) ? ($totalAnggota / $package->max_members) * 100 : 0; @endphp
                    <div class="progress progress-modern"><div class="progress-bar {{ $memberPercent > 80 ? 'bg-danger' : 'bg-primary' }}" style="width: {{ $memberPercent }}%"></div></div>
                </div>

                <div class="mb-2">
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Kuota Admin</span>
                        <span class="font-weight-bold">{{ $currentUsers }}/{{ $package->max_users ?? '∞' }}</span>
                    </div>
                    @php $userPercent = ($package && $package->max_users > 0) ? ($currentUsers / $package->max_users) * 100 : 0; @endphp
                    <div class="progress progress-modern"><div class="progress-bar {{ $userPercent > 80 ? 'bg-danger' : 'bg-info' }}" style="width: {{ $userPercent }}%"></div></div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-white"><h6 class="mb-0 font-weight-bold">Aksi Cepat</h6></div>
            <div class="card-body p-2">
                <div class="row no-gutters text-center">
                    <div class="col-6 p-1"><a href="{{ route('simpanan.create') }}" class="btn btn-outline-primary btn-block py-3 rounded-lg"><i class="fas fa-save d-block mb-1"></i> <small>Simpanan</small></a></div>
                    <div class="col-6 p-1"><a href="{{ route('pinjaman.create') }}" class="btn btn-outline-success btn-block py-3 rounded-lg"><i class="fas fa-hand-holding-usd d-block mb-1"></i> <small>Pinjaman</small></a></div>
                    <div class="col-6 p-1"><a href="{{ route('penarikan.create') }}" class="btn btn-outline-danger btn-block py-3 rounded-lg"><i class="fas fa-wallet d-block mb-1"></i> <small>Tarik Tunai</small></a></div>
                    <div class="col-6 p-1"><a href="{{ route('nasabah.create') }}" class="btn btn-outline-info btn-block py-3 rounded-lg"><i class="fas fa-user-plus d-block mb-1"></i> <small>Anggota Baru</small></a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection