@extends('layouts.public')

@section('content')
    <!-- Secciones de la página de inicio -->
    @include('partials.hero')
    
    @include('partials.mision-vision')
    
    @include('partials.como-funciona')
    
    @include('partials.testimonios')
    
    @include('partials.faq')
@endsection
