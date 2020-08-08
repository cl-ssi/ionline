@extends('layouts.app')

@section('title', 'Metas')

@section('content')

@include('indicators.rem.partials.nav')

<h3 class="mb-3">Resumen Estadístico Mensual</h3>
<h6 class="mb-3">Serie BM (USO EXCLUSIVO DE ESTABLECIMIENTOS MUNICIPALES)</h6>

<ol>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_bm', 'b18']) }}">REM-B18. ACTIVIDADES DE APOYO DIAGNOSTICO y TERAPEUTICO.</a></li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_bm', 'b18a']) }}">REM-18A - LIBRO DE PRESTACIONES DE APOYO DIAGNOSTICO y TERAPÉUTICO.</a></li>
</ol>

@endsection

@section('custom_js')

@endsection
