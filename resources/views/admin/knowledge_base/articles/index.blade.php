@extends('layouts.admin')

@section('title', 'Artikel Bantuan')

@section('content')
<style>
    .table-modern thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        border-top: none;
    }
    .thumb-preview {
        width: 60px;
        height: 40px;
        object-fit: cover;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .badge-published { background-color: #dcfce7; color: #15803d; }
    .badge-draft { background-color: #f1f5f9; color: #475569; }
</style>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 font-weight-bold">Artikel Edukasi & Bantuan</h5>
                <p class="text-muted small mb-0">Kelola panduan penggunaan sistem untuk koperasi</p>
            </div>
            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-sm font-weight-bold px-3 rounded-pill shadow-sm">
                    <i class="fas fa-plus mr-1"></i> Tulis Artikel Baru
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover m-0">
                <thead>
                    <tr>
                        <th class="px-4" style="width: 80px;">Media</th>
                        <th>Konten Artikel</th>
                        <th>Kategori</th>
                        <th class="text-center">Status</th>
                        <th class="text-center"><i class="fas fa-eye"></i></th>
                        <th class="text-right px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                    <tr>
                        <td class="align-middle px-4">
                            @if($article->thumbnail)
                                <img src="{{ Storage::url($article->thumbnail) }}" class="thumb-preview border">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center thumb-preview border">
                                    <i class="fas fa-image text-muted small"></i>
                                </div>
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold text-dark mb-0">{{ Str::limit($article->title, 60) }}</div>
                            <small class="text-muted text-monospace" style="font-size: 0.7rem;">/{{ $article->slug }}</small>
                        </td>
                        <td class="align-middle">
                            @if($article->category)
                                <span class="badge badge-light border px-2 py-1">{{ $article->category->name }}</span>
                            @else
                                <span class="text-muted small">Tanpa Kategori</span>
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            @if($article->is_published)
                                <span class="badge badge-published px-2 py-1 rounded-pill small">PUBLISHED</span>
                            @else
                                <span class="badge badge-draft px-2 py-1 rounded-pill small">DRAFT</span>
                            @endif
                        </td>
                        <td class="align-middle text-center font-weight-bold text-muted small">
                            {{ number_format($article->view_count) }}
                        </td>
                        <td class="align-middle text-right px-4">
                            <div class="btn-group shadow-sm rounded-lg overflow-hidden border">
                                <a href="{{ route('knowledge-base.show', $article->slug) }}" target="_blank" class="btn btn-white btn-sm text-info" title="Pratinjau">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-white btn-sm text-warning" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus artikel ini selamanya?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-white btn-sm text-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-book-open fa-3x mb-3 opacity-25"></i>
                            <p>Belum ada artikel bantuan yang ditulis.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection