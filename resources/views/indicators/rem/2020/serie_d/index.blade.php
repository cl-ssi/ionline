@extends('layouts.app')

@section('title', 'Metas')

@section('content')

@include('indicators.rem.partials.nav')

<h3 class="mb-3">Resumen Estadístico Mensual</h3>
<h6 class="mb-3">Serie D</h6>

<ol>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_d', 'd15']) }}">REM-D.15 - Programa Nacional de Alimentación Complementaria (PNAC).</a></li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_d', 'd16']) }}">REM-D.16 - Programa de Alimentación Complementaria del Adulto Mayor (PACAM).</a></li>
</ol>

@endsection

@section('custom_js')

@endsection
