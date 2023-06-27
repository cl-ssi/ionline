@extends('layouts.app')

@section('title', 'Crear Establecimiento Farmacia')

@section('content')

@include('hotel_booking.partials.nav')

<h3>Nueva Habitación</h3>

<form method="POST" action="{{ route('hotel_booking.rooms.store') }}" enctype="multipart/form-data">
	@csrf

	<div class="form-row">

        <fieldset class="form-group col-3">
		    <label for="for_hotel_id">Hotel</label>
		    <select class="form-control" name="hotel_id" id="for_hotel_id">
                @foreach($hotels as $hotel)
                    <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                @endforeach
            </select>
		</fieldset>

        <fieldset class="form-group col-3">
		    <label for="for_room_type_id">Tipo</label>
		    <select class="form-control" name="room_type_id" id="for_room_type_id">
                @foreach($roomTypes as $roomType)
                    <option value="{{$roomType->id}}">{{$roomType->name}}</option>
                @endforeach
            </select>
		</fieldset>
    
    </div>

    <div class="form-row">

		<fieldset class="form-group col">
		    <label for="for_name">Identificador</label>
		    <input type="text" class="form-control" id="for_identifier" name="identifier" required="required" placeholder="Identificador interno, por ejemplo Cabaña 1, Habitación 202, etc.">
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_name">Descripción</label>
		    <input type="text" class="form-control" id="for_description" placeholder="Agregue una breve descripción del hotel" name="description" required="required">
		</fieldset>

    </div>

	<button type="submit" class="btn btn-primary">Crear</button>
</form>

@endsection

@section('custom_js')

@endsection
