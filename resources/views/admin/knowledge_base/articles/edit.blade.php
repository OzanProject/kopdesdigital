@extends('layouts.admin')

@section('title', 'Edit Artikel')

@push('css')
<style>
    .ck-editor__editable_inline {
        min-height: 300px;
    }
</style>
@endpush

@section('content')
<form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Edit Konten</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Judul Artikel</label>
                        <input type="text" name="title" class="form-control" value="{{ $article->title }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Konten</label>
                        <textarea id="editor" name="content" class="form-control" style="height: 300px;">{!! $article->content !!}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Pengaturan</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $article->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Thumbnail (Opsional)</label>
                        @if($article->thumbnail)
                            <div class="mb-2">
                                <img src="{{ Storage::url($article->thumbnail) }}" class="img-fluid rounded" style="max-height: 150px;">
                            </div>
                        @endif
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="thumbnail" id="customFile">
                            <label class="custom-file-label" for="customFile">Ganti file</label>
                        </div>
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    </div>

                    <div class="form-group">
                         <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_published" {{ $article->is_published ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customSwitch1">Publish</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Update Artikel
                    </button>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-default btn-block">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    $(document).ready(function () {
        // CKEditor
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editor.editing.view.change(writer => {
                    writer.setStyle('min-height', '300px', editor.editing.view.document.getRoot());
                });
            })
            .catch(error => {
                console.error(error);
            });

        // Custom File Input name
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });
</script>
@endpush
