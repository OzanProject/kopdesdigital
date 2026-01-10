@extends('layouts.admin')

@section('title', 'Pusat Bantuan')

@section('content')
<div class="row justify-content-center">
    <!-- Search Section -->
    <div class="col-md-8 text-center mt-4 mb-5">
        <h2 class="mb-3">Apa yang bisa kami bantu?</h2>
        <form action="{{ route('knowledge-base.search') }}" method="GET">
            <div class="input-group input-group-lg">
                <input type="text" name="q" class="form-control" placeholder="Cari panduan, tutorial, atau pertanyaan..." required>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <!-- Categories Grid -->
    <div class="col-12 mb-3">
        <h4>Kategori Bantuan</h4>
    </div>
    @forelse($categories as $cat)
    <div class="col-md-4 col-sm-6 col-12">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-info"><i class="fas fa-book"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ $cat->name }}</span>
                <span class="info-box-number">{{ $cat->articles_count }} Artikel</span>
                <a href="{{ route('knowledge-base.category', $cat->slug) }}" class="stretched-link"></a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <p class="text-muted">Belum ada kategori bantuan.</p>
    </div>
    @endforelse
</div>

<div class="row mt-4">
    <!-- Recent Articles -->
    <div class="col-md-8">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Artikel Terbaru</h3>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    @forelse($recentArticles as $article)
                    <li class="item">
                        <div class="product-img">
                            @if($article->thumbnail)
                                <img src="{{ Storage::url($article->thumbnail) }}" alt="Product Image" class="img-size-50">
                            @else
                                <img src="https://via.placeholder.com/150" alt="Default" class="img-size-50">
                            @endif
                        </div>
                        <div class="product-info">
                            <a href="{{ route('knowledge-base.show', $article->slug) }}" class="product-title">{{ $article->title }}
                                <span class="badge badge-warning float-right">{{ $article->view_count }} Views</span>
                            </a>
                            <span class="product-description">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </span>
                        </div>
                    </li>
                    @empty
                    <li class="item">
                        <div class="p-3 text-center text-muted">Belum ada artikel terbaru.</div>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Contact Support -->
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-header text-muted border-bottom-0">
                Butuh bantuan lebih lanjut?
            </div>
            <div class="card-body pt-0">
                <h2 class="lead"><b>Tim Support</b></h2>
                <p class="text-muted text-sm">Jika tidak menemukan jawaban di panduan, silakan buat tiket bantuan.</p>
                <div class="text-center mt-3">
                    <a href="{{ route('support.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-ticket-alt"></i> Buat Tiket Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
