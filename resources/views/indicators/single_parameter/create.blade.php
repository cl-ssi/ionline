@extends('layouts.app')

@section('title', 'Crear nuevo parametro')

@section('content')
<h3 class="mb-3">Crear nuevo parametro</h3>

<form method="POST" class="form-horizontal" action="{{ route('indicators.single_parameter.store') }}">
    @csrf

    <div class="row">
        <fieldset class="form-group col">
            <label for="for_law">Ley</label>
            <select name="law" id="for_law" class="form-control" required>
                <option value="18834">Ley 18.834</option>
                <option value="19664">Ley 19.664</option>
                <option value="19813">Ley 19.813</option>
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_year">Año</label>
            <select name="year" id="for_year" class="form-control" required>
                <option value="2020">2020</option>
                <option value="2019">2019</option>
                <option value="2018">2018</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-5">
            <label for="for_description">Descripción</label>
            <input type="text" class="form-control" id="for_description" name="description">
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_establishment_id">Establecimiento</label>
            <select name="establishment_id" id="for_establishment_id" class="form-control">
                @foreach($establishments as $estab)
                <option value="{{ $estab->id }}">{{ $estab->name }}</option>
                @endforeach
            </select>
        </fieldset>

    </div>

    <div class="row">

        <fieldset class="form-group col-2">
            <label for="for_indicator">Numero de indicador</label>
            <input type="text" class="form-control" id="for_indicator" placeholder="" name="indicator" required>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_type">Tipo</label>
            <select name="type" id="for_type" class="form-control">
                <option value="mensual">Mensual</option>
                <option value="semestral">Semestral</option>
                <option value="anual">Anual</option>
                <option value="acumulada">Acumulada</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_month">Mes</label>
            <input type="number" class="form-control" id="for_month" name="month">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_position">Posición</label>
            <select name="position" id="for_position" class="form-control">
                <option></option>
                <option value="numerador">Numerador</option>
                <option value="denominador">Denominador</option>
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_value">Valor</label>
            <input type="text" class="form-control" id="for_value" placeholder="" name="value" required="">
        </fieldset>


    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>



</form>

@endsection

@section('custom_js')

@endsection
