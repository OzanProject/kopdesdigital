@extends('layouts.admin')

@section('title', 'Global Users')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Semua User (Global)</h3>
        <div class="card-tools">
            <form action="{{ route('global-users.index') }}" method="GET">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Cari Nama / Email" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover text-nowrap">
                <thead>
                    <tr>
                        <th style="width: 1%">#</th>
                        <th>User ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Koperasi (Tenant)</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge badge-info">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if($user->koperasi)
                                <a href="{{ route('koperasi.edit', $user->koperasi_id) }}">{{ $user->koperasi->nama }}</a>
                            @elseif(!$user->koperasi_id)
                                <span class="badge badge-warning">Super Admin / System</span>
                            @else
                                <span class="text-muted">Deleted Tenant</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data user.</td>
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
