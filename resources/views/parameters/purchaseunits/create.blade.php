@extends('layouts.bt4.app')

@section('title', 'Crear Unidad de Compra')

@section('content')

<h3 class="mb-3">Crear Unidad de Compra</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.purchaseunits.store') }}">
    @csrf

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name" name="name">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_supply_continuous_day">Días Continuos</label>
            <input type="number" class="form-control" id="for_supply_continuous_day" name="supply_continuous_day">
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.purchaseunits.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
