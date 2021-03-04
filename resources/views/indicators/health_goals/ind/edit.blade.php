@extends('layouts.app')
@php
    $months = array (1=>'Ene',2=>'Feb',3=>'Mar',4=>'Abr',5=>'May',6=>'Jun',7=>'Jul',8=>'Ago',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dic');
    $sources_type = array('REM', 'Programación anual', 'Datamart', 'Reporte RRHH', 'Certificado Hospital', 'SIGTE', 'UGCC Minsal', 'GRD Minsal');
@endphp
@section('title', 'Metas Sanitarias Ley N° ' . $healthGoal->law . ' / '. $healthGoal->year . ' - ' . $healthGoal->name)

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('indicators.index') }}">Indicadores</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.health_goals.index', $healthGoal->law) }}">Ley {{number_format($healthGoal->law,0,',','.')}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.health_goals.list', [$healthGoal->law, $healthGoal->year]) }}">{{$healthGoal->year}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.health_goals.show', [$healthGoal->law, $healthGoal->year, $healthGoal->number]) }}">{{$healthGoal->name}}</a></li>
        <li class="breadcrumb-item">Indicador N° {{$indicator->number}}</li>
    </ol>
</nav>

<h3 class="mb-3">Editar indicador N° {{$indicator->number}} en {{$healthGoal->name}}.</h3>
<!-- @if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div><br />
@endif -->

<form method="post" action="{{route('indicators.health_goals.ind.update', [$healthGoal->law, $healthGoal->year, $healthGoal->number, $indicator])}}">
    @csrf
    @method('PUT')
    <div class="form-row">
        <div class="form-group col-md-1">
            <label for="number">Número *</label>
            <input type="number" min="1" step=".01" class="form-control" id="number" name="number" value="{{$indicator->number}}" required>
        </div>
        <div class="form-group col-md-9">
            <label for="name">Nombre *</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$indicator->name}}" required>
        </div>
        <div class="form-group col-md-1">
            <label for="weighting">Meta</label>
            <input type="text" class="form-control" id="goal" name="goal" value="{{$indicator->goal}}">
        </div>
        <div class="form-group col-md-1">
            <label for="weighting">% pond.</label>
            <input type="number" class="form-control" id="weighting" name="weighting" value="{{$indicator->weighting}}">
        </div>
    </div>
    <hr>
    <div class="form-row">
        <div class="form-group col-md-10">
            <label for="numerator">Nombre numerador</label>
            <input type="text" class="form-control" id="numerator" name="numerator" value="{{$indicator->numerator}}" required>
        </div>
        <div class="form-group col-md-2">
            <label for="numerator">Fuente de datos</label>
            <select class="form-control" id="numerator_source" name="numerator_source" required>
                @foreach($sources_type as $source)
                <option value="{{$source}}" @if($indicator->numerator_source == $source) selected @endif>{{$source}}</option>
                @endforeach
            </select>
        </div>
        @foreach($months as $number => $month)
        <div class="form-group col-md-1 n_months">
            <label for="month">{{$month}}</label>
            <input type="number" class="form-control" id="numerator_month" name="numerator_month[]" value="{{$indicator->getValueByFactorAndMonth('numerador', $number)}}">
        </div>
        @endforeach
        <div class="form-group col-md-6 n_source" style="display: none">
            <label for="numerator_cods">Códigos de prestación para numerador separados por coma</label>
            <input type="text" class="form-control" id="numerator_cods" name="numerator_cods" value="{{$indicator->numerator_cods}}" disabled>
        </div>
        <div class="form-group col-md-6 n_source" style="display: none">
            <label for="numerator_cols">Columnas para numerador separados por coma</label>
            <input type="text" class="form-control" id="numerator_cols" name="numerator_cols" value="{{$indicator->numerator_cols}}" disabled>
        </div>
    </div>
    <hr>
    <div class="form-row">
        <div class="form-group col-md-10">
            <label for="denominator">Nombre denominador</label>
            <input type="text" class="form-control" id="denominator" name="denominator" value="{{$indicator->denominator}}">
        </div>
        <div class="form-group col-md-2">
            <label for="numerator">Fuente de datos</label>
            <select class="form-control" id="denominator_source" name="denominator_source" required>
                @foreach($sources_type as $source)
                <option value="{{$source}}" @if($indicator->denominator_source == $source) selected @endif>{{$source}}</option>
                @endforeach
            </select>
        </div>
        @foreach($months as $number => $month)
        <div class="form-group col-md-1 d_months">
            <label for="month">{{$month}}</label>
            <input type="number" class="form-control" id="denominator_month" name="denominator_month[]" value="{{$indicator->getValueByFactorAndMonth('denominador', $number)}}">
        </div>
        @endforeach
        <div class="form-group col-md-6 d_source" style="display: none">
            <label for="denominator_cods">Códigos de prestación para denominador separados por coma</label>
            <input type="text" class="form-control" id="denominator_cods" name="denominator_cods" value="{{$indicator->denominator_cods}}" disabled>
        </div>
        <div class="form-group col-md-6 d_source" style="display: none">
            <label for="denominator_cols">Columnas para denominador separados por coma</label>
            <input type="text" class="form-control" id="denominator_cols" name="denominator_cols" value="{{$indicator->denominator_cols}}" disabled>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>

@endsection

@section('custom_js')
<script type="text/javascript"> 
    $(document).ready(function() {
        if($('#numerator_source option[value="REM"]').is(':selected')) showSource('n')
        if($('#denominator_source option[value="REM"]').is(':selected')) showSource('d')
        $('#numerator_source').change(function() {
            $(this).val() == 'REM' ? showSource('n') : hideSource('n')
        });
        $('#denominator_source').change(function() {
            $(this).val() == 'REM' ? showSource('d') : hideSource('d')
        });

        function showSource(factor){
            $("." + factor + "_source").show();
            factor == 'n' ? $('#numerator_cols, #numerator_cods').prop('disabled', false) : $('#denominator_cols, #denominator_cods').prop('disabled', false);
            $("." + factor + "_months").hide();
            factor == 'n' ? $('#numerator_month').prop('disabled', true) : $('#denominator_month').prop('disabled', true);
        }

        function hideSource(factor){
            $("." + factor + "_source").hide();
            factor == 'n' ? $('#numerator_cols, #numerator_cods').prop('disabled', true) : $('#denominator_cols, #denominator_cods').prop('disabled', true);
            $("." + factor + "_months").show();
            factor == 'n' ? $('#numerator_month').prop('disabled', false) : $('#denominator_month').prop('disabled', false);
        }

        // if($('input[type="checkbox"]').is(':checked')) showSource()
        // $('input[type="checkbox"]').click(function() {
        //     $(this).prop('checked') ? showSource() : hideSource()
        // });

        // function showSource(){
        //     $(".source").show();
        //     $('#numerator_source, #denominator_source').prop('disabled', false);
        //     $(".months").hide();
        //     $('#numerator_month, #denominator_month').prop('disabled', true);
        // }

        // function hideSource(){
        //     $(".source").hide();
        //         $('#numerator_source, #denominator_source').prop('disabled', true);
        //         $(".months").show();
        //         $('#numerator_month, #denominator_month').prop('disabled', false);
        // }
    }); 
</script> 
@endsection