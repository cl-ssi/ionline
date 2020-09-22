@extends('layouts.app')

@section('title', 'Editar Teléfono Móvil')

@section('content')

<h3 class="mb-3">Editar Teléfono Móvil</h3>

<form method="POST" class="form-horizontal" action="{{ route('resources.mobile.update', $mobile) }}">
	@method('PUT')
	@csrf

	<fieldset class="form-group">
		<label for="forNumero">Número</label>
		<input type="integer" class="form-control" id="forNumero" name="number" value="{{ $mobile->number }}">
	</fieldset>

	<fieldset class="form-group">
		<label for="forBrand">Marca</label>
		<input type="text" class="form-control" id="forBrand" name="brand" value="{{ $mobile->brand }}">
	</fieldset>

    <fieldset class="form-group">
		<label for="forModel">Modelo</label>
		<input type="text" class="form-control" id="forModel" name="model" value="{{ $mobile->model }}">
	</fieldset>

	<fieldset class="form-group">
		<label for="forUsers">Asignar a:</label>
		<select class="custom-select" id="forUsers" name="user">
			<option></option>
			@foreach($users as $user)
				<option value="{{ $user->id }}" @if ($user == $mobile->user) selected="selected" @endif>{{ $user->fullName }}</option>
			@endforeach
		</select>
	</fieldset>

	<fieldset class="form-group">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save" aria-hidden="true"></span> Actualizar</button>

		</form>

		<a href="{{ route('resources.mobile.index') }}" class="btn btn-outline-secondary">Cancelar</a>

		<form method="POST" action="{{ route('resources.mobile.destroy', $mobile) }}" class="d-inline">
			@csrf
            @method('DELETE')
			<button class="btn btn-danger float-right"><span class="fas fa-trash" aria-hidden="true"></span> Eliminar</button>
		</form>

	</fieldset>

@endsection
