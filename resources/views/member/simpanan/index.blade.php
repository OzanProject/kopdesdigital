@extends('layouts.admin')

@section('title', 'Riwayat Simpanan')

@section('content')
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</h3>
                <p>Saldo Aktif Saat Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</h3>
                <p>Total Setoran Masuk</p>
            </div>
            <div class="icon">
                <i class="fas fa-arrow-down"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>Rp {{ number_format($totalPenarikan, 0, ',', '.') }}</h3>
                <p>Total Penarikan Keluar</p>
            </div>
            <div class="icon">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Transaksi Simpanan</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Simpanan</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($simpanans as $simpanan)
                <tr>
                    <td>{{ $simpanan->tanggal_transaksi->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($simpanan->jenis) }}</td>
                    <td>{{ $simpanan->keterangan ?? '-' }}</td>
                    <td class="text-success font-weight-bold">+ Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}</td>
                    <td><span class="badge badge-success">Berhasil</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data simpanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $simpanans->links() }}
    </div>
</div>
@endsection
