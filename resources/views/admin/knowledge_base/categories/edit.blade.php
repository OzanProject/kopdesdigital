@extends('layouts.admin')

@section('title', 'Edit Kategori Bantuan')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Kategori</h3>
            </div>
            <form action="{{ route('admin.article-categories.update', $article_category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="name" class="form-control" value="{{ $article_category->name }}" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.article-categories.index') }}" class="btn btn-default float-right">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
