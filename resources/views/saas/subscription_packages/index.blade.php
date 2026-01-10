@extends('layouts.admin')

@section('title', 'Manajemen Paket Langganan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Paket Langganan</h3>
        <div class="card-tools">
            <a href="{{ route('subscription-packages.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Paket
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Nama Paket</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th>Batas Member</th>
                        <th>Batas Admin</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $package)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $package->name }}</strong><br>
                            <small class="text-muted">{{ Str::limit($package->description, 30) }}</small>
                        </td>
                        <td>Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                        <td>{{ $package->duration_days }} Hari</td>
                        <td>{{ $package->max_members }}</td>
                        <td>{{ $package->max_users }}</td>
                        <td>
                            @if($package->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('subscription-packages.edit', $package->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('subscription-packages.destroy', $package->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus paket ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada paket langganan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
