@extends('layouts.app')

@section('title', 'Metas')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Indicadores</a></li>
    </ol>
</nav>

<h3 class="mb-3">Metas Sanitarias</h3>

<div class="row">

    <div class="col">
        @include('indicators.18834.partials.card')
    </div>

    <div class="col">
        @include('indicators.19664.partials.card')
    </div>

    <div class="col">
        @include('indicators.19813.partials.card')
    </div>
</div>

<hr>

<h3 class="mb-3">Indicadores</h3>

<div class="row">

    <div class="col">
        @include('indicators.comges.partials.card')
    </div>

    <div class="col">
        @include('indicators.program_aps.partials.card')
    </div>

    <div class="col">
        @include('indicators.iaaps.partials.card')
    </div>

    <div class="col">
        @include('indicators.aps.partials.card')
    </div>
</div>

<hr>

<h3 class="mb-3 mt-3">Resumen Estadístico Mensual</h3>

<div class="row">
    <div class="col-3">
        <div class="card">
            <div class="card-header">
                <strong>Serie A</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_a']) }}">2020</a></li>
                <li class="list-group-item"><a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_a']) }}">2019</a></li>
            </ul>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-header">
                <strong>Serie BM</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_bm']) }}">2020</a></li>
                <li class="list-group-item text-muted"><a>2019</a> </li>
            </ul>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-header">
                <strong>Serie BS</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted"><a>2020</a> <span class="badge badge-secondary">No Disponible</span></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_bs']) }}">2019</a> </li>
            </ul>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-header">
                <strong>Serie D</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_d']) }}">2020</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_d']) }}">2019</a></li>
            </ul>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-3">
        <div class="card">
            <div class="card-header">
                <strong>Serie P</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_p']) }}">2020</a> </li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_p']) }}">2019</a> </li>
            </ul>
        </div>
    </div>
</div>
<br>
<a class="btn btn-primary" href="http://intranet.saludiquique.cl/estadistica/index.html" role="button">Años anteriores</a>
<br>
<br>
<br>

@can('Indicators: manager')
<br>
<h4>Acceso para administrador de parametros de indicadores</h4>
<ul>
    <li><a href="{{ route('indicators.single_parameter.index') }}">Parametros</a></li>
    <li><a href="{{ route('indicators.single_parameter.create') }}">Nuevo parametro</a></li>
</ul>
@endcan

@endsection

@section('custom_js')

@endsection
