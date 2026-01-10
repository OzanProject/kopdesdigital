@extends('layouts.admin')

@section('title', 'Edit Fitur')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Fitur</h3>
    </div>
    <form action="{{ route('landing-features.update', $landingFeature->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Judul Fitur</label>
                <input type="text" name="title" class="form-control" value="{{ $landingFeature->title }}" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="3" required>{{ $landingFeature->description }}</textarea>
            </div>
            <div class="form-group">
                <label>Icon Class (FontAwesome)</label>
                <input type="text" name="icon" class="form-control" value="{{ $landingFeature->icon }}">
            </div>
            <div class="form-group">
                <label>Urutan Penampilan</label>
                <input type="number" name="order" class="form-control" value="{{ $landingFeature->order }}">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('landing-features.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
