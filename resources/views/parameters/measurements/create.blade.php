@extends('layouts.app')

@section('title', 'Crear Unidad de Medida')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Crear Unidad de Medida</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.measurements.store') }}">
    @csrf

    <div class="row">
        <fieldset class="form-group col">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name"
            placeholder="Ej: Cosam 1, Edificio 3, Cesfam" name="name" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_address">Prefijo</label>
            <input type="text" class="form-control" id="for_address"
            placeholder="Opcional" name="prefix">
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.measurements.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
