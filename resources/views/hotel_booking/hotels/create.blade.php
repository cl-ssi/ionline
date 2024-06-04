@extends('layouts.bt4.app')

@section('title', 'Crear Recinto')

@section('content')

@include('welfare.nav')

<h3>Nuevo Recinto</h3>

<form method="POST" action="{{ route('hotel_booking.hotels.store') }}" enctype="multipart/form-data">
	@csrf

	<div class="form-row">

		<fieldset class="form-group col">
		    <label for="for_name">Nombre</label>
		    <input type="text" class="form-control" id="for_name" name="name" required="required">
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_name">Descripción</label>
		    <input type="text" class="form-control" id="for_description" placeholder="Agregue una breve descripción del recinto" name="description" required="required">
		</fieldset>

    </div>

    <div class="form-row">

        @livewire('request-form.commune-region-select')

        <fieldset class="form-group col">
		    <label for="for_name">Dirección</label>
		    <input type="text" class="form-control" id="for_address" name="address" required="required">
		</fieldset>

    </div>

    <div class="form-row">

        <fieldset class="form-group col-3">
		    <label for="for_name">Latitud</label>
		    <input type="text" class="form-control" id="for_latitude" name="latitude" required="required">
		</fieldset>

		<fieldset class="form-group col-3">
		    <label for="for_name">Longitud</label>
		    <input type="text" class="form-control" id="for_longitude" name="longitude" required="required">
		</fieldset>

        <fieldset class="form-group col-3">
		    <label for="for_manager_email">Correo encargado(a)</label>
		    <input type="text" class="form-control" id="for_manager_email" name="manager_email">
		</fieldset>

        <fieldset class="form-group col-3">
		    <label for="for_manager_phone">Teléfono encargado(a)</label>
		    <input type="text" class="form-control" id="for_manager_phone" name="manager_phone">
		</fieldset>

	</div>

	<button type="submit" class="btn btn-primary">Crear</button>
</form>

@endsection

@section('custom_js')

@endsection
