@extends('layouts.admin')

@section('title', 'Dashboard Anggota')

@section('content')
@section('content')
<!-- Row 1: Summary Widgets -->
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><sup style="font-size: 20px">Rp</sup>{{ number_format($totalSimpanan, 0, ',', '.') }}</h3>
                <p>Saldo Simpanan</p>
            </div>
            <div class="icon"><i class="ion ion-stats-bars"></i></div>
            <a href="{{ route('member.simpanan.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><sup style="font-size: 20px">Rp</sup>{{ number_format($totalHutang, 0, ',', '.') }}</h3>
                <p>Sisa Hutang</p>
            </div>
            <div class="icon"><i class="ion ion-pie-graph"></i></div>
            <a href="{{ route('member.pinjaman.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><sup style="font-size: 20px">Rp</sup>{{ number_format($totalShu, 0, ',', '.') }}</h3>
                <p>Total SHU Diterima</p>
            </div>
            <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
            <a href="{{ route('member.shu.index') }}" class="small-box-footer">Lihat Histori <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Row 2: Main Content -->
<div class="row">
    <!-- Left Col: Profile & Loan Status -->
    <div class="col-md-5">
        <!-- Quick Actions -->
        <div class="card mb-3">
            <div class="card-header border-0">
                <h3 class="card-title">Aksi Cepat</h3>
            </div>
            <div class="card-body p-2 d-flex justify-content-around">
                <a href="{{ route('member.pinjaman.create') }}" class="btn btn-app bg-primary text-white">
                    <i class="fas fa-file-invoice-dollar"></i> Ajukan Pinjaman
                </a>
                <a href="{{ route('member.pinjaman.index') }}" class="btn btn-app">
                    <i class="fas fa-history"></i> Riwayat Pinjaman
                </a>
                 <a href="{{ route('member.shu.index') }}" class="btn btn-app">
                    <i class="fas fa-chart-line"></i> SHU Saya
                </a>
                <a href="{{ route('member.profile.card') }}" target="_blank" class="btn btn-app bg-purple text-white">
                    <i class="fas fa-id-card"></i> Cetak Kartu
                </a>
            </div>
        </div>

        @if($activePinjaman)
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Pinjaman Aktif</h3>
                <div class="card-tools">
                    <span class="badge badge-warning">Jatuh Tempo: {{ \Carbon\Carbon::parse($activePinjaman->created_at)->addMonths(1)->format('d M') }}*</span>
                </div>
            </div>
            <div class="card-body">
                <p class="text-muted mb-1">Pinjaman Pokok</p>
                <h5>Rp {{ number_format($activePinjaman->jumlah_pengajuan, 0, ',', '.') }}</h5>
                
                <p class="text-muted mb-1 mt-3">Progress Pelunasan ({{ number_format($loanProgress, 0) }}%)</p>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $loanProgress }}%" aria-valuenow="{{ $loanProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                
                <div class="row text-center mt-4">
                    <div class="col-6">
                        <small class="text-muted">Tenor</small>
                        <h6>{{ $activePinjaman->tenor_bulan }} Bulan</h6>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-info">
            <h5><i class="icon fas fa-info"></i> Tidak Ada Pinjaman Aktif</h5>
            Anda tidak memiliki pinjaman berjalan saat ini. Butuh dana? Ajukan sekarang!
        </div>
        @endif
        
        <!-- Compact Profile -->
        <div class="card card-widget widget-user-2 mt-3">
            <div class="widget-user-header bg-navy">
                <div class="widget-user-image">
                    <img class="img-circle elevation-2" src="{{ $nasabah->foto ? asset('storage/' . $nasabah->foto) : asset('adminlte3/dist/img/user2-160x160.jpg') }}" alt="User Avatar" style="width:65px; object-fit: cover;">
                </div>
                <h3 class="widget-user-username">{{ $nasabah->nama }}</h3>
                <h5 class="widget-user-desc">{{ $nasabah->no_anggota }}</h5>
            </div>
        </div>
    </div>

    <!-- Right Col: Transactions Tabs -->
    <div class="col-md-7">
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-simpanan" data-toggle="pill" href="#content-simpanan" role="tab" aria-controls="content-simpanan" aria-selected="true">Simpanan Terakhir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-angsuran" data-toggle="pill" href="#content-angsuran" role="tab" aria-controls="content-angsuran" aria-selected="false">Angsuran Terakhir</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="content-simpanan" role="tabpanel" aria-labelledby="tab-simpanan">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSimpanan as $item)
                                <tr>
                                    <td>{{ $item->tanggal_transaksi->format('d/m/Y') }}</td>
                                    <td>{{ ucfirst($item->jenis) }}</td>
                                    <td class="text-success">+ Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="content-angsuran" role="tabpanel" aria-labelledby="tab-angsuran">
                         <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal Bayar</th>
                                    <th>Pinjaman Ref</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAngsuran as $item)
                                <tr>
                                    <td>{{ $item->tanggal_bayar ? $item->tanggal_bayar->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $item->pinjaman->kode_pinjaman ?? '-' }}</td>
                                    <td class="text-danger">- Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center">Belum ada pembayaran.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection
