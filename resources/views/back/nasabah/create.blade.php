@extends('layouts.admin')

@section('title', isset($nasabah) ? 'Edit Data Anggota' : 'Tambah Anggota Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 font-weight-bold text-primary">
                    <i class="fas {{ isset($nasabah) ? 'fa-user-edit' : 'fa-user-plus' }} mr-2"></i>
                    {{ isset($nasabah) ? 'Update Informasi Anggota: ' . $nasabah->no_anggota : 'Formulir Pendaftaran Anggota' }}
                </h6>
            </div>
            
            <form action="{{ isset($nasabah) ? route('nasabah.update', $nasabah->id) : route('nasabah.store') }}" method="POST">
                @csrf
                @if(isset($nasabah)) @method('PUT') @endif
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $nasabah->nama ?? '') }}" placeholder="Ahmad Sulaiman">
                                @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">NIK (No. KTP)</label>
                                <input type="number" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $nasabah->nik ?? '') }}" placeholder="16 digit angka">
                                @error('nik') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Nomor Telepon / WA</label>
                                <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $nasabah->telepon ?? '') }}" placeholder="0812...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $nasabah->pekerjaan ?? '') }}" placeholder="Karyawan Swasta">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Alamat Tinggal</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Jl. Raya Desa No. 12...">{{ old('alamat', $nasabah->alamat ?? '') }}</textarea>
                    </div>

                    @if(isset($nasabah))
                    <div class="form-group">
                        <label class="small font-weight-bold text-danger">Status Keanggotaan</label>
                        <select name="status" class="form-control select2">
                            <option value="active" {{ $nasabah->status == 'active' ? 'selected' : '' }}>AKTIF (Dapat Bertransaksi)</option>
                            <option value="inactive" {{ $nasabah->status == 'inactive' ? 'selected' : '' }}>NON-AKTIF</option>
                            <option value="keluar" {{ $nasabah->status == 'keluar' ? 'selected' : '' }}>KELUAR (Tutup Akun)</option>
                        </select>
                    </div>
                    @endif

                    <div class="mt-5 p-4 bg-light rounded-lg border border-dashed">
                        <h6 class="font-weight-bold mb-3"><i class="fas fa-key mr-2 text-primary"></i> Akses Dashboard Member</h6>
                        
                        @if(isset($nasabah) && $nasabah->user)
                            <div class="alert alert-info bg-white border-0 shadow-sm small mb-4">
                                <i class="fas fa-check-circle text-success mr-2"></i> Akun login sudah aktif. Admin hanya bisa mengubah email atau mereset password.
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold">Email Username</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $nasabah->user->email) }}">
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-0">
                                <label class="small font-weight-bold text-primary">Reset Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Isi hanya jika ingin mengganti password">
                                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        @else
                            <div class="custom-control custom-switch mb-3">
                                <input type="checkbox" class="custom-control-input" id="create_login" name="create_login" value="1" {{ old('create_login') ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold" for="create_login">Aktifkan Akses Login Anggota</label>
                            </div>

                            <div id="login_fields" style="display: {{ old('create_login') ? 'block' : 'none' }};">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Email Username</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="nasabah@example.com">
                                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Password Awal</label>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 8 Karakter">
                                            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-footer bg-white py-4 d-flex justify-content-between">
                    <a href="{{ route('nasabah.index') }}" class="btn btn-light px-4 font-weight-bold">Batal</a>
                    <button type="submit" class="btn btn-primary px-5 font-weight-bold rounded-pill shadow">
                        <i class="fas fa-save mr-2"></i> {{ isset($nasabah) ? 'Update Data Anggota' : 'Simpan Data Anggota' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
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