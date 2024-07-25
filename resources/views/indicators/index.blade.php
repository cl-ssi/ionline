@extends('layouts.bt4.app')

@section('title', 'Metas')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Indicadores</a></li>
    </ol>
</nav>

<!-- <div class="alert alert-warning" role="alert">
    Se publica datos REM serie A de meses de Enero y Febrero 2023, ésta contiene datos preliminares con información enviada por los establecimientos, previo al nuevo cambio de serie con la cual deberán tributar a partir del mes de Abril.
</div> -->

<h3 class="mb-3">Metas Sanitarias</h3>

<!-- <div class="alert alert-warning" role="alert">
    Indicadores "<strong>En Revisión</strong>", pendientes de verificación por parte de referentes.
</div> -->

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
    <div class="col-sm-4">
        @include('indicators.program_aps.partials.card')
    </div>
    
    <div class="col-sm-4">
        @include('indicators.iaaps.partials.card')
    </div>
    
    <div class="col-sm-4">
        @include('indicators.aps.partials.card')
    </div>
    @auth
    <div class="col-sm-4 mt-3">
        @include('indicators.comges.partials.card')
    </div>
    @endauth
</div>

<hr>

<h3 class="mb-3 mt-3">Resumen Estadístico Mensual</h3>

<div class="row">
    <div class="col mb-3">
        <div class="card">
            <div class="card-header">
                <strong>Serie A</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2024, 'A']) }}">2024 <span class="badge badge-pill badge-secondary">En Revisión</span></a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2023, 'A']) }}">2023</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2022, 'A']) }}">2022</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2021, 'A']) }}">2021</a></li>
                <!-- <li class="list-group-item"><a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_a']) }}">2020</a></li> -->
                <!-- <li class="list-group-item"><a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_a']) }}">2019</a></li> -->
                <!-- <li class="list-group-item"><a href="{{ route('indicators.rems.index') }}">Años anteriores</a> <span class="badge badge-warning">En Desarrollo</span></li> -->
            </ul>
        </div>
    </div>
    <div class="col mb-3">
        <div class="card">
            <div class="card-header">
                <strong>Serie BM</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2024, 'BM']) }}">2024 <span class="badge badge-pill badge-secondary">En Revisión</span></a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2023, 'BM']) }}">2023</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2022, 'BM']) }}">2022</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2021, 'BM']) }}">2021</a></li>
                <!-- <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_bm']) }}">2020</a></li> -->
                <!-- <li class="list-group-item text-muted"><a>2019</a> </li> -->
                <!-- <li class="list-group-item"><a href="{{ route('indicators.rems.index') }}">Años anteriores</a> <span class="badge badge-warning">En Desarrollo</span></li> -->
            </ul>
        </div>
    </div>
    <div class="col mb-3">
        <div class="card">
            <div class="card-header">
                <strong>Serie BS</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2024, 'BS']) }}">2024 <span class="badge badge-pill badge-secondary">En Revisión</span></a></li>
                <li class="list-group-item text-muted">2023</li>
                <li class="list-group-item text-muted">2022</li>
                <li class="list-group-item text-muted">2021</li>
                <!-- <li class="list-group-item text-muted"><a>2020</a></li> -->
                <!-- <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_bs']) }}">2019</a> </li> -->
                <!-- <li class="list-group-item"><a href="{{ route('indicators.rems.index') }}">Años anteriores</a> <span class="badge badge-warning">En Desarrollo</span></li> -->
            </ul>
        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <strong>Serie D</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2024, 'D']) }}">2024 <span class="badge badge-pill badge-warning">En Desarrollo</span></a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2023, 'D']) }}">2023</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2022, 'D']) }}">2022</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2021, 'D']) }}">2021</a></li>
                <!-- <li class="list-group-item"><a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_d']) }}">2020</a></li> -->
                <!-- <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_d']) }}">2019</a></li> -->
                <!-- <li class="list-group-item"><a href="{{ route('indicators.rems.index') }}">Años anteriores</a> <span class="badge badge-warning">En Desarrollo</span></li> -->
            </ul>
        </div>
    </div>

    <div class="col">
        <div class="card">
            <div class="card-header">
                <strong>Serie P</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2024, 'P']) }}">2024 <span class="badge badge-pill badge-warning">En Desarrollo</span></a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2023, 'P']) }}">2023</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2022, 'P']) }}">2022</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2021, 'P']) }}">2021</a></li>
                <!-- <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_p']) }}">2020</a> </li> -->
                <!-- <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_p']) }}">2019</a> </li> -->
                <!-- <li class="list-group-item"><a href="{{ route('indicators.rems.index') }}">Años anteriores</a> <span class="badge badge-warning">En Desarrollo</span></li> -->
            </ul>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <strong>Serie F</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted">2023</li>
                <li class="list-group-item text-muted">2022</li>
                <li class="list-group-item text-muted">2021</li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_f', 'covid']) }}">2020</a></li>
            </ul>
        </div>
    </div>
</div>
<br>
<a class="btn btn-outline-primary" href="{{ route('indicators.rems.index') }}" role="button">Años anteriores</a>
<!-- <a class="btn btn-outline-primary" href="http://intranet.saludtarapaca.gob.cl/estadistica/index.html" role="button">Años anteriores (Intranet)</a> -->
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
