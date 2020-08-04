@extends('layouts.app')

@section('title', 'Indicadores')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores Ley N°19.664</h3>

<ol>
    <li> <a href="{{ route('indicators.19664.2018.servicio') }}">Servicio de Salud.</a> </li>
    <li> <a href="{{ route('indicators.19664.2018.hospital') }}">Hospital Dr. Ernesto Torres G.</a> </li>
    <li> CGU Dr. Héctor Reyno. </li>
</ol>

@endsection

@section('custom_js')

@endsection
