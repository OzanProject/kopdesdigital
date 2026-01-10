@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengguna Sistem</h3>
        <div class="card-tools">
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus"></i> Tambah User
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
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                            @endforeach
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id != Auth::id())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $users->links() }}
    </div>
</div>
@endsection
