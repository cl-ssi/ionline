@extends('layouts.app')

@section('title', 'Crear Solicitud de Contratación de Servicios')

@section('content')

@include('service_requests.partials.nav')

<h3>Solicitud de Contratación de Servicios</h3>

<form method="POST" enctype="multipart/form-data" action="{{ route('rrhh.service-request.store') }}">
	@csrf

	<div class="form-row">

		<div class="form-group col-6">
			@livewire('service-request.create-types')
		</div>

    <fieldset class="form-group col">
		    <label for="for_subdirection_ou_id">Subdirección</label>
				<select class="form-control selectpicker" data-live-search="true" id="subdirection_ou_id" name="subdirection_ou_id" required data-size="5">
					<option value=""></option>
          @foreach($subdirections as $key => $subdirection)
            <option value="{{$subdirection->id}}">{{$subdirection->name}}</option>
          @endforeach
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_responsability_center_ou_id">Centro de Responsabilidad</label>
				<select class="form-control selectpicker" data-live-search="true" name="responsability_center_ou_id" id="responsability_center_ou_id" required data-size="5">
					<option value=""></option>
          @foreach($responsabilityCenters as $key => $responsabilityCenter)
            <option value="{{$responsabilityCenter->id}}">{{$responsabilityCenter->name}}</option>
          @endforeach
        </select>
		</fieldset>

	</div>

	<div class="form-row">

		<fieldset class="form-group col">
				<label for="for_users">Responsable</label>
				<select name="responsable_id" id="responsable_id" class="form-control selectpicker" data-live-search="true" data-size="5" required>
					<option value=""></option>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
		</fieldset>

		<fieldset class="form-group col">
				<label for="for_users">Supervisor</label>
				<select name="users[]" id="users" class="form-control selectpicker" data-live-search="true" data-size="5" required>
					<option value=""></option>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
		</fieldset>

	</div>

	@livewire('service-request.signature-flows')

	<br>

	@livewire('service-request.employee-data')

	<br>

  <div class="row">

		<fieldset class="form-group col">
        <label for="for_contract_type">Tipo de Contrato</label>
        <select name="contract_type" class="form-control" required>
          <option value=""></option>
          <option value="NUEVO">Nuevo</option>
          <option value="ANTIGUO">Antiguo</option>
          <option value="CONTRATO PERM.">Permanente</option>
          <option value="PRESTACION">Prestación</option>
        </select>
    </fieldset>

		<fieldset class="form-group col">
		    <label for="for_request_date">Fecha Solicitud</label>
		    <input type="date" class="form-control" id="for_request_date" name="request_date" max="2030-12-31" required>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_start_date">F.Inicio de Contrato</label>
		    <input type="date" class="form-control" id="for_start_date" name="start_date" max="2030-12-31" required>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_end_date">F.Término de Contrato</label>
		    <input type="date" class="form-control" id="for_end_date" name="end_date" max="2030-12-31" required>
		</fieldset>

  </div>

  <hr>

  <div class="row">

    <fieldset class="form-group col">
        <label for="for_service_description">Descripción Servicio</label>
        <textarea id="service_description" name="service_description" class="form-control" rows="4" cols="50"></textarea>

				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_enfermeros">Enfermeras/os</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_kinesiologos">Kinesiólogos/as</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_paramedicos">Técnicos paraméricos</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_auxiliares">Auxiliares de servicio</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_administrativos">Administrativos/as</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_matronas">Matronas</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_tm_imageneologia">T.M. Imagenología</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_medico">Médico</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_fonoaudiologas">Fonoaudiologas</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_terapeuta_ocupacional">Terapeuta Ocupacional</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_psicologo">Psicólogo</button>

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
						<fieldset class="form-group col-3">
								<label for="for_estate">Entrada</label>
								<input type="date" class="form-control" name="shift_start_date" id="shift_start_date">
						</fieldset>
						<fieldset class="form-group col">
								<label for="for_estate">Hora</label>
								<input type="time" class="form-control" name="start_hour" id="start_hour">
						</fieldset>
						<fieldset class="form-group col-3">
								<label for="for_estate">Salida</label>
								<input type="date" class="form-control" name="shift_end_date" id="shift_end_date">
						</fieldset>
						<fieldset class="form-group col">
								<label for="for_estate">Hora</label>
								<input type="time" class="form-control" name="end_hour" id="end_hour">
						</fieldset>
						<fieldset class="form-group col">
								<label for="for_estate">Observación</label>
								<input type="text" class="form-control" name="observation" id="observation">
						</fieldset>
						<fieldset class="form-group col">
								<label for="for_estate"><br/></label>
								<button type="button" class="btn btn-primary form-control add-row" id="shift_button_add" formnovalidate="formnovalidate">Ingresar</button>
						</fieldset>
					</div>

					<table class="table table-sm">
			        <thead>
			            <tr>
			                <th>Select</th>
			                <th>Entrada</th>
			                <th>Hora</th>
											<th>Salida</th>
											<th>Hora</th>
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
		    <label for="for_contractual_condition">Calidad Contractual</label>
        <select name="contractual_condition" class="form-control" id="contractual_condition">
          <option value=""></option>
          <option value="SUPLENTE" >SUPLENTE</option>
          <option value="CONTRATA" >CONTRATA</option>
          <option value="TITULAR" >TITULAR</option>
          <option value="HONORARIO COVID" >HONORARIO COVID</option>
					@can('Service Request: additional data rrhh')
						<option value="SUMA ALZADA" >SUMA ALZADA</option>
					@endcan
        </select>
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_estate">Estamento al que corresponde CS</label>
		    <select name="estate" class="form-control" required id="estate">
					<option value=""></option>
          <option value="Profesional Médico">Profesional Médico</option>
          <option value="Profesional">Profesional</option>
          <option value="Técnico">Técnico</option>
          <option value="Administrativo">Administrativo</option>
          <option value="Farmaceutico">Farmaceutico</option>
          <option value="Odontólogo">Odontólogo</option>
					<option value="Bioquímico">Bioquímico</option>
          <option value="Auxiliar">Auxiliar</option>
          <!-- <option value="Otro (justificar)">Otro (justificar)</option> -->
        </select>
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_weekly_hours">Hrs.Semanales</label>
		    <select name="weekly_hours" class="form-control" id="for_weekly_hours">
					<option value=""></option>
          <option value="44">44</option>
          <option value="33">33</option>
					<option value="28">28</option>
					<option value="22">22</option>
          <option value="11">11</option>
        </select>
		</fieldset>

		<fieldset class="form-group col">
        <label for="for_establishment_id">Establecimiento</label>
        <select name="establishment_id" class="form-control" required>
          <option value=""></option>
          @foreach($establishments as $key => $establishment)
            <option value="{{$establishment->id}}" @if($establishment->id == 1) selected @endif>{{$establishment->name}}</option>
          @endforeach
        </select>
    </fieldset>

    <!-- <fieldset class="form-group col">
		    <label for="for_daily_hours">Horas Diurnas</label>
		    <input type="number" class="form-control" id="for_daily_hours" placeholder="" name="daily_hours">
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_nightly_hours">Horas Nocturnas</label>
		    <input type="number" class="form-control" id="for_nightly_hours" placeholder="" name="nightly_hours">
		</fieldset> -->

  </div>

  <div class="row">

		<fieldset class="form-group col">
		    <label for="for_programm_name">Nombre del programa</label>
		    <!-- <input type="text" class="form-control" id="for_programm_name" placeholder="" name="programm_name"> -->
        <select name="programm_name" class="form-control" required id="programm_name">
					<option value=""></option>
          <option value="Covid19-APS No Médicos">Covid19-APS No Médicos</option>
          <option value="Covid19-APS Médicos">Covid19-APS Médicos</option>
          <option value="Covid19 No Médicos">Covid19 No Médicos</option>
          <option value="Covid19 Médicos">Covid19 Médicos</option>
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_estate_other">Detalle estamento</label>
		    <input type="text" class="form-control" id="for_estate_other" placeholder="" name="estate_other">
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_working_day_type">Jornada de Trabajo</label>
		    <select name="working_day_type" class="form-control" required id="working_day_type">
					<option value=""></option>
          <option value="DIURNO">DIURNO</option>
          <option value="TERCER TURNO">TERCER TURNO</option>
					<option value="TERCER TURNO - MODIFICADO">TERCER TURNO - MODIFICADO</option>
          <option value="CUARTO TURNO">CUARTO TURNO</option>
					<option value="CUARTO TURNO - MODIFICADO">CUARTO TURNO - MODIFICADO</option>

					<option value="DIURNO PASADO A TURNO">DIURNO PASADO A TURNO</option>
					<option value="HORA MÉDICA">HORA MÉDICA</option>
          <option value="HORA EXTRA">HORA EXTRA</option>
					<option value="TURNO EXTRA">TURNO EXTRA</option>
					<!-- <option value="OTRO">OTRO</option> -->
        </select>

		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_working_day_type_other">Otro</label>
		    <input type="text" class="form-control" id="for_working_day_type_other" placeholder="" name="working_day_type_other">
		</fieldset>

  </div>

	<div class="row">
		<fieldset class="form-group col-3 col-md-3">
				<label for="for_rrhh_team">Equipo RRHH*</label>
				<select name="rrhh_team" class="form-control" id="rrhh_team" required>

					<option value=""></option>
					<option value="Residencia Médica" >Residencia Médica</option>
					<option value="Médico Diurno" >Médico Diurno</option>
					<option value="Enfermera Supervisora">Enfermera Supervisora</option>
					<option value="Enfermera Diurna" >Enfermera Diurna</option>
					<option value="Enfermera Turno" >Enfermera Turno</option>
					<option value="Kinesiólogo Diurno" >Kinesiólogo Diurno</option>
					<option value="Kinesiólogo Turno">Kinesiólogo Turno</option>
					<option value="Téc.Paramédicos Diurno">Téc.Paramédicos Diurno</option>
					<option value="Téc.Paramédicos Turno" >Téc.Paramédicos Turno</option>
					<option value="Auxiliar Diurno" >Auxiliar Diurno</option>
					<option value="Auxiliar Turno">Auxiliar Turno</option>
					<option value="Terapeuta Ocupacional" >Terapeuta Ocupacional</option>
					<option value="Químico Farmacéutico" >Químico Farmacéutico</option>
					<option value="Bioquímico" >Bioquímico</option>
					<option value="Fonoaudiologo" >Fonoaudiologo</option>
					<option value="Prevencionista Diurno">Prevencionista Diurno</option>
					<option value="Administrativo Diurno" >Administrativo Diurno</option>
					<option value="Administrativo Turno" >Administrativo Turno</option>
					<option value="Biotecnólogo Turno" >Biotecnólogo Turno</option>
					<option value="Matrona Turno" >Matrona Turno</option>
					<option value="Matrona Diurno" >Matrona Diurno</option>
					<option value="Otros técnicos" >Otros técnicos</option>
					<option value="Psicólogo" >Psicólogo</option>
					<option value="Tecn. Médico Diurno" >Tecn. Médico Diurno</option>
					<option value="Tecn. Médico Turno" >Tecn. Médico Turno</option>
					<option value="Trabajador Social" >Trabajador Social</option>
					<option value="Nutricionista Diurno" >Nutricionista Diurno</option>
					<option value="Prevencionista de Riesgo" >Prevencionista de Riesgo</option>
					<option value="Nutricionista turno" >Nutricionista turno</option>
				</select>
		</fieldset>

		<fieldset class="form-group col-3 col-md-3">
				<label for="for_digera_strategy">Estrategia Digera Covid</label>
				<select name="digera_strategy" class="form-control" id="digera_strategy" required>
					<option value=""></option>
					<option value="Camas MEDIAS Aperturadas" >Camas MEDIAS Aperturadas</option>
					<option value="Camas MEDIAS Complejizadas" >Camas MEDIAS Complejizadas</option>
					<option value="Camas UCI Aperturadas" >Camas UCI Aperturadas</option>
					<option value="Camas UCI Complejizadas" >Camas UCI Complejizadas</option>
					<option value="Camas UTI Aperturadas" >Camas UTI Aperturadas</option>
					<option value="Camas UTI Complejizadas" >Camas UTI Complejizadas</option>
					<option value="Cupos Hosp. Domiciliaria" >Cupos Hosp. Domiciliaria</option>
					<option value="Refuerzo Anatomía Patologica" >Refuerzo Anatomía Patologica</option>
					<option value="Refuerzo Laboratorio" >Refuerzo Laboratorio</option>
					<option value="Refuerzo SAMU" >Refuerzo SAMU</option>
					<option value="Refuerzo UEH" >Refuerzo UEH</option>
					@if(Auth::user()->organizationalUnit->establishment_id == 1)
						<option value="Migración Colchane" >Migración Colchane</option>
					@endif
				</select>
		</fieldset>
	</div>

	<button type="submit" id="principal_form" class="btn btn-primary">Crear</button>

