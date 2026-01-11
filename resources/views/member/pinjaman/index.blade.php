@extends('layouts.admin')

@section('title', 'Riwayat Pinjaman Saya')

@section('content')
<style>
    .table-loan thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        border-top: none;
    }
    .badge-soft-success { background-color: #dcfce7; color: #15803d; }
    .badge-soft-primary { background-color: #e0f2fe; color: #0369a1; }
    .badge-soft-warning { background-color: #fef3c7; color: #92400e; }
    .text-remaining { color: #ef4444; font-weight: 700; }
</style>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 font-weight-bold text-dark">Daftar Pinjaman Anda</h5>
                <p class="text-muted small mb-0">Pantau status pengajuan dan sisa tagihan pinjaman Anda</p>
            </div>
            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                <a href="{{ route('member.pinjaman.create') }}" class="btn btn-primary btn-sm font-weight-bold px-3 rounded-pill shadow-sm">
                    <i class="fas fa-plus mr-1"></i> Ajukan Pinjaman Baru
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-loan table-hover m-0">
                <thead>
                    <tr>
                        <th class="px-4">Ref. ID</th>
                        <th>Tgl Pengajuan</th>
                        <th class="text-right">Pokok Pinjaman</th>
                        <th class="text-right">Total Kewajiban</th>
                        <th class="text-right">Sisa Tagihan</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pinjamans as $pinjaman)
                    <tr>
                        <td class="align-middle px-4">
                            <span class="font-weight-bold text-dark">{{ $pinjaman->kode_pinjaman ?? 'REQ-'.$pinjaman->id }}</span>
                            <br><small class="text-muted">{{ Str::limit($pinjaman->keterangan ?? 'Tanpa keterangan', 20) }}</small>
                        </td>
                        <td class="align-middle">
                            <span class="text-muted small font-weight-bold">{{ $pinjaman->tanggal_pengajuan->translatedFormat('d M Y') }}</span>
                        </td>
                        <td class="align-middle text-right font-weight-bold">
                            Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}
                            <br><small class="text-primary">{{ $pinjaman->bunga_persen }}% Bunga</small>
                        </td>
                        <td class="align-middle text-right text-muted small">
                            Rp {{ number_format($pinjaman->total_jumlah, 0, ',', '.') }}
                        </td>
                        <td class="align-middle text-right">
                            <span class="text-remaining fs-5">Rp {{ number_format($pinjaman->sisa_tagihan, 0, ',', '.') }}</span>
                        </td>
                        <td class="align-middle text-center">
                            @php
                                $statusClass = match($pinjaman->status) {
                                    'lunas' => 'badge-soft-success',
                                    'aktif' => 'badge-soft-primary',
                                    'pending' => 'badge-soft-warning',
                                    default => 'badge-soft-secondary',
                                };
                                $statusLabel = match($pinjaman->status) {
                                    'lunas' => 'LUNAS',
                                    'aktif' => 'AKTIF / BERJALAN',
                                    'pending' => 'REVIEW ADMIN',
                                    default => strtoupper($pinjaman->status),
                                };
                            @endphp
                            <span class="badge {{ $statusClass }} px-3 py-2 rounded-pill font-weight-bold">
                                {{ $statusLabel }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="mb-3 opacity-25"><i class="fas fa-hand-holding-usd fa-3x"></i></div>
                            <p class="text-muted">Anda belum memiliki riwayat pengajuan pinjaman.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3 px-4">
        {{ $pinjamans->links() }}
    </div>
</div>
@endsection