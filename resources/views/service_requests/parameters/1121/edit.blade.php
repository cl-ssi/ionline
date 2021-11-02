@extends('layouts.app')

@section('title', 'Editar Ubicación')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Editar Ubicación</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.locations.update', $location) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <fieldset class="form-group col">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name"
            value="{{ $location->name }}" name="name" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_address">Dirección</label>
            <input type="text" class="form-control" id="for_address"
            value="{{ $location->address }}" placeholder="Opcional"
            name="address">
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.locations.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
