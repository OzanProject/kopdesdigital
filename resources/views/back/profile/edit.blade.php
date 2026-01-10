@extends('layouts.admin')

@section('title', 'Edit Profil Saya')

@section('content')
<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('adminlte3/dist/img/user2-160x160.jpg') }}"
                         alt="User profile picture" style="width: 100px; height: 100px; object-fit: cover;">
                </div>

                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                <p class="text-muted text-center">{{ $user->roles->pluck('name')->first() ?? 'User' }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Terdaftar</b> <a class="float-right">{{ $user->created_at->format('d M Y') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update Informasi Akun</h3>
            </div>
            @php
                $updateRoute = route('admin.profile.update');
                if (auth()->user()->hasRole('super_admin')) {
                    $updateRoute = route('super.profile.update');
                }
            @endphp
            <form action="{{ $updateRoute }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('adminlte3/dist/img/user2-160x160.jpg') }}"
                             alt="User profile picture" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>

                    <div class="form-group">
                        <label>Foto Profil</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="avatar" name="avatar">
                            <label class="custom-file-label" for="avatar">Pilih file</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <hr class="my-4">
                    <h5 class="text-muted mb-3"><i class="fas fa-lock mr-1"></i> Ganti Password</h5>
                    <div class="alert alert-light">
                        <small><i class="fas fa-info-circle"></i> Biarkan kosong jika tidak ingin mengganti password.</small>
                    </div>

                    <div class="form-group">
                        <label>Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" placeholder="Password lama (wajib jika ganti password)">
                        @error('current_password')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="Password baru">
                                @error('password')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <button type="reset" class="btn btn-default float-right">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        // Update label with filename on selection
        $('#avatar').on('change', function () {
            // Get filename
            var fileName = $(this).val().split('\\').pop();
            // Update label
            $(this).next('.custom-file-label').html(fileName);
            
            // Preview image
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.profile-user-img').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush
