@extends('layouts.landing')

@section('title', 'Harga & Paket')

@section('content')
    <!-- Page Header -->
    <div class="bg-primary text-white py-5 mt-5 mb-4">
        <div class="container text-center">
            <h1 class="fw-bold display-5">Penawaran Harga & Paket</h1>
            <p class="lead opacity-75">Pilih solusi terbaik untuk pertumbuhan Koperasi Anda.</p>
        </div>
    </div>

    @include('landing.sections.pricing')
    @include('landing.sections.faq')
@endsection
