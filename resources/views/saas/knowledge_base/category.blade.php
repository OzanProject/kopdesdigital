@extends('layouts.admin')

@section('title', 'Kategori: ' . $category->name)

@section('content')
<div class="mb-3">
    <a href="{{ route('knowledge-base.index') }}" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Artikel dalam kategori: <strong>{{ $category->name }}</strong></h3>
    </div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            @forelse($articles as $article)
            <a href="{{ route('knowledge-base.show', $article->slug) }}" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 text-primary">{{ $article->title }}</h5>
                    <small>{{ $article->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-1 text-muted">{{ Str::limit(strip_tags($article->content), 150) }}</p>
                <small><i class="fas fa-eye"></i> {{ $article->view_count }} views</small>
            </a>
            @empty
            <div class="text-center py-5 text-muted">
                <p>Belum ada artikel dalam kategori ini.</p>
            </div>
            @endforelse
        </div>
    </div>
    <div class="card-footer">
        {{ $articles->links() }}
    </div>
</div>
@endsection
