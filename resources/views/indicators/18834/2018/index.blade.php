@extends('layouts.app')

@section('title', 'Ley N° 18.834')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores</h3>
<h6 class="mb-3">Metas Sanitarias Ley N° 18.834</h6>

<ol>
    <li> <a href="{{ route('indicators.18834.2018.servicio') }}">Servicio de Salud.</a> </li>
    <li> <a href="{{ route('indicators.18834.2018.hospital') }}">Hospital Dr. Ernesto Torres G.</a> </li>
    <li> <a href="{{ route('indicators.18834.2018.reyno') }}">CGU Dr. Héctor Reyno.</a> </li>
</ol>

@endsection

@section('custom_js')

@endsection
