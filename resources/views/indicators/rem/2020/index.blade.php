@extends('layouts.app')

@section('title', 'Metas')

@section('content')

@include('indicators.rem.partials.nav')

<h3 class="mb-3">Resumen Estadístico Mensual</h3>

<ol>
    <li> <a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_a']) }}">Serie A</a></li>
    <li> <a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_bm']) }}">Serie BM</a></li>
    <li> <a >Serie BS</a> <span class="badge badge-secondary">No Disponible</span></li>
    <li> <a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_d']) }}">Serie D</a></li>
    <li> <a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_p']) }}">Serie P</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_f', 'covid']) }}">Serie F</a> </li>
</ol>

@endsection

@section('custom_js')

@endsection
