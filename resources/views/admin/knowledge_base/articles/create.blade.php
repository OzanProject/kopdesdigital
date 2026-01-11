@extends('layouts.admin')

@section('title', isset($article) ? 'Edit Artikel' : 'Tulis Artikel Baru')

@push('css')
<style>
    .ck-editor__editable_inline { min-height: 450px; border-bottom-left-radius: 12px !important; border-bottom-right-radius: 12px !important; }
    .card-settings { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .thumbnail-upload-box { 
        border: 2px dashed #e2e8f0; border-radius: 12px; padding: 15px; text-align: center; background: #f8fafc; cursor: pointer; transition: 0.3s;
    }
    .thumbnail-upload-box:hover { border-color: #0d6efd; background: #f1f5f9; }
</style>
@endpush

@section('content')
<form action="{{ isset($article) ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($article)) @method('PUT') @endif
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-lg overflow-hidden mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 font-weight-bold text-primary"><i class="fas fa-edit mr-2"></i> Editor Konten</h6>
                </div>
                <div class="card-body p-4">
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold">Judul Artikel</label>
                        <input type="text" name="title" class="form-control form-control-lg fs-5 font-weight-bold border-0 bg-light rounded-lg" 
                               value="{{ old('title', $article->title ?? '') }}" placeholder="Masukan judul yang menarik..." required>
                    </div>
                    
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Isi Panduan</label>
                        <textarea id="editor" name="content" class="form-control">{{ old('content', $article->content ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-settings mb-4">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="font-weight-bold mb-0">Publikasi</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="small font-weight-bold">Kategori Artikel</label>
                        <select name="category_id" class="form-control select2" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (old('category_id', $article->category_id ?? '') == $cat->id) ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group py-2 border-top border-bottom my-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="isPublished" name="is_published" 
                                   {{ old('is_published', $article->is_published ?? true) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold text-dark" for="isPublished">Tampilkan ke Publik</label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block font-weight-bold py-2 rounded-pill shadow">
                        <i class="fas fa-save mr-1"></i> {{ isset($article) ? 'Update Artikel' : 'Simpan & Publish' }}
                    </button>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-light btn-block btn-sm mt-2 text-muted">Batal</a>
                </div>
            </div>

            <div class="card card-settings">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="font-weight-bold mb-0">Gambar Cover (Thumbnail)</h6>
                </div>
                <div class="card-body">
                    @if(isset($article) && $article->thumbnail)
                        <div class="mb-3">
                            <img src="{{ Storage::url($article->thumbnail) }}" id="previewImage" class="img-fluid rounded border shadow-sm w-100" style="max-height: 200px; object-fit: cover;">
                        </div>
                    @else
                        <div class="mb-3" id="previewContainer" style="display: none;">
                            <img src="#" id="previewImage" class="img-fluid rounded border shadow-sm w-100" style="max-height: 200px; object-fit: cover;">
                        </div>
                    @endif

                    <div class="thumbnail-upload-box" onclick="document.getElementById('customFile').click();">
                        <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                        <div class="small font-weight-bold text-muted">Klik untuk upload gambar</div>
                        <input type="file" name="thumbnail" id="customFile" style="display: none;" accept="image/*">
                    </div>
                    <small class="text-muted d-block mt-2 text-center italic">Rekomendasi: 1200x630px (Max 2MB)</small>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    $(document).ready(function () {
        // CKEditor Setup
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => console.error(error));

        // Thumbnail Preview Logic
        $("#customFile").on("change", function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewContainer').show();
                    $('#previewImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush