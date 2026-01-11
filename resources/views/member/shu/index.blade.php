@extends('layouts.admin')

@section('title', 'Riwayat SHU Saya')

@section('content')
<style>
    .shu-card {
        border: none;
        border-radius: 20px;
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: white;
    }
    .table-shu thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        border-top: none;
    }
    .text-profit { color: #059669; font-weight: 800; }
    .info-shu-box {
        background-color: #f0fdf4;
        border: 1px dashed #22c55e;
        border-radius: 16px;
    }
</style>

<div class="row mb-4">
    <div class="col-md-6 col-lg-4">
        <div class="card shu-card shadow-lg mb-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small font-weight-bold opacity-75">TOTAL SHU DITERIMA</span>
                    <i class="fas fa-coins fa-lg opacity-50"></i>
                </div>
                <h2 class="font-weight-bold mb-1">Rp {{ number_format($shu_members->sum('total_diterima'), 0, ',', '.') }}</h2>
                <p class="small mb-0 opacity-75">Akumulasi keuntungan dari awal bergabung</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-8">
        <div class="card info-shu-box shadow-none h-100 mb-3">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 bg-white rounded-circle mr-3 shadow-sm text-success">
                    <i class="fas fa-info-circle fa-2x"></i>
                </div>
                <div>
                    <h6 class="font-weight-bold text-success mb-1">Mengenai Sisa Hasil Usaha (SHU)</h6>
                    <p class="small text-muted mb-0">SHU adalah dividen yang Anda peroleh dari kombinasi <strong>Jasa Modal</strong> (keaktifan menabung) dan <strong>Jasa Usaha</strong> (partisipasi pinjaman/transaksi).</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-list-ul mr-2 text-success"></i> Histori Pembagian Per Tahun Buku
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-shu table-hover m-0">
                <thead>
                    <tr>
                        <th class="px-4">Tahun Buku</th>
                        <th class="text-right">Jasa Modal</th>
                        <th class="text-right">Jasa Usaha</th>
                        <th class="text-right">Total Diterima</th>
                        <th class="text-center">Tgl Distribusi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shu_members as $item)
                    <tr>
                        <td class="align-middle px-4">
                            <span class="badge badge-dark px-3 py-2 rounded-pill font-weight-bold">
                                {{ $item->shu->tahun }}
                            </span>
                        </td>
                        <td class="align-middle text-right font-weight-bold text-muted">
                            Rp {{ number_format($item->shu_modal, 0, ',', '.') }}
                        </td>
                        <td class="align-middle text-right font-weight-bold text-muted">
                            Rp {{ number_format($item->shu_usaha, 0, ',', '.') }}
                        </td>
                        <td class="align-middle text-right">
                            <span class="text-profit fs-5">Rp {{ number_format($item->total_diterima, 0, ',', '.') }}</span>
                        </td>
                        <td class="align-middle text-center small text-muted font-weight-bold">
                            {{ $item->created_at->translatedFormat('d M Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-gift fa-3x text-light mb-3"></i>
                            <p class="text-muted">Riwayat pembagian SHU Anda belum tersedia.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3 px-4">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Semua perhitungan SHU sah berdasarkan Rapat Anggota Tahunan (RAT).</small>
            <div>{{ $shu_members->links() }}</div>
        </div>
    </div>
</div>
@endsection