@extends('layouts.app')

@section('title', 'GES Odontológico')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores</h3>
<h6 class="mb-3">GES Odontológico.</h6>

<ol>
    <li> <a href="{{ route('indicators.aps.2020.ges_odont.aps') }}">APS.</a> <span class="badge badge-success"><i class="fas fa-check"></i></li>
    <li> <a href="{{ route('indicators.aps.2020.ges_odont.reyno') }}">CGU Dr. Hector Reyno.</a> <span class="badge badge-success"><i class="fas fa-check"></i></li>
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
