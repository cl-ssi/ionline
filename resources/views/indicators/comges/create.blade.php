@extends('layouts.app')

@section('title', 'Compromiso de Gestión ' . $year . '- Crear nuevo Comges')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('indicators.index') }}">Indicadores</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.comges.index') }}">Comges</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.comges.list', [$year]) }}">{{$year}}</a></li>
        <li class="breadcrumb-item">Nuevo Comges</li>
    </ol>
</nav>

<h3 class="mb-3">Crear nuevo Compromiso de Gestión {{$year}}, referentes e indicadores.</h3>
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
<form method="post" action="{{ route('indicators.comges.store', [$year]) }}">
    @csrf
    <h4 class="mb-3">Comges</h4><hr>
    <div class="form-row">
        <div class="form-group col-md-1">
            <label for="number">Número</label>
            <input type="text" class="form-control" id="number" name="number" value="{{$last_number}}" disabled>
            <input type="hidden" class="form-control" id="number" name="number" value="{{$last_number}}">
        </div>
        <div class="form-group col-md-11">
            <label for="name">Nombre *</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
    </div><br>
    <h4 class="mb-3">Referentes</h4><hr>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="referrer">Primer referente</label>
            <select class="form-control" id="referrer_1" name="referrer[]">
                <option value="">Seleccione primer referente</option>
                @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->name}} {{$user->fathers_family}} {{$user->mothers_family}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="referrer">Segundo referente</label>
            <select class="form-control" id="referrer_2" name="referrer[]">
                <option value="">Seleccione segundo referente</option>
                @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->name}} {{$user->fathers_family}} {{$user->mothers_family}}</option>
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
    <div class="dynamic-stuff"></div>
    <button type="button" class="btn btn-link mx-auto d-block add-one">+ Añadir indicador</button><br>
    <button type="submit" class="btn btn-primary">Crear</button>
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