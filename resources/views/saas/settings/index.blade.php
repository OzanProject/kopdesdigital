@extends('layouts.admin')

@section('title', 'Global Settings')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Pengaturan Aplikasi (SaaS)</h3>
    </div>
    <form action="{{ route('saas-settings.update', 'update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="app_name">Nama Aplikasi / Brand</label>
                <input type="text" name="app_name" class="form-control" id="app_name" value="{{ $settings['app_name'] ?? 'SaaS Super Admin' }}" required>
                <small class="text-muted">Nama ini akan muncul di Title Bar Browser dan Halaman Login.</small>
            </div>

            <div class="form-group">
                <label for="app_version">Versi Aplikasi</label>
                <input type="text" name="app_version" class="form-control" id="app_version" value="{{ $settings['app_version'] ?? '1.0.0' }}" placeholder="1.0.0">
            </div>

            <div class="form-group">
                 <label for="app_timezone">Zona Waktu Sistem (Super Admin)</label>
                 <select name="app_timezone" class="form-control" id="app_timezone">
                    <option value="Asia/Jakarta" {{ ($settings['app_timezone'] ?? 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (Asia/Jakarta)</option>
                    <option value="Asia/Makassar" {{ ($settings['app_timezone'] ?? '') == 'Asia/Makassar' ? 'selected' : '' }}>WITA (Asia/Makassar)</option>
                    <option value="Asia/Jayapura" {{ ($settings['app_timezone'] ?? '') == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (Asia/Jayapura)</option>
                 </select>
                 <small class="text-muted">Zona waktu ini berlaku untuk halaman Super Admin.</small>
            </div>

            <div class="form-group">
                <label for="app_logo">Logo Aplikasi</label>
                @if(isset($settings['app_logo']))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $settings['app_logo']) }}" alt="App Logo" style="max-height: 100px;">
                    </div>
                @endif
                <input type="file" name="app_logo" class="form-control-file" id="app_logo" accept="image/*">
                <small class="text-muted">Upload logo untuk mengganti logo default AdminLTE. (Format: PNG/JPG)</small>
            </div>
            
            <div class="form-group">
                <label for="footer_text">Teks Footer</label>
                <input type="text" name="footer_text" class="form-control" id="footer_text" value="{{ $settings['footer_text'] ?? 'Copyright &copy; 2026 Koperasi SaaS. All rights reserved.' }}">
            </div>

            <hr>
            <h5>Informasi Kontak (Untuk Footer)</h5>
            <div class="form-group">
                <label for="company_email">Email Support</label>
                <input type="email" name="company_email" class="form-control" id="company_email" value="{{ $settings['company_email'] ?? 'support@kopdes.id' }}">
            </div>
            <div class="form-group">
                <label for="company_phone">Nomor Telepon / WhatsApp</label>
                <input type="text" name="company_phone" class="form-control" id="company_phone" value="{{ $settings['company_phone'] ?? '+62 812-3456-7890' }}">
            </div>
             <div class="form-group">
                <label for="company_address">Alamat Kantor (Opsional)</label>
                <textarea name="company_address" class="form-control" id="company_address" rows="2">{{ $settings['company_address'] ?? '' }}</textarea>
            </div>
            
            <!-- Future settings like maintenance mode can go here -->
             <div class="form-group">
                <label for="company_address">Alamat Kantor (Opsional)</label>
                <textarea name="company_address" class="form-control" id="company_address" rows="2">{{ $settings['company_address'] ?? '' }}</textarea>
            </div>

            <hr>
            <h4 class="mt-4 mb-3">Halaman Legal (AdSense Compliance)</h4>
            
            <div class="form-group">
                <label for="privacy_content">Konten Kebijakan Privasi</label>
                <textarea name="privacy_content" class="form-control summernote" id="privacy_content">{{ $settings['privacy_content'] ?? '<h5>1. Pendahuluan</h5><p>Kami sangat menghargai privasi Anda...</p>' }}</textarea>
            </div>

            <div class="form-group">
                <label for="terms_content">Konten Syarat & Ketentuan</label>
                <textarea name="terms_content" class="form-control summernote" id="terms_content">{{ $settings['terms_content'] ?? '<h5>1. Persetujuan Layanan</h5><p>Dengan mengakses layanan kami...</p>' }}</textarea>
            </div>
            
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
        </div>
    </form>
</div>
@endsection

@push('css')
<!-- Summernote -->
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/summernote/summernote-bs4.min.css') }}">
@endpush

@push('js')
<!-- Summernote -->
<script src="{{ asset('adminlte3/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function () {
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        })
    })
</script>
@endpush
