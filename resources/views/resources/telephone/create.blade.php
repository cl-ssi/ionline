@extends('layouts.app')

@section('title', 'Crear Telefono')

@section('content')

<h3 class="mb-3">Crear nuevo Teléfono</h3>

<form method="POST" class="form-horizontal" action="{{ route('resources.telephone.store') }}">
	@csrf

	<fieldset class="form-group">
		<label for="forNumero">Número*</label>
		<input type="integer" class="form-control" id="forNumero" placeholder="Número" name="number" required="required">
	</fieldset>

	<fieldset class="form-group">
		<label for="forMinsal">Minsal*</label>
		<input type="integer" class="form-control" id="forMinsal" placeholder="Anexo Minsal" name="minsal" required="required">
	</fieldset>

	<fieldset class="form-group">
		<label for="forMac">MAC</label>
		<input type="integer" class="form-control" id="forMac" name="mac" maxlength="17">
	</fieldset>

	<fieldset class="form-group">
	    <label for="for_places">Lugares</label>
	    <select name="place_id" id="for_place_id" class="form-control">
			@foreach($places as $place)
	        <option value="{{ $place->id }}">{{ $place->location->name }} -> {{ $place->name }}</option>
			@endforeach
	    </select>
	</fieldset>

	<fieldset class="form-group">
		<label for="forUsers">Asignar a persona:</label>
		<select size="9" multiple class="custom-select" id="forUsers" name="users[]">
			@foreach($users as $user)
				<option value="{{ $user->id }}">{{ $user->FullName }}</option>
			@endforeach
		</select>
		<small class="form-text text-muted">
			Ctrl + Click para deseleccionar un usuario o seleccionar más de uno
		</small>
	</fieldset>

    <button type="submit" class="btn btn-primary">Crear</button>

    <a href="{{ route('resources.telephone.index') }}" class="btn btn-outline-dark">Cancelar</a>

</form>

@endsection
