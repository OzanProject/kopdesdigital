@extends('layouts.admin')

@section('title', $article->title)

@section('content')
<style>
    .article-header { border-bottom: 1px solid #f1f5f9; padding-bottom: 2rem; margin-bottom: 2rem; }
    .article-title { font-size: 2.5rem; font-weight: 800; color: #1e293b; letter-spacing: -1px; line-height: 1.2; }
    .article-body { font-size: 1.15rem; line-height: 1.8; color: #334155; }
    .article-body img { border-radius: 12px; shadow: 0 4px 12px rgba(0,0,0,0.1); margin: 1.5rem 0; }
    .sidebar-widget { border: none; border-radius: 16px; background-color: #f8fafc; }
    .related-link { border-bottom: 1px solid #e2e8f0; transition: 0.2s; padding: 12px 15px !important; color: #475569 !important; font-weight: 600; }
    .related-link:hover { background: #fff; color: #0d6efd !important; padding-left: 20px !important; }
</style>

<div class="row">
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm rounded-lg overflow-hidden mb-4">
            <div class="card-body p-4 p-md-5">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-transparent p-0 small">
                        <li class="breadcrumb-item"><a href="{{ route('knowledge-base.index') }}">Bantuan</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('knowledge-base.category', $article->category->slug) }}">{{ $article->category->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Panduan</li>
                    </ol>
                </nav>

                <header class="article-header">
                    <h1 class="article-title mb-3">{{ $article->title }}</h1>
                    <div class="d-flex align-items-center text-muted small">
                        <div class="d-flex align-items-center mr-4">
                            <i class="far fa-calendar-alt mr-2"></i> {{ $article->created_at->translatedFormat('d F Y') }}
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="far fa-eye mr-2"></i> Telah dibaca {{ number_format($article->view_count) }} kali
                        </div>
                    </div>
                </header>
                
                @if($article->thumbnail)
                    <div class="mb-5">
                        <img src="{{ Storage::url($article->thumbnail) }}" class="img-fluid rounded-xl shadow-lg" style="width: 100%; max-height: 450px; object-fit: cover; border-radius: 20px;">
                    </div>
                @endif

                <article class="article-body">
                    {!! $article->content !!}
                </article>
                
                <div class="mt-5 pt-5 border-top">
                    <div class="bg-light p-4 rounded-lg d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 font-weight-bold text-dark">Apakah panduan ini membantu?</h6>
                        <div>
                            <button class="btn btn-outline-success btn-sm px-4 rounded-pill mr-2"><i class="far fa-thumbs-up mr-1"></i> Ya</button>
                            <button class="btn btn-outline-danger btn-sm px-4 rounded-pill"><i class="far fa-thumbs-down mr-1"></i> Tidak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card sidebar-widget shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h6 class="font-weight-bold mb-0 text-dark">Panduan Terkait</h6>
            </div>
            <div class="card-body p-2">
                <ul class="nav flex-column mb-3">
                    @forelse($relatedArticles as $related)
                    <li class="nav-item">
                        <a href="{{ route('knowledge-base.show', $related->slug) }}" class="nav-link related-link small">
                            <i class="fas fa-file-alt mr-2 opacity-50"></i> {{ $related->title }}
                        </a>
                    </li>
                    @empty
                    <li class="p-3 text-muted small">Tidak ada artikel terkait.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        
        <div class="card bg-primary-soft border-0 rounded-lg mt-4 shadow-sm" style="background: #eef2ff;">
            <div class="card-body p-4">
                <h6 class="font-weight-bold text-primary mb-2">Masih butuh bantuan?</h6>
                <p class="small text-muted mb-3">Tim dukungan teknis kami siap menjawab pertanyaan Anda secara personal.</p>
                <a href="{{ route('support.create') }}" class="btn btn-primary btn-block btn-sm rounded-pill font-weight-bold">Buka Tiket Support</a>
            </div>
        </div>

        <div class="mt-4 px-2">
            <a href="{{ route('knowledge-base.index') }}" class="btn btn-block btn-light font-weight-bold text-muted rounded-pill shadow-sm border">
                <i class="fas fa-home mr-2"></i> Ke Pusat Bantuan
            </a>
        </div>
    </div>
</div>
@endsection