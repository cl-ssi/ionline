@extends('layouts.app')

@section('title', 'Editar Rol')

@section('content')

@include('parameters/nav')

<h3 class="mb-3">Editar Rol</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.roles.update', $role->id) }}">
    @csrf
    @method('PUT')

    <div class="form-row">

        <fieldset class="form-group col">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name" name="name"
                value="{{ $role->name }}" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_description">Descripción</label>
            <input type="text" class="form-control" id="for_description" name="description"
                value="{{ $role->description }}">
        </fieldset>

    </div>

    @foreach($permissions as $name => $id)
    	<div class="form-check">
      		<input class="form-check-input" type="checkbox" id="{{ $name }}"
                name="permissions[]" value="{{ $name }}"
                {{ $role->hasPermissionTo($name) ? 'checked':'' }} >
      		<label class="form-check-label" for="{{ $name }}">{{ $name }}</label>
    	</div>
    @endforeach

    <button type="submit" class="btn btn-primary mt-3 float-left">Guardar</button>

</form>

<form method="POST" class="form-horizontal" action="{{ route('parameters.roles.destroy', $role) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger mt-3 float-right">Eliminar</button>
</form><br><br>

@endsection
