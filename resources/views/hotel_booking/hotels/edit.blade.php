@extends('layouts.bt4.app')

@section('title', 'Editar Recinto')

@section('content')

@include('welfare.nav')

<h3>Editar Recinto</h3>

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<form method="POST" action="{{ route('hotel_booking.hotels.update',$hotel) }}">
	@csrf
	@method('PUT')

	<div class="form-row">

		<fieldset class="form-group col">
		    <label for="for_name">Nombre</label>
		    <input type="text" class="form-control" id="for_name"
				value="{{ $hotel->name }}" name="name" required="required">
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_name">Descripción</label>
		    <input type="text" class="form-control" id="for_description"
				value="{{ $hotel->description }}" name="description" required="required">
		</fieldset>
	</div>

    <div class="form-row">

        @livewire('request-form.commune-region-select')

        <fieldset class="form-group col">
		    <label for="for_name">Dirección</label>
		    <input type="text" class="form-control" id="for_address" name="address" required="required" value="{{ $hotel->address }}">
		</fieldset>

    </div>

    <div class="form-row">

        <fieldset class="form-group col-3">
		    <label for="for_name">Latitud</label>
		    <input type="text" class="form-control" id="for_latitude" name="latitude" required="required" value="{{ $hotel->latitude }}">
		</fieldset>

		<fieldset class="form-group col-3">
		    <label for="for_name">Longitud</label>
		    <input type="text" class="form-control" id="for_longitude" name="longitude" required="required" value="{{ $hotel->longitude }}">
		</fieldset>

        <fieldset class="form-group col-3">
		    <label for="for_manager_email">Correo encargado(a)</label>
		    <input type="text" class="form-control" id="for_manager_email" name="manager_email" value="{{ $hotel->manager_email }}">
		</fieldset>

        <fieldset class="form-group col-3">
		    <label for="for_manager_phone">Teléfono encargado(a)</label>
		    <input type="text" class="form-control" id="for_manager_phone" name="manager_phone" value="{{ $hotel->manager_phone }}">
		</fieldset>

	</div>

	<button type="submit" class="btn btn-primary">Guardar</button>

    @livewire('hotel-booking.upload-imagen',['hotel' => $hotel])
    
</form>
@endsection

@section('custom_js')

@endsection
