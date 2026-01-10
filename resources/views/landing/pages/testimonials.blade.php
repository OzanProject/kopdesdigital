@extends('layouts.landing')

@section('title', 'Apa Kata Mereka')

@section('content')
    <!-- Page Header -->
    <div class="bg-primary text-white py-5 mt-5 mb-4">
        <div class="container text-center">
            <h1 class="fw-bold display-5">Kisah Sukses</h1>
            <p class="lead opacity-75">Mereka yang telah mempercayakan operasional koperasinya kepada kami.</p>
        </div>
    </div>

    @include('landing.sections.testimonials')
    @include('landing.sections.cta')
@endsection
