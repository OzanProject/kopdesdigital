@extends('layouts.landing')

@section('title', 'Fitur Unggulan')

@section('content')
    <!-- Page Header -->
    <div class="bg-primary text-white py-5 mt-5 mb-4">
        <div class="container text-center">
            <h1 class="fw-bold display-5">Fitur & Keunggulan</h1>
            <p class="lead opacity-75">Teknologi modern untuk operasional koperasi yang lebih efisien.</p>
        </div>
    </div>

    @include('landing.sections.features')
    @include('landing.sections.cta')
@endsection
