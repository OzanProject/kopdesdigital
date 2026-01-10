@extends('layouts.admin')

@section('title', 'Edit FAQ')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit FAQ</h3>
    </div>
    <form action="{{ route('landing-faqs.update', $landingFaq->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Pertanyaan</label>
                <input type="text" name="question" class="form-control" value="{{ $landingFaq->question }}" required>
            </div>
            <div class="form-group">
                <label>Jawaban</label>
                <textarea name="answer" class="form-control" rows="3" required>{{ $landingFaq->answer }}</textarea>
            </div>
            <div class="form-group">
                <label>Urutan Penampilan</label>
                <input type="number" name="order" class="form-control" value="{{ $landingFaq->order }}">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('landing-faqs.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
