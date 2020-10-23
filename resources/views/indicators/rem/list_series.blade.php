@extends('layouts.app')

@section('title', "Resumen Estadistico Mensual {$year}")

@section('content')

@include('indicators.rem.partials.navbar')

<h3 class="mb-3">Resumen Estadístico Mensual {{$year}}</h3>

<ul>
    @foreach($series as $serie)
        <li><a href="{{ route('indicators.rem.index', [$year, $serie]) }}">Serie {{$serie}}</a></li>
    @endforeach
</ul>

@endsection

@section('custom_js')

@endsection
