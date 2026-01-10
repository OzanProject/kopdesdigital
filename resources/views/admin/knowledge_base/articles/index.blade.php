@extends('layouts.admin')

@section('title', 'Artikel Bantuan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Artikel Bantuan</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tulis Artikel Baru
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Thumbnail</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>
                                @if($article->thumbnail)
                                    <img src="{{ Storage::url($article->thumbnail) }}" alt="thumb" style="width: 50px; height: 30px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <span class="text-muted"><i class="fas fa-image"></i></span>
                                @endif
                            </td>
                            <td style="white-space: normal; max-width: 300px;">
                                <strong>{{ $article->title }}</strong><br>
                                <small class="text-muted">/{{ $article->slug }}</small>
                            </td>
                            <td>
                                @if($article->category)
                                    <span class="badge badge-info">{{ $article->category->name }}</span>
                                @else
                                    <span class="badge badge-secondary">Uncategorized</span>
                                @endif
                            </td>
                            <td>
                                @if($article->is_published)
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-warning">Draft</span>
                                @endif
                            </td>
                            <td>{{ $article->view_count }}</td>
                            <td>
                                <a href="{{ route('knowledge-base.show', $article->slug) }}" target="_blank" class="btn btn-sm btn-info" title="Lihat Artikel (Web)">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada artikel.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
