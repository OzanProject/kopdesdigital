@extends('layouts.admin')

@section('title', 'Tambah Testimoni')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Tambah Testimoni Baru</h3>
    </div>
    <form action="{{ route('landing-testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Nama Pengguna</label>
                <input type="text" name="name" class="form-control" required placeholder="Contoh: Budi Santoso">
            </div>
            <div class="form-group">
                <label>Role / Jabatan</label>
                <input type="text" name="role" class="form-control" placeholder="Contoh: Ketua Koperasi Sejahtera">
            </div>
            <div class="form-group">
                <label>Rating (1-5)</label>
                <select name="rating" class="form-control">
                    <option value="5">5 Bintang (Sempurna)</option>
                    <option value="4">4 Bintang (Sangat Baik)</option>
                    <option value="3">3 Bintang (Cukup)</option>
                    <option value="2">2 Bintang (Kurang)</option>
                    <option value="1">1 Bintang (Buruk)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Isi Testimoni</label>
                <textarea name="content" class="form-control" rows="3" required placeholder="Apa kata mereka tentang aplikasi ini?"></textarea>
            </div>
            <div class="form-group">
                <label>Foto Profil (Avatar)</label>
                <input type="file" name="avatar" class="form-control-file">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('landing-testimonials.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
