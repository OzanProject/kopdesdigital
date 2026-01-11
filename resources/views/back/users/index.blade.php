@extends('layouts.admin')

@section('title', 'Manajemen User')

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
    .badge-role { background-color: #e2e8f0; color: #475569; font-weight: 700; font-size: 0.7rem; }
    .badge-admin { background-color: #dbeafe; color: #1e40af; }
    .user-avatar-small { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
</style>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 font-weight-bold text-dark">Daftar Pengguna Sistem</h5>
                <p class="text-muted small mb-0">Kelola hak akses administrator dan petugas koperasi</p>
            </div>
            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm font-weight-bold px-3 rounded-pill shadow-sm">
                    <i class="fas fa-user-plus mr-1"></i> Tambah User Baru
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover m-0">
                <thead>
                    <tr>
                        <th class="px-4" style="width: 50px">#</th>
                        <th>Informasi Pengguna</th>
                        <th>Email</th>
                        <th>Role / Jabatan</th>
                        <th>Tanggal Terdaftar</th>
                        <th class="text-right px-4">Kelola</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="align-middle px-4 text-muted font-weight-bold">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="user-avatar-small mr-2 shadow-sm">
                                <span class="font-weight-bold text-dark">{{ $user->name }}</span>
                                @if($user->id == Auth::id())
                                    <span class="badge badge-light border ml-2 small">Anda</span>
                                @endif
                            </div>
                        </td>
                        <td class="align-middle">{{ $user->email }}</td>
                        <td class="align-middle text-uppercase">
                            @foreach($user->roles as $role)
                                @php $isAdmin = str_contains($role->name, 'admin'); @endphp
                                <span class="badge {{ $isAdmin ? 'badge-admin' : 'badge-role' }} px-2 py-1 rounded">
                                    {{ str_replace('_', ' ', $role->name) }}
                                </span>
                            @endforeach
                        </td>
                        <td class="align-middle text-muted">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="align-middle text-right px-4">
                            <div class="btn-group shadow-sm rounded-lg overflow-hidden">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-white btn-sm text-warning" title="Edit Data">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                @if($user->id != Auth::id())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus akses user ini dari sistem?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-white btn-sm text-danger" title="Hapus User">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
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
    <div class="card-footer bg-white border-0 py-3">
        {{ $users->links() }}
    </div>
</div>
@endsection