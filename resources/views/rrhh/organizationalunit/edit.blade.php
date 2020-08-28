@extends('layouts.app')

@section('title', 'Editar Unidad Organizacional')

@section('content')

<h3>Editar Unidad Organizacional</h3>

<form method="POST" class="form-horizontal" action="{{ route('rrhh.organizational-units.update',$organizationalUnit->id) }}">
	{{ method_field('PUT') }} {{ csrf_field() }}

	<fieldset class="form-group">
		<label for="forName">Nombre</label>
		<input type="text" class="form-control" id="forName" name="name" value="{{ $organizationalUnit->name }}">
	</fieldset>

	<fieldset class="form-group">
		<label for="forFather">Depende de</label>
		<select class="custom-select" id="forFather" name="father">
			@foreach($organizationalUnits as $ou)
				<option value="{{ $ou->id }}" @if ($organizationalUnit->father == $ou) selected="selected" @endif>{{ $ou->name }}</option>
			@endforeach
		</select>
	</fieldset>

	<fieldset class="form-group">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save" aria-hidden="true"></span> Actualizar</button>

		</form>

		<a href="{{ route('rrhh.organizational-units.index') }}" class="btn btn-outline-dark">Cancelar</a>

		<form method="POST" action="{{ route('rrhh.organizational-units.destroy', $organizationalUnit->id) }}" class="d-inline">
			{{ method_field('DELETE') }} {{ csrf_field() }}
			<button class="btn btn-danger"><span class="fas fa-trash" aria-hidden="true"></span> Eliminar</button>
		</form>

	</fieldset>

@endsection
