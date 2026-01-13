@extends('layouts.landing')

@section('title', 'Kisah Sukses Pengguna')

@section('content')
<style>
    /* Header Halaman dengan sentuhan premium */
    .page-header-success {
        padding: 140px 0 80px;
        background: radial-gradient(circle at top right, #e0eaff 0%, #ffffff 100%);
        position: relative;
        overflow: hidden;
    }

    .page-header-success::before {
        content: '“';
        position: absolute;
        top: 20px;
        right: 10%;
        font-size: 250px;
        font-family: serif;
        color: rgba(13, 110, 253, 0.03);
        line-height: 1;
        z-index: 0;
    }

    .success-badge {
        display: inline-block;
        padding: 8px 16px;
        background: rgba(13, 110, 253, 0.08);
        color: #0d6efd;
        border-radius: 100px;
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }

    .header-title-modern {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1.5px;
        line-height: 1.1;
    }

    .header-subtitle-modern {
        font-size: 1.15rem;
        color: #64748b;
        max-width: 600px;
        margin: 1.5rem auto 0;
    }

    /* Merapikan transisi antar section */
    .testimonial-page-content {
        background: #ffffff;
        position: relative;
        z-index: 1;
        margin-top: -20px;
    }
</style>

<div class="page-header-success text-center">
    <div class="container position-relative" style="z-index: 1;">
        <div class="success-badge animate__animated animate__fadeInDown">
            Testimoni & Review
        </div>
        <h1 class="header-title-modern animate__animated animate__fadeInUp">
            Kisah Sukses <br><span class="text-primary">Koperasi Indonesia</span>
        </h1>
        <p class="header-subtitle-modern animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
            Dengarkan langsung dari para pengurus koperasi yang telah mentransformasi operasional mereka menjadi lebih transparan, akuntabel, dan efisien.
        </p>
    </div>
</div>

<div class="testimonial-page-content">
    @include('landing.sections.testimonials')
    
    <div class="py-5 bg-light border-top border-bottom">
        <div class="container">
            <p class="text-center small text-muted fw-bold text-uppercase ls-2 mb-4">Telah Digunakan Oleh</p>
            @if($clients->count() > 0)
                <div class="row align-items-center justify-content-center g-5 client-logos">
                    @foreach($clients as $client)
                        <div class="col-4 col-md-3 col-lg-2 text-center">
                            <img src="{{ asset('storage/' . $client->logo) }}" 
                                 alt="{{ $client->nama }}" 
                                 class="img-fluid grayscale-img" 
                                 style="max-height: 50px; opacity: 0.6; transition: all 0.3s;"
                                 data-toggle="tooltip" title="{{ $client->nama }}">
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted small">
                    <em>Bergabunglah dengan ratusan koperasi lainnya.</em>
                </div>
            @endif
        </div>
    </div>

    <style>
        .grayscale-img {
            filter: grayscale(100%);
        }
        .grayscale-img:hover {
            filter: grayscale(0%);
            opacity: 1 !important;
            transform: scale(1.1);
        }
    </style>

    @include('landing.sections.cta')
</div>
@endsection