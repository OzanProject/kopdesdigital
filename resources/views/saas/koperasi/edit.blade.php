@extends('layouts.admin')

@section('title', 'Edit Koperasi')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Data Koperasi</h3>
    </div>
    <form action="{{ route('koperasi.update', $koperasi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Nama Koperasi <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama', $koperasi->nama) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="no_badan_hukum">No. Badan Hukum</label>
                        <input type="text" name="no_badan_hukum" class="form-control" id="no_badan_hukum" value="{{ old('no_badan_hukum', $koperasi->no_badan_hukum) }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Resmi</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $koperasi->email) }}">
                    </div>
                    <div class="form-group">
                        <label for="kontak">No. Telepon / WA</label>
                        <input type="text" name="kontak" class="form-control" id="kontak" value="{{ old('kontak', $koperasi->kontak) }}">
                    </div>
                    <div class="form-group">
                        <label for="website">Website</label>
                        <input type="url" name="website" class="form-control" id="website" value="{{ old('website', $koperasi->website) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="logo">Logo Koperasi</label>
                        @if($koperasi->logo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $koperasi->logo) }}" alt="Logo" class="img-thumbnail" style="height: 80px;">
                        </div>
                        @endif
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="logo" name="logo">
                            <label class="custom-file-label" for="logo">Ganti logo...</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" id="alamat" rows="3">{{ old('alamat', $koperasi->alamat) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="subscription_package_id">Paket Langganan</label>
                        <select name="subscription_package_id" class="form-control" required>
                            <option value="">-- Pilih Paket --</option>
                            @foreach($packages as $pkg)
                                <option value="{{ $pkg->id }}" {{ old('subscription_package_id', $koperasi->subscription_package_id) == $pkg->id ? 'selected' : '' }}>
                                    {{ $pkg->name }} (Rp {{ number_format($pkg->price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ old('status', $koperasi->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $koperasi->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ old('status', $koperasi->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('koperasi.index') }}" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#logo').on('change', function () {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });
    });
</script>
@endpush
