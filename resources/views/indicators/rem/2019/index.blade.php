@extends('layouts.app')

@section('title', 'Metas')

@section('content')

@include('indicators.rem.partials.nav')

<h3 class="mb-3">Resumen Estadístico Mensual</h3>

<ol>
    <li> <a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_a']) }}">Serie A</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_bs']) }}">Serie BS</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_d']) }}">Serie D</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_p']) }}">Serie P</a> </li>
</ol>

@endsection

@section('custom_js')

@endsection
