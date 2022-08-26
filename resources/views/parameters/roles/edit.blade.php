@extends('layouts.app')

@section('title', 'Editar Rol')

@section('content')

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

    @foreach($permissions as $permission)
    	<div class="form-check">
      		<input class="form-check-input" type="checkbox" id="{{ $permission->name }}"
                name="permissions[]" value="{{ $permission->name }}"
                {{ $role->hasPermissionTo($permission->name) ? 'checked':'' }} >
      		<label class="form-check-label" for="{{ $permission->name }}">{{ $permission->name }}</label>
            <br>
            <small class="text-secondary">{{ $permission->description }}</small>
    	</div>
    @endforeach

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Guardar</button>

        <a class="btn btn-outline-secondary" href="{{ route('parameters.roles.index') }}">Volver</a>
    </div>
    
</form>

<form method="POST" class="form-horizontal" action="{{ route('parameters.roles.destroy', $role) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger float-right">Eliminar</button>
</form><br><br>

@endsection
