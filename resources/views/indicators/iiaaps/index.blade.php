@extends('layouts.app')

@section('title', 'Indicadores APS')

@section('content')

@include('indicators.partials.nav')

<div class="col-5">
    <div class="card">
        <div class="card-header">
            <strong>Índice de Actividad de la Atención Primaria de Salud</strong>
        </div>

        <ul class="list-group list-group-flush">
        @foreach(range(now()->year, 2021) as $year)
            <li class="list-group-item">
                <a href="{{ route('indicators.iiaaps.list', $year) }}">{{$year}}</a>
            </li>
        @endforeach
            <li class="list-group-item">
                <a href="{{ route('indicators.iaaps.2019.index') }}">2019</a>
            </li>
        </ul>

    </div>
</div>

@endsection

@section('custom_js')

@endsection