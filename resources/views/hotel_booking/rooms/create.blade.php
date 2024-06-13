@extends('layouts.bt4.app')

@section('title', 'Crear Hospedaje')

@section('content')

@include('welfare.nav')

<h3>Nuevo Hospedaje</h3>

<form method="POST" action="{{ route('hotel_booking.rooms.store') }}" enctype="multipart/form-data">
	@csrf

	<div class="form-row">

        <fieldset class="form-group col-3">
		    <label for="for_hotel_id">Recinto</label>
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
		    <label for="for_identifier">Identificador</label>
		    <input type="text" class="form-control" id="for_identifier" name="identifier" required="required" placeholder="Identificador interno, por ejemplo Cabaña 1, Habitación 202, etc.">
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_description">Descripción</label>
		    <input type="text" class="form-control" id="for_description" placeholder="Agregue una breve descripción del recinto" name="description" required="required">
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_max_days_avaliable">Días max. reserva</label>
		    <input type="number" class="form-control" id="for_max_days_avaliable" name="max_days_avaliable" required="required">
		</fieldset>

    </div>

    <div class="form-row">

		<fieldset class="form-group col">
		    <label for="for_single_bed">Cantidad - Cama Simple</label>
		    <input type="number" class="form-control" id="for_single_bed" name="single_bed">
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_double_bed">Cantidad - Cama Doble</label>
		    <input type="number" class="form-control" id="for_double_bed" name="double_bed">
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_price">Precio</label>
		    <input type="text" class="form-control" id="for_price" placeholder="Valor diario del hospedaje" name="price" required="required">
		</fieldset>

        <fieldset class="form-group col">
		    <label for="for_status">Estado</label>
		    <select class="form-control" name="status" id="for_status">
                <option value="1">Activo</option>
                <option value="0">Desactivado</option>
            </select>
		</fieldset>

    </div>

	<button type="submit" class="btn btn-primary">Crear</button>
</form>

@endsection

@section('custom_js')

@endsection
