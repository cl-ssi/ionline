@extends('layouts.app')

@section('title', 'Editar Permiso')

@section('content')

@include('parameters/nav')

<h3 class="mb-3">Editar Permiso</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.permissions.update', $permission->id) }}">
    @csrf
    @method('PUT')

    <div class="row">

        <fieldset class="form-group col-6 col-md-3">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name" name="name"
                value="{{ $permission->name }}" required>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_guard_name">Guard</label>
            <input type="text" class="form-control" id="for_guard_name" name="guard_name"
                value="{{ $permission->guard_name }}" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-7">
            <label for="for_description">Descripción</label>
            <input type="text" class="form-control" id="for_description" name="description"
                value="{{ $permission->description }}" required>
        </fieldset>
    </div>



    <button type="submit" class="btn btn-primary float-left">Guardar</button>

</form>

<form method="POST" class="form-horizontal" action="{{ route('parameters.permissions.destroy', $permission) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger float-right">Eliminar</button>
</form>

@endsection
