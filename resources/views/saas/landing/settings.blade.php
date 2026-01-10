@extends('layouts.admin')

@section('title', 'Landing Page Settings')

@section('content')
<div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="landing-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="hero-tab" data-toggle="pill" href="#hero" role="tab" aria-controls="hero" aria-selected="true">Hero Section</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="seo-tab" data-toggle="pill" href="#seo" role="tab" aria-controls="seo" aria-selected="false">SEO Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="payment-tab" data-toggle="pill" href="#payment" role="tab" aria-controls="payment" aria-selected="false">Payment Gateway</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="smtp-tab" data-toggle="pill" href="#smtp" role="tab" aria-controls="smtp" aria-selected="false">SMTP Email</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <form action="{{ route('landing-settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="tab-content" id="landing-tabContent">
                
                <!-- HERO SECTION -->
                <div class="tab-pane fade show active" id="hero" role="tabpanel" aria-labelledby="hero-tab">
                    <div class="form-group">
                        <label>Judul Utama (Hero Title)</label>
                        <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>Sub Judul (Hero Subtitle)</label>
                        <textarea name="hero_subtitle" class="form-control" rows="3">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Teks Tombol (CTA Text)</label>
                        <input type="text" name="hero_cta_text" class="form-control" value="{{ $settings['hero_cta_text'] ?? 'Mulai Sekarang' }}">
                    </div>
                    <div class="form-group">
                        <label>Link Tombol (CTA URL)</label>
                        <input type="text" name="hero_cta_link" class="form-control" value="{{ $settings['hero_cta_link'] ?? '#' }}">
                    </div>
                    <div class="form-group">
                        <label>Gambar Hero</label>
                        @if(isset($settings['hero_image']))
                            <div class="mb-2"><img src="{{ asset('storage/'.$settings['hero_image']) }}" style="height: 100px;"></div>
                        @endif
                        <input type="file" name="hero_image" class="form-control-file">
                    </div>
                </div>

                <!-- SEO SECTION -->
                <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                    <div class="form-group">
                        <label>Meta Title</label>
                        <input type="text" name="seo_meta_title" class="form-control" value="{{ $settings['seo_meta_title'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea name="seo_meta_description" class="form-control" rows="3">{{ $settings['seo_meta_description'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Meta Keywords (Pishakan dengan koma)</label>
                        <input type="text" name="seo_meta_keywords" class="form-control" value="{{ $settings['seo_meta_keywords'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>OG Image (Thumbnail Social Media)</label>
                        @if(isset($settings['seo_og_image']))
                             <div class="mb-2"><img src="{{ asset('storage/'.$settings['seo_og_image']) }}" style="height: 100px;"></div>
                        @endif
                        <input type="file" name="seo_og_image" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <label>Scripts Header (GTM, GA4, Pixel)</label>
                        <textarea name="seo_head_scripts" class="form-control" rows="5" placeholder="<script>...</script>">{{ $settings['seo_head_scripts'] ?? '' }}</textarea>
                    </div>
                </div>

                <!-- PAYMENT GATEWAY SECTION -->
                <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                    <div class="form-group">
                        <label>Provider</label>
                        <select name="payment_gateway_provider" class="form-control">
                            <option value="midtrans" {{ ($settings['payment_gateway_provider'] ?? '') == 'midtrans' ? 'selected' : '' }}>Midtrans</option>
                            <option value="xendit" {{ ($settings['payment_gateway_provider'] ?? '') == 'xendit' ? 'selected' : '' }}>Xendit</option>
                            <option value="manual" {{ ($settings['payment_gateway_provider'] ?? '') == 'manual' ? 'selected' : '' }}>Transfer Manual</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 border-right">
                            <h5 class="text-warning"><i class="fas fa-hammer"></i> Sandbox Mode (Testing)</h5>
                            <div class="form-group">
                                <label>Sandbox Server Key</label>
                                <input type="text" name="midtrans_server_key_sandbox" class="form-control" value="{{ $settings['midtrans_server_key_sandbox'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Sandbox Client Key</label>
                                <input type="text" name="midtrans_client_key_sandbox" class="form-control" value="{{ $settings['midtrans_client_key_sandbox'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Sandbox Merchant ID</label>
                                <input type="text" name="midtrans_merchant_id_sandbox" class="form-control" value="{{ $settings['midtrans_merchant_id_sandbox'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-success"><i class="fas fa-rocket"></i> Production Mode (Live)</h5>
                            <div class="form-group">
                                <label>Production Server Key</label>
                                <input type="text" name="midtrans_server_key_production" class="form-control" value="{{ $settings['midtrans_server_key_production'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Production Client Key</label>
                                <input type="text" name="midtrans_client_key_production" class="form-control" value="{{ $settings['midtrans_client_key_production'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Production Merchant ID</label>
                                <input type="text" name="midtrans_merchant_id_production" class="form-control" value="{{ $settings['midtrans_merchant_id_production'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="form-check mt-3">
                         <input type="checkbox" class="form-check-input" name="midtrans_is_production" value="1" {{ isset($settings['midtrans_is_production']) && $settings['midtrans_is_production'] ? 'checked' : '' }}>
                        <label class="form-check-label font-weight-bold">Aktifkan Mode Produksi (Live)</label>
                        <small class="d-block text-muted">Jika dicentang, sistem akan menggunakan Kredensial Production. Jika tidak, menggunakan Sandbox.</small>
                    </div>
                </div>

                <!-- SMTP EMAIL SECTION -->
                <div class="tab-pane fade" id="smtp" role="tabpanel" aria-labelledby="smtp-tab">
                    <div class="form-group">
                        <label>Mail Host</label>
                        <input type="text" name="mail_host" class="form-control" value="{{ $settings['mail_host'] ?? '' }}" placeholder="smtp.gmail.com">
                    </div>
                    <div class="form-group">
                        <label>Mail Port</label>
                        <input type="text" name="mail_port" class="form-control" value="{{ $settings['mail_port'] ?? '587' }}" placeholder="587">
                    </div>
                    <div class="form-group">
                        <label>Mail Username</label>
                        <input type="text" name="mail_username" class="form-control" value="{{ $settings['mail_username'] ?? '' }}" placeholder="email@domain.com">
                    </div>
                    <div class="form-group">
                        <label>Mail Password</label>
                        <input type="password" name="mail_password" class="form-control" value="{{ $settings['mail_password'] ?? '' }}" placeholder="Password / App Password">
                    </div>
                    <div class="form-group">
                        <label>Mail Encryption</label>
                        <select name="mail_encryption" class="form-control">
                            <option value="tls" {{ ($settings['mail_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ ($settings['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="" {{ ($settings['mail_encryption'] ?? '') == '' ? 'selected' : '' }}>None</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>From Address</label>
                        <input type="email" name="mail_from_address" class="form-control" value="{{ $settings['mail_from_address'] ?? '' }}" placeholder="noreply@koperasi.com">
                    </div>
                    <div class="form-group">
                        <label>From Name</label>
                        <input type="text" name="mail_from_name" class="form-control" value="{{ $settings['mail_from_name'] ?? '' }}" placeholder="KopDes Digital">
                    </div>
                </div>

            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>
@endsection
