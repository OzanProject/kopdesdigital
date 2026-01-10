@extends('layouts.landing')

@section('content')
    
    @include('landing.sections.hero')

    @include('landing.sections.features')

    @include('landing.sections.pricing')

    @include('landing.sections.testimonials')

    @include('landing.sections.faq')
    
    @include('landing.sections.cta')

@endsection
