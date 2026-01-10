@extends('layouts.admin')

@section('title', 'Tambah FAQ')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Tambah FAQ Baru</h3>
    </div>
    <form action="{{ route('landing-faqs.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Pertanyaan</label>
                <input type="text" name="question" class="form-control" required placeholder="Contoh: Bagaimana cara mendaftar?">
            </div>
            <div class="form-group">
                <label>Jawaban</label>
                <textarea name="answer" class="form-control" rows="3" required placeholder="Jelaskan jawabannya..."></textarea>
            </div>
            <div class="form-group">
                <label>Urutan Penampilan</label>
                <input type="number" name="order" class="form-control" value="0">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('landing-faqs.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
