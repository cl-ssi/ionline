@extends('layouts.app')

@section('title', 'Editar Establecimiento')

@section('content')

@include('hotel_booking.partials.nav')

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

	</div>

	<button type="submit" class="btn btn-primary">Guardar</button>
</form>
@endsection

@section('custom_js')

@endsection
