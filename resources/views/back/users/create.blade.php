@extends('layouts.admin')

@section('title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 font-weight-bold text-primary">
                    <i class="fas {{ isset($user) ? 'fa-user-edit' : 'fa-user-shield' }} mr-2"></i>
                    {{ isset($user) ? 'Update Akses Pengguna' : 'Form Pembuatan User Baru' }}
                </h6>
            </div>
            
            <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
                @csrf
                @if(isset($user)) @method('PUT') @endif
                
                <div class="card-body p-4">
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control form-control-lg fs-6" 
                               value="{{ old('name', $user->name ?? '') }}" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold">Alamat Email (Username)</label>
                        <input type="email" name="email" class="form-control form-control-lg fs-6" 
                               value="{{ old('email', $user->email ?? '') }}" placeholder="email@koperasi.id" required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-primary">Role / Hak Akses</label>
                        <select name="role" class="form-control form-control-lg fs-6 custom-select">
                            <option value="petugas" {{ (isset($user) && $user->hasRole('petugas')) ? 'selected' : '' }}>👷 Petugas (Hanya Input Data)</option>
                            <option value="admin_koperasi" {{ (isset($user) && $user->hasRole('admin_koperasi')) ? 'selected' : '' }}>🛡️ Admin Koperasi (Akses Penuh)</option>
                        </select>
                    </div>

                    <div class="p-4 bg-light rounded-lg border border-dashed mt-5">
                        <h6 class="font-weight-bold mb-3"><i class="fas fa-key text-muted mr-2"></i> Kredensial Keamanan</h6>
                        
                        @if(isset($user))
                            <div class="alert alert-warning border-0 small mb-4 py-2">
                                <i class="fas fa-info-circle mr-1"></i> Biarkan kolom password kosong jika tidak ingin mengubahnya.
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small font-weight-bold">{{ isset($user) ? 'Password Baru' : 'Password Akses' }}</label>
                                    <input type="password" name="password" class="form-control" 
                                           placeholder="Min. 8 karakter" {{ isset($user) ? '' : 'required' }}>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" 
                                           placeholder="Ulangi password" {{ isset($user) ? '' : 'required' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 py-4 d-flex justify-content-between px-4">
                    <a href="{{ route('users.index') }}" class="btn btn-light px-4 font-weight-bold">Batal</a>
                    <button type="submit" class="btn {{ isset($user) ? 'btn-warning' : 'btn-primary' }} px-5 font-weight-bold rounded-pill shadow">
                        <i class="fas fa-save mr-2"></i> {{ isset($user) ? 'Update Akses User' : 'Buat User Sekarang' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection