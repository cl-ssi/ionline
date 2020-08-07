@extends('layouts.app')

@section('title', 'IAAPS')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores</h3>
<h6 class="mb-3">Índice de Actividad de la Atención Primaria de Salud</h6>

<ol>
    <li> <a href="{{ route('indicators.iaaps.2019.show','iquique') }}">Iquique.</a> </li>
    <li> <a href="{{ route('indicators.iaaps.2019.show','alto_hospicio') }}">Alto Hospicio.</a> </li>
    <li> <a href="{{ route('indicators.iaaps.2019.show','pozo_almonte') }}">Pozo Almonte.</a> </li>
    <li> <a href="{{ route('indicators.iaaps.2019.show','pica') }}">Pica.</a> </li>
</ol>

@endsection

@section('custom_js')

@endsection
