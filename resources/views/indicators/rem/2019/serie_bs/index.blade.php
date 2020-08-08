@extends('layouts.app')

@section('title', 'Metas')

@section('content')

@include('indicators.rem.partials.nav')

<h3 class="mb-3">Resumen Estadístico Mensual</h3>
<h6 class="mb-3">Serie A</h6>

<ol>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_bs', 'b']) }}">GLOSA.</a> <span class="badge badge-warning">En Desarrollo</span> </li>
    <li> REM-B17. ACTIVIDADES DE APOYO DIAGNOSTICO y TERAPEUTICO. </li>

</ol>

@endsection

@section('custom_js')

@endsection
