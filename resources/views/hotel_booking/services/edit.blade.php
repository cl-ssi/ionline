@extends('layouts.bt4.app')

@section('title', 'Editar Establecimiento')

@section('content')

@include('welfare.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<form method="POST" action="{{ route('hotel_booking.services.update',$service) }}">
	@csrf
	@method('PUT')

	<div class="form-row">

		<fieldset class="form-group col">
		    <label for="for_name">Nombre</label>
		    <input type="text" class="form-control" id="for_name"
				value="{{ $service->name }}" name="name" required="required">
		</fieldset>

	</div>

	<button type="submit" class="btn btn-primary">Guardar</button>
</form>
@endsection

@section('custom_js')

@endsection
