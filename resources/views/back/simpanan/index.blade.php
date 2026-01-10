@extends('layouts.admin')

@section('title', 'Riwayat Simpanan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Transaksi Simpanan</h3>
        <div class="card-tools">
            <a href="{{ route('simpanan.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Setor Simpanan
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">No</th>
                        <th>Tanggal</th>
                        <th>No Anggota</th>
                        <th>Nama Nasabah</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Ket</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($simpanans as $simpanan)
                    <tr>
                        <td>{{ $loop->iteration + $simpanans->firstItem() - 1 }}</td>
                        <td>{{ $simpanan->tanggal_transaksi->format('d/m/Y') }}</td>
                        <td>{{ $simpanan->nasabah->no_anggota }}</td>
                        <td>{{ $simpanan->nasabah->nama }}</td>
                        <td><span class="badge badge-info">{{ ucfirst($simpanan->jenis) }}</span></td>
                        <td>Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $simpanan->keterangan }}</td>
                        <td>{{ $simpanan->user->name ?? '-' }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('simpanan.edit', $simpanan->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('simpanan.destroy', $simpanan->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus transaksi ini? Saldo anggota akan berkurang.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $simpanans->links() }}
    </div>
</div>
@endsection
