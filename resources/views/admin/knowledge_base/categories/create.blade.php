@extends('layouts.admin')

@section('title', 'Tambah Kategori Bantuan')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Kategori Baru</h3>
            </div>
            <form action="{{ route('admin.article-categories.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Panduan Mengelola Simpanan" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.article-categories.index') }}" class="btn btn-default float-right">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
