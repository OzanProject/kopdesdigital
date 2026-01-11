@extends('layouts.admin')

@section('title', 'Hasil Pencarian')

@section('content')
<div class="mb-4">
    <a href="{{ route('knowledge-base.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm border text-muted">
        <i class="fas fa-chevron-left mr-2"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm rounded-lg overflow-hidden">
    <div class="card-header bg-light py-4">
        <h5 class="mb-0">Hasil pencarian untuk: <span class="text-primary font-weight-bold">"{{ $query }}"</span></h5>
    </div>
    <div class="card-body p-0">
        @if($articles->count() > 0)
            <div class="list-group list-group-flush">
                @foreach($articles as $article)
                <a href="{{ route('knowledge-base.show', $article->slug) }}" class="list-group-item list-group-item-action py-4 px-4 border-bottom">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-primary-soft mr-3 px-2 py-1" style="background: rgba(13,110,253,0.1); color: #0d6efd; font-size: 0.7rem;">
                            {{ strtoupper($article->category->name) }}
                        </span>
                        <h5 class="font-weight-bold text-dark mb-0">{{ $article->title }}</h5>
                    </div>
                    <p class="text-muted mb-0 small">{{ Str::limit(strip_tags($article->content), 200) }}</p>
                </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                    <i class="fas fa-search-minus fa-3x text-muted opacity-50"></i>
                </div>
                <h4 class="font-weight-bold">Pencarian Tidak Ditemukan</h4>
                <p class="text-muted mx-auto" style="max-width: 400px;">Kami tidak menemukan hasil untuk kata kunci tersebut. Coba gunakan kata kunci yang lebih umum atau hubungi tim support.</p>
                <a href="{{ route('knowledge-base.index') }}" class="btn btn-primary rounded-pill px-4 mt-3 shadow">Jelajahi Kategori</a>
            </div>
        @endif
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $articles->appends(['q' => $query])->links() }}
    </div>
</div>
@endsection