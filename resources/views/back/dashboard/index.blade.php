@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@section('content')
@php
    $currentKoperasi = auth()->user()->koperasi;
    $pendingTrans = \App\Models\SubscriptionTransaction::where('koperasi_id', $currentKoperasi->id)->where('status', 'pending')->latest()->first();
@endphp

@if($currentKoperasi && $currentKoperasi->status == 'pending_payment' && $pendingTrans)
    @if(isset($pendingTrans->payment_type) && str_contains($pendingTrans->payment_type, 'manual'))
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-clock"></i> Pembayaran Sedang Diverifikasi!</h5>
            Anda telah melakukan pembayaran manual via transfer bank. Admin sedang memverifikasi bukti transfer Anda.
            <br>Status: <strong>Menunggu Konfirmasi Admin</strong>.
            @php
                 $adminWa = \App\Models\SaasSetting::where('key', 'app_wa')->value('value') ?? '6281234567890';
            @endphp
            <a href="https://wa.me/{{ $adminWa }}" target="_blank" class="btn btn-light btn-sm font-weight-bold ml-2 text-dark shadow-sm">
                <i class="fab fa-whatsapp mr-1"></i> Hubungi Admin
            </a>
        </div>
    @else
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Menunggu Pembayaran!</h5>
            Akun koperasi Anda belum aktif sepenuhnya. Silakan selesaikan pembayaran untuk menghilangkan batasan.
            <a href="{{ route('payment.show', $pendingTrans->order_id) }}" class="btn btn-light font-weight-bold ml-2 text-dark shadow-sm">
                <i class="fas fa-credit-card mr-1"></i> Bayar Sekarang
            </a>
            <a href="{{ route('payment.check', $pendingTrans->order_id) }}" class="btn btn-outline-light font-weight-bold ml-2 shadow-sm">
                <i class="fas fa-sync mr-1"></i> Cek Status (Refresh)
            </a>
        </div>
    @endif
@endif



<div class="row mb-3">
    <div class="col-12">
        <div class="card bg-gradient-dark">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0"><i class="far fa-clock mr-2"></i> Waktu Server Saat Ini</h5>
                    <small class="text-white-50">Zona Waktu: <strong>{{ config('app.timezone') }}</strong></small>
                </div>
                <h3 class="mb-0 font-weight-bold" id="server-clock">{{ now()->translatedFormat('H:i:s') }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalAnggota }}</h3>
                <p>Total Anggota</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-stalker"></i>
            </div>
            <a href="{{ route('nasabah.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3><sup style="font-size: 20px">Rp</sup>{{ number_format($totalSimpanan, 0, ',', '.') }}</h3>
                <p>Total Simpanan Masuk</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('simpanan.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><sup style="font-size: 20px">Rp</sup>{{ number_format($totalPinjamanDisalurkan, 0, ',', '.') }}</h3>
                <p>Pinjaman Disalurkan</p>
            </div>
            <div class="icon">
                <i class="ion ion-cash"></i>
            </div>
            <a href="{{ route('pinjaman.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><sup style="font-size: 20px">Rp</sup>{{ number_format($tagihanBelumLunas, 0, ',', '.') }}</h3>
                <p>Piutang (Belum Lunas)</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('pinjaman.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Transaksi Simpanan Terakhir</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Anggota</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSimpanan as $simpanan)
                            <tr>
                                <td>{{ $simpanan->tanggal_transaksi->format('d/m/Y') }}</td>
                                <td>{{ $simpanan->nasabah->nama }}</td>
                                <td><span class="badge badge-info">{{ ucfirst($simpanan->jenis) }}</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}</div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <a href="{{ route('simpanan.create') }}" class="btn btn-sm btn-info float-left">Tambah Simpanan Baru</a>
                <a href="{{ route('simpanan.index') }}" class="btn btn-sm btn-secondary float-right">Lihat Semua Transaksi</a>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Subscription Package Card -->
        <div class="card bg-gradient-primary">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-crown mr-1"></i>
                    {{ $package->name ?? 'Tanpa Paket' }}
                </h3>
            </div>
            <div class="card-body pt-0">
                <p>Status: {{ $currentKoperasi->status == 'active' ? 'Aktif' : 'Menunggu Pembayaran' }}</p>
                
                <div class="progress-group">
                    Kuota Nasabah
                    <span class="float-right"><b>{{ $totalAnggota }}</b>/{{ $package->max_members ?? '∞' }}</span>
                    <div class="progress progress-sm">
                        @php
                            $memberPercent = ($package && $package->max_members > 0) ? ($totalAnggota / $package->max_members) * 100 : 0;
                            $memberColor = $memberPercent > 90 ? 'bg-danger' : 'bg-warning';
                        @endphp
                        <div class="progress-bar {{ $memberColor }}" style="width: {{ $memberPercent }}%"></div>
                    </div>
                </div>

                <div class="progress-group mt-3">
                    Kuota User Admin
                    <span class="float-right"><b>{{ $currentUsers }}</b>/{{ $package->max_users ?? '∞' }}</span>
                    <div class="progress progress-sm">
                         @php
                            $userPercent = ($package && $package->max_users > 0) ? ($currentUsers / $package->max_users) * 100 : 0;
                            $userColor = $userPercent > 90 ? 'bg-danger' : 'bg-warning';
                        @endphp
                        <div class="progress-bar {{ $userColor }}" style="width: {{ $userPercent }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Boxes Style 2 -->
        <div class="info-box mb-3 bg-secondary">
            <span class="info-box-icon"><i class="fas fa-user-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Anggota Aktif</span>
                <span class="info-box-number">{{ $anggotaAktif }}</span>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Aksi Cepat</h3>
            </div>
            <div class="card-body">
                <a href="{{ route('simpanan.create') }}" class="btn btn-app">
                    <i class="fas fa-save"></i> Simpanan
                </a>
                <a href="{{ route('pinjaman.create') }}" class="btn btn-app">
                    <i class="fas fa-hand-holding-usd"></i> Ajukan Pinjaman
                </a>
                <a href="{{ route('penarikan.create') }}" class="btn btn-app">
                    <i class="fas fa-wallet"></i> Penarikan
                </a>
                <a href="{{ route('nasabah.create') }}" class="btn btn-app">
                    <i class="fas fa-user-plus"></i> Nasabah Baru
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Initial Server Time handling
        var serverTime = new Date("{{ now()->format('Y-m-d H:i:s') }}");
        
        function updateClock() {
            // Increment by 1 second
            serverTime.setSeconds(serverTime.getSeconds() + 1);
            
            var hours = String(serverTime.getHours()).padStart(2, '0');
            var minutes = String(serverTime.getMinutes()).padStart(2, '0');
            var seconds = String(serverTime.getSeconds()).padStart(2, '0');
            
            $('#server-clock').text(hours + ':' + minutes + ':' + seconds);
        }

        setInterval(updateClock, 1000);
    });
</script>
@endpush
