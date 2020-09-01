@extends('layouts.app')

@section('title', 'Editar Lugar')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Editar Lugar</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.places.update', $place) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <fieldset class="form-group col">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name"
            value="{{ $place->name }}" name="name" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_description">Descripción</label>
            <input type="text" class="form-control" id="for_description"
            value="{{ $place->description }}" placeholder="Opcional"
            name="description">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_location_id">Edificio</label>
            <select name="location_id" id="for_location_id" class="form-control" required>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}"
                        {{ $location->id == $place->location_id ? 'selected': '' }}>
                        {{ $location->name }}
                    </option>
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
