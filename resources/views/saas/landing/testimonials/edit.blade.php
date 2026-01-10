@extends('layouts.admin')

@section('title', 'Edit Testimoni')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Testimoni</h3>
    </div>
    <form action="{{ route('landing-testimonials.update', $landingTestimonial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
             <div class="form-group">
                <label>Nama Pengguna</label>
                <input type="text" name="name" class="form-control" value="{{ $landingTestimonial->name }}" required>
            </div>
            <div class="form-group">
                <label>Role / Jabatan</label>
                <input type="text" name="role" class="form-control" value="{{ $landingTestimonial->role }}">
            </div>
            <div class="form-group">
                <label>Rating (1-5)</label>
                <select name="rating" class="form-control">
                    <option value="5" {{ $landingTestimonial->rating == 5 ? 'selected' : '' }}>5 Bintang (Sempurna)</option>
                    <option value="4" {{ $landingTestimonial->rating == 4 ? 'selected' : '' }}>4 Bintang (Sangat Baik)</option>
                    <option value="3" {{ $landingTestimonial->rating == 3 ? 'selected' : '' }}>3 Bintang (Cukup)</option>
                    <option value="2" {{ $landingTestimonial->rating == 2 ? 'selected' : '' }}>2 Bintang (Kurang)</option>
                    <option value="1" {{ $landingTestimonial->rating == 1 ? 'selected' : '' }}>1 Bintang (Buruk)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Isi Testimoni</label>
                <textarea name="content" class="form-control" rows="3" required>{{ $landingTestimonial->content }}</textarea>
            </div>
            <div class="form-group">
                <label>Foto Profil (Avatar)</label>
                @if($landingTestimonial->avatar)
                    <div class="mb-2"><img src="{{ asset('storage/' . $landingTestimonial->avatar) }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;"></div>
                @endif
                <input type="file" name="avatar" class="form-control-file">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('landing-testimonials.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
