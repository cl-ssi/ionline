@extends('layouts.bt4.app')

@section('title', 'Editar Permiso')

@section('content')

<h3 class="mb-3">Editar Permiso</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.permissions.update', $permission->id) }}">
    @csrf
    @method('PUT')

    <div class="form-row">

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name" name="name"
                value="{{ $permission->name }}" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-6">
            <label for="for_description">Descripción</label>
            <input type="text" class="form-control" id="for_description" name="description"
                value="{{ $permission->description }}" required>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_guard_name">Guard</label>
            <input type="text" class="form-control" id="for_guard_name" name="guard_name" readonly
                value="{{ $permission->guard_name }}" required>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.permissions.index', $permission->guard_name) }}">Volver</a>

</form>

<form method="POST" class="form-horizontal" action="{{ route('parameters.permissions.destroy', $permission) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger float-right">Eliminar</button>
</form>

@endsection
