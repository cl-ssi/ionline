@extends('layouts.app')

@section('title', 'Editar Programa')

@section('content')

@include('pharmacies.nav')

<form method="POST" action="{{ route('pharmacies.programs.update',$program) }}">
	@csrf
	@method('PUT')

	<div class="row">

		<fieldset class="form-group col">
		    <label for="for_name">Nombre</label>
		    <input type="text" class="form-control" id="for_name"
				value="{{ $program->name }}" name="name" required="required">
		</fieldset>

	</div>

	<button type="submit" class="btn btn-primary">Crear</button>
</form>
@endsection

@section('custom_js')

@endsection
