@extends('layouts.admin')

@section('title', 'Edit Admin Koperasi')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit User: {{ $user->name }}</h3>
    </div>
    <form action="{{ route('koperasi.users.update', [$koperasi->id, $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password Baru (Opsional)</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Kosongkan jika tidak ingin mengganti password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('koperasi.users.index', $koperasi->id) }}" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
@endsection
