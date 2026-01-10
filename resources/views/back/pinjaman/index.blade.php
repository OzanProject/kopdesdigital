@extends('layouts.admin')

@section('title', 'Daftar Pinjaman')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pengajuan Pinjaman</h3>
        <div class="card-tools">
            <a href="{{ route('pinjaman.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Buat Pengajuan
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nasabah</th>
                        <th>Pengajuan</th>
                        <th>Tenor</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pinjamans as $pinjaman)
                    <tr>
                        <td>{{ $pinjaman->tanggal_pengajuan->format('d/m/Y') }}</td>
                        <td>{{ $pinjaman->nasabah->nama }} <br> <small>{{ $pinjaman->nasabah->no_anggota }}</small></td>
                        <td>Rp {{ number_format($pinjaman->jumlah_pengajuan, 0, ',', '.') }}</td>
                        <td>{{ $pinjaman->tenor_bulan }} Bulan</td>
                        <td>
                            @if($pinjaman->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($pinjaman->status == 'approved')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($pinjaman->status == 'rejected')
                                <span class="badge badge-danger">Ditolak</span>
                            @else
                                <span class="badge badge-info">Lunas</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('pinjaman.show', $pinjaman->id) }}" class="btn btn-sm btn-primary" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($pinjaman->status == 'pending')
                                <a href="{{ route('pinjaman.edit', $pinjaman->id) }}" class="btn btn-sm btn-info" title="Review">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                                @elseif($pinjaman->status == 'approved')
                                <button class="btn btn-sm btn-success disabled" title="Disetujui"><i class="fas fa-check"></i></button>
                                @else
                                <button class="btn btn-sm btn-danger disabled" title="Ditolak"><i class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada pengajuan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $pinjamans->links() }}
    </div>
</div>
@endsection
