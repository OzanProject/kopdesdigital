@extends('layouts.admin')

@section('title', 'Riwayat Penarikan')

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
    .text-amount-out { color: #dc2626; font-family: 'Monaco', 'Consolas', monospace; }
    .badge-user { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
</style>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 font-weight-bold">Log Penarikan Simpanan</h5>
                <p class="text-muted small mb-0">Catatan mutasi keluar dari Simpanan Sukarela anggota</p>
            </div>
            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                <a href="{{ route('penarikan.create') }}" class="btn btn-warning btn-sm font-weight-bold px-3 rounded-pill shadow-sm">
                    <i class="fas fa-minus-circle mr-1"></i> Catat Penarikan
                </a>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover m-0">
                <thead>
                    <tr>
                        <th class="px-4">Tanggal</th>
                        <th>Nasabah / Anggota</th>
                        <th class="text-right">Jumlah Tarik</th>
                        <th>Petugas Pelaksana</th>
                        <th class="px-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penarikans as $penarikan)
                    <tr>
                        <td class="align-middle px-4 font-weight-bold text-muted">
                            {{ $penarikan->tanggal_penarikan->format('d M Y') }}
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold text-dark">{{ $penarikan->nasabah->nama }}</div>
                            <small class="text-muted text-uppercase">{{ $nasabah->no_anggota }}</small>
                        </td>
                        <td class="align-middle text-right font-weight-bold text-amount-out fs-5">
                            - Rp {{ number_format($penarikan->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="align-middle">
                            <span class="badge badge-user px-2 py-1 rounded">
                                <i class="fas fa-user-tie mr-1 small"></i> {{ $penarikan->user->name ?? '-' }}
                            </span>
                        </td>
                        <td class="align-middle px-4">
                            <small class="text-muted">{{ $penarikan->keterangan ?: 'Mutasi Penarikan Tunai' }}</small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-history fa-3x text-light mb-3 d-block"></i>
                            <p class="text-muted">Belum ada data penarikan simpanan tercatat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3 px-4">
        {{ $penarikans->links() }}
    </div>
</div>
@endsection