@extends('layouts.admin')

@section('title', $article->title)

@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card card-outline card-primary">
            <div class="card-body">
                <h1 class="mb-3">{{ $article->title }}</h1>
                <div class="text-muted mb-4">
                    <i class="fas fa-folder mr-1"></i> {{ $article->category->name }} &nbsp;&nbsp;|&nbsp;&nbsp;
                    <i class="far fa-clock mr-1"></i> {{ $article->created_at->format('d M Y') }} &nbsp;&nbsp;|&nbsp;&nbsp;
                    <i class="fas fa-eye mr-1"></i> {{ $article->view_count }} dilihat
                </div>
                
                @if($article->thumbnail)
                    <div class="text-center mb-4">
                        <img src="{{ Storage::url($article->thumbnail) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px; width: auto; max-width: 100%;">
                    </div>
                @endif

                <div class="article-content" style="font-size: 1.1em; line-height: 1.6;">
                    {!! $article->content !!}
                </div>
            </div>
            <div class="card-footer">
                <p class="text-muted">Apakah artikel ini membantu? Jika tidak, silakan <a href="{{ route('support.create') }}">hubungi support</a>.</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Artikel Terkait</h3>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                    @forelse($relatedArticles as $related)
                    <li class="nav-item">
                        <a href="{{ route('knowledge-base.show', $related->slug) }}" class="nav-link">
                            <i class="far fa-file-alt text-primary"></i> {{ Str::limit($related->title, 30) }}
                        </a>
                    </li>
                    @empty
                    <li class="nav-item">
                        <span class="nav-link text-muted">Tidak ada artikel terkait.</span>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
        
        <div class="mt-3">
            <a href="{{ route('knowledge-base.index') }}" class="btn btn-default btn-block">
                <i class="fas fa-arrow-left"></i> Kembali ke Pusat Bantuan
            </a>
        </div>
    </div>
</div>
@endsection
