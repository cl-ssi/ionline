@extends('layouts.app')

@section('title', 'Editar Solicitud de Firma')

@section('content')

<h3>Edición Solicitud de Firma</h3>

  <form method="POST" action="{{ route('rrhh.resolutions.update', $resolution) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="card">
    <div class="card-header">
      Aprobaciones de Solicitud
    </div>
      <div class="card-body">

        <table class="table table-sm table-bordered" style='font-size:65%' >
        	<thead>
        		<tr>
        			<th scope="col">Fecha</th>
              <th scope="col">U.Organizacional</th>
        			<th scope="col">Cargo</th>
              <th scope="col">Usuario</th>
              <th scope="col">Tipo</th>
              <th scope="col">Estado</th>
        		</tr>
        	</thead>
        	<tbody>
            @foreach($resolution->SignatureFlows as $key => $SignatureFlow)
            @if($SignatureFlow->status === null)
              <tr class="bg-light">
            @elseif($SignatureFlow->status === 0)
              <tr class="bg-danger">
            @elseif($SignatureFlow->status === 1)
              <tr>
            @endif
               <td>{{ $SignatureFlow->signature_date}}</td>
               <td>{{ $SignatureFlow->organizationalUnit->name}}</td>
               <td>{{ $SignatureFlow->employee }}</td>
               <td>@if($SignatureFlow->user) {{ $SignatureFlow->user->getFullNameAttribute() }} @endif</td>
               <td>{{ $SignatureFlow->type }}</td>
               <td>@if($SignatureFlow->status === null)  @elseif($SignatureFlow->status === 1) Aceptada @elseif($SignatureFlow->status === 0) Rechazada @endif</td>
             </tr>
           @endforeach
        	</tbody>
        </table>


        <div class="row">
          <fieldset class="form-group col-4">
					    <label for="for_name">Tipo</label>

              <input type="text" class="form-control" name="employee" value="{{$employee}}" readonly="readonly">

					</fieldset>
          <fieldset class="form-group col-4">
              <label for="for_name">Estado Solicitud</label>
              <select name="status" class="form-control">
                <option value="">Seleccionar una opción</option>
                <option value="1">Aceptada</option>
                <option value="0">Rechazada</option>
              </select>
          </fieldset>
          <fieldset class="form-group col">
              <label for="for_observation">Observación</label>
              <input type="text" class="form-control" id="for_observation" placeholder="" name="observation">
          </fieldset>

        </div>

      </div>
  </div>

  <hr>

  <div class="row">

    <fieldset class="form-group col">
		    <label for="for_request_date">Fecha Solicitud</label>
		    <input type="date" class="form-control" id="for_request_date" name="request_date" required value="{{\Carbon\Carbon::parse($resolution->request_date)->format('Y-m-d')}}">
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_responsability_center_id">Unidad Organizacional</label>
		    <select class="form-control selectpicker" data-live-search="true" name="ou_id" required="" data-size="5">
          @foreach($organizationalUnits as $key => $organizationalUnit)
            <option value="{{$organizationalUnit->id}}" @if($resolution->ou_id == $organizationalUnit->id) selected @endif>{{$organizationalUnit->name}}</option>
          @endforeach
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_responsability_center_id">Responsable</label>
		    <!-- <select name="responsable_id" class="form-control" required> -->
        <select class="form-control selectpicker" data-live-search="true" name="responsable_id" required="" data-size="5">
          @foreach($users as $key => $user)
            <option value="{{$user->id}}" @if($resolution->responsable_id == $user->id) selected @endif>{{$user->getFullNameAttribute()}}</option>
          @endforeach
        </select>
		</fieldset>

	</div>

  <div class="row">

    <fieldset class="form-group col">
		    <label for="for_document_type">Tipo de Documento</label>
		    <select class="form-control selectpicker" data-live-search="true" name="document_type" required="" data-size="5">
          <option value="Carta" @if($resolution->document_type == "Carta") selected @endif>Carta</option>
					<option value="Circular" @if($resolution->document_type == "Circular") selected @endif>Circular</option>
					<option value="Convenios" @if($resolution->document_type == "Convenios") selected @endif>Convenios</option>
					<option value="Memorando" @if($resolution->document_type == "Memorando") selected @endif>Memorando</option>
					<option value="Oficio" @if($resolution->document_type == "Oficio") selected @endif>Oficio</option>
					<option value="Resoluciones" @if($resolution->document_type == "Resoluciones") selected @endif>Resoluciones</option>
        </select>
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_resolution_matter">Materia o tema del documento</label>
				<input type="text" class="form-control" id="for_resolution_matter" name="resolution_matter" required value="{{$resolution->resolution_matter}}">
		</fieldset>

	</div>

	<div class="row">

		<fieldset class="form-group col">
		    <label for="for_description">Descripción del documento</label>
				<input type="text" class="form-control" id="for_description" name="description" required value="{{$resolution->description}}">
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
          <option value="No requiere visación" @if($resolution->endorse_type == "No requiere visación") selected @endif>No requiere visación</option>
					<option value="Visación opcional" @if($resolution->endorse_type == "Visación opcional") selected @endif>Visación opcional</option>
					<option value="Visación en cadena de responsabilidad" @if($resolution->endorse_type == "Visación en cadena de responsabilidad") selected @endif>Visación en cadena de responsabilidad</option>
        </select>
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_visators">Visadores</label>
				<select name="visators[]" id="visators_id" class="form-control selectpicker" multiple disabled>
					@foreach($organizationalUnits as $key => $organizationalUnit)
						<option value="{{$organizationalUnit->id}}" @if(!$resolution->SignatureFlows->where('type','visador')->where('ou_id',$organizationalUnit->id)->isEmpty()) selected @endif>{{$organizationalUnit->name}}</option>
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
				<select name="signers[]" id="signers_id" class="form-control selectpicker" multiple required disabled>
					@foreach($organizationalUnits as $key => $organizationalUnit)
						<option value="{{$organizationalUnit->id}}" @if(!$resolution->SignatureFlows->where('type','firmante')->where('ou_id',$organizationalUnit->id)->isEmpty()) selected @endif>{{$organizationalUnit->name}}</option>
					@endforeach
				</select>
		</fieldset>

	</div>

	<div class="row">

		<fieldset class="form-group col">
		    <label for="for_document_recipients">Destinatarios del documento (separados por punto y coma)</label>
				<input type="text" class="form-control" id="for_document_recipients" name="document_recipients" value="{{$resolution->document_recipients}}">
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_annexed">Districuión del documento (separados por punto y coma)</label>
				<input type="text" class="form-control" id="for_annexed" name="annexed" value="{{$resolution->annexed}}">
		</fieldset>

	</div>

	<button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
