@extends('layouts.bt4.app')

@section('title', 'REM')

@section('content')

@include('indicators.rem.partials.nav')

<h3 class="mb-3">Resumen Estadístico Mensual</h3>

<div class="row">
    <div class="col-2">
        <div class="card">
            <div class="card-header">
                <strong>Serie A</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2024, 'A']) }}">2024 <span class="badge badge-pill badge-secondary">En Revisión</span></a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2023, 'A']) }}">2023</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2022, 'A']) }}">2022</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2021, 'A']) }}">2021</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_a']) }}">2020</a> </li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_a']) }}">2019</a> </li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2018, 'A']) }}">2018</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2017, 'A']) }}">2017</a></li>
                <!-- <li class="list-group-item text-muted"><a href="">2017</a> </li>
                <li class="list-group-item text-muted"><a href="">2016</a> </li>
                <li class="list-group-item text-muted"><a href="">2015</a> </li> -->
            </ul>
        </div>
    </div>
    <div class="col-2">
        <div class="card">
            <div class="card-header">
                <strong>Serie BM</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2024, 'BM']) }}">2024 <span class="badge badge-pill badge-secondary">En Revisión</span></a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2023, 'BM']) }}">2023</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2022, 'BM']) }}">2022</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2021, 'BM']) }}">2021</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_bm']) }}">2020</a></li>
                <li class="list-group-item text-muted"><a>2019</a> </li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2018, 'BM']) }}">2018</a></li>
                <!-- <li class="list-group-item text-muted"><a href="">2017</a> </li>
                <li class="list-group-item text-muted"><a href="">2016</a> </li>
                <li class="list-group-item text-muted"><a href="">2015</a> </li> -->
            </ul>
        </div>
    </div>
    <div class="col-2">
        <div class="card">
            <div class="card-header">
                <strong>Serie BS</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2024, 'BS']) }}">2024 <span class="badge badge-pill badge-secondary">En Revisión</span></a></li>
                <li class="list-group-item text-muted">2023</li>
                <li class="list-group-item text-muted">2022</li>
                <li class="list-group-item text-muted">2021</li>
                <li class="list-group-item text-muted">2020</li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_bs']) }}">2019</a> </li>
                <li class="list-group-item text-muted">2018</li>
                <!-- <li class="list-group-item text-muted"><a href="">2017</a> </li>
                <li class="list-group-item text-muted"><a href="">2016</a> </li>
                <li class="list-group-item text-muted"><a href="">2015</a> </li> -->
            </ul>
        </div>
    </div>
    <div class="col-2">
        <div class="card">
            <div class="card-header">
                <strong>Serie D</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2024, 'D']) }}">2024 <span class="badge badge-pill badge-secondary">En Revisión</span></a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2023, 'D']) }}">2023</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2022, 'D']) }}">2022</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2021, 'D']) }}">2021</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_d']) }}">2020</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_d']) }}">2019</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2018, 'D']) }}">2018</a></li>
                <!-- <li class="list-group-item text-muted"><a href="">2017</a> </li>
                <li class="list-group-item text-muted"><a href="">2016</a> </li>
                <li class="list-group-item text-muted"><a href="">2015</a> </li> -->
            </ul>
        </div>
    </div>
    <div class="col-2">
        <div class="card">
            <div class="card-header">
                <strong>Serie P</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2024, 'P']) }}">2024</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2023, 'P']) }}">2023</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2022, 'P']) }}">2022</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2021, 'P']) }}">2021</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2020, 'serie_p']) }}">2020</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.index', [2019, 'serie_p']) }}">2019</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2018, 'P']) }}">2018</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2017, 'P']) }}">2017</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2016, 'P']) }}">2016</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2015, 'P']) }}">2015</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2014, 'P']) }}">2014</a></li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rem.index', [2013, 'P']) }}">2013</a></li>
                <!-- <li class="list-group-item text-muted"><a href="">2017</a> </li>
                <li class="list-group-item text-muted"><a href="">2016</a> </li>
                <li class="list-group-item text-muted"><a href="">2015</a> </li> -->
            </ul>
        </div>
    </div>
    <div class="col-2">
        <div class="card">
            <div class="card-header">
                <strong>Serie F</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted">{{--<a href="{{ route('indicators.rem.index', [2021, 'F']) }}">2021</a>--}} 2021</li>
                <li class="list-group-item text-muted"><a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_f', 'covid']) }}">2020</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Include Twitter Bootstrap and jQuery: -->

@endsection

@section('custom_js')

@endsection
