@extends('layouts.app')

@section('title', 'Indicadores APS ' . $year)

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('indicators.index') }}">Indicadores</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.iaps.index') }}">APS</a></li>
        <li class="breadcrumb-item">{{$year}}</li>
    </ol>
</nav>


<h3 class="mb-3">Indicadores APS {{$year}}.</h3>
@if($iaps->indicators->isEmpty())
    <p>No existen o no se han definido aún indicadores APS para el presente año</p>
@else
    <p>
    <!-- class="btn btn-outline-primary btn-sm"  -->
        {{$iaps->number}}. {{$iaps->name}} 
        <a class="badge badge-primary" href="{{ route('indicators.iaps.show', [$year, $iaps->slug, 'aps']) }}">APS</a> 
        @if($iaps->reyno_active)<a class="badge badge-primary" href="{{ route('indicators.iaps.show', [$year, $iaps->slug, 'reyno']) }}">CGU Dr. Hector Reyno</a> @endif
        @if($iaps->hospital_active)<a class="badge badge-primary" href="{{ route('indicators.iaps.show', [$year, $iaps->slug, 'hospital']) }}">Hospital Dr. Ernesto Torres G.</a> @endif
        @if($iaps->ssi_active)<a class="badge badge-primary" href="{{ route('indicators.iaps.show', [$year, $iaps->slug, 'ssi']) }}">Dirección Servicio de Salud</a> @endif
    </p>
@endif
@endsection

@section('custom_js')

@endsection