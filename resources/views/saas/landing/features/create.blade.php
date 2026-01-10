@extends('layouts.admin')

@section('title', 'Tambah Fitur Baru')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Tambah Fitur</h3>
    </div>
    <form action="{{ route('landing-features.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Judul Fitur</label>
                <input type="text" name="title" class="form-control" required placeholder="Contoh: Keamanan Terjamin">
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="3" required placeholder="Jelaskan fitur ini..."></textarea>
            </div>
            <div class="form-group">
                <label>Icon Class (FontAwesome)</label>
                <input type="text" name="icon" class="form-control" placeholder="Contoh: fas fa-lock">
                <small><a href="https://fontawesome.com/v5/search" target="_blank">Lihat Referensi Icon</a></small>
            </div>
            <div class="form-group">
                <label>Urutan Penampilan</label>
                <input type="number" name="order" class="form-control" value="0">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('landing-features.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
