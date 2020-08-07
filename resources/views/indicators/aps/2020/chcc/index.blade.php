@extends('layouts.app')

@section('title', 'ChCC')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores</h3>
<h6 class="mb-3">Chile Crece Contigo (ChCC.)</h6>

<ol>
    <li> <a href="{{ route('indicators.aps.2020.chcc.aps') }}">APS.</a> <span class="badge badge-success"><i class="fas fa-check"></i></span></li>
    <li> <a href="{{ route('indicators.aps.2020.chcc.reyno') }}">CGU Dr. Hector Reyno.</a> <span class="badge badge-success"><i class="fas fa-check"></i></span></li>
    <li> <a href="{{ route('indicators.aps.2020.chcc.hospital') }}">Hospital Dr. Ernesto Torres G.</a> <span class="badge badge-success"><i class="fas fa-check"></i></span></li>
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
