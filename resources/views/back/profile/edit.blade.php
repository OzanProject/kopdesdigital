@extends('layouts.admin')

@section('title', 'Pengaturan Profil')

@section('content')
<style>
    .profile-card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .avatar-upload-wrapper {
        position: relative;
        display: inline-block;
    }
    .avatar-preview {
        width: 120px;
        height: 120px;
        border: 4px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        object-fit: cover;
        border-radius: 50%;
    }
    .btn-upload-overlay {
        position: absolute;
        bottom: 0;
        right: 0;
        background: #0d6efd;
        color: white;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 3px solid #fff;
        transition: 0.3s;
    }
    .btn-upload-overlay:hover { background: #0052d4; transform: scale(1.1); }
    .nav-pills-custom .nav-link {
        border-radius: 10px;
        font-weight: 600;
        color: #64748b;
        padding: 12px 20px;
        transition: 0.3s;
    }
    .nav-pills-custom .nav-link.active {
        background: #0d6efd;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-xl-3">
            <div class="card profile-card-modern shadow-sm mb-4">
                <div class="card-body text-center py-5">
                    <div class="avatar-upload-wrapper mb-3">
                        <img class="avatar-preview profile-user-img-main"
                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('adminlte3/dist/img/user2-160x160.jpg') }}"
                             alt="User profile">
                    </div>
                    
                    <h5 class="font-weight-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small text-uppercase font-weight-bold ls-1">{{ $user->roles->pluck('name')->first() ?? 'Pengguna' }}</p>
                    
                    <div class="mt-4 pt-4 border-top">
                        <div class="text-left small mb-2">
                            <span class="text-muted d-block">Alamat Email</span>
                            <span class="font-weight-bold">{{ $user->email }}</span>
                        </div>
                        <div class="text-left small">
                            <span class="text-muted d-block">Terdaftar Sejak</span>
                            <span class="font-weight-bold">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-xl-9">
            <div class="card profile-card-modern">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="font-weight-bold mb-0">Informasi Akun</h5>
                    <p class="text-muted small">Perbarui detail profil dan kredensial keamanan Anda</p>
                </div>
                
                @php
                    $updateRoute = auth()->user()->hasRole('super_admin') ? route('super.profile.update') : route('admin.profile.update');
                @endphp

                <form action="{{ $updateRoute }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body px-4">
                        <input type="file" name="avatar" id="avatarInput" style="display: none;" accept="image/*">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control form-control-lg fs-6" value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Alamat Email</label>
                                    <input type="email" name="email" class="form-control form-control-lg fs-6" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-light rounded-lg mt-4 mb-4">
                            <h6 class="font-weight-bold mb-3"><i class="fas fa-shield-alt text-primary mr-2"></i> Keamanan Akun</h6>
                            <p class="text-muted small">Kosongkan kolom di bawah ini jika Anda tidak ingin mengubah password.</p>
                            
                            <div class="form-group">
                                <label class="small font-weight-bold">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Masukkan password lama untuk verifikasi">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Password Baru</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Konfirmasi Password Baru</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 pb-4 px-4 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold rounded-pill">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                        <button type="button" class="btn btn-outline-primary px-4 py-2 font-weight-bold rounded-pill" onclick="document.getElementById('avatarInput').click();">
                            <i class="fas fa-camera mr-2"></i> Ubah Foto
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
    $(document).ready(function () {
        // Trigger klik input file saat klik tombol atau overlay (opsional tambahan)
        $('#avatarInput').on('change', function () {
            var fileName = $(this).val().split('\\').pop();
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.profile-user-img-main').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush