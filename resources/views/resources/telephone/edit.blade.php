@extends('layouts.app')

@section('title', 'Editar Telefono')

@section('content')

<h3 class="mb-3">Editar Teléfono</h3>

<form method="POST" class="form-horizontal" action="{{ route('resources.telephone.update',$telephone) }}">
	@method('PUT')
	@csrf

	<fieldset class="form-group">
		<label for="forNumero">Número*</label>
		<input type="integer" class="form-control" id="forNumero" name="number" value="{{ $telephone->number }}">
	</fieldset>

	<fieldset class="form-group">
		<label for="forMinsal">Minsal*</label>
		<input type="integer" class="form-control" id="forMinsal" name="minsal" value="{{ $telephone->minsal }}">
	</fieldset>

	<fieldset class="form-group">
		<label for="forMac">MAC</label>
		<input type="integer" class="form-control" id="forMac" name="mac" value="{{ $telephone->mac }}" maxlength="17">
	</fieldset>

	<fieldset class="form-group">
	    <label for="for_places">Lugares</label>
	    <select name="place_id" id="for_place_id" class="form-control">
			<option></option>
			@foreach($places as $place)
	        <option value="{{ $place->id }}" {{ ($telephone->place_id == $place->id)?'selected':'' }} >
				{{ $place->location->name }} -> {{ $place->name }}
			</option>
			@endforeach
	    </select>
	</fieldset>

	<fieldset class="form-group">
		<label for="forUsers">Asignar a persona:</label>
		<select size="9" multiple class="custom-select" id="forUsers" name="users[]">
			@foreach($users as $user)
				<option value="{{ $user->id }}" @if ($user->telephones->contains($telephone->id)) selected="selected" @endif>{{ $user->FullName }}</option>
			@endforeach
		</select>
		<small class="form-text text-muted">
			Ctrl + Click para deseleccionar un usuario o seleccionar más de uno
		</small>
	</fieldset>

	<fieldset class="form-group">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save" aria-hidden="true"></span> Actualizar</button>

		</form>

		<a href="{{ route('resources.telephone.index') }}" class="btn btn-outline-secondary">Cancelar</a>

		<form method="POST" action="{{ route('resources.telephone.destroy', $telephone->id) }}" class="d-inline">
			@csrf
            @method('DELETE')
			<button class="btn btn-danger float-right"><span class="fas fa-trash" aria-hidden="true"></span> Eliminar</button>
		</form>

	</fieldset>

@endsection
