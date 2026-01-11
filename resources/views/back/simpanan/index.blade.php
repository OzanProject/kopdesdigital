@extends('layouts.admin')

@section('title', 'Riwayat Simpanan')

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
    .badge-soft-pokok { background-color: #e0f2fe; color: #0369a1; }
    .badge-soft-wajib { background-color: #fef3c7; color: #92400e; }
    .badge-soft-sukarela { background-color: #dcfce7; color: #15803d; }
    .btn-action { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; }
</style>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 font-weight-bold">Transaksi Simpanan</h5>
                <p class="text-muted small mb-0">Kelola setoran simpanan anggota koperasi</p>
            </div>
            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                <a href="{{ route('simpanan.create') }}" class="btn btn-primary btn-sm font-weight-bold px-3 rounded-pill shadow-sm">
                    <i class="fas fa-plus mr-1"></i> Setor Simpanan
                </a>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover m-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px">No</th>
                        <th>Tanggal</th>
                        <th>Anggota</th>
                        <th>Jenis Simpanan</th>
                        <th class="text-right">Jumlah (IDR)</th>
                        <th>Petugas</th>
                        <th class="text-center" style="width: 120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($simpanans as $simpanan)
                    <tr>
                        <td class="text-center align-middle font-weight-bold text-muted">{{ $loop->iteration + $simpanans->firstItem() - 1 }}</td>
                        <td class="align-middle">
                            <span class="font-weight-bold text-dark d-block">{{ $simpanan->tanggal_transaksi->format('d M Y') }}</span>
                            <small class="text-muted">{{ $simpanan->keterangan ?: 'Tanpa catatan' }}</small>
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold">{{ $simpanan->nasabah->nama }}</div>
                            <small class="text-muted text-uppercase">{{ $simpanan->nasabah->no_anggota }}</small>
                        </td>
                        <td class="align-middle">
                            @php
                                $badgeClass = match($simpanan->jenis) {
                                    'pokok' => 'badge-soft-pokok',
                                    'wajib' => 'badge-soft-wajib',
                                    default => 'badge-soft-sukarela',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill font-weight-bold">
                                {{ strtoupper($simpanan->jenis) }}
                            </span>
                        </td>
                        <td class="align-middle text-right font-weight-bold text-primary">
                            Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="align-middle small">
                            <i class="fas fa-user-circle mr-1 text-muted"></i> {{ $simpanan->user->name ?? '-' }}
                        </td>
                        <td class="text-center align-middle">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('simpanan.edit', $simpanan->id) }}" class="btn btn-white btn-sm text-warning btn-action" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('simpanan.destroy', $simpanan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus transaksi ini? Saldo anggota akan berkurang secara otomatis.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-white btn-sm text-danger btn-action" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-receipt fa-3x text-light mb-3"></i>
                            <p class="text-muted">Belum ada riwayat transaksi simpanan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $simpanans->links() }}
    </div>
</div>
@endsection