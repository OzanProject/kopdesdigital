@extends('layouts.admin')

@section('title', 'Pengaturan Umum Koperasi')

@section('content')
<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    @if($koperasi->logo)
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{ asset('storage/' . $koperasi->logo) }}"
                             alt="Logo Koperasi">
                    @else
                        <img class="profile-user-img img-fluid img-circle"
                             src="https://ui-avatars.com/api/?name={{ urlencode($koperasi->nama) }}&background=random"
                             alt="User profile picture">
                    @endif
                </div>

                <h3 class="profile-username text-center">{{ $koperasi->nama }}</h3>
                <p class="text-muted text-center">{{ $koperasi->no_badan_hukum ?? 'Belum ada No. Badan Hukum' }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Status</b> <a class="float-right"><span class="badge badge-success">{{ $koperasi->status }}</span></a>
                    </li>
                    <li class="list-group-item">
                        <b>Paket</b> <a class="float-right">{{ $koperasi->paket_langganan ?? 'Free' }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Profil Koperasi</h3>
            </div>
            <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Koperasi</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $koperasi->nama) }}" required>
                    </div>
                    <div class="form-group">
                        <label>No. Badan Hukum</label>
                        <input type="text" name="no_badan_hukum" class="form-control" value="{{ old('no_badan_hukum', $koperasi->no_badan_hukum) }}" placeholder="Contoh: AHU-00000.AH.01.26.Tahun 2024">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Resmi</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $koperasi->email) }}" placeholder="email@koperasi.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Telepon / WA</label>
                                <input type="text" name="kontak" class="form-control" value="{{ old('kontak', $koperasi->kontak) }}" placeholder="0812xxxx">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Website</label>
                        <input type="url" name="website" class="form-control" value="{{ old('website', $koperasi->website) }}" placeholder="https://koperasiku.com">
                    </div>

                    <div class="form-group">
                         <label>Zona Waktu</label>
                         <select name="timezone" class="form-control" required>
                            <option value="Asia/Jakarta" {{ $koperasi->timezone == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (Asia/Jakarta)</option>
                            <option value="Asia/Makassar" {{ $koperasi->timezone == 'Asia/Makassar' ? 'selected' : '' }}>WITA (Asia/Makassar)</option>
                            <option value="Asia/Jayapura" {{ $koperasi->timezone == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (Asia/Jayapura)</option>
                         </select>
                         <small class="text-muted">Waktu sistem akan mengikuti zona waktu yang dipilih.</small>
                    </div>

                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $koperasi->alamat) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi Singkat</label>
                        <textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi', $koperasi->deskripsi) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Opsi Tenor Pinjaman (Bulan)</label>
                        @php
                            $defaultTenors = [3, 6, 12, 18, 24, 36];
                            $currentTenors = $koperasi->settings['tenor_options'] ?? $defaultTenors;
                            $tenorString = implode(', ', $currentTenors);
                        @endphp
                        <input type="text" name="tenor_options" class="form-control" value="{{ old('tenor_options', $tenorString) }}" placeholder="Contoh: 3, 6, 12, 24">
                        <small class="text-muted">Pisahkan dengan koma. Contoh: 3, 6, 12, 18</small>
                    </div>

                    <div class="form-group">
                        <label>Upload Logo Baru</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="logo" class="custom-file-input" id="logoInput">
                                <label class="custom-file-label" for="logoInput">Pilih file logo (PNG/JPG)</label>
                            </div>
                        </div>
                        <small class="text-muted">Maksimal 2MB.</small>
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
