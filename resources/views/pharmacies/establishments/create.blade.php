@extends('layouts.app')

@section('title', 'Crear Establecimiento Farmacia')

@section('content')

@include('pharmacies.nav')

<h3>Nuevo Establecimiento Farmacia</h3>

<form method="POST" action="{{ route('pharmacies.establishments.store') }}" enctype="multipart/form-data">
	@csrf

	<div class="row">

		<fieldset class="form-group col">
		    <label for="for_name">Nombre</label>
		    <input type="text" class="form-control" id="for_name" placeholder="Nombre del establecimiento" name="name" required="required">
		</fieldset>

	</div>

	<button type="submit" class="btn btn-primary">Crear</button>
</form>

@endsection

@section('custom_js')

@endsection
