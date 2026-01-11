@extends('layouts.admin')

@section('title', 'Daftar Pinjaman')

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
    .badge-soft-warning { background-color: #fffbeb; color: #92400e; }
    .badge-soft-success { background-color: #f0fdf4; color: #15803d; }
    .badge-soft-danger { background-color: #fef2f2; color: #b91c1c; }
    .badge-soft-info { background-color: #f0f9ff; color: #0369a1; }
    .btn-action { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; }
</style>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 font-weight-bold">Pengajuan Pinjaman Anggota</h5>
                <p class="text-muted small mb-0">Kelola persetujuan dan riwayat kredit anggota</p>
            </div>
            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                <a href="{{ route('pinjaman.create') }}" class="btn btn-primary btn-sm font-weight-bold px-3 rounded-pill shadow-sm">
                    <i class="fas fa-plus mr-1"></i> Buat Pengajuan Baru
                </a>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover m-0">
                <thead>
                    <tr>
                        <th class="px-4">Tgl Pengajuan</th>
                        <th>Nasabah</th>
                        <th class="text-right">Jumlah Pinjaman</th>
                        <th class="text-center">Tenor</th>
                        <th class="text-center">Status</th>
                        <th class="text-right px-4">Kelola</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pinjamans as $pinjaman)
                    <tr>
                        <td class="align-middle px-4 font-weight-bold text-muted">
                            {{ $pinjaman->tanggal_pengajuan->format('d M Y') }}
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold text-dark">{{ $pinjaman->nasabah->nama }}</div>
                            <small class="text-muted text-uppercase">{{ $pinjaman->nasabah->no_anggota }}</small>
                        </td>
                        <td class="align-middle text-right font-weight-bold text-primary fs-5">
                            Rp {{ number_format($pinjaman->jumlah_pengajuan, 0, ',', '.') }}
                        </td>
                        <td class="align-middle text-center">
                            <span class="badge bg-light border text-dark px-2 py-1">{{ $pinjaman->tenor_bulan }} Bulan</span>
                        </td>
                        <td class="align-middle text-center">
                            @php
                                $statusMap = [
                                    'pending' => ['badge-soft-warning', 'PENDING'],
                                    'approved' => ['badge-soft-success', 'DISETUJUI'],
                                    'rejected' => ['badge-soft-danger', 'DITOLAK'],
                                    'lunas' => ['badge-soft-info', 'LUNAS'],
                                ];
                                $state = $statusMap[$pinjaman->status] ?? ['badge-secondary', $pinjaman->status];
                            @endphp
                            <span class="badge {{ $state[0] }} px-3 py-2 rounded-pill font-weight-bold">
                                {{ $state[1] }}
                            </span>
                        </td>
                        <td class="align-middle text-right px-4">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('pinjaman.show', $pinjaman->id) }}" class="btn btn-white btn-sm text-primary btn-action" title="Lihat Jadwal">
                                    <i class="fas fa-calendar-alt"></i>
                                </a>
                                @if($pinjaman->status == 'pending')
                                <a href="{{ route('pinjaman.edit', $pinjaman->id) }}" class="btn btn-white btn-sm text-info btn-action" title="Review & Setujui">
                                    <i class="fas fa-check-double"></i>
                                </a>
                                <form action="{{ route('pinjaman.update', $pinjaman->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="reject" value="1">
                                    <button type="submit" class="btn btn-white btn-sm text-warning btn-action" title="Tolak Langsung" onclick="return confirm('Tolak pinjaman ini?')">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('pinjaman.destroy', $pinjaman->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pinjaman ini? Data angsuran terkait juga akan terhapus permanen.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-white btn-sm text-danger btn-action" title="Hapus Permanen">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-hand-holding-usd fa-3x text-light mb-3"></i>
                            <p class="text-muted">Belum ada pengajuan pinjaman masuk.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $pinjamans->links() }}
    </div>
</div>
@endsection