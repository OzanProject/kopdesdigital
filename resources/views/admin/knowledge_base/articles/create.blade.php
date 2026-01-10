@extends('layouts.admin')

@section('title', 'Tulis Artikel Baru')

@push('css')
<style>
    .ck-editor__editable_inline {
        min-height: 300px;
    }
</style>
@endpush

@section('content')
<form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Konten Artikel</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Judul Artikel</label>
                        <input type="text" name="title" class="form-control" placeholder="Masukan judul artikel..." required>
                    </div>
                    
                    <div class="form-group">
                        <label>Konten</label>
                        <textarea id="editor" name="content" class="form-control" style="height: 300px;"></textarea>
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
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Thumbnail (Opsional)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="thumbnail" id="customFile">
                            <label class="custom-file-label" for="customFile">Pilih file</label>
                        </div>
                        <small class="text-muted">Format: jpg, png. Max: 2MB</small>
                    </div>

                    <div class="form-group">
                         <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_published" checked>
                            <label class="custom-control-label" for="customSwitch1">Publish Sekarang</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Simpan Artikel
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
