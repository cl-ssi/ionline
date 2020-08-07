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
<h3 class="mb-3">{{$data3['nombre']}} - I Corte<br>
    <small>
        - Cumplimiento : {{ number_format(($data3_1['cumplimientoponderado']+ $data3_2['cumplimientoponderado'] + $data3_3['cumplimientoponderado'] + $data3_4['cumplimientoponderado'])/4 , 2, ',', '.') }}%
    </small>
</h3>
<div id="collapsebutton" class="nodisp expandcollapse btn btn-small btn-success no-print" style="margin: 10px 0px;"><i class="glyphicon glyphicon-minus"></i> Contraer Todo</div>
<div id="expandbutton" class="disp expandcollapse btn btn-small btn-success no-print" style="margin: 10px 0px;"><i class="glyphicon glyphicon-plus"></i>Expandir Todo</div>
<hr>
<h5 class="mb-3 text-justify"><button class="btn btn-link dropdown-toggle-split text-justify" data-toggle="collapse" data-target="#comges3_1">{{ $data3_1['label']['meta'] }} (Ver Detalle)</button></h5>
<div class="collapse" id="comges3_1">
    @include('indicators.comges.2020.comges3.3_1corte1acciones')
    @include('indicators.comges.2020.comges3.3_1corte1indicadores')
</div>
<hr>
<h5 class="mb-3 text-justify"><button class="btn btn-link dropdown-toggle-split text-justify" data-toggle="collapse" data-target="#comges3_2">{{ $data3_2['label']['meta'] }} (Ver Detalle)</button></h5>
<div class="collapse" id="comges3_2">
@include('indicators.comges.2020.comges3.3_2corte1acciones')
@include('indicators.comges.2020.comges3.3_2corte1indicadores')
</div>
<hr>
<h5 class="mb-3 text-justify"><button class="btn btn-link dropdown-toggle-split text-justify" data-toggle="collapse" data-target="#comges3_3">{{ $data3_3['label']['meta'] }} (Ver Detalle)</button></h5>
<div class="collapse" id="comges3_3">
@include('indicators.comges.2020.comges3.3_3corte1acciones')
@include('indicators.comges.2020.comges3.3_3corte1indicadores')
</div>
<hr>
<h5 class="mb-3 text-justify"><button class="btn btn-link dropdown-toggle-split text-justify" data-toggle="collapse" data-target="#comges3_4">{{ $data3_4['label']['meta'] }} (Ver Detalle)</button></h5>
<div class="collapse" id="comges3_4">
@include('indicators.comges.2020.comges3.3_4corte1acciones')
@include('indicators.comges.2020.comges3.3_4corte1indicadores')
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