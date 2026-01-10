@extends('layouts.admin')

@section('title', 'Tambah Admin Koperasi')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Buat Akun Admin untuk: {{ $koperasi->nama }}</h3>
    </div>
    <form action="{{ route('koperasi.users.store', $koperasi->id) }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Nama Admin" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="admin@koperasi.com" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password Default</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
            </div>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> User ini akan otomatis mendapatkan role <b>admin_koperasi</b> dan memiliki akses penuh ke manajemen koperasi ini.
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan User</button>
            <a href="{{ route('koperasi.users.index', $koperasi->id) }}" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
@endsection
