<style>
    .page-header {
        padding: 100px 0 60px;
        background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
        position: relative;
        overflow: hidden;
        color: white;
    }
    .page-header::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url('https://www.transparenttextures.com/patterns/cubes.png');
        opacity: 0.1;
    }
    .content-card {
        background: white;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
    }
    .content-body h3 {
        color: #0f172a;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .content-body p, .content-body li {
        color: #64748b;
        line-height: 1.8;
    }
</style>

@extends('layouts.landing')
@section('title', 'Fitur Unggulan')

@section('content')
    <div class="page-header text-center">
        <div class="container position-relative" style="z-index: 1;">
            <h1 class="fw-extrabold display-4 mb-3">Fitur & Keunggulan</h1>
            <p class="lead opacity-75 mx-auto" style="max-width: 600px;">Teknologi otomatisasi yang dirancang khusus untuk kebutuhan Koperasi Indonesia.</p>
        </div>
    </div>

    @include('landing.sections.features')
    @include('landing.sections.cta')
@endsection