@extends('layouts.app')

@section('title', 'Asociar usuarios a farmacia')

@section('content')

@include('pharmacies.admin_nav')

<h3>Asociar usuario a farmacia</h3>

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
