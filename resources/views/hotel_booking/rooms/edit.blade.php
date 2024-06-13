@extends('layouts.bt4.app')

@section('title', 'Editar Hospedaje')

@section('content')

@include('welfare.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<form method="POST" action="{{ route('hotel_booking.rooms.update',$room) }}">
	@csrf
	@method('PUT')

	<div class="form-row">

        <fieldset class="form-group col-3">
		    <label for="for_hotel_id">Recinto</label>
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
		    <label for="for_identifier">Identificador</label>
		    <input type="text" class="form-control" id="for_identifier" name="identifier" required="required" value="{{$room->identifier}}">
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_description">Descripción</label>
		    <input type="text" class="form-control" id="for_description" name="description" required="required" value="{{$room->description}}">
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_max_days_avaliable">Días max. reserva</label>
		    <input type="number" class="form-control" id="for_max_days_avaliable" name="max_days_avaliable" required="required" value="{{$room->max_days_avaliable}}">
		</fieldset>

    </div>

    <div class="form-row">

		<fieldset class="form-group col">
		    <label for="for_name">Cantidad - Cama Simple</label>
		    <input type="number" class="form-control" id="for_single_bed" name="single_bed" value="{{$room->single_bed}}" required>
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_name">Cantidad - Cama Doble</label>
		    <input type="number" class="form-control" id="for_description" name="double_bed" value="{{$room->double_bed}}" required>
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_price">Precio</label>
		    <input type="text" class="form-control" id="for_price" placeholder="Valor diario del hospedaje" value="{{$room->price}}" name="price" required="required">
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_status">Estado</label>
		    <select class="form-control" name="status" id="for_status">
                <option value="1" @selected($room->status == 1)>Activo</option>
                <option value="0" @selected($room->status == 0)>Desactivado</option>
            </select>
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
