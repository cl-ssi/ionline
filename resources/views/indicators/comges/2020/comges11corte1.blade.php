@extends('layouts.app')
@section('title', 'Compromiso de Gestión 2020')
@section('content')
@include('indicators.partials.nav')
<style media="screen">
    .label {
        width: 40%;
    }
</style>
<h3 class="mb-3">{{$data11['nombre']}} - I Corte<br>
    <small>
        - Cumplimiento : {{ number_format(($data11_1['cumplimientoponderado']+$data11_2['cumplimientoponderado']+$data11_3['cumplimientoponderado'])/3, 2, ',', '.') }}%
    </small>
</h3>
<div id="collapsebutton" class="nodisp expandcollapse btn btn-small btn-success no-print" style="margin: 10px 0px;"><i class="glyphicon glyphicon-minus"></i> Contraer Todo</div>
<div id="expandbutton" class="disp expandcollapse btn btn-small btn-success no-print" style="margin: 10px 0px;"><i class="glyphicon glyphicon-plus"></i>Expandir Todo</div>
<hr>
<h5 class="mb-3 text-justify"><button class="btn btn-link dropdown-toggle-split text-justify" data-toggle="collapse" data-target="#comges11_1">{{ $data11_1['label']['meta'] }} (Ver Detalle)</button></h5>
<div class="collapse" id="comges11_1">
    @include('indicators.comges.2020.comges11.11_1corte1acciones')
    @include('indicators.comges.2020.comges11.11_1corte1indicadores')
</div>
<hr>
<h5 class="mb-3 text-justify"><button class="btn btn-link dropdown-toggle-split text-justify" data-toggle="collapse" data-target="#comges11_2">{{ $data11_2['label']['meta'] }} (Ver Detalle)</button></h5>
<div class="collapse" id="comges11_2">
@include('indicators.comges.2020.comges11.11_2corte1acciones')
@include('indicators.comges.2020.comges11.11_2corte1indicadores')
</div>
<hr>
<h5 class="mb-3 text-justify"><button class="btn btn-link dropdown-toggle-split text-justify" data-toggle="collapse" data-target="#comges11_3">{{ $data11_3['label']['meta'] }} (Ver Detalle)</button></h5>
<div class="collapse" id="comges11_3">
@include('indicators.comges.2020.comges11.11_3corte1acciones')
@include('indicators.comges.2020.comges11.11_3corte1indicadores')
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