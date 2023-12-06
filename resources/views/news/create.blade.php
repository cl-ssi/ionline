@extends('layouts.bt5.app')

@section('title', 'Crear Noticia')

@section('content')

@include('news.partials.nav')

<h4 class="mt-3"><i class="far fa-newspaper"></i> Nueva Noticia</h4>

<div class="row mt-4">
    <div class="col">
        @livewire('news.create-news', [
            'newsToEdit'    => '',
            'form'          => 'create'
        ])
    </div>

    <div class="col">
        <h5>Este es un ejemplo de como se publicará tu noticia</h5>
        <img src="{{ asset('images/ejemplo_de_noticia.png') }}"
            class="img-thumbnail mb-3">
    </div>
</div>

@endsection

@section('custom_js')

@endsection