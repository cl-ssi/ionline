@extends('layouts.app')

@section('title', 'PESPI')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores</h3>
<h6 class="mb-3">Programa Especial de Salud y Pueblos Indígenas (PESPI).</h6>

<ol>
    <li> <a href="{{ route('indicators.aps.2020.pespi.aps') }}">APS.</a> <span class="badge badge-success"><i class="fas fa-check"></i></span></li></li>
    <li> <a href="{{ route('indicators.aps.2020.pespi.reyno') }}">CGU Dr. Héctor Reyno</a> <span class="badge badge-success"><i class="fas fa-check"></i></span></li></li>
</ol>



@endsection

@section('custom_js')


@endsection

@section('custom_js_head')

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

@endsection
