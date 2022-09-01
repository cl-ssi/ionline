@extends('layouts.app')

@section('title', 'Crear Ubicación')

@section('content')

<h3 class="mb-3">Crear Ubicación</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.locations.store') }}">
    @csrf

    <div class="form-row">
        <fieldset class="form-group col-md col-sm-12">
            <label for="for_name">Nombre*</label>
            <input
                type="text"
                class="form-control"
                id="for_name"
                placeholder="Ej: Cosam 1, Edificio 3, Cesfam"
                name="name"
                required
            >
        </fieldset>

        <fieldset class="form-group col-md col-sm-12">
            <label for="for_address">Dirección</label>
            <input
                type="text"
                class="form-control"
                id="for_address"
                placeholder="Opcional"
                name="address"
            >
        </fieldset>
    </div>
    
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.locations.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
