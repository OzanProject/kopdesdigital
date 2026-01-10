@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit User</h3>
            </div>
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    
                    <hr>
                    <small class="text-danger">*Kosongkan jika tidak ingin mengganti password</small>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Password Baru">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi Password Baru">
                    </div>
                    <hr>

                    <div class="form-group">
                        <label>Role / Jabatan</label>
                        <select name="role" class="form-control">
                            <option value="petugas" {{ $user->hasRole('petugas') ? 'selected' : '' }}>Petugas</option>
                            <option value="admin_koperasi" {{ $user->hasRole('admin_koperasi') ? 'selected' : '' }}>Admin Koperasi</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Update Data</button>
                    <a href="{{ route('users.index') }}" class="btn btn-default float-right">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
