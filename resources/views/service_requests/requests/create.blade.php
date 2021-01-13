@extends('layouts.app')

@section('title', 'Crear Programa Farmacia')

@section('content')

<h3>Solicitud de Contratación de Servicios</h3>

<form method="POST" enctype="multipart/form-data" action="{{ route('rrhh.service_requests.store') }}">
	@csrf

	<!-- <div class="card">
    <div class="card-header">
      Aprobaciones de Solicitud
    </div>
      <div class="card-body">
				<div class="row">

					<fieldset class="form-group col-4">
					    <label for="for_name">Tipo</label>
					    <select name="employee" class="form-control" readonly="readonly">
			          	<option value="Jefatura de servicio" readonly="readonly">Jefatura de servicio</option>
			        </select>
					</fieldset>

					<fieldset class="form-group col">
					    <label for="for_name">Usuario Aprobador</label>
					    <select name="user_id" class="form-control selectpicker" data-live-search="true" required="" data-size="5">
								@foreach($users as $key => $user)
			          	<option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
			          @endforeach
			        </select>
					</fieldset>

				</div>
      </div>
  </div>

	<br> -->

	<div class="row">

    <fieldset class="form-group col">
		    <label for="for_name">Tipo</label>
		    <select name="type" class="form-control" required>
          <option value="Genérico">Honorarios - Genérico</option>
          <option value="Covid">Honorarios - Covid</option>
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_subdirection_ou_id">Subdirección</label>
				<select class="form-control selectpicker" data-live-search="true" name="subdirection_ou_id" required="" data-size="5">
          @foreach($subdirections as $key => $subdirection)
            <option value="{{$subdirection->id}}">{{$subdirection->name}}</option>
          @endforeach
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_responsability_center_ou_id">Centro de Responsabilidad</label>
				<select class="form-control selectpicker" data-live-search="true" name="responsability_center_ou_id" required="" data-size="5">
          @foreach($responsabilityCenters as $key => $responsabilityCenter)
            <option value="{{$responsabilityCenter->id}}">{{$responsabilityCenter->name}}</option>
          @endforeach
        </select>
		</fieldset>

		<fieldset class="form-group col">
				<label for="for_name">Firmantes</label>
				<select name="users[]" id="users" class="form-control selectpicker" multiple>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
		</fieldset>

	</div>

  <div class="row">

    <fieldset class="form-group col">
		    <label for="for_rut">Rut</label>
		    <input type="text" class="form-control" id="for_rut" placeholder="" name="rut" required="required">
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_name">Nombre</label>
		    <input type="text" class="form-control" id="for_name" placeholder="" name="name" required="required">
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_name">Tipo de Contrato</label>
		    <select name="contract_type" class="form-control" required>
          <option value="NUEVO">Nuevo</option>
          <option value="ANTIGUO">Antiguo</option>
          <option value="CONTRATO PERM.">Contrato Perm.</option>
          <option value="PRESTACION">Prestación</option>
        </select>
		</fieldset>

  </div>

	<div class="row">

    <fieldset class="form-group col">
		    <label for="for_address">Dirección</label>
		    <input type="text" class="form-control" id="foraddress" placeholder="" name="address">
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_phone_number">Número telefónico</label>
		    <input type="text" class="form-control" id="for_phone_number" placeholder="" name="phone_number">
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_email">Correo electrónico</label>
		    <input type="text" class="form-control" id="for_email" placeholder="" name="email">
		</fieldset>

  </div>

  <div class="row">

		<fieldset class="form-group col">
		    <label for="for_request_date">Fecha Solicitud</label>
		    <input type="date" class="form-control" id="for_request_date" name="request_date" required>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_start_date">Fecha de Inicio</label>
		    <input type="date" class="form-control" id="for_start_date" name="start_date" required>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_end_date">Fecha de Término</label>
		    <input type="date" class="form-control" id="for_end_date" name="end_date" required>
		</fieldset>

  </div>

  <hr>

  <div class="row">

    <fieldset class="form-group col">
        <label for="for_service_description">Descripción Servicio</label>
        <textarea id="service_description" name="service_description" class="form-control" rows="4" cols="50"></textarea>
    </fieldset>

  </div>

  <div class="row">

    <fieldset class="form-group col">
		    <label for="for_programm_name">Nombre del programa</label>
		    <!-- <input type="text" class="form-control" id="for_programm_name" placeholder="" name="programm_name"> -->
        <select name="programm_name" class="form-control" required>
          <option value="Covid19-APS No Médicos">Covid19-APS No Médicos</option>
          <option value="Covid19-APS Médicos">Covid19-APS Médicos</option>
          <option value="Covid19 No Médicos">Covid19 No Médicos</option>
          <option value="Covid19 Médicos">Covid19 Médicos</option>
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_name">Otro</label>
		    <select name="other" class="form-control" required>
          <option value="Brecha">Brecha</option>
          <option value="LM:LICENCIAS MEDICAS">LM:LICENCIAS MEDICAS</option>
          <option value="HE:HORAS EXTRAS">HE:HORAS EXTRAS</option>
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_normal_hour_payment">Pago Hora Normal</label>
		    <select name="normal_hour_payment" class="form-control">
          <option value=""></option>
          <option value="MACROZONA">MACROZONA</option>
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_amount">Valor $</label>
		    <input type="number" class="form-control" id="for_amount" placeholder="" name="amount">
		</fieldset>

  </div>

  <div class="row">

    <fieldset class="form-group col">
		    <label for="for_program_contract_type">Tipo de Contratación</label>
		    <select name="program_contract_type" class="form-control" id="program_contract_type" required>
          <option value="Semanal">Semanal</option>
          <option value="Mensual">Mensual</option>
					<option value="Horas">Horas</option>
          <option value="Otro">Otro</option>
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_daily_hours">Horas Diurnas</label>
		    <input type="number" class="form-control" id="for_daily_hours" placeholder="" name="daily_hours">
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_nightly_hours">Horas Nocturnas</label>
		    <input type="number" class="form-control" id="for_nightly_hours" placeholder="" name="nightly_hours">
		</fieldset>

  </div>


	<div id="control_turnos">
		<br>
		<div class="card" id="card">
		  <div class="card-header">
		    Control de Turnos
		  </div>
		  <ul class="list-group list-group-flush">
		    <li class="list-group-item">
					<div class="row">
						<fieldset class="form-group col">
								<label for="for_estate">Entrada</label>
								<input type="date" class="form-control" name="shift_date" id="shift_date">
						</fieldset>
						<fieldset class="form-group col">
								<label for="for_estate">H.Inicio</label>
								<input type="time" class="form-control" name="start_hour" id="start_hour">
						</fieldset>
						<fieldset class="form-group col">
								<label for="for_estate">H.Término</label>
								<input type="time" class="form-control" name="end_hour" id="end_hour">
						</fieldset>
						<fieldset class="form-group col">
								<label for="for_estate">Observación</label>
								<input type="text" class="form-control" name="observation" id="observation">
						</fieldset>
						<fieldset class="form-group col-2">
								<label for="for_estate"><br/></label>
								<button type="button" class="btn btn-primary form-control add-row" id="shift_button_add" formnovalidate="formnovalidate">Ingresar</button>
								<!-- formnovalidate="formnovalidate" formaction="{{ route('rrhh.shift_control.store') }}" -->
						</fieldset>
					</div>

					<table class="table table-sm">
			        <thead>
			            <tr>
			                <th>Select</th>
			                <th>Entrada</th>
			                <th>H.Inicio</th>
											<th>H.Término</th>
											<th>Observación</th>
			            </tr>
			        </thead>
			        <tbody>
			            <!-- <tr>
			                <td><input type="checkbox" name="record"></td>
			                <td>Peter Parker</td>
			                <td>peterparker@mail.com</td>
			            </tr> -->
			        </tbody>
			    </table>
					<button type="button" class="btn btn-primary delete-row">Eliminar filas</button>
				</li>
		  </ul>
		</div>
		<br>
	</div>

  <div class="row">

    <fieldset class="form-group col">
		    <label for="for_estate">Estamento al que corresponde CS</label>
		    <select name="estate" class="form-control" required>
          <option value="Profesional Médico">Profesional Médico</option>
          <option value="Profesional">Profesional</option>
          <option value="Técnico">Técnico</option>
          <option value="Administrativo">Administrativo</option>
          <option value="Farmaceutico">Farmaceutico</option>
          <option value="Odontólogo">Odontólogo</option>
					<option value="Bioquímico">Bioquímico</option>
          <option value="Auxiliar">Auxiliar</option>
          <option value="Otro (justificar)">Otro (justificar)</option>
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_estate_other">Otro</label>
		    <input type="text" class="form-control" id="for_estate_other" placeholder="" name="estate_other">
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_working_day_type">Jornada de Trabajo</label>
		    <select name="working_day_type" class="form-control" required>
          <option value="08:00 a 16:48 hrs (L-M-M-J-V)">08:00 a 16:48 hrs (L-M-M-J-V)</option>
          <option value="TERCER TURNO">TERCER TURNO</option>
          <option value="CUARTO TURNO">CUARTO TURNO</option>
        </select>

		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_working_day_type_other">Otro</label>
		    <input type="text" class="form-control" id="for_working_day_type_other" placeholder="" name="working_day_type_other">
		</fieldset>

  </div>

	<button type="submit" id="principal_form" class="btn btn-primary">Crear</button>

