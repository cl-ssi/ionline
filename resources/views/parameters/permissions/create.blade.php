@extends('layouts.bt4.app')

@section('title', 'Crear nuevo Permisos')

@section('content')

<h3 class="mb-3">Crear nuevo Permisos</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.permissions.store') }}">
    @csrf
    @method('POST')

    <div class="form-row">

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name" name="name" autocomplete="off" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-6">
            <label for="for_description">Descripción</label>
            <input type="text" class="form-control" id="for_description" autocomplete="off" name="description">
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_guard_name">Guard</label>
            <input type="text" class="form-control" id="for_guard_name" name="guard_name" readonly
                value="{{$guard}}">
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.permissions.index', 'web') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
