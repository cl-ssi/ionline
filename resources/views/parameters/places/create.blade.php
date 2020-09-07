@extends('layouts.app')

@section('title', 'Crear Lugar')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Crear Lugar</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.places.store') }}">
    @csrf

    <div class="row">
        <fieldset class="form-group col">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name"
            placeholder="Ej. Oficina 211" name="name" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_description">Descripción</label>
            <input type="text" class="form-control" id="for_description"
            placeholder="Opcional" name="description">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_location_id">Edificio</label>
            <select name="location_id" id="for_location_id" class="form-control" required>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.places.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
