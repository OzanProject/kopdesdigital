@extends('layouts.admin')

@section('title', 'Edit Nasabah')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Data Nasabah: {{ $nasabah->no_anggota }}</h3>
    </div>
    <form action="{{ route('nasabah.update', $nasabah->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $nasabah->nama) }}">
                @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="number" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $nasabah->nik) }}">
                 @error('nik') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="telepon">No. Telepon / WA</label>
                <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $nasabah->telepon) }}">
            </div>
            <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $nasabah->pekerjaan) }}">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $nasabah->alamat) }}</textarea>
            </div>
            <div class="form-group">
                <label for="status">Status Keanggotaan</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $nasabah->status == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ $nasabah->status == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                    <option value="keluar" {{ $nasabah->status == 'keluar' ? 'selected' : '' }}>Keluar</option>
                </select>
            </div>

            <hr>
            <h5 class="mt-4 mb-3"><i class="fas fa-lock mr-2"></i> Akses Login Anggota</h5>

            @if($nasabah->user)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Anggota ini sudah memiliki akun login.
                </div>
                <div class="form-group">
                    <label>Email Login</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $nasabah->user->email) }}">
                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Reset Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password baru">
                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            @else
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="create_login" name="create_login" value="1" {{ old('create_login') ? 'checked' : '' }}>
                    <label class="form-check-label" for="create_login">Buatkan akun login untuk anggota ini</label>
                </div>

                <div id="login_fields" style="{{ old('create_login') ? '' : 'display: none;' }}">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="contoh@email.com">
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update Data</button>
            <a href="{{ route('nasabah.index') }}" class="btn btn-default float-right">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#create_login').change(function() {
            if(this.checked) {
                $('#login_fields').slideDown();
            } else {
                $('#login_fields').slideUp();
            }
        });
    });
</script>
@endpush
@endsection
