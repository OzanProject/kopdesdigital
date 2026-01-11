@extends('layouts.admin')

@section('title', 'Riwayat Simpanan & Tabungan')

@section('content')
<style>
    .stat-card-member {
        border: none;
        border-radius: 16px;
        transition: transform 0.3s;
    }
    .stat-card-member:hover { transform: translateY(-5px); }
    
    .table-ledger thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        border-top: none;
    }
    .badge-soft-success { background-color: #dcfce7; color: #15803d; }
    .badge-soft-info { background-color: #e0f2fe; color: #0369a1; }
    .text-income { color: #10b981; font-weight: 700; }
    .text-expense { color: #ef4444; font-weight: 700; }
</style>

<div class="row mb-4">
    <div class="col-lg-4 col-sm-6 mb-3">
        <div class="card stat-card-member shadow-sm bg-gradient-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-white-50 small mb-1 font-weight-bold">SALDO AKTIF</p>
                        <h3 class="text-white font-weight-bold mb-0">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg text-white">
                        <i class="fas fa-wallet fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-sm-6 mb-3">
        <div class="card stat-card-member shadow-sm bg-white border-left border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1 font-weight-bold uppercase">TOTAL SETORAN</p>
                        <h3 class="text-success font-weight-bold mb-0">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 p-2 rounded-lg text-success">
                        <i class="fas fa-arrow-circle-down fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-sm-12 mb-3">
        <div class="card stat-card-member shadow-sm bg-white border-left border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1 font-weight-bold uppercase">TOTAL PENARIKAN</p>
                        <h3 class="text-danger font-weight-bold mb-0">Rp {{ number_format($totalPenarikan, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-danger bg-opacity-10 p-2 rounded-lg text-danger">
                        <i class="fas fa-arrow-circle-up fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-history mr-2 text-primary"></i> Mutasi Rekening Anggota
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-ledger table-hover m-0">
                <thead>
                    <tr>
                        <th class="px-4">Tanggal</th>
                        <th>Kategori Simpanan</th>
                        <th>Keterangan</th>
                        <th class="text-right">Nominal</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($simpanans as $simpanan)
                    <tr>
                        <td class="align-middle px-4">
                            <span class="font-weight-bold text-dark d-block">{{ $simpanan->tanggal_transaksi->format('d M Y') }}</span>
                            <small class="text-muted">{{ $simpanan->tanggal_transaksi->format('H:i') }} WIB</small>
                        </td>
                        <td class="align-middle">
                            <span class="badge badge-soft-info px-3 py-2 rounded-pill font-weight-bold">
                                {{ strtoupper($simpanan->jenis) }}
                            </span>
                        </td>
                        <td class="align-middle text-muted small">
                            {{ $simpanan->keterangan ?? 'Setoran rutin simpanan' }}
                        </td>
                        <td class="align-middle text-right">
                            <span class="text-income fs-5">+ Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="badge badge-soft-success px-2 py-1 rounded">
                                <i class="fas fa-check-circle mr-1"></i> BERHASIL
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-receipt fa-3x text-light mb-3"></i>
                            <p class="text-muted">Belum ada riwayat transaksi pada akun Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Menampilkan riwayat simpanan periode berjalan.</small>
            <div>{{ $simpanans->links() }}</div>
        </div>
    </div>
</div>
@endsection