@extends('layouts.bt4.app')

@section('title', 'Crear destino farmacia')

@section('content')

@include('pharmacies.nav')

<h3>Nuevo destino Farmacia</h3>

<form method="POST" action="{{ route('pharmacies.destines.store') }}" enctype="multipart/form-data">
	@csrf

	<div class="form-row">

		<fieldset class="form-group col">
		    <label for="for_name">Nombre</label>
		    <input type="text" class="form-control" id="for_name" placeholder="Nombre del destino" name="name" required="required">
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_name">Correo electrónico</label>
		    <input type="text" class="form-control" id="for_name" placeholder="Correo electrónico" name="email" required="required">
		</fieldset>

	</div>

	<button type="submit" class="btn btn-primary">Crear</button>
</form>

@endsection

@section('custom_js')

@endsection
