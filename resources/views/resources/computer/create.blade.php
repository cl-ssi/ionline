@extends('layouts.app')

@section('title', 'Crear Computador')

@section('content')

<h3 class="mb-3">Crear nuevo Computador</h3>

<form method="POST" class="form-horizontal" action="{{ route('resources.computer.store') }}">
	@csrf

	<label for="forBrand">Tipo</label>
	<fieldset class="form-group">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="RadioType1" value="desktop" required>
            <label class="form-check-label" for="inlineRadio1"><i class="fas fa-desktop"></i> Desktop</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="RadioType2" value="all-in-one" required>
            <label class="form-check-label" for="inlineRadio2"><i class="fas fa-tv"></i> All in one</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="RadioType3" value="notebook" required>
            <label class="form-check-label" for="inlineRadio2"><i class="fas fa-laptop"></i> Notebook</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="RadioType4" value="other" required>
            <label class="form-check-label" for="inlineRadio2">Otro</label>
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
			<label for="for_hostname">Hostname</label>
			<input type="text" class="form-control" id="for_hostname" name="hostname">
		</fieldset>

		<fieldset class="form-group col">
			<label for="for_domain">Dominio</label>
			<input type="text" class="form-control" id="for_domain" name="domain">
		</fieldset>

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
			<label for="for_operating_system">Sistema Operativo</label>
			<input type="text" class="form-control" id="for_operating_system" placeholder="Ej: Windows 7, Windows 10, Linux, etc." name="operating_system" required="required">
		</fieldset>

		<fieldset class="form-group col">
			<label for="for_processorr">Procesador</label>
			<input type="integer" class="form-control" id="for_processor" name="processor" placeholder="Ej: I7 3.6GHz" required="required">
		</fieldset>

		<fieldset class="form-group col">
			<label for="for_ram">RAM</label>
			<input type="text" class="form-control" id="for_ram" name="ram" placeholder="Ej: 8GB" required="required">
		</fieldset>

		<fieldset class="form-group col">
			<label for="for_hard_disk">Disco Duro</label>
			<input type="text" class="form-control" id="for_hard_disk" name="hard_disk" placeholder="Ej: 1TB" required="required">
		</fieldset>
	</div>

	<div class="row">
		<fieldset class="form-group col">
			<label for="for_inventory_number">Número de Inventario</label>
			<input type="integer" class="form-control" id="for_inventory_number" name="inventory_number">
		</fieldset>

		<fieldset class="form-group col">
			<label for="for_intesis_id">ID Intesis</label>
			<input type="text" class="form-control" id="for_intesis_id" name="intesis_id" >
		</fieldset>

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
	</div>

	<div class="row">
		<fieldset class="form-group col">
			<label for="for_office_serial">Licencia Office</label>
			<input type="text" class="form-control" id="for_office_serial" name="office_serial">
		</fieldset>

		<fieldset class="form-group col">
			<label for="for_windows_serial">Licencia Windows</label>
			<input type="text" class="form-control" id="for_windows_serial" name="windows_serial">
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

    <a href="{{ route('resources.computer.index') }}" class="btn btn-outline-dark">Volver</a>

</form>

@endsection
