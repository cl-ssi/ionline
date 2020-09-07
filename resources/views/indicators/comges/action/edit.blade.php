@extends('layouts.app')
@php
    $months = array (1=>'Ene',2=>'Feb',3=>'Mar',4=>'Abr',5=>'May',6=>'Jun',7=>'Jul',8=>'Ago',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
    $months_by_section = array(1 => array(1,2,3), 2 => array(4,5,6), 3 => array(7,8,9), 4 => array(10,11,12));
    $romans = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV'];
    $title2 = $comges->name.' - '.$romans[isset($corte) ? $corte->number : $section].' Corte';
@endphp
@section('title', 'Compromiso de Gestión ' . $comges->year . ' - ' . $title2)

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('indicators.index') }}">Indicadores</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.comges.index') }}">Comges</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.comges.list', [$comges->year]) }}">{{$comges->year}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.comges.show', [$comges->year, $comges->number, isset($corte) ? $corte->number : $section]) }}">{{$title2}}</a></li>
        <li class="breadcrumb-item">Indicador N° {{$indicator->number}} - Acción N° {{$action->number}}</li>
    </ol>
</nav>

<h3 class="mb-3">Editar acción N° {{$action->number}} para indicador N° {{$indicator->number}} en {{$title2}}.</h3>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div><br />
@endif

