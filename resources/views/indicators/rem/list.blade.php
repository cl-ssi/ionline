@extends('layouts.bt4.app')

@section('title', "Resumen Estadistico Mensual {$year} - Serie {$serie}")

@section('content')

@include('indicators.rem.partials.navbar')

<h3 class="mb-3">Resumen Estadístico Mensual {{$year}}</h3>
<h6 class="mb-3">Serie {{$serie}}</h6>

<ul>
    @foreach($Nseries as $nserie)
        @if($nserie->active)
            @if($nserie->otherSections)
            <li>REM-{{$nserie->Nserie}} - {{$nserie->nombre_serie}}
                <ul>
                    <li><a href="{{ route('indicators.rem.show', [$year, $serie, $nserie->Nserie, 'A']) }}">SECCION A</a></li>
                    <li><a href="{{ route('indicators.rem.show', [$year, $serie, $nserie->Nserie]) }}">SECCION {{implode(', ', $nserie->otherSections)}}</a></li>
                </ul>
            </li>
            @else
            <li><a href="{{ route('indicators.rem.show', [$year, $serie, $nserie->Nserie]) }}">REM-{{$nserie->Nserie}} - {{$nserie->nombre_serie}}</a></li>
            @endif
        @else
            <li>REM-{{$nserie->Nserie}} - {{$nserie->nombre_serie}} <span class="badge badge-secondary">No Disponible</span></li>
        @endif
    @endforeach
</ul>

@endsection

@section('custom_js')

@endsection
