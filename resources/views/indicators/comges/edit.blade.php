@extends('layouts.app')

@section('title', 'Compromiso de Gestión ' . $comges->year . '- Editar Comges')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('indicators.index') }}">Indicadores</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.comges.index') }}">Comges</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.comges.list', [$comges->year]) }}">{{$comges->year}}</a></li>
        <li class="breadcrumb-item">{{$comges->name}}</li>
    </ol>
</nav>

<h3 class="mb-3">Editar Compromiso de Gestión N° {{$comges->number}} - {{$comges->year}}, referentes e indicadores.</h3>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div><br />
@endif
@canany(['Indicators: manager'])
<form method="post" action="{{ route('indicators.comges.update', [$comges]) }}">
    @csrf
    @method('PUT') 
    <div class="form-row">
        <div class="form-group col-md-1">
            <label for="number">Número</label>
            <input type="text" class="form-control" id="number" name="number" value="{{$comges->number}}" disabled>
        </div>
        <div class="form-group col-md-11">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$comges->name}}" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="referrer">Primer referente</label>
            <select class="form-control" id="referrer_1" name="referrer[]">
                <option value="">Seleccione primer referente</option>
                @php($referrer = $comges->getReferrer(1))
                @foreach($users as $user)
                <option value="{{$user->id}}" @if($referrer != null){{$user->id == $referrer->id ? "selected" : ""}}@endif>{{$user->name}} {{$user->fathers_family}} {{$user->mothers_family}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="referrer">Segundo referente</label>
            <select class="form-control" id="referrer" name="referrer[]">
                <option value="">Seleccione segundo referente</option>
                @php($referrer = $comges->getReferrer(2))
                @foreach($users as $user)
                <option value="{{$user->id}}" @if($referrer != null){{$user->id == $referrer->id ? "selected" : ""}}@endif>{{$user->name}} {{$user->fathers_family}} {{$user->mothers_family}}</option>
                @endforeach
            </select>
        </div>
    </div><br>
    <!-- hidden dynamic element to clone -->
    <div class="form-group dynamic-element" style="display:none">
    <hr>
    <div class="form-row">
        <div class="form-group col-md-1">
            <label for="number">Número *</label>
            <input type="text" class="form-control" id="number" name="indicator[0][number]" disabled>
        </div>
        <div class="form-group col-md-9">
            <label for="name">Nombre *</label>
            <input type="text" class="form-control" id="name" name="indicator[0][name]" disabled>
        </div>
        <div class="form-group col-md-2">
            <label for="weighting">% pond. por Corte</label>
            <input type="number" class="form-control" id="weighting" name="indicator[0][weighting]" step="0.001" disabled>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="numerator">Nombre numerador *</label>
            <input type="text" class="form-control" id="numerator" name="indicator[0][numerator]" disabled>

        </div>
        <div class="form-group col-md-4">
            <label for="numerator_source">Fuente datos *</label>
            <input type="text" class="form-control" id="numerator_source" name="indicator[0][numerator_source]" disabled>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="denominator">Nombre denominador</label>
            <input type="text" class="form-control" id="denominator" name="indicator[0][denominator]" disabled>

        </div>
        <div class="form-group col-md-4">
            <label for="denominator_source">Fuente datos</label>
            <input type="text" class="form-control" id="denominator_source" name="indicator[0][denominator_source]" disabled>
        </div>
    </div>
    <p>% de evaluación anual por corte</p>
    <div class="form-row">
        <label class="col-sm-1 col-form-label" for="corte_1">Corte I</label>
        <div class="form-group col-md-2">
            <input type="number" class="form-control" id="corte_1" name="indicator[0][cortes][]" disabled>
        </div>
        <label class="col-sm-1 col-form-label" for="corte_2">Corte II</label>
        <div class="form-group col-md-2">
            <input type="number" class="form-control" id="corte_2" name="indicator[0][cortes][]" disabled>
        </div>
        <label class="col-sm-1 col-form-label" for="corte_3">Corte III</label>
        <div class="form-group col-md-2">
            <input type="number" class="form-control" id="corte_3" name="indicator[0][cortes][]" disabled>
        </div>
        <label class="col-sm-1 col-form-label" for="corte_4">Corte IV</label>
        <div class="form-group col-md-2">
            <input type="number" class="form-control" id="corte_4" name="indicator[0][cortes][]" disabled>
        </div>
    </div>
    </div>
    <!-- end hidden dynamic element to clone -->
    <h4 class="mb-3">Indicadores</h4>
    <div class="dynamic-stuff">
        <!-- active indicators -->
        @foreach($comges->indicators as $i => $indicator)
        <div class="form-group dynamic-element">
        <hr>
        <div class="form-row">
            <div class="form-group col-md-1">
                <label for="number">Número *</label>
                <input type="text" class="form-control" id="number" name="indicator[{{$i}}][number]" value="{{$indicator->number}}">
            </div>
            <div class="form-group col-md-9">
                <label for="name">Nombre *</label>
                <input type="text" class="form-control" id="name" name="indicator[{{$i}}][name]" value="{{$indicator->name}}">
            </div>
            <div class="form-group col-md-2">
                <label for="weighting">% pond. por Corte</label>
                <input type="number" class="form-control" id="weighting" name="indicator[{{$i}}][weighting]" step="0.001" value="{{$indicator->weighting_by_section}}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="numerator">Nombre numerador *</label>
                <input type="text" class="form-control" id="numerator" name="indicator[{{$i}}][numerator]" value="{{$indicator->numerator}}">

            </div>
            <div class="form-group col-md-4">
                <label for="numerator_source">Fuente datos *</label>
                <input type="text" class="form-control" id="numerator_source" name="indicator[{{$i}}][numerator_source]" value="{{$indicator->numerator_source}}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="denominator">Nombre denominador</label>
                <input type="text" class="form-control" id="denominator" name="indicator[{{$i}}][denominator]" value="{{$indicator->denominator}}">

            </div>
            <div class="form-group col-md-4">
                <label for="denominator_source">Fuente datos</label>
                <input type="text" class="form-control" id="denominator_source" name="indicator[{{$i}}][denominator_source]" value="{{$indicator->denominator_source}}">
            </div>
        </div>
        <p>% de evaluación anual por corte</p>
        <div class="form-row">
            @php($romans = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV'])
            @foreach($indicator->sections as $j => $section)
            <label class="col-sm-1 col-form-label" for="corte_{{$i+1}}">Corte {{$romans[$j+1]}}</label>
            <div class="form-group col-md-2">
                <input type="number" class="form-control" id="corte_{{$j+1}}" name="indicator[{{$i}}][cortes][]" value="{{number_format($section->weighting)}}">
            </div>
            @endforeach
        </div>
        </div>
        @endforeach
        <!-- end active indicators -->
    </div>
    <button type="button" class="btn btn-link mx-auto d-block add-one">+ Añadir indicador</button><br>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
@else
<p>No tiene los permisos para realizar esta operación</p>
@endcanany
@endsection

@section('custom_js')
<script>
//Clone the hidden element and shows it
$('.add-one').click(function(){
    //$('.dynamic-element').first().clone().appendTo('.dynamic-stuff').show();
    var newElement = $('.dynamic-element').first().clone();
    var num = $('.dynamic-element').length - 2;
    var newNum = num + 1;
    newElement.find('input').each(function(i){
        $(this).attr('name', $(this).attr('name').replace($(this).attr("name").match(/\[[0-9]+\]/), "["+(newNum)+"]"));
        $(this).prop('disabled', false);
    });
    newElement.find('#number').val(newNum+1);
    newElement.find('#number, #name, #numerator, #numerator_source').prop('required', true);
    newElement.appendTo('.dynamic-stuff').show();
});
</script>
@endsection