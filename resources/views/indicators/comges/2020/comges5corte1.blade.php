@extends('layouts.app')
@section('title', 'Compromiso de Gestión 2020')
@section('content')
@include('indicators.partials.nav')
<style media="screen">
    .label {
        width: 40%;
    }
</style>
<h3 class="mb-3">Reducción de los Tiempos de Espera por Intervenciones Quirúrgicas - I Corte<br>
    <small>
        - Cumplimiento : {{ number_format(($data5_1['cumplimientoponderado']+$data5_2['cumplimientoponderado'])/2, 2, ',', '.') }}%
    </small>
</h3>
<div id="collapsebutton" class="nodisp expandcollapse btn btn-small btn-success no-print" style="margin: 10px 0px;"><i class="glyphicon glyphicon-minus"></i> Contraer Todo</div>
<div id="expandbutton" class="disp expandcollapse btn btn-small btn-success no-print" style="margin: 10px 0px;"><i class="glyphicon glyphicon-plus"></i>Expandir Todo</div>
<hr>
<h5 class="mb-3 text-justify"><button class="btn btn-link dropdown-toggle-split text-justify" data-toggle="collapse" data-target="#comges5_1">{{ $data5_1['label']['meta'] }} (Ver Detalle)</button></h5>
<div class="collapse" id="comges5_1">
    @include('indicators.comges.2020.comges5.5_1corte1acciones')
    @include('indicators.comges.2020.comges5.5_1corte1indicadores')
</div>
<hr>
<h5 class="mb-3 text-justify"><button class="btn btn-link dropdown-toggle-split text-justify" data-toggle="collapse" data-target="#comges5_2">{{ $data5_2['label']['meta'] }} (Ver Detalle)</button></h5>
<div class="collapse" id="comges5_2">
@include('indicators.comges.2020.comges5.5_2corte1acciones')
@include('indicators.comges.2020.comges5.5_2corte1indicadores')
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