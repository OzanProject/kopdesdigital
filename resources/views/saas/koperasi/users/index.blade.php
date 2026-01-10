@extends('layouts.admin')

@section('title', 'Admin Koperasi: ' . $koperasi->nama)

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengguna / Admin</h3>
        <div class="card-tools">
            <a href="{{ route('koperasi.users.create', $koperasi->id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Admin Baru
            </a>
            <a href="{{ route('koperasi.index') }}" class="btn btn-default btn-sm ml-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Gabung</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge badge-info">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('koperasi.users.edit', [$koperasi->id, $user->id]) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id != auth()->id())
                                <form action="{{ route('koperasi.users.destroy', [$koperasi->id, $user->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus admin ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada admin untuk koperasi ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $users->links() }}
    </div>
</div>
@endsection
