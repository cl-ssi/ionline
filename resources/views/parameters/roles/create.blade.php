@extends('layouts.bt4.app')

@section('title', 'Crear nuevo Rol')

@section('content')

<h3 class="mb-3">Crear nuevo Rol</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.roles.store') }}">
    @csrf
    @method('POST')

    <div class="form-row">

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name"
                placeholder="Nombre del rol" name="name" required>
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="for_description">Descripción</label>
            <input type="text" class="form-control" id="for_description"
                placeholder="Descripciól del rol" name="description">
        </fieldset>
    </div>

    @foreach($permissions as $permission)
    	<div class="form-check">
      		<input class="form-check-input" type="checkbox" id="{{$permission->name}}"
                name="permissions[]" value="{{ $permission->name }}">
      		<label class="form-check-label" for="{{$permission->name}}">{{ $permission->name }}</label>
            <br>
            <small class="text-secondary">{{ $permission->description }}</small>
    	</div>
    @endforeach

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Guardar</button>

        <a class="btn btn-outline-secondary" href="{{ route('parameters.roles.index') }}">Volver</a>
    </div>
</form>

@endsection

@section('custom_js')

@endsection
