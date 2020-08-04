@extends('layouts.app')

@section('title', 'Editar Rol')

@section('content')

@include('parameters/nav')

<h3 class="mb-3">Editar Rol</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.roles.update', $role->id) }}">
    @csrf
    @method('PUT')

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name" name="name"
                value="{{ $role->name }}" required>
        </fieldset>

    </div>

    @foreach($permissions as $permission)
    	<div class="form-check">
      		<input class="form-check-input" type="checkbox" id="{{$permission->name}}"
                name="permissions[]" value="{{ $permission->name }}"
                {{ $role->hasPermissionTo($permission->name) ? 'checked':'' }} >
      		<label class="form-check-label" for="{{$permission->name}}">{{$permission->name}}</label>
    	</div>
    @endforeach

    <button type="submit" class="btn btn-primary mt-3 float-left">Guardar</button>

</form>

<form method="POST" class="form-horizontal" action="{{ route('parameters.roles.destroy', $role) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger float-right">Eliminar</button>
</form>

@endsection
