@extends('layouts.admin')

@section('title', 'Pusat Bantuan')

@section('content')
<style>
    .help-search-wrapper {
        background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
        border-radius: 20px;
        padding: 60px 20px;
        margin-bottom: 40px;
        color: white;
    }
    .search-input-group {
        max-width: 700px;
        margin: 0 auto;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border-radius: 50px;
        overflow: hidden;
        border: 4px solid rgba(255,255,255,0.2);
    }
    .search-input-group .form-control {
        border: none;
        padding: 1.5rem 2rem;
        height: auto;
        font-size: 1.1rem;
    }
    .search-input-group .btn {
        padding: 0 30px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .cat-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
        text-align: center;
        padding: 30px 20px;
        height: 100%;
    }
    .cat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
    }
    .cat-icon-wrapper {
        width: 60px;
        height: 60px;
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin: 0 auto 20px;
    }
    .article-item {
        border: none;
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 20px;
        transition: 0.2s;
    }
    .article-item:hover { background-color: #f8fafc; }
    .article-thumb {
        width: 80px;
        height: 55px;
        object-fit: cover;
        border-radius: 8px;
    }
    .support-card {
        background: #1e293b;
        color: white;
        border-radius: 16px;
        border: none;
    }
</style>

<div class="help-search-wrapper text-center shadow-lg">
    <h1 class="fw-bold mb-3 animate__animated animate__fadeInDown">Halo, ada yang bisa kami bantu?</h1>
    <p class="lead opacity-75 mb-4 animate__animated animate__fadeInUp">Temukan panduan penggunaan, tutorial video, dan jawaban teknis di sini.</p>
    
    <form action="{{ route('knowledge-base.search') }}" method="GET" class="animate__animated animate__zoomIn">
        <div class="input-group search-input-group">
            <input type="text" name="q" class="form-control" placeholder="Tulis kendala Anda di sini (misal: 'cara tarik simpanan')..." required>
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search mr-2"></i> CARI
                </button>
            </div>
        </div>
    </form>
</div>

<div class="row mb-5">
    <div class="col-12 mb-4 d-flex align-items-center">
        <h4 class="font-weight-bold mb-0">Telusuri Berdasarkan Kategori</h4>
        <div class="flex-grow-1 ml-3 bg-light" style="height: 1px;"></div>
    </div>
    
    @forelse($categories as $cat)
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card cat-card shadow-sm border">
            <div class="cat-icon-wrapper">
                <i class="fas fa-folder-open"></i>
            </div>
            <h6 class="font-weight-bold text-dark mb-1">{{ $cat->name }}</h6>
            <p class="text-muted small mb-3">{{ $cat->articles_count }} Artikel Panduan</p>
            <a href="{{ route('knowledge-base.category', $cat->slug) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Lihat Semua</a>
            <a href="{{ route('knowledge-base.category', $cat->slug) }}" class="stretched-link"></a>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="fas fa-layer-group fa-3x text-light mb-3"></i>
        <p class="text-muted">Kategori bantuan belum tersedia.</p>
    </div>
    @endforelse
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 font-weight-bold"><i class="fas fa-newspaper text-primary mr-2"></i> Update Artikel Terbaru</h6>
            </div>
            <div class="card-body p-0">
                @forelse($recentArticles as $article)
                <div class="article-item d-flex align-items-center">
                    <div class="mr-3">
                        @if($article->thumbnail)
                            <img src="{{ Storage::url($article->thumbnail) }}" class="article-thumb shadow-sm border">
                        @else
                            <div class="article-thumb bg-light d-flex align-items-center justify-content-center border">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <a href="{{ route('knowledge-base.show', $article->slug) }}" class="text-dark font-weight-bold d-block mb-1 fs-5 text-decoration-none">
                            {{ $article->title }}
                        </a>
                        <p class="text-muted small mb-0 line-clamp-1">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>
                    </div>
                    <div class="text-right ml-3 d-none d-md-block">
                        <span class="badge badge-light border px-2 py-1"><i class="fas fa-eye mr-1"></i> {{ $article->view_count }}</span>
                    </div>
                </div>
                @empty
                <div class="p-5 text-center text-muted">Belum ada artikel terbaru.</div>
                @endforelse
            </div>
            <div class="card-footer bg-white text-center">
                <a href="#" class="small font-weight-bold text-uppercase">Lihat Semua Dokumentasi</a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card support-card shadow-lg animate__animated animate__fadeInRight">
            <div class="card-body p-4 text-center">
                <div class="bg-primary p-3 rounded-circle d-inline-block mb-4 shadow">
                    <i class="fas fa-headset fa-3x text-white"></i>
                </div>
                <h4 class="font-weight-bold">Masih Bingung?</h4>
                <p class="opacity-75 mb-4">Jika Anda tidak menemukan jawaban yang dicari, tim support kami siap membantu Anda melalui tiket bantuan.</p>
                
                <a href="{{ route('support.create') }}" class="btn btn-primary btn-block btn-lg rounded-pill font-weight-bold shadow-sm py-3">
                    <i class="fas fa-plus-circle mr-1"></i> BUAT TIKET BANTUAN
                </a>
                
                <div class="mt-4 pt-4 border-top border-secondary">
                    <div class="d-flex justify-content-center small opacity-75">
                        <span class="mr-3"><i class="fas fa-clock mr-1"></i> Respon: ~1-2 Jam</span>
                        <span><i class="fas fa-calendar-check mr-1"></i> Senin - Jumat</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm rounded-lg mt-4">
            <div class="card-body">
                <h6 class="font-weight-bold mb-3">Tautan Populer</h6>
                <ul class="list-unstyled mb-0 small">
                    <li class="mb-2"><a href="#" class="text-muted"><i class="fas fa-chevron-right mr-2 fs-xs"></i> Cara Aktivasi Akun</a></li>
                    <li class="mb-2"><a href="#" class="text-muted"><i class="fas fa-chevron-right mr-2 fs-xs"></i> Lupa Password Admin</a></li>
                    <li class="mb-0"><a href="#" class="text-muted"><i class="fas fa-chevron-right mr-2 fs-xs"></i> Panduan Import Data Excel</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection