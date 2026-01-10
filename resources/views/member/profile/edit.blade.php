@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('content')
<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ $nasabah->foto ? asset('storage/' . $nasabah->foto) : asset('img/default-user.png') }}"
                        alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                <p class="text-muted text-center">{{ $nasabah->no_anggota }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Status</b> <a class="float-right badge badge-success">{{ ucfirst($nasabah->status) }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Bergabung</b> <a class="float-right">{{ $nasabah->tanggal_bergabung->format('d M Y') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Pengaturan Profil</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="settings">
                        <form class="form-horizontal" method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $nasabah->nama) }}" placeholder="Nama">
                                    @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                                    <small class="text-muted">Email tidak dapat diubah (hubungi admin).</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telepon" class="col-sm-2 col-form-label">No. Telepon</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon', $nasabah->telepon) }}" placeholder="Telepon">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pekerjaan" class="col-sm-2 col-form-label">Pekerjaan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $nasabah->pekerjaan) }}" placeholder="Pekerjaan">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat">{{ old('alamat', $nasabah->alamat) }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="foto" class="col-sm-2 col-form-label">Foto Profil</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto" name="foto">
                                            <label class="custom-file-label" for="foto">Pilih file (jika ingin ganti)</label>
                                        </div>
                                    </div>
                                    <small class="text-muted">Format: JPG, PNG. Maks: 2MB.</small>
                                </div>
                            </div>

                            <hr>
                            <h5 class="text-primary mb-3"><i class="fas fa-lock mr-1"></i> Keamanan (Ganti Password)</h5>
                            
                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">Password Baru</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password_confirmation" class="col-sm-2 col-form-label">Konfirmasi</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
@endsection

@push('js')
<script>
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush
