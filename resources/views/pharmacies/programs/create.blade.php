@extends('layouts.app')

@section('title', 'Crear Programa Farmacia')

@section('content')

@include('pharmacies.nav')

<h3>Nuevo Programa Farmacia</h3>

<form method="POST" action="{{ route('pharmacies.programs.store') }}" enctype="multipart/form-data">
	@csrf

	<div class="row">

		<fieldset class="form-group col">
		    <label for="for_name">Nombre</label>
		    <input type="text" class="form-control" id="for_name" placeholder="Nombre del programa" name="name" required="required">
		</fieldset>

	</div>

	<button type="submit" class="btn btn-primary">Crear</button>
</form>

@endsection

@section('custom_js')

@endsection
