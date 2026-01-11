@extends('layouts.admin')

@section('title', 'Kategori: ' . $category->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('knowledge-base.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm border">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Pusat Bantuan
    </a>
</div>

<div class="card border-0 shadow-sm rounded-lg overflow-hidden">
    <div class="card-header bg-white py-4 border-bottom">
        <div class="d-flex align-items-center">
            <div class="bg-primary-soft p-3 rounded mr-3" style="background: rgba(13,110,253,0.1); color: #0d6efd;">
                <i class="fas fa-folder-open fa-2x"></i>
            </div>
            <div>
                <h4 class="font-weight-bold mb-0">Topik: {{ $category->name }}</h4>
                <p class="text-muted small mb-0">Menampilkan {{ $articles->count() }} panduan dalam kategori ini</p>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            @forelse($articles as $article)
            <a href="{{ route('knowledge-base.show', $article->slug) }}" class="list-group-item list-group-item-action py-4 px-4 border-bottom transition-hover">
                <div class="d-flex w-100 justify-content-between align-items-start mb-2">
                    <h5 class="font-weight-bold text-dark mb-0">{{ $article->title }}</h5>
                    <span class="badge badge-light border rounded-pill px-3 py-1">{{ $article->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-muted mb-3" style="line-height: 1.6;">{{ Str::limit(strip_tags($article->content), 180) }}</p>
                <div class="d-flex align-items-center small text-muted">
                    <span class="mr-3"><i class="far fa-eye mr-1"></i> {{ number_format($article->view_count) }} Pembaca</span>
                    <span><i class="far fa-clock mr-1"></i> Estimasi baca: 3 Menit</span>
                </div>
            </a>
            @empty
            <div class="text-center py-5 text-muted">
                <i class="fas fa-ghost fa-3x mb-3 opacity-25"></i>
                <p class="lead">Belum ada artikel dalam kategori ini.</p>
            </div>
            @endforelse
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $articles->links() }}
    </div>
</div>
@endsection