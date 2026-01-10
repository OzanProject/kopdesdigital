@extends('layouts.landing')

@section('title', 'Pusat Bantuan')

@section('content')
    <!-- Page Header -->
    <div class="bg-primary text-white py-5 mt-5 mb-4">
        <div class="container text-center">
            <h1 class="fw-bold display-5">Pusat Bantuan</h1>
            <p class="lead opacity-75">Temukan jawaban untuk pertanyaan yang sering diajukan.</p>
        </div>
    </div>

    @include('landing.sections.faq')
    @include('landing.sections.cta')
@endsection
