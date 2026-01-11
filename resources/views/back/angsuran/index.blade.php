@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Angsuran')

@section('content')
<style>
    .table-modern thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        border-top: none;
    }
    .badge-soft-warning { background-color: #fef3c7; color: #92400e; }
    .badge-soft-success { background-color: #dcfce7; color: #15803d; }
    .badge-soft-danger { background-color: #fee2e2; color: #b91c1c; }
    .stat-mini-card { border: none; border-radius: 12px; transition: transform 0.2s; }
    .stat-mini-card:hover { transform: translateY(-3px); }
</style>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stat-mini-card shadow-sm border-left border-warning">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small font-weight-bold mb-1">ANGSURAN BERJALAN</p>
                        <h5 class="font-weight-bold mb-0 text-warning">{{ $angsurans->where('status', 'unpaid')->count() }} Tagihan</h5>
                    </div>
                    <div class="bg-warning-soft p-2 rounded-circle" style="background: rgba(245, 158, 11, 0.1)">
                        <i class="fas fa-clock text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-mini-card shadow-sm border-left border-danger">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small font-weight-bold mb-1">MENUNGGU PEMBAYARAN</p>
                        <h5 class="font-weight-bold mb-0 text-danger">Rp {{ number_format($angsurans->where('status', 'unpaid')->sum('jumlah_bayar'), 0, ',', '.') }}</h5>
                    </div>
                    <div class="bg-danger-soft p-2 rounded-circle" style="background: rgba(239, 68, 68, 0.1)">
                        <i class="fas fa-exclamation-circle text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-mini-card shadow-sm border-left border-success">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small font-weight-bold mb-1">LUNAS BULAN INI</p>
                        <h5 class="font-weight-bold mb-0 text-success">Rp {{ number_format($angsurans->where('status', 'paid')->sum('jumlah_bayar'), 0, ',', '.') }}</h5>
                    </div>
                    <div class="bg-success-soft p-2 rounded-circle" style="background: rgba(16, 185, 129, 0.1)">
                        <i class="fas fa-check-double text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-4">
                <h5 class="mb-0 font-weight-bold">Daftar Jadwal Masuk</h5>
                <p class="text-muted small mb-0">Total: {{ $angsurans->total() }} record tagihan</p>
            </div>
            <div class="col-md-8 text-md-right mt-2 mt-md-0">
                <form action="{{ route('angsuran.index') }}" method="GET" class="form-inline justify-content-md-end">
                    <div class="input-group input-group-sm mr-2 shadow-xs">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-filter text-muted"></i></span>
                        </div>
                        <select name="status" class="form-control border-left-0" onchange="this.form.submit()">
                            <option value="">Status Bayar</option>
                            <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>🚨 Belum Lunas</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>✅ Sudah Lunas</option>
                        </select>
                    </div>
                    <div class="input-group input-group-sm shadow-xs" style="width: 250px;">
                        <input type="text" name="search" class="form-control border-right-0" placeholder="Nama atau ID Anggota..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover m-0">
                <thead>
                    <tr>
                        <th class="px-4">Estimasi Bayar</th>
                        <th>Identitas Anggota</th>
                        <th>Referensi Pinjaman</th>
                        <th class="text-right">Nominal Tagihan</th>
                        <th class="text-center">Tenor Ke</th>
                        <th class="text-center">Keterangan Status</th>
                        <th class="text-right px-4">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($angsurans as $angsuran)
                    <tr>
                        <td class="align-middle px-4">
                            <span class="font-weight-bold {{ $angsuran->status != 'paid' && $angsuran->jatuh_tempo->isPast() ? 'text-danger' : 'text-dark' }}">
                                {{ $angsuran->jatuh_tempo->translatedFormat('d M Y') }}
                            </span>
                            @if($angsuran->status != 'paid' && $angsuran->jatuh_tempo->isPast())
                                <span class="badge badge-soft-danger ml-1 font-weight-bold" style="font-size: 0.65rem;">TERLAMBAT</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold text-dark">{{ $angsuran->pinjaman->nasabah->nama ?? '-' }}</div>
                            <code class="small text-muted">{{ $angsuran->pinjaman->nasabah->no_anggota ?? '-' }}</code>
                        </td>
                        <td class="align-middle">
                            <a href="{{ route('pinjaman.show', $angsuran->pinjaman_id) }}" class="text-primary font-weight-bold small">
                                <i class="fas fa-file-invoice mr-1"></i>{{ $angsuran->pinjaman->kode_pinjaman ?? $angsuran->pinjaman_id }}
                            </a>
                            <div class="small text-muted italic">{{ Str::limit($angsuran->pinjaman->product->nama_produk ?? 'Pinjaman Reguler', 20) }}</div>
                        </td>
                        <td class="align-middle text-right">
                            <span class="font-weight-bold text-dark fs-6">Rp {{ number_format($angsuran->jumlah_bayar, 0, ',', '.') }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="badge badge-light border px-2 py-1 shadow-xs">
                                {{ $angsuran->angsuran_ke }} <small class="text-muted">/{{ $angsuran->pinjaman->tenor_bulan }}</small>
                            </div>
                        </td>
                        <td class="align-middle text-center">
                            @if($angsuran->status == 'paid')
                                <span class="badge badge-soft-success px-3 py-2 rounded-pill font-weight-bold shadow-xs">LUNAS</span>
                                <div class="small text-muted mt-1 font-italic" style="font-size: 0.7rem;">Diterima: {{ $angsuran->tanggal_bayar->format('d/m/y') }}</div>
                            @else
                                <span class="badge badge-soft-warning px-3 py-2 rounded-pill font-weight-bold shadow-xs">BELUM BAYAR</span>
                            @endif
                        </td>
                        <td class="align-middle text-right px-4">
                            @if($angsuran->status != 'paid')
                            <a href="{{ route('angsuran.edit', $angsuran->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 font-weight-bold shadow-sm">
                                <i class="fas fa-cash-register mr-1"></i> Terima Bayar
                            </a>
                            @else
                            <button class="btn btn-light btn-sm rounded-pill px-3 text-muted border shadow-xs" disabled>
                                <i class="fas fa-check-circle mr-1 text-success"></i> Terverifikasi
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="opacity-25 mb-3"><i class="fas fa-calendar-times fa-4x"></i></div>
                            <p class="text-muted font-italic">Tidak ada jadwal angsuran yang tersedia untuk filter ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <small class="text-muted">Menampilkan {{ $angsurans->count() }} data dari total {{ $angsurans->total() }}</small>
        <div>{{ $angsurans->appends(request()->input())->links() }}</div>
    </div>
</div>
@endsection