</form>

@endsection

@section('custom_js')
<script src='{{asset("js/jquery.rut.chileno.js")}}'></script>
<script type="text/javascript">

	$( document ).ready(function() {

		$("#control_turnos").hide();
		$("#div_turno").hide();
		$("#div_suma_alzada").hide();

		$('#program_contract_type').on('change', function() {

			if (this.value == "Horas") {
				$('#for_daily_hours').val("");
				$('#for_nightly_hours').val("");
				$('#for_daily_hours').attr('readonly', true);
				$('#for_nightly_hours').attr('readonly', true);
				$('#for_weekly_hours').attr('disabled', 'disabled');
				$("#control_turnos").show();

				// $("#div_mensual :input").attr("disabled", true);
				// $("#div_mensual").hide();
				//
				// $("#div_suma_alzada :input").attr("disabled", true);
				// $("#div_suma_alzada").hide();
				//
				// $("#div_turno :input").attr("disabled", false);
				// $("#div_turno").show();

				$("#working_day_type option[value='DIURNO']").hide();
				$("#working_day_type option[value='TERCER TURNO']").hide();
				$("#working_day_type option[value='TERCER TURNO - MODIFICADO']").hide();
				$("#working_day_type option[value='CUARTO TURNO']").hide();
				$("#working_day_type option[value='CUARTO TURNO - MODIFICADO']").hide();

				$("#working_day_type option[value='DIURNO PASADO A TURNO']").show();
				$("#working_day_type option[value='HORA MÉDICA']").show();
				$("#working_day_type option[value='HORA EXTRA']").show();
				$("#working_day_type option[value='TURNO EXTRA']").show();

				$("#contractual_condition").prop('required',true);

			}else{
				$('#for_daily_hours').attr('readonly', false);
				$('#for_nightly_hours').attr('readonly', false);
				$('#for_weekly_hours').removeAttr('disabled');
				$("#control_turnos").hide();

				// $("#div_mensual :input").attr("disabled", false);
				// $("#div_mensual").show();
				//
				// $("#div_suma_alzada :input").attr("disabled", true);
				// $("#div_suma_alzada").hide();
				//
				// $("#div_turno :input").attr("disabled", true);
				// $("#div_turno").hide();

				$("#working_day_type option[value='DIURNO']").show();
				$("#working_day_type option[value='TERCER TURNO']").show();
				$("#working_day_type option[value='TERCER TURNO - MODIFICADO']").show();
				$("#working_day_type option[value='CUARTO TURNO']").show();
				$("#working_day_type option[value='CUARTO TURNO - MODIFICADO']").show();

				$("#working_day_type option[value='DIURNO PASADO A TURNO']").hide();
				$("#working_day_type option[value='HORA MÉDICA']").hide();
				$("#working_day_type option[value='HORA EXTRA']").hide();
				$("#working_day_type option[value='TURNO EXTRA']").hide();

				$("#contractual_condition").prop('required',false);
			}
		});

		$('#estate').on('change', function() {
			if (this.value == "Profesional" || this.value == "Técnico" || this.value == "Administrativo" || this.value == "Auxiliar") {
				$('#programm_name').val('Covid19 No Médicos');
				$('#programm_name').selectpicker('refresh');
			}
			if (this.value == "Profesional Médico" || this.value == "Farmaceutico" || this.value == "Odontólogo" || this.value == "Bioquímico") {
				$('#programm_name').val('Covid19 Médicos');
				$('#programm_name').selectpicker('refresh');
			}
		});

		$('#working_day_type').on('change', function() {
			if (this.value == "HORA MÉDICA") {
				$('#rrhh_team').val('Residencia Médica');
				$('#rrhh_team').selectpicker('refresh');
			}
		});

		$('#responsability_center_ou_id').on('change', function() {
			if ($("#responsability_center_ou_id option:selected").text() == "Departamento de Salud Ocupacional" ||
		      $("#responsability_center_ou_id option:selected").text() == "Extensión Hospital -Estadio" ||
					$("#responsability_center_ou_id option:selected").text() == "Sección Administrativa Honorarios Covid" ||
					$("#responsability_center_ou_id option:selected").text() == "Servicio de Cirugía" ||
					$("#responsability_center_ou_id option:selected").text() == "Servicio de Ginecología y Obstetricia" ||
					$("#responsability_center_ou_id option:selected").text() == "Servicio de Medicina" ||
					$("#responsability_center_ou_id option:selected").text() == "Unidad de Alimentación y Nutrición" ||
					$("#responsability_center_ou_id option:selected").text() == "Unidad de Gestión de Camas" ||
					$("#responsability_center_ou_id option:selected").text() == "Unidad de Ginecología" ||
					$("#responsability_center_ou_id option:selected").text() == "Unidad de Medicina Física y Rehabilitación" ||
					$("#responsability_center_ou_id option:selected").text() == "Unidad de Movilización" ||
					$("#responsability_center_ou_id option:selected").text() == "Unidad de Salud Ocupacional" ||
					$("#responsability_center_ou_id option:selected").text() == "Unidad Imagenología") {
				$('#digera_strategy').val('Camas MEDIAS Complejizadas');
				$('#digera_strategy').selectpicker('refresh');
			}
			if ($("#responsability_center_ou_id option:selected").text() == "Servicio de Anestesia y Pabellones" ||
		      $("#responsability_center_ou_id option:selected").text() == "Servicio Unidad Paciente Crítico Adulto" ||
					$("#responsability_center_ou_id option:selected").text() == "Servicio Unidad Paciente Crítico Pediatrico") {
				$('#digera_strategy').val('Camas UCI Complejizadas');
				$('#digera_strategy').selectpicker('refresh');
			}
			if ($("#responsability_center_ou_id option:selected").text() == "Unidad de Hospitalización Domiciliaria" ) {
				$('#digera_strategy').val('Cupos Hosp. Domiciliaria');
				$('#digera_strategy').selectpicker('refresh');
			}
			if ($("#responsability_center_ou_id option:selected").text() == "Subdirección de Gestion Asistencial / Subdirección Médica" ||
		      $("#responsability_center_ou_id option:selected").text() == "Unidad Laboratorio Clínico") {
				$('#digera_strategy').val('Refuerzo Laboratorio');
				$('#digera_strategy').selectpicker('refresh');
			}
			if ($("#responsability_center_ou_id option:selected").text() == "Establecimientos de Red de Urgencias" ) {
				$('#digera_strategy').val('Refuerzo SAMU');
				$('#digera_strategy').selectpicker('refresh');
			}
			if ($("#responsability_center_ou_id option:selected").text() == "Consultorio General Urbano Dr. Hector Reyno" ||
		      $("#responsability_center_ou_id option:selected").text() == "Servicio de Emergencia Hospitalaria" ||
					$("#responsability_center_ou_id option:selected").text() == "Servicio Urgencia Ginecoobstetricia") {
				$('#digera_strategy').val('Refuerzo UEH');
				$('#digera_strategy').selectpicker('refresh');
			}
			if ($("#responsability_center_ou_id option:selected").text() == "Departamento Operaciones" ) {
				$('#digera_strategy').val('Camas MEDIAS Complejizadas');
				$('#digera_strategy').selectpicker('refresh');
			}
			if ($("#responsability_center_ou_id option:selected").text() == "Unidad Farmacia" ) {
				$('#digera_strategy').val('Camas MEDIAS Complejizadas');
				$('#digera_strategy').selectpicker('refresh');
			}
		});



		//obtiene digito verificador
    $('input[name=user_id]').keyup(function(e) {
        var str = $("#for_user_id").val();
        $('#for_dv').val($.rut.dv(str));
    });
	});

	$('#subdirection_ou_id').on('change', function() {
		var value = this.value;

		//subdirección gestión del cuidado al paciente
		if (value == 85) {
			$("#Subdirector option[value=13835321]").removeAttr('disabled');
			$('#Subdirector').val(13835321);
			$('#Subdirector').selectpicker('refresh');

			$("#SubdirectorTurnos option[value=13835321]").removeAttr('disabled');
			$('#SubdirectorTurnos').val(13835321);
			$('#SubdirectorTurnos').selectpicker('refresh');
		}
		if (value != 85) {
			$('#Subdirector').val(14101085); //PERDRO IRIONDO: 9882506
			$('#Subdirector').selectpicker('refresh');

			$('#SubdirectorTurnos').val(14101085); //PERDRO IRIONDO: 9882506
			$('#SubdirectorTurnos').selectpicker('refresh');
		}
	});

	// $('#type').on('change', function() {
	// 	var value = this.value;
	//
	// 	if (value == "Suma alzada") {
	// 		$("#div_suma_alzada :input").attr("disabled", false);
	// 		$("#div_suma_alzada").show();
	// 		// $('#div_turno').attr('disabled','disabled');
	// 		$("#div_turno :input").attr("disabled", true);
	// 		$("#div_turno").hide();
	//
	// 		$("#div_mensual :input").attr("disabled", true);
	// 		$("#div_mensual").hide();
	//
	// 	}else{
	// 		$("#div_turno :input").attr("disabled", false);
	// 		$("#div_turno").show();
	// 		// $('#div_turno').attr('disabled','disabled');
	// 		$("#div_suma_alzada :input").attr("disabled", true);
	// 		$("#div_suma_alzada").hide();
	//
	// 		$("#div_mensual :input").attr("disabled", true);
	// 		$("#div_mensual").hide();
	// 	}
	// });



	// $('#working_day_type').on('change', function() {
	// 	var working_day_type = this.value;
	// 	var program_contract_type = document.getElementById("program_contract_type").value;
	//
	// 	if (program_contract_type == "Horas") {
	// 		$('#for_weekly_hours').val("");
	// 	}
	// 	if (program_contract_type == "Horas" && working_day_type == "HORA MÉDICA") {
	// 		$('#for_weekly_hours').val(28);
	// 	}
	// 	$('#for_weekly_hours').selectpicker('refresh');
	// });

	$('#btn_fonasa').click(function() {
	    var btn = $(this);
	    btn.prop('disabled',true);

	    var run = $("#for_run").val();
	    var dv  = $("#for_dv").val();
	    var url = '{{route('webservices.fonasa')}}/?run='+run+'&dv='+dv;

	    $.getJSON(url, function(data) {
	        if(data){
	            document.getElementById("name").value = data.name + " " + data.fathers_family + " " + data.mothers_family;
	            // document.getElementById("for_fathers_family").value = ;
	            // document.getElementById("for_mothers_family").value = ;
	            // document.getElementById("for_birthday").value = data.birthday;

	            // //CALCULO DE FECHA EN CACHO QUE EXISTA EL DATO DE FECHA DE NACIMIENTO
	            // var birthDate =data.birthday;
	            // var d = new Date(birthDate);
	            // var mdate = birthDate.toString();
	            // var yearThen = parseInt(mdate.substring(0,4), 10);
	            // var monthThen = parseInt(mdate.substring(5,7), 10);
	            // var dayThen = parseInt(mdate.substring(8,10), 10);
	            // var today = new Date();
	            // var birthday = new Date(yearThen, monthThen-1, dayThen);
	            // var differenceInMilisecond = today.valueOf() - birthday.valueOf();
	            // var year_age = Math.floor(differenceInMilisecond / 31536000000);
	            // $("#for_age").val(year_age);
	            // //FIN DE CALCULO DE EDAD

	        } else {
	            document.getElementById("name").value = "";
	            // document.getElementById("for_fathers_family").value = "";
	            // document.getElementById("for_mothers_family").value = "";
	            // // document.getElementById("for_gender").value = "";
	            // document.getElementById("for_birthday").value = "";
	        }
	}).done(function() {
	        btn.prop('disabled',false);
	    });
	});


	$(".add-row").click(function(){
      var shift_start_date = $("#shift_start_date").val();
      var start_hour = $("#start_hour").val();
			var shift_end_date = $("#shift_end_date").val();
			var end_hour = $("#end_hour").val();
			var observation = $("#observation").val();
      var markup = "<tr><td><input type='checkbox' name='record'></td><td> <input type='hidden' class='form-control' name='shift_start_date[]' id='shift_start_date' value='"+ shift_start_date +"'>"+ shift_start_date +"</td><td> <input type='hidden' class='form-control' name='shift_start_hour[]' id='start_hour' value='"+ start_hour +"'>" + start_hour + "</td><td> <input type='hidden' class='form-control' name='shift_end_date[]' id='shift_end_date' value='"+ shift_end_date +"'>"+ shift_end_date +"</td><td> <input type='hidden' class='form-control' name='shift_end_hour[]' id='end_hour' value='"+ end_hour +"'>" + end_hour + "</td><td> <input type='hidden' class='form-control' name='shift_observation[]' id='observation' value='"+ observation +"'>" + observation + "</td></tr>";
      $("table tbody").append(markup);
  });

	// Find and remove selected table rows
  $(".delete-row").click(function(){
      $("table tbody").find('input[name="record"]').each(function(){
      	if($(this).is(":checked")){
              $(this).parents("tr").remove();
          }
      });
  });

	$("#alias_enfermeros").click(function(){
		$('#service_description').val("Prestará servicios de enfermería realizando las funciones descritas en el Manual de Organización interno, en el contexto de pandemia Covid");
	});
	$("#alias_kinesiologos").click(function(){
		$('#service_description').val("Prestará servicios de kinesiología realizando las funciones descritas en el Manual de Organización interno, en el contexto de pandemia Covid");
	});
	$("#alias_paramedicos").click(function(){
		$('#service_description').val("Prestará servicios como técnico paramédico realizando las funciones descritas en el Manual de Organización interno, en el contexto de pandemia Covid");
	});
	$("#alias_auxiliares").click(function(){
		$('#service_description').val("Prestará servicios como auxiliar de servicio realizando las funciones descritas en el Manual de Organización interno, en el contexto de pandemia Covid");
	});
	$("#alias_administrativos").click(function(){
		$('#service_description').val("Prestará servicios en el área administrativa realizando las funciones descritas en el Manual de Organización interno, en el contexto de pandemia Covid");
	});
	$("#alias_matronas").click(function(){
		$('#service_description').val("Prestará servicios de matronería realizando las funciones descritas en el Manual de Organización interno, en el contexto de pandemia Covid");
	});
	$("#alias_tm_imageneologia").click(function(){
		$('#service_description').val("Prestará servicios de Tecnología Médica en Imagenología realizando las funciones descritas en el Manual de Organización interno, en el contexto de pandemia Covid");
	});
	$("#alias_medico").click(function(){
		$('#service_description').val("Prestará servicios de médico realizando las funciones descritas en el Manual de Organización interno, en el contexto de pandemia Covid.");
	});
	$("#alias_fonoaudiologas").click(function(){
		$('#service_description').val("Prestará servicios de Fonoaudiologia realizando las funciones descritas en el Manuel de Organización interno , en el contexto de pandemia covid.");
	});
	$("#alias_terapeuta_ocupacional").click(function(){
		$('#service_description').val("Prestará servicios de Terapia Ocupacional realizando las funciones descritas en el Manuel de Organización interno , en el contexto de pandemia covid.");
	});
	$("#alias_psicologo").click(function(){
		$('#service_description').val("Prestará servicios de psicología realizando las funciones descritas en el Manual de Organización interno, en el contexto de pandemia Covid.");
	});


</script>
@endsection
