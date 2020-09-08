@extends('layouts.app')

@section('title', 'Crear Impresora')

@section('content')

<h3 class="mb-3">Crear nueva Impresora</h3>

<form method="POST" class="form-horizontal" action="{{ route('resources.printer.store') }}">
	@csrf

	<label for="forBrand">Tipo</label>
	<fieldset class="form-group">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="RadioType1" value="printer" required checked>
            <label class="form-check-label" for="inlineRadio1"><i class="fas fa-print"></i> Impresora</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="RadioType2" value="scanner" required>
            <label class="form-check-label" for="inlineRadio2"><i class="far fa-copy"></i> Scanner</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="RadioType3" value="plotter" required>
            <label class="form-check-label" for="inlineRadio2"><i class="fas fa-memory"></i> Plotter</label>
        </div>
  </fieldset>

	<div class="row">
		<fieldset class="form-group col">
			<label for="forBrand">Marca</label>
			<input type="text" class="form-control" id="forBrand" placeholder="Marca" name="brand" required="required">
		</fieldset>

		<fieldset class="form-group col">
			<label for="forModel">Modelo</label>
			<input type="text" class="form-control" id="forModel" placeholder="Modelo del equipo" name="model" required="required">
		</fieldset>

		<fieldset class="form-group col">
			<label for="forSerial">Serial</label>
			<input type="text" class="form-control" id="forSerial" placeholder="Serial del equuipo" name="serial" required="required">
		</fieldset>
	</div>

	<div class="row">
		<fieldset class="form-group col">
			<label for="forIP">Número IP</label>
			<input type="IP" class="form-control" id="forIP" placeholder="10.x.x.x" name="ip" required="required">
		</fieldset>

		<fieldset class="form-group col">
			<label for="for_mac_address">Dirección MAC</label>
			<input type="text" class="form-control" id="for_mac_address" placeholder="00:1B:2C:3D:xx:xx" name="mac_address" required="required">
		</fieldset>
	</div>

	<div class="row">
		<fieldset class="form-group col">
			<label for="forComment">Comentario</label>
			<input type="text" class="form-control" id="forComment" name="comment">
		</fieldset>

		<fieldset class="form-group col">
			<label for="for_active_type">Tipo de Activo</label>
			<select class="form-control" id="for_active_type" name="active_type">
				<option value="leased">Arrendado</option>
				<option value="own">Propio</option>
				<option value="user">Usuario</option>
			</select>
		</fieldset>

    <fieldset class="form-group col">
			<label for="for_status">Estado</label>
			<select class="form-control" id="for_status" name="status">
				<option value="active">Activo</option>
				<option value="inactive">Inactive</option>
			</select>
		</fieldset>
	</div>

  <hr class="mt-4">

	<div class="row">
		<fieldset class="form-group col">
			<label for="forUsers">Asignar a persona:</label>
			<select size="9" multiple class="custom-select" id="forUsers" name="users[]">
				@foreach($users as $user)
					<option value="{{ $user->id }}">{{ $user->FullName }}</option>
				@endforeach
			</select>
			<small class="form-text text-muted">
				Ctrl + Click para deseleccionar un usuario o seleccionar más de uno
			</small>
		</fieldset>

		<fieldset class="form-group col">
			<label for="for_place_id">Asignar a lugar:</label>
			<select class="form-control" id="for_place_id" name="place_id">
				<option readonly></option>
				@foreach($places as $place)
					<option value="{{ $place->id }}">{{ $place->location->name }} - {{ $place->name }}</option>
				@endforeach
			</select>
		</fieldset>
	</div>

    <button type="submit" class="btn btn-primary">Crear</button>
    <a href="{{ route('resources.printer.index') }}" class="btn btn-outline-dark">Volver</a>
</form>

@endsection