</form>

@endsection

@section('custom_js')
<script type="text/javascript">

	$( document ).ready(function() {

		$("#control_turnos").hide();
		$('#program_contract_type').on('change', function() {
			if (this.value == "Horas") {
				$('#for_daily_hours').val("");
				$('#for_nightly_hours').val("");
				$('#for_daily_hours').attr('readonly', true);
				$('#for_nightly_hours').attr('readonly', true);
				$("#control_turnos").show();
			}else{
				$('#for_daily_hours').attr('readonly', false);
				$('#for_nightly_hours').attr('readonly', false);
				$("#control_turnos").hide();
			}
		})
	});


	$(".add-row").click(function(){
      var shift_date = $("#shift_date").val();
      var start_hour = $("#start_hour").val();
			var end_hour = $("#end_hour").val();
			var observation = $("#observation").val();
      var markup = "<tr><td><input type='checkbox' name='record'></td><td> <input type='hidden' class='form-control' name='shift_date[]' id='shift_date' value='"+ shift_date +"'>"+ shift_date +"</td><td> <input type='hidden' class='form-control' name='shift_start_hour[]' id='start_hour' value='"+ start_hour +"'>" + start_hour + "</td><td> <input type='hidden' class='form-control' name='shift_end_hour[]' id='end_hour' value='"+ end_hour +"'>" + end_hour + "</td><td> <input type='hidden' class='form-control' name='shift_observation[]' id='observation' value='"+ observation +"'>" + observation + "</td></tr>";
      $("table tbody").append(markup);

			// $("#shift_date").val("");
      // $("#start_hour").val("");
			// $("#end_hour").val("");
			// $("#observation").val("");
  });

	// Find and remove selected table rows
  $(".delete-row").click(function(){
      $("table tbody").find('input[name="record"]').each(function(){
      	if($(this).is(":checked")){
              $(this).parents("tr").remove();
          }
      });
  });
</script>
@endsection
