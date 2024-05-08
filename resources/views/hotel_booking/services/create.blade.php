@extends('layouts.bt4.app')

@section('title', 'Crear Establecimiento Farmacia')

@section('content')

@include('welfare.nav')

<h3>Nuevo Hotel</h3>

<form method="POST" action="{{ route('hotel_booking.services.store') }}" enctype="multipart/form-data">
	@csrf

	<div class="form-row">

		<fieldset class="form-group col">
		    <label for="for_name">Nombre</label>
		    <input type="text" class="form-control" id="for_name" name="name" required="required">
		</fieldset>

    </div>

	<button type="submit" class="btn btn-primary">Crear</button>
</form>

@endsection

@section('custom_js')

@endsection
