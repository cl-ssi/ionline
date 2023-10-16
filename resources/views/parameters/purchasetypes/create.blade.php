@extends('layouts.bt4.app')

@section('title', 'Crear Tipo de Compra')

@section('content')

<h3 class="mb-3">Crear Tipo de Compra</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.purchasetypes.store') }}">
    @csrf

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name" name="name">
        </fieldset>
        <fieldset class="form-group col">
            <label for="for_name">Días Hábiles Finanza</label>
            <input type="number" class="form-control" id="for_name" name="finance_business_day">
        </fieldset>
        <fieldset class="form-group col">
            <label for="for_name">Días Corridos Abastecimiento</label>
            <input type="number" class="form-control" id="for_name" name="supply_continuous_day">
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.purchasetypes.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
