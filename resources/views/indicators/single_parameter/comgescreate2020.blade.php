@extends('layouts.app')

@section('title', 'Crear Nuevo Numerador/Denominador')

@section('content')
<h3 class="mb-3">Crear Nuevo {{$nd}} Comges {{$indicador}}</h3>

<form method="POST" class="form-horizontal" action="{{ route('indicators.single_parameter.store') }}">
    @csrf

    <div class="row">

        <input type="hidden" class="form-control" name="law" id="for_law" value="Comges"> 
        <input type="hidden" class="form-control" name="id" id="for_id" value="{{$id}}">
        <input type="hidden" class="form-control" name="year" id="for_year" value="2020">

        <!-- <fieldset class="form-group col-2">
            <label for="for_year">Año</label>
            <select name="year" id="for_year" class="form-control" required>
                <option value="2020">2020</option>
            </select>
        </fieldset> -->

    </div>

    <div class="row">

        <fieldset class="form-group col-2">
            <label for="for_indicator">Numero de indicador</label>
            <input readonly type="text" class="form-control" id="for_indicator" placeholder="Ej 25.10 (todas deben finalizar con 0 excepto si su indicador tiene mas de 1 acción) ej: 25.13 (indicador 25.1 acción 3)" name="indicator" value="{{$indicador}}" required autocomplete="off">
        </fieldset>


        <fieldset class="form-group col-2">
            <label for="for_month">Mes</label>
            <input readonly type="number" class="form-control" id="for_month" name="month" min="1" max="3" value="{{$mes}}">
        </fieldset>


        <fieldset class="form-group col-2">
            <label for="for_month">Posición</label>
            <input readonly class="form-control" id="for_month" name="position" value="{{$nd}}">
        </fieldset>
    </div>

    <div class="row">
        <fieldset class="form-group col-2">
            <label for="for_value">Nuevo Valor</label>
            <input type="number" class="form-control" id="for_value" placeholder="" name="value" required="" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-5">
            <label for="for_description">Descripción</label>
            <input type="text" class="form-control" id="for_description" name="description" placeholder="Opcional" autocomplete="off">
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>



</form>

@endsection

@section('custom_js')

@endsection