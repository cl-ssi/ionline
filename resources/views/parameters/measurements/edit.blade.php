@extends('layouts.app')

@section('title', 'Editar Ubicación')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Editar Unidad de Medida</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.measurements.update', $measurement) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <fieldset class="form-group col">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name"
            value="{{ $measurement->name }}" name="name" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_prefix">Prefijo</label>
            <input type="text" class="form-control" id="for_prefix"
            value="{{ $measurement->prefix }}" placeholder="Opcional"
            name="prefix">
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.measurements.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
