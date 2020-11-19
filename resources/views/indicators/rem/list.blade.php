@extends('layouts.app')

@section('title', "Resumen Estadistico Mensual {$year} - Serie {$serie}")

@section('content')

@include('indicators.rem.partials.navbar')

<h3 class="mb-3">Resumen Estadístico Mensual {{$year}}</h3>
<h6 class="mb-3">Serie {{$serie}}</h6>

<ul>
    @foreach($prestaciones as $prestacion)
        @if(!in_array($prestacion->Nserie, $series_not_available[$year]))
            <li><a href="{{ route('indicators.rem.show', [$year, $serie, $prestacion->Nserie]) }}">REM-{{$prestacion->Nserie}} - {{$prestacion->nombre_serie}}</a></li>
        @else
        <li>REM-{{$prestacion->Nserie}} - {{$prestacion->nombre_serie}} <span class="badge badge-secondary">No Disponible</span></li>
        @endif
    @endforeach
</ul>

@endsection

@section('custom_js')

@endsection
