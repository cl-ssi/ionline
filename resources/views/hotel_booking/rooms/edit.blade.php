@extends('layouts.app')

@section('title', 'Editar Hospedaje')

@section('content')

@include('hotel_booking.partials.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<form method="POST" action="{{ route('hotel_booking.rooms.update',$room) }}">
	@csrf
	@method('PUT')

	<div class="form-row">

        <fieldset class="form-group col-3">
		    <label for="for_hotel_id">Hotel</label>
		    <select class="form-control" name="hotel_id" id="for_hotel_id">
                @foreach($hotels as $hotel)
                    <option value="{{$hotel->id}}" @if($hotel->id == $room->hotel_id) selected @endif>{{$hotel->name}}</option>
                @endforeach
            </select>
		</fieldset>

        <fieldset class="form-group col-3">
		    <label for="for_room_type_id">Tipo</label>
		    <select class="form-control" name="room_type_id" id="for_room_type_id">
                @foreach($roomTypes as $roomType)
                    <option value="{{$roomType->id}}" @if($roomType->id == $room->room_type_id) selected @endif>{{$roomType->name}}</option>
                @endforeach
            </select>
		</fieldset>
    
    </div>

    <div class="form-row">

		<fieldset class="form-group col">
		    <label for="for_name">Identificador</label>
		    <input type="text" class="form-control" id="for_identifier" name="identifier" required="required" value="{{$room->identifier}}">
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_name">Descripción</label>
		    <input type="text" class="form-control" id="for_description" name="description" required="required" value="{{$room->description}}">
		</fieldset>

    </div>

    <div class="form-row">

		<fieldset class="form-group col">
		    <label for="for_name">Cantidad - Cama Simple</label>
		    <input type="numeric" class="form-control" id="for_single_bed" name="single_bed" value="{{$room->single_bed}}" required>
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_name">Cantidad - Cama Doble</label>
		    <input type="numeric" class="form-control" id="for_description" name="double_bed" value="{{$room->double_bed}}" required>
		</fieldset>

    </div>

    @livewire('hotel-booking.add-services',['room' => $room])

    <hr>

	<button type="submit" class="btn btn-primary">Guardar</button>

    @livewire('hotel-booking.upload-imagen',['room' => $room])

</form>
@endsection

@section('custom_js')

@endsection
