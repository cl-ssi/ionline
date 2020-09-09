@extends('layouts.app')

@section('title', 'Crear Teléfono Móvil')

@section('content')

<h3 class="mb-3">Crear nuevo Teléfono Móvil</h3>

<form method="POST" class="form-horizontal" action="{{ route('resources.mobile.store') }}">
	{{ csrf_field() }}

	<fieldset class="form-group">
		<label for="forNumero">Número</label>
		<input type="integer" class="form-control" id="forNumero" placeholder="Número" name="number" required="required">
	</fieldset>

	<fieldset class="form-group">
		<label for="forBrand">Marca</label>
		<input type="text" class="form-control" id="forBrand" name="brand" required="required">
	</fieldset>

    <fieldset class="form-group">
        <label for="forModel">Modelo</label>
        <input type="text" class="form-control" id="forModel" name="model" required="required">
    </fieldset>

	<fieldset class="form-group">
		<label for="forUsers">Asignar a:</label>
		<select class="custom-select" id="forUsers" name="user">
			<option></option>
			@foreach($users as $user)
				<option value="{{ $user->id }}">{{ $user->fullName }}</option>
			@endforeach
		</select>
	</fieldset>

    <button type="submit" class="btn btn-primary">Crear</button>
    <a href="{{ route('resources.mobile.index') }}" class="btn btn-outline-dark">Cancelar</a>

</form>

@endsection
