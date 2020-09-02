@extends('layouts.app')

@section('title', 'Editar parametro')

@section('content')
<h3 class="mb-3">Editar parametro</h3>

<form method="POST" class="form-horizontal" action="{{ route('indicators.single_parameter.update', $singleParameter) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <fieldset class="form-group col-1">
            <label for="for_law">Ley</label>
            <input type="text" readonly class="form-control-plaintext"
                id="for_law" value="{{ $singleParameter->law }}">
        </fieldset>

        <fieldset class="form-group col-1">
            <label for="for_year">Año</label>
            <input type="text" readonly class="form-control-plaintext"
                id="for_year" value="{{ $singleParameter->year }}">
        </fieldset>

        <fieldset class="form-group col-1">
            <label for="for_indicator">Indicador</label>
            <input type="text" class="form-control" id="for_indicator"
            value="{{ $singleParameter->indicator }}" name="indicator" required>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_type">Tipo</label>
            <select name="type" id="for_type" class="form-control">
                <option value="mensual" {{ $singleParameter->type == 'mensual' ? "selected":"" }}>
                    Mensual</option>
                <option value="semestral" {{ $singleParameter->type == 'semestral' ? "selected":"" }}>
                    Semestral</option>
                <option value="anual" {{ $singleParameter->type == 'anual' ? "selected":"" }}>
                    Anual</option>
                <option value="acumulada" {{ $singleParameter->type == 'acumulada' ? "selected":"" }}>
                    Acumulada</option>
            </select>
        </fieldset>


        <fieldset class="form-group col-1">
            <label for="for_month">Mes</label>
            <input type="number" class="form-control" id="for_month" name="month"
            value="{{ $singleParameter->month }}">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_position">Posición</label>
            <select name="position" id="for_position" class="form-control">
                <option></option>
                <option value="numerador" {{ $singleParameter->position == 'numerador' ? "selected":"" }}>
                    Numerador</option>
                <option value="denominador" {{ $singleParameter->position == 'denominador' ? "selected":"" }}>
                    Denominador</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_establishment">Establecimiento</label>
            <select name="establishment_id" id="for_establishment_id" class="form-control">
                @foreach($establishments as $estab)
                    <option value="{{ $estab->id }}" {{ $singleParameter->establishment->id ==  $estab->id ? "selected":"" }}>
                        {{ $estab->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_value">Valor</label>
            <input type="text" class="form-control text-right" id="for_value" name="value"
            value="{{ $singleParameter->value}}" required>
        </fieldset>

    </div>
    <div class="row">
        <fieldset class="form-group col">
            <label for="for_description">Descripción</label>
            <input type="text" class="form-control" name="description"
                id="for_description" value="{{ $singleParameter->description}}">
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary float-right">Guardar</button>


</form>

@endsection

@section('custom_js')

@endsection