@if($comges->users->contains('id', Auth::id()))
<form method="post" action="{{ route('indicators.comges.action.update', [$comges->year, $comges, isset($corte) ? $corte->number : $section, $indicator, $action]) }}">
    @csrf
    @method('PUT')
    <div class="form-row">
        <div class="form-group col-md-1">
            <label for="number">Número *</label>
            <input type="number" min="1" class="form-control" id="number" name="number" value="{{$action->number}}" required>
            {{--<input type="hidden" class="form-control" id="number" name="number" value="{{$action->number}}">--}}
        </div>
        <div class="form-group col-md-9">
            <label for="name">Nombre *</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$action->name}}" required>
        </div>
        <div class="form-group col-md-2">
            <label for="weighting">% pond. al corte</label>
            <input type="number" class="form-control" id="weighting" name="weighting" value="{{$action->weighting}}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-10">
            <label for="verification_means">Medios de verificación *</label>
            <input type="text" class="form-control" id="verification_means" name="verification_means" value="{{$action->verification_means}}" required>
        </div>
        <div class="form-group col-md-2">
            <label for="target_type">Tipo de meta aplicada</label>
            <select class="form-control" id="target_type" name="target_type">
                <option value=""></option>
                <option value="de mantención" @if($action->target_type == 'de mantención') selected @endif>De mantención</option>
                <option value="de disminución de la brecha" @if($action->target_type == 'de disminución de la brecha') selected @endif>De disminución de la brecha</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="form-check">
        <input class="form-check-input" type="checkbox" id="gridCheck" {{$action->isActionWithFactorSource() ? 'checked' : ''}}>
        <label class="form-check-label" for="gridCheck">
            Fuente Rem?
        </label>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-9">
            <label for="numerator">Nombre numerador</label>
            <input type="text" class="form-control" id="numerator" name="numerator" value="{{$action->numerator}}">
        </div>
        @foreach($months_by_section[isset($corte) ? $corte->number : $section] as $index)
        <div class="form-group col-md-1 months">
            <label for="month">{{$months[$index]}}</label>
            <input type="number" class="form-control" id="numerator_month" name="numerator_month[]" value="{{$action->getValueByFactorAndMonth('numerador', $index)}}">
        </div>
        @endforeach
        <div class="form-group col-md-3 source" style="display: none">
            <label for="numerator_source">Fuente datos</label>
            <input type="text" class="form-control" id="numerator_source" name="numerator_source" value="{{$action->denominator_source}}" disabled>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-9">
            <label for="denominator">Nombre denominador</label>
            <input type="text" class="form-control" id="denominator" name="denominator" value="{{$action->denominator}}">
        </div>
        @foreach($months_by_section[isset($corte) ? $corte->number : $section] as $index)
        <div class="form-group col-md-1 months">
            <label for="month">{{$months[$index]}}</label>
            <input type="number" class="form-control" id="denominator_month" name="denominator_month[]" value="{{$action->getValueByFactorAndMonth('denominador', $index)}}">
        </div>
        @endforeach
        <div class="form-group col-md-3 source" style="display: none">
            <label for="denominator_source">Fuente datos</label>
            <input type="text" class="form-control" id="denominator_source" name="denominator_source" value="{{$action->denominator_source}}" disabled>
        </div>
    </div>
    <h4 class="mb-3">Cálculos de cumplimiento</h4><hr>
    <div class="form-row">
        <div class="form-group col-md-1">
            <label for="left_result_value">% o valor</label>
        </div>
        <div class="form-group col-md-1">
            <label for="left_result_operator">Operador</label>
        </div>
        <div class="form-group col-md-1">
            <label for="result">Resultado</label>
        </div>
        <div class="form-group col-md-1">
            <label for="right_result_value">Operador</label>
        </div>
        <div class="form-group col-md-1">
            <label for="right_result_operator">% o valor</label>
        </div>
        <div class="form-group col-md-1">
            <label for="staticEmail">&nbsp;</label>
        </div>
        <div class="form-group col-md-3">
            <label for="compliance_value">% o valor de cumplimiento</label>
        </div>
    </div>
    @for($i=0; $i < 5; $i++)
    <div class="form-row">
        <div class="form-group col-md-1">
            <input type="number" class="form-control" id="left_result_value" name="left_result_value[]" @isset($action->compliances[$i]) value="{{$action->compliances[$i]->left_result_value}}" @endisset>
        </div>
        <div class="form-group col-md-1">
            <select class="form-control" id="left_result_operator" name="left_result_operator[]">
                <option value=""></option>
                <option value="<" @isset($action->compliances[$i]) {{$action->compliances[$i]->left_result_operator == '<' ? 'selected' : ''}} @endisset><</option>
                <option value="<=" @isset($action->compliances[$i]) {{$action->compliances[$i]->left_result_operator == '<=' ? 'selected' : ''}} @endisset>&le;</option>
                <option value=">" @isset($action->compliances[$i]) {{$action->compliances[$i]->left_result_operator == '>' ? 'selected' : ''}} @endisset>></option>
                <option value=">=" @isset($action->compliances[$i]) {{$action->compliances[$i]->left_result_operator == '>=' ? 'selected' : ''}} @endisset>&ge;</option>
            </select>
        </div>
        <div class="form-group col-md-1">
            <input type="text" readonly class="form-control-plaintext text-center" id="text" value="X">
        </div>
        <div class="form-group col-md-1">
            <select class="form-control" id="right_result_operator" name="right_result_operator[]">
                <option value=""></option>
                <option value="<" @isset($action->compliances[$i]) {{$action->compliances[$i]->right_result_operator == '<' ? 'selected' : ''}} @endisset><</option>
                <option value="<=" @isset($action->compliances[$i]) {{$action->compliances[$i]->right_result_operator == '<=' ? 'selected' : ''}} @endisset>&le;</option>
                <option value=">" @isset($action->compliances[$i]) {{$action->compliances[$i]->right_result_operator == '>' ? 'selected' : ''}} @endisset>></option>
                <option value=">=" @isset($action->compliances[$i]) {{$action->compliances[$i]->right_result_operator == '>=' ? 'selected' : ''}} @endisset>&ge;</option>
                <option value="=" @isset($action->compliances[$i]) {{$action->compliances[$i]->right_result_operator == '==' ? 'selected' : ''}} @endisset>=</option>
            </select>
        </div>
        <div class="form-group col-md-1">
            <input type="number" class="form-control" id="right_result_value" name="right_result_value[]" @isset($action->compliances[$i]) value="{{$action->compliances[$i]->right_result_value}}" @endisset>
        </div>
        <div class="form-group col-md-1">
            <input type="text" readonly class="form-control-plaintext text-center" id="staticEmail" value="=>">
        </div>
        <div class="form-group col-md-3">
            <input type="number" class="form-control" id="compliance_value" name="compliance_value[]" @isset($action->compliances[$i]) value="{{$action->compliances[$i]->compliance_value}}" @endisset>
        </div>
    </div>
    @endfor
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
@else
<p>No tiene los permisos para realizar esta operación</p>
@endif

@endsection

@section('custom_js')
<script type="text/javascript"> 
    $(document).ready(function() {
        if($('input[type="checkbox"]').is(':checked')) showSource()
        $('input[type="checkbox"]').click(function() {
            $(this).prop('checked') ? showSource() : hideSource()
        });

        function showSource(){
            $(".source").show();
            $('#numerator_source, #denominator_source').prop('disabled', false);
            $(".months").hide();
            $('#numerator_month, #denominator_month').prop('disabled', true);
        }

        function hideSource(){
            $(".source").hide();
                $('#numerator_source, #denominator_source').prop('disabled', true);
                $(".months").show();
                $('#numerator_month, #denominator_month').prop('disabled', false);
        }
    }); 
</script> 
@endsection