@extends('layouts.admin')

@section('title', 'Tambah Nasabah')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Formulir Pendaftaran</h3>
    </div>
    <form action="{{ route('nasabah.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap">
                @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="number" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" placeholder="Nomor Induk Kependudukan">
                 @error('nik') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="telepon">No. Telepon / WA</label>
                <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}" placeholder="Contoh: 0812...">
            </div>
            <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}" placeholder="Pekerjaan saat ini">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat domisili">{{ old('alamat') }}</textarea>
            </div>

            <hr>
            <h5 class="text-primary"><i class="fas fa-lock mr-2"></i> Akses Login Anggota</h5>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="create_login" name="create_login" value="1" {{ old('create_login') ? 'checked' : '' }}>
                    <label for="create_login" class="custom-control-label">Buatkan akun login untuk anggota ini</label>
                </div>
            </div>

            <div id="login_fields" style="display: {{ old('create_login') ? 'block' : 'none' }};">
                <div class="form-group">
                    <label for="email">Email (Username)</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="nasabah@email.com">
                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter">
                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <script>
                document.getElementById('create_login').addEventListener('change', function() {
                    document.getElementById('login_fields').style.display = this.checked ? 'block' : 'none';
                });
            </script>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Nasabah</button>
            <a href="{{ route('nasabah.index') }}" class="btn btn-default float-right">Batal</a>
        </div>
    </form>
</div>
@endsection
