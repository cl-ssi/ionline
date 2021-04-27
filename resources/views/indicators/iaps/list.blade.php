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
@if($iaps->isEmpty())
    <p>No existen o no se han definido aún indicadores APS para el presente año</p>
@else
    @foreach($iaps as $item)
        {{$item->number}}. {{$item->name}} 
        <ol>
            <li>  <a href="{{ route('indicators.iaps.show', [$year, $item->slug, 'aps']) }}">APS</a> </li>
            @if($item->reyno_active)<li><a href="{{ route('indicators.iaps.show', [$year, $item->slug, 'reyno']) }}">CGU Dr. Hector Reyno</a></li>  @endif
            @if($item->hospital_active)<li><a href="{{ route('indicators.iaps.show', [$year, $item->slug, 'hospital']) }}">Hospital Dr. Ernesto Torres G.</a></li> @endif
            @if($item->ssi_active)<li><a href="{{ route('indicators.iaps.show', [$year, $item->slug, 'ssi']) }}">Dirección Servicio de Salud</a> @endif
        </ol>
      
       
    
    @endforeach
@endif
@endsection

@section('custom_js')

@endsection