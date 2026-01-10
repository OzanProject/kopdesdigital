@extends('layouts.admin')

@section('title', 'Hasil Pencarian')

@section('content')
<div class="mb-3">
    <a href="{{ route('knowledge-base.index') }}" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Hasil pencarian untuk: <strong>"{{ $query }}"</strong></h3>
    </div>
    <div class="card-body">
        @if($articles->count() > 0)
            <div class="list-group list-group-flush">
                @foreach($articles as $article)
                <a href="{{ route('knowledge-base.show', $article->slug) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1 text-primary">{{ $article->title }}</h5>
                        <small class="badge badge-info">{{ $article->category->name }}</small>
                    </div>
                    <p class="mb-1 text-muted">{{ Str::limit(strip_tags($article->content), 150) }}</p>
                </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <p class="lead">Maaf, tidak ditemukan artikel yang cocok.</p>
                <a href="{{ route('knowledge-base.index') }}" class="btn btn-primary mt-2">Lihat Semua Kategori</a>
            </div>
        @endif
    </div>
    <div class="card-footer">
        {{ $articles->appends(['q' => $query])->links() }}
    </div>
</div>
@endsection
