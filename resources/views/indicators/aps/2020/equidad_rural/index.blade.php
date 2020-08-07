@extends('layouts.app')

@section('title', 'Equidad Rural')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores</h3>
<h6 class="mb-3">Programa Equidad en Salud Rural.</h6>

<ol>
    <li> <a href="{{ route('indicators.aps.2020.equidad_rural.aps') }}">APS.</a> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span>



@endsection

@section('custom_js')


@endsection

@section('custom_js_head')

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

@endsection
