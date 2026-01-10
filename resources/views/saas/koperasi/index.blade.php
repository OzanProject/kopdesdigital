@extends('layouts.admin')

@section('title', 'Manajemen Koperasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Tenant Koperasi</h3>
        <div class="card-tools">
            <a href="{{ route('koperasi.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Koperasi
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Logo</th>
                        <th>Nama Koperasi</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Paket</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($koperasis as $koperasi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($koperasi->logo)
                                <img src="{{ asset('storage/' . $koperasi->logo) }}" alt="Logo" class="img-circle img-size-32 mr-2" style="object-fit: cover;">
                            @else
                                <span class="img-size-32 mr-2 text-center d-inline-block bg-light rounded-circle" style="line-height:32px"><i class="fas fa-building text-muted"></i></span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $koperasi->nama }}</strong><br>
                            <small class="text-muted">{{ $koperasi->email ?? '-' }}</small>
                        </td>
                        <td>{{ Str::limit($koperasi->alamat, 30) }}</td>
                        <td>
                            @if($koperasi->status == 'active')
                                <span class="badge badge-success">Active</span>
                            @elseif($koperasi->status == 'inactive')
                                <span class="badge badge-warning">Inactive</span>
                            @else
                                <span class="badge badge-danger">Suspended</span>
                            @endif
                        </td>
                        <td>
                            @if($koperasi->subscriptionPackage)
                                <span class="badge badge-info">{{ $koperasi->subscriptionPackage->name }}</span>
                            @else
                                <span class="badge badge-secondary">No Package</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('koperasi.users.index', $koperasi->id) }}" class="btn btn-info btn-sm" title="Kelola Admin">
                                    <i class="fas fa-users-cog"></i>
                                </a>
                                <a href="{{ route('koperasi.edit', $koperasi->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('koperasi.destroy', $koperasi->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                                <form action="{{ route('koperasi.reset', $koperasi->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('BAHAYA: Anda yakin ingin mereset SEMUA data nasabah dan transaksi? Data tidak bisa dikembalikan!')">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary btn-sm" title="Reset Data Transaksi"><i class="fas fa-sync-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data koperasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $koperasis->links() }}
    </div>
</div>
@endsection
