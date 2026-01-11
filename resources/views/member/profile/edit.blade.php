@extends('layouts.admin')

@section('title', 'Pengaturan Profil Anggota')

@section('content')
<style>
    .profile-card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .avatar-wrapper {
        position: relative;
        display: inline-block;
        padding: 5px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .profile-user-img-main {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 3px solid #f8fafc;
    }
    .status-badge-profile {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 25px;
        height: 25px;
        background: #22c55e;
        border: 4px solid #fff;
        border-radius: 50%;
    }
    .form-section-title {
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }
    .form-section-title::after {
        content: "";
        flex-grow: 1;
        height: 1px;
        background: #e2e8f0;
        margin-left: 15px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-xl-3 mb-4">
            <div class="card profile-card-modern shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="avatar-wrapper mb-3">
                        <img class="profile-user-img-main img-fluid img-circle"
                             src="{{ $nasabah->foto ? asset('storage/' . $nasabah->foto) : asset('adminlte3/dist/img/user2-160x160.jpg') }}"
                             id="avatarPreview" alt="User profile picture">
                        <div class="status-badge-profile" title="Akun Aktif"></div>
                    </div>

                    <h5 class="font-weight-bold text-dark mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-4">{{ $nasabah->no_anggota }}</p>

                    <div class="text-left mt-4 pt-4 border-top">
                        <div class="mb-3">
                            <label class="small text-muted d-block mb-0">Status Keanggotaan</label>
                            <span class="badge badge-success px-3 py-2 rounded-pill shadow-xs">{{ strtoupper($nasabah->status) }}</span>
                        </div>
                        <div class="mb-0">
                            <label class="small text-muted d-block mb-0">Tanggal Bergabung</label>
                            <span class="font-weight-bold text-dark">{{ $nasabah->tanggal_bergabung->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3 text-center">
                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-4 font-weight-bold" onclick="document.getElementById('fotoInput').click();">
                        <i class="fas fa-camera mr-1"></i> Ganti Foto Profil
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-xl-9">
            <div class="card profile-card-modern shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="font-weight-bold mb-0">Informasi Pribadi</h5>
                    <p class="text-muted small">Kelola data diri dan keamanan akun Anda</p>
                </div>

                <form action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    {{-- Input File Tersembunyi --}}
                    <input type="file" name="foto" id="fotoInput" style="display: none;" accept="image/*">

                    <div class="card-body px-4">
                        <div class="form-section-title">Data Identitas</div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="small font-weight-bold">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control form-control-lg fs-6 @error('nama') is-invalid @enderror" 
                                           value="{{ old('nama', $nasabah->nama) }}" placeholder="Masukkan nama sesuai KTP">
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="small font-weight-bold">Alamat Email</label>
                                    <input type="email" class="form-control form-control-lg fs-6 bg-light" value="{{ $user->email }}" disabled>
                                    <small class="text-muted italic"><i class="fas fa-info-circle mr-1"></i> Hubungi Admin untuk mengubah email.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="small font-weight-bold">Nomor Telepon / WA</label>
                                    <input type="text" name="telepon" class="form-control form-control-lg fs-6" 
                                           value="{{ old('telepon', $nasabah->telepon) }}" placeholder="Contoh: 0812xxxx">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="small font-weight-bold">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control form-control-lg fs-6" 
                                           value="{{ old('pekerjaan', $nasabah->pekerjaan) }}" placeholder="Karyawan Swasta, PNS, dll.">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small font-weight-bold">Alamat Domisili</label>
                            <textarea name="alamat" class="form-control fs-6" rows="2" placeholder="Alamat lengkap tempat tinggal saat ini">{{ old('alamat', $nasabah->alamat) }}</textarea>
                        </div>

                        <div class="form-section-title mt-5">Keamanan Akun</div>
                        
                        <div class="p-4 rounded-lg bg-light border border-dashed mb-4">
                            <p class="text-muted small mb-3"><i class="fas fa-shield-alt mr-1"></i> Biarkan kolom di bawah ini kosong jika Anda tidak ingin mengganti password.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Password Baru</label>
                                        <input type="password" name="password" class="form-control bg-white" placeholder="Minimal 8 karakter">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Konfirmasi Password Baru</label>
                                        <input type="password" name="password_confirmation" class="form-control bg-white" placeholder="Ulangi password baru">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 py-4 px-4 d-flex justify-content-between">
                        <a href="{{ route('dashboard') }}" class="btn btn-light px-4 rounded-pill font-weight-bold text-muted">Batal</a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pill font-weight-bold shadow">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Preview Foto Profil saat dipilih
        $('#fotoInput').on('change', function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatarPreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
                
                // Beri notifikasi toast/small text
                Swal.fire({
                    icon: 'info',
                    title: 'Foto Terpilih',
                    text: 'Jangan lupa klik tombol "Simpan Perubahan" untuk menerapkan foto baru.',
                    timer: 3000,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false
                });
            }
        });
    });
</script>
@endpush