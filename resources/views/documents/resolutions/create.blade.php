@extends('layouts.app')

@section('title', 'Crear Solicitud de Firma')

@section('content')

<h3>Creación Solicitud de Firma</h3>

<form method="POST" action="{{ route('rrhh.resolutions.store') }}" enctype="multipart/form-data">
	@csrf

	<div class="row">

    <fieldset class="form-group col">
		    <label for="for_request_date">Fecha Solicitud</label>
				<input type="date" class="form-control" id="for_request_date" name="request_date" required>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_responsability_center_id">Unidad Organizacional</label>
		    <select class="form-control selectpicker" data-live-search="true" name="ou_id" required="" data-size="5">
          @foreach($organizationalUnits as $key => $organizationalUnit)
            <option value="{{$organizationalUnit->id}}">{{$organizationalUnit->name}}</option>
          @endforeach
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_responsable_id">Responsable</label>
		    <!-- <select name="responsable_id" class="form-control" required> -->
        <select class="form-control selectpicker" data-live-search="true" name="responsable_id" required="" data-size="5">
          @foreach($users as $key => $user)
            <option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
          @endforeach
        </select>
		</fieldset>

	</div>

	<div class="row">

    <fieldset class="form-group col">
		    <label for="for_document_type">Tipo de Documento</label>
		    <select class="form-control selectpicker" data-live-search="true" name="document_type" required="" data-size="5">
          <option value="Carta">Carta</option>
					<option value="Circular">Circular</option>
					<option value="Convenios">Convenios</option>
					<option value="Memorando">Memorando</option>
					<option value="Oficio">Oficio</option>
					<option value="Resoluciones">Resoluciones</option>
        </select>
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_resolution_matter">Materia o tema del documento</label>
				<input type="text" class="form-control" id="for_resolution_matter" name="resolution_matter" required>
		</fieldset>

	</div>

	<div class="row">

		<fieldset class="form-group col">
		    <label for="for_description">Descripción del documento</label>
				<input type="text" class="form-control" id="for_description" name="description" required>
		</fieldset>

	</div>

	<div class="row">

		<fieldset class="form-group col">
		    <label for="for_document">Documento a distribuir</label>
				<input type="file" class="form-control" id="for_document" name="document">
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_annexed">Anexos</label>
				<input type="file" class="form-control" id="for_annexed" name="annexed">
		</fieldset>

	</div>

  <div class="row">

		<fieldset class="form-group col">
		    <label for="for_endorse_type">Tipo de visación</label>
		    <select class="form-control selectpicker" data-live-search="true" name="endorse_type" required="" data-size="5">
          <option value="No requiere visación">No requiere visación</option>
					<option value="Visación opcional">Visación opcional</option>
					<option value="Visación en cadena de responsabilidad">Visación en cadena de responsabilidad</option>
        </select>
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_visators">Visadores</label>
				<select name="visators[]" id="visators_id" class="form-control selectpicker" multiple>
					@foreach($organizationalUnits as $key => $organizationalUnit)
						<option value="{{$organizationalUnit->id}}">{{$organizationalUnit->name}}</option>
					@endforeach
				</select>
		</fieldset>

	</div>

	<div class="row">

		<fieldset class="form-group col-6">
		    <!-- <label for="for_endorse_type">Tipo de visación</label>
		    <select class="form-control selectpicker" data-live-search="true" name="endorse_type" required="" data-size="5">
          <option value="No requiere visación">No requiere visación</option>
					<option value="Visación opcional">Visación opcional</option>
					<option value="Visación en cadena de responsabilidad">Visación en cadena de responsabilidad</option>
        </select> -->
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_signers">Firmantes</label>
				<select name="signers[]" id="signers_id" class="form-control selectpicker" multiple required>
					@foreach($organizationalUnits as $key => $organizationalUnit)
						<option value="{{$organizationalUnit->id}}">{{$organizationalUnit->name}}</option>
					@endforeach
				</select>
		</fieldset>

	</div>

	<div class="row">

		<fieldset class="form-group col">
		    <label for="for_document_recipients">Destinatarios del documento (separados por punto y coma)</label>
				<input type="text" class="form-control" id="for_document_recipients" name="document_recipients">
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_annexed">Districuión del documento (separados por punto y coma)</label>
				<input type="text" class="form-control" id="for_annexed" name="annexed">
		</fieldset>

	</div>

	<button type="submit" class="btn btn-primary">Crear</button>

</form>

@endsection

@section('custom_js')

@endsection
