@extends('layouts.bt5.app')

@section('title', 'Plan de Compras')

@section('content')

@include('news.partials.nav')

<div class="row mt-3">
    <div class="col-sm-8 col-12">
        <small><i class="fas fa-calendar-alt"></i> {{ $news->publication_date_at->format('d-m-Y H:i:s') }}</small>
        
        <h2 class="mt-2"><i class="bi bi-newspaper"></i> {{ $news->title }}</h2>

        <h5 class="mt-4">{{ $news->subtitle }}</h5>

        <div class="card">
            <img src="{{ route('news.view_image', $news) }}" class="img-fluid" alt="...">
            <div class="card-body">
                <p class="card-text" style="text-align: justify; white-space: pre-wrap">{{ $news->lead }}</p>
            </div>
        </div>
        
        <div class="mt-4 text-article">
            <p style="text-align: justify; white-space: pre-wrap">{{ $news->body }}</p>
        </div>

    </div>
    
    <div class="col-sm-4 col-12">
        <h5 class="text-center" style="background-color: #006FB3; color: #EEEEEE">
            <i class="far fa-newspaper"></i> Todas las Noticias
        </h5> 
        <ul class="list-group">
            @foreach($allNews as $news)
                <a href="{{ route('news.show',$news) }}" 
                    class="list-group-item list-group-item-action small">
                    <small><i class="fas fa-calendar-alt"></i> {{ $news->publication_date_at->format('d-m-Y H:i:s') }}</small> <br>
                    <b>{{ $news->title }}</b>
                </a>
             @endforeach  
        </ul>
    </div>
</div>

@endsection

@section('custom_js')

<style>
    .text-article {
        color: #000;
    }
    .text-article:first-letter {
        float:left;
        font-weight: bold;
        font-size: 60px;
        font-size: 6rem;
        line-height: 40px;
        line-height: 4rem;
        height:4rem;
        text-transform: uppercase;
    }
</style>

@endsection