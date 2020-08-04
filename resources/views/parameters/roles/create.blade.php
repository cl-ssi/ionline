@extends('layouts.app')

@section('title', 'Crear nuevo Rol')

@section('content')

@include('parameters/nav')

<h3 class="mb-3">Crear nuevo Rol</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.roles.store') }}">
    @csrf
    @method('POST')

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name"
                placeholder="nombre del rol" name="name" required>
        </fieldset>

    </div>

    @foreach($permissions as $permission)
    	<div class="form-check">
      		<input class="form-check-input" type="checkbox" id="{{$permission->name}}"
                name="permissions[]" value="{{ $permission->name }}">
      		<label class="form-check-label" for="{{$permission->name}}">{{$permission->name}}</label>
    	</div>
    @endforeach

    <button type="submit" class="btn btn-primary mt-3">Guardar</button>
</form>

@endsection

@section('custom_js')

@endsection
