@extends('layouts.app')
@section('title', 'Compromiso de Gestión 2020')
@section('content')
@include('indicators.partials.nav')
@php
$links = session()->has('links') ? session('links') : [];
$currentLink = request()->path(); // Getting current URI like 'category/books/'
array_unshift($links, $currentLink); // Putting it in the beginning of links array
session(['links' => $links]); // Saving links array to the session
@endphp
<style media="screen">
    .label {
        width: 40%;
    }
</style>
<h3 class="mb-3">{{$data1['nombre']}} - I Corte<br>
    <small>
        - Cumplimiento : {{ number_format(($data1_1[1]['cumplimientoponderado']+$data1_2[1]['cumplimientoponderado']+$data1_3[1]['cumplimientoponderado'])/3, 2, ',', '.') }}%
    </small>
</h3>
<div id="collapsebutton" class="nodisp expandcollapse btn btn-small btn-success no-print" style="margin: 10px 0px;"><i class="glyphicon glyphicon-minus"></i> Contraer Todo</div>
<div id="expandbutton" class="disp expandcollapse btn btn-small btn-success no-print" style="margin: 10px 0px;"><i class="glyphicon glyphicon-plus"></i>Expandir Todo</div>
<hr>
<h5 class="mb-3 text-justify"><button class="btn btn-link dropdown-toggle-split text-justify" data-toggle="collapse" data-target="#comges1_1">{{ $data1_1['label']['meta'] }} (Ver Detalle)</button></h5>
<div class="collapse" id="comges1_1">
    @include('indicators.comges.2020.comges1.1_1corte1acciones')
    @include('indicators.comges.2020.comges1.1_1corte1indicadores')
</div>
<hr>
<h5 class="mb-3 text-justify"><button class="btn btn-link dropdown-toggle-split text-justify" data-toggle="collapse" data-target="#comges1_2">{{ $data1_2['label']['meta'] }} (Ver Detalle)</button></h5>
<div class="collapse" id="comges1_2">
@include('indicators.comges.2020.comges1.1_2corte1acciones')
@include('indicators.comges.2020.comges1.1_2corte1indicadores')
</div>
<hr>
<h5 class="mb-3 text-justify"><button class="btn btn-link dropdown-toggle-split text-justify" data-toggle="collapse" data-target="#comges1_3">{{ $data1_3['label']['meta'] }} (Ver Detalle)</button></h5>
<div class="collapse" id="comges1_3">
@include('indicators.comges.2020.comges1.1_3corte1acciones')
@include('indicators.comges.2020.comges1.1_3corte1indicadores')
</div>
<hr>


@endsection
@section('custom_js')
<script>
    $(document).ready(function() {
    $("#collapsebutton").hide();    
    $("#expandbutton").click(function() {
        $('div.collapse').addClass('in').css("height", "");
        $("#expandbutton").hide();
        $("#collapsebutton").show();
        $('.collapse').collapse('show');
    });
    $("#collapsebutton").click(function() {
        $('div.collapse').removeClass('in');
        $("#expandbutton").show();
        $("#collapsebutton").hide();
        $('.collapse').collapse('hide');
    });
    });    
</script>
@endsection