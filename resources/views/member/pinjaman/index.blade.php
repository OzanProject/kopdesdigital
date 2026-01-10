@extends('layouts.admin')

@section('title', 'Riwayat Pinjaman')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pinjaman Saya</h3>
        <div class="card-tools">
            <a href="{{ route('member.pinjaman.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Ajukan Pinjaman
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Kode Pinjaman</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Jumlah Pinjaman</th>
                    <th>Bunga</th>
                    <th>Total Harus Bayar</th>
                    <th>Sisa Tagihan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pinjamans as $pinjaman)
                <tr>
                    <td>{{ $pinjaman->kode_pinjaman ?? '-' }}</td>
                    <td>{{ $pinjaman->tanggal_pengajuan->format('d/m/Y') }}</td>
                    <td>Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}</td>
                    <td>{{ $pinjaman->bunga_persen }}%</td>
                    <td>Rp {{ number_format($pinjaman->total_jumlah, 0, ',', '.') }}</td>
                    <td class="text-danger font-weight-bold">Rp {{ number_format($pinjaman->sisa_tagihan, 0, ',', '.') }}</td>
                    <td>
                        @if($pinjaman->status == 'lunas')
                            <span class="badge badge-success">Lunas</span>
                        @elseif($pinjaman->status == 'aktif')
                            <span class="badge badge-primary">Aktif (Belum Lunas)</span>
                        @elseif($pinjaman->status == 'pending')
                            <span class="badge badge-warning">Menunggu Persetujuan</span>
                        @else
                            <span class="badge badge-secondary">{{ ucfirst($pinjaman->status) }}</span>
                        @endif
                    </td>
                    <td>{{ $pinjaman->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Anda belum pernah melakukan pinjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $pinjamans->links() }}
    </div>
</div>
@endsection
