@extends('layouts.app')

@section('title', 'Crear Solicitud de Contratación de Servicios')

@section('content')

@include('service_requests.partials.nav')

<h3>Solicitud de Contratación de Servicios</h3>

<form method="POST" enctype="multipart/form-data" action="{{ route('rrhh.service-request.store') }}">
	@csrf

@livewire('service-request.create-types',['subdirections' => $subdirections,
                                          'responsabilityCenters' => $responsabilityCenters])

	<br>

	@livewire('service-request.employee-data')

	<br>

  	<div class="form-row">

		<fieldset class="form-group col-6 col-md-3">
			<label for="for_contract_type">Tipo de Contrato</label>
			<select name="contract_type" class="form-control" required>
			<option value=""></option>
			<option value="NUEVO">Nuevo</option>
			<option value="ANTIGUO">Antiguo</option>
			<option value="CONTRATO PERM.">Permanente</option>
			<option value="PRESTACION">Prestación</option>
			</select>
		</fieldset>

		<fieldset class="form-group col-6 col-md-3">
		    <label for="for_request_date">Fecha Solicitud</label>
		    <input type="date" class="form-control" id="for_request_date"
				name="request_date" max="2022-12-31" required>
		</fieldset>

    	<fieldset class="form-group col-12 col-md-3">
		    <label for="for_start_date">Fecha Inicio de Contrato</label>
		    <input type="date" class="form-control" id="for_start_date"
				name="start_date" min="2020-01-01" max="2022-12-31" required>
		</fieldset>

    	<fieldset class="form-group col-12 col-md-3">
		    <label for="for_end_date">Fecha Término de Contrato</label>
		    <input type="date" class="form-control" id="for_end_date"
				name="end_date" min="2020-01-01" max="2022-12-31" required>
		</fieldset>

  </div>

  <hr>

	<div class="form-row">

		<fieldset class="form-group col-12 col-md-4">
			<label for="for_establishment_id">Establecimiento</label>
			<select name="establishment_id" class="form-control" required>
				<option value=""></option>
				@foreach($establishments as $key => $establishment)
				<option value="{{$establishment->id}}" @if($establishment->id == 1) selected @endif>{{$establishment->name}}</option>
				@endforeach
			</select>
		</fieldset>

		<fieldset class="form-group col-6 col-md-3">
			<label for="for_profession_id">Profesión</label>
			<select name="profession_id" class="form-control" required id="profession_id">
				<option value=""></option>
				@foreach($professions as $profession)
					<option value="{{$profession->id}}">{{$profession->name}}</option>
				@endforeach
			</select>
		</fieldset>

		<fieldset class="form-group col-6 col-md-2">
			<label for="for_weekly_hours">Hrs.Semanales</label>
			<select name="weekly_hours" class="form-control" id="for_weekly_hours">
				<option value=""></option>
				<option value="44">44</option>
				<option value="33">33</option>
				<option value="30">30</option>
				<option value="28">28</option>
				<option value="22">22</option>
				<option value="20">20</option>
				<option value="16">16</option>
				<option value="15">15</option>
				<option value="11">11</option>
				<option value="9">9</option>
				<option value="8.5">8.5</option>
				<option value="7.5">7.5</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
			</select>
		</fieldset>


		<fieldset class="form-group col-6 col-md-3">
			<label for="for_working_day_type">Jornada de Trabajo</label>
			<select name="working_day_type" class="form-control" required id="working_day_type">
				<option value=""></option>
				<option value="DIURNO">DIURNO</option>
				<option value="VESPERTINO">VESPERTINO</option>
				<option value="TERCER TURNO">TERCER TURNO</option>
				<option value="TERCER TURNO - MODIFICADO">TERCER TURNO - MODIFICADO</option>
				<option value="CUARTO TURNO">CUARTO TURNO</option>
				<option value="CUARTO TURNO - MODIFICADO">CUARTO TURNO - MODIFICADO</option>
				<option value="DIURNO PASADO A TURNO">DIURNO PASADO A TURNO</option>
				<option value="HORA MÉDICA">HORA MÉDICA</option>
				<option value="HORA EXTRA">HORA EXTRA</option>
				<option value="TURNO EXTRA">TURNO EXTRA</option>
				<option value="TURNO DE REEMPLAZO">TURNO DE REEMPLAZO</option>
				<option value="QUIRURGICO">QUIRÚRGICO</option>
				<!-- <option value="OTRO">OTRO</option> -->
				<option value=""></option>
				<option value="DIARIO">DIARIO</option>
			</select>
		</fieldset>

		<fieldset class="form-group col-12 col-md-12">
			<label for="for_working_day_type_other">Otra jornada de trabajo<small> (Saldrá en la resolución luego del horario)</small></label>
			<input type="text" class="form-control" id="for_working_day_type_other" placeholder="" name="working_day_type_other">
		</fieldset>

	</div>

	<div class="form-row">
    
		<fieldset class="form-group col-12">
			<label for="for_service_description">Descripción Servicio*</label>
			<textarea id="service_description" name="service_description" class="form-control" rows="4" cols="50" required></textarea>
		</fieldset>

		<fieldset class="form-group">
			<div id="id_descripcion_servicio">
				<button type="button" class="btn btn-outline-primary btn-sm col-6 col-md-3" id="alias_enfermeros">Enfermeras/os</button>
				<button type="button" class="btn btn-outline-primary btn-sm col-5 col-md-3" id="alias_kinesiologos">Kinesiólogos/as</button>
				<button type="button" class="btn btn-outline-primary btn-sm col-6 col-md-3" id="alias_paramedicos">Técnicos paraméricos</button>
				<button type="button" class="btn btn-outline-primary btn-sm col-5 col-md-2" id="alias_medico">Médico</button>
				<button type="button" class="btn btn-outline-primary btn-sm col-6 col-md-3" id="alias_auxiliares">Auxiliares de servicio</button>
				<button type="button" class="btn btn-outline-primary btn-sm col-5 col-md-3" id="alias_psicologo">Psicólogo</button>
				<button type="button" class="btn btn-outline-primary btn-sm col-6 col-md-3" id="alias_administrativos">Administrativos/as</button>
				<button type="button" class="btn btn-outline-primary btn-sm col-5 col-md-2" id="alias_matronas">Matronas</button>
				<button type="button" class="btn btn-outline-primary btn-sm col-6 col-md-3" id="alias_tm_imageneologia">T.M. Imagenología</button>
				<button type="button" class="btn btn-outline-primary btn-sm col-5 col-md-3" id="alias_fonoaudiologas">Fonoaudiologas</button>
				<button type="button" class="btn btn-outline-primary btn-sm col-6 col-md-3" id="alias_terapeuta_ocupacional">Terapeuta Ocupacional</button>
			</div>
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
			                <th>H.Entrada</th>
							<th>Salida</th>
							<th>H.Salida</th>
							<th>Horas</th>
							<th>Observación</th>
			            </tr>
			        </thead>
			        <tbody>

			        </tbody>
			    </table>
					<button type="button" class="btn btn-primary delete-row">Eliminar filas</button>
				</li>
		  </ul>
		</div>
		<br>
	</div>

  	<div class="form-row">

  		<fieldset class="form-group col-6 col-md-3">
			<label for="for_programm_name">Nombre Programa</label>
			<!-- <input type="text" class="form-control" id="for_programm_name" placeholder="" name="programm_name"> -->
			<select name="programm_name" class="form-control" required id="programm_name">
				<option value=""></option>
				<option value="Covid19-APS No Médicos">Covid19-APS No Médicos</option>
				<option value="Covid19-APS Médicos">Covid19-APS Médicos</option>
				<option value="Covid19 No Médicos">Covid19 No Médicos</option>
				<option value="Covid19 Médicos">Covid19 Médicos</option>

				@if(Auth::user()->organizationalUnit->establishment_id == 1)
					<option value="Covid 2022">Covid 2022</option>
					<option value="CONSULTORIO DE LLAMADA">CONSULTORIO DE LLAMADA</option>
					<option value="33 MIL HORAS">33 MIL HORAS</option>
					<option value="DFL">DFL</option>
					<option value="TURNOS VACANTES">TURNOS VACANTES</option>
					<option value="OTROS PROGRAMAS HETG">OTROS PROGRAMAS HETG</option>
					<option value="CAMPAÑA INVIERNO">CAMPAÑA INVIERNO</option>
					<option value="PABELLON TARDE">PABELLON TARDE</option>
					<option value="PABELLON GINE">PABELLON GINE</option>
					<option value="TURNO DE RESIDENCIA">TURNO DE RESIDENCIA</option>
					<option value="SENDA">SENDA</option>
				@else
					<option value="PRAPS">PRAPS</option>
					<option value="PESPI">PESPI</option>
					<option value="CHILE CRECE CONTIGO">CHILE CRECE CONTIGO</option>
					<option value="OTROS PROGRAMAS SSI">OTROS PROGRAMAS SSI</option>
					<option value="LISTA ESPERA">LISTA ESPERA</option>
					<option value="CAMPAÑA INVIERNO">CAMPAÑA INVIERNO</option>

					<option value="ADP DIRECTOR">ADP DIRECTOR</option>
					<option value="SENDA">SENDA</option>
					<option value="SENDA LEY ALCOHOLES">SENDA LEY ALCOHOLES</option>
					<option value="SENDA UHCIP">SENDA UHCIP</option>
					<option value="SENDA PSIQUIATRIA ADULTO">SENDA PSIQUIATRIA ADULTO</option>
					<option value="SENADIS">SENADIS</option>
					<option value="SUBT.31">SUBT.31</option>
				@endif
			</select>
		</fieldset>

		<fieldset class="form-group col-6 col-md-3">
			<label for="for_digera_strategy">Estrategia Digera C.</label>
			<select name="digera_strategy" class="form-control" id="digera_strategy" required>
				<option value=""></option>
				<option value="Camas MEDIAS Aperturadas">Camas MEDIAS Aperturadas</option>
				<option value="Camas MEDIAS Complejizadas">Camas MEDIAS Complejizadas</option>
				<option value="Camas UCI Aperturadas">Camas UCI Aperturadas</option>
				<option value="Camas UCI Complejizadas">Camas UCI Complejizadas</option>
				<option value="Camas UTI Aperturadas">Camas UTI Aperturadas</option>
				<option value="Camas UTI Complejizadas">Camas UTI Complejizadas</option>
				<option value="Cupos Hosp. Domiciliaria">Cupos Hosp. Domiciliaria</option>
				<option value="Refuerzo Anatomía Patologica">Refuerzo Anatomía Patologica</option>
				<option value="Refuerzo Laboratorio">Refuerzo Laboratorio</option>
				<option value="Refuerzo SAMU">Refuerzo SAMU</option>
				<option value="Refuerzo UEH">Refuerzo UEH</option>
				@if(Auth::user()->organizationalUnit->establishment_id == 1)
					<option value="Migración Colchane">Migración Colchane</option>
				@endif
			</select>
		</fieldset>

		<fieldset class="form-group col-6 col-md-3">
			<label for="for_contractual_condition">Calidad Contractual</label>
			<select name="contractual_condition" class="form-control" id="contractual_condition" disabled>
			<option value=""></option>
			<option value="SUPLENTE">SUPLENTE</option>
			<option value="CONTRATA">CONTRATA</option>
			<option value="TITULAR">TITULAR</option>
			<!--
			<option value="HONORARIO COVID">HONORARIO COVID</option>
			<option value="SUMA ALZADA">SUMA ALZADA</option>
			-->
			</select>
		</fieldset>

		<fieldset class="form-group col-6 col-md-3" id="div_covid_schedule">
			<label for="for_schedule_detail">Detalle de horario</label>
			<select name="schedule_detail" class="form-control" id="schedule_detail">
				<option value=""></option>
				<option value="DIURNO DE LUNES A VIERNES (DESDE LAS 08:00 HRS HASTA LAS 16:48 HRS)">DIURNO DE LUNES A VIERNES (DESDE LAS 08:00 HRS HASTA LAS 16:48 HRS)</option>
				<option value="DIURNO DE LUNES A JUEVES (DESDE LAS 08:00 HRS HASTA LAS 17:00 HRS) Y VIERNES (DESDE LAS 08:00 HRS HASTA LAS 16:00 HRS)">DIURNO DE LUNES A JUEVES (DESDE LAS 08:00 HRS HASTA LAS 17:00 HRS) Y VIERNES (DESDE LAS 08:00 HRS HASTA LAS 16:00 HRS)</option>
				<option value="DIURNO DE LUNES A JUEVES (DESDE LAS 08:30 HRS HASTA LAS 17:30 HRS) Y VIERNES (DESDE LAS 08:30 HRS HASTA LAS 16:30 HRS)">DIURNO DE LUNES A JUEVES (DESDE LAS 08:30 HRS HASTA LAS 17:30 HRS) Y VIERNES (DESDE LAS 08:30 HRS HASTA LAS 16:30 HRS)</option>
				<option value="FLEXIBILIDAD HORARIA DE LUNES A VIERNES (INGRESO ENTRE 07:30 HRS A 09:00 HRS Y SALIDA DEPENDIENDO DE LA HORA DE LLEGADA)">FLEXIBILIDAD HORARIA DE LUNES A VIERNES (INGRESO ENTRE 07:30 HRS A 09:00 HRS Y SALIDA DEPENDIENDO DE LA HORA DE LLEGADA)</option>
			</select>
		</fieldset>

		<fieldset class="form-group col-3" style="display: none" id="div_hsa_schedule">
			<label for="for_hsa_schedule_detail">Detalle de Horario HSA</label>
			<input type="text" class="form-control" id="for_hsa_schedule_detail" placeholder="" name="hsa_schedule_detail">
		</fieldset>

	</div>

	


	{{--
	<div class="form-row">

		<fieldset class="form-group col-12 col-md-3">
			<label for="for_estate">Estamento al que corresponde CS</label>
			<select name="estate" class="form-control" required id="estate" disabled>
				<option value=""></option>
				<option value="Profesional Médico">Profesional Médico</option>
				<option value="Profesional">Profesional</option>
				<option value="Técnico">Técnico</option>
				<option value="Administrativo">Administrativo</option>
				<option value="Farmaceutico">Farmaceutico</option>
				<option value="Odontólogo">Odontólogo</option>
				<option value="Bioquímico">Bioquímico</option>
				<option value="Auxiliar">Auxiliar</option>
				<!--
				<option value="Otro (justificar)">Otro (justificar)</option>
				-->
			</select>
		</fieldset>

		<fieldset class="form-group col-12 col-md-6">
			<label for="for_estate_other">Detalle estamento</label>
			<input type="text" class="form-control" id="for_estate_other" placeholder="" name="estate_other">
		</fieldset>


		<fieldset class="form-group col-6 col-md-3">
			<label for="for_rrhh_team">Equipo RRHH*</label>
			<select name="rrhh_team" class="form-control" id="rrhh_team" required>
				<option value=""></option>
				<option value="Residencia Médica">Residencia Médica</option>
				<option value="Médico Diurno">Médico Diurno</option>
				<option value="Enfermera Supervisora">Enfermera Supervisora</option>
				<option value="Enfermera Diurna">Enfermera Diurna</option>
				<option value="Enfermera Turno">Enfermera Turno</option>
				<option value="Kinesiólogo Diurno">Kinesiólogo Diurno</option>
				<option value="Kinesiólogo Turno">Kinesiólogo Turno</option>
				<option value="Téc.Paramédicos Diurno">Téc.Paramédicos Diurno</option>
				<option value="Téc.Paramédicos Turno">Téc.Paramédicos Turno</option>
				<option value="Auxiliar Diurno">Auxiliar Diurno</option>
				<option value="Auxiliar Turno">Auxiliar Turno</option>
				<option value="Terapeuta Ocupacional">Terapeuta Ocupacional</option>
				<option value="Químico Farmacéutico">Químico Farmacéutico</option>
				<option value="Bioquímico">Bioquímico</option>
				<option value="Fonoaudiologo">Fonoaudiologo</option>
				<option value="Prevencionista Diurno">Prevencionista Diurno</option>
				<option value="Administrativo Diurno">Administrativo Diurno</option>
				<option value="Administrativo Turno">Administrativo Turno</option>
				<option value="Biotecnólogo Turno">Biotecnólogo Turno</option>
				<option value="Matrona Turno">Matrona Turno</option>
				<option value="Matrona Diurno">Matrona Diurno</option>
				<option value="Otros técnicos">Otros técnicos</option>
				<option value="Psicólogo">Psicólogo</option>
				<option value="Tecn. Médico Diurno">Tecn. Médico Diurno</option>
				<option value="Tecn. Médico Turno">Tecn. Médico Turno</option>
				<option value="Trabajador Social">Trabajador Social</option>
				<option value="Nutricionista Diurno">Nutricionista Diurno</option>
				<option value="Prevencionista de Riesgo">Prevencionista de Riesgo</option>
				<option value="Nutricionista turno">Nutricionista turno</option>
				<option value="Informático">Informático</option>
				<option value="Ingeniero">Ingeniero</option>
				<option value="Constructor civil">Constructor civil</option>
				<option value="Arquitecto">Arquitecto</option>
				<option value="Dibujante técnico proyectista">Dibujante técnico proyectista</option>
				<option value="Técnico en rehabilitación">Técnico en rehabilitación</option>
				<option value="Psiquiatra">Psiquiatra</option>
				<option value="Monitor/a">Monitor/a</option>
				<option value="Preparador físico">Preparador físico</option>
				<option value="Otros técnicos">Otros técnicos</option>
				<option value="Otros profesionales">Otros profesionales</option>
				<option value="Médico por prestación">Médico por prestación</option>
			</select>
		</fieldset>

	</div>

	--}}



	<div class="form-row" id="div_objectives" style="display: none">
		<fieldset class="form-group col">
				<label for="for_estate">Objetivos*</label>
				<textarea id="objectives" name="objectives" class="form-control" rows="4" cols="50" disabled></textarea>
		</fieldset>
	</div>

	<!-- <div class="form-row" id="div_resolve" style="display: none">
		<fieldset class="form-group col">
				<label for="for_estate">Resuelvo</label>
				<textarea id="resolve" name="resolve" class="form-control" rows="4" cols="50" disabled></textarea>
		</fieldset>
	</div> -->


	@if(Auth::user()->organizationalUnit->establishment_id == 1)

	@else
	<div class="form-row" id="div_subt31" style="display: none">
		<fieldset class="form-group col">
				<label for="for_subt31">Subtitulo 31 <small>(Aparecerá en resolución, luego del texto "El gasto corresponde")</small></label>
				<textarea id="subt31" name="subt31" class="form-control" rows="4" cols="50" disabled></textarea>
		</fieldset>
	</div>
	@endif

	<div class="form-row">
		<fieldset class="form-group col">
				<label for="for_estate">Aguinaldos (se inserta en cláusula 8va)</label>
				<textarea name="bonus_indications" class="form-control" rows="4" cols="50" placeholder="ej: en septiembre un bono de 53.000 por concepto de aguinaldo de fiestas patrias"></textarea>
		</fieldset>
	</div>

	<div class="form-row" id="div_additional_benefits" style="display: none">
		<fieldset class="form-group col">
			<label for="for_estate">Beneficios adicionales (se inserta en cláusula 14)</label>
			<textarea id="additional_benefits" name="additional_benefits" class="form-control" rows="4" cols="50" disabled></textarea>

			<button type="button" class="btn btn-outline-primary btn-sm" id="alias_dias_descanzo">Días de descanso</button>
			<button type="button" class="btn btn-outline-primary btn-sm" id="alias_ausentarse_motivos_particulares">Ausentarse por motivos particulares</button>

			<button type="button" class="btn btn-outline-primary btn-sm" id="alias_capacitacion">Capacitación</button>
			@if(Auth::user()->organizationalUnit->establishment_id == 1)
			@else
			<button type="button" class="btn btn-outline-primary btn-sm" id="alias_fiestas_patrias">Aguinaldo fiestas patrias</button>
			<button type="button" class="btn btn-outline-primary btn-sm" id="alias_navidad">Aguinaldo navidad</button>
			@endif
			<button type="button" class="btn btn-outline-primary btn-sm" id="alias_devolucion">Devolución de tiempo</button>
		</fieldset>
	</div>

	<br>
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

		$("#programm_name option[value='PRAPS']").hide();
		$("#programm_name option[value='PESPI']").hide();
		$("#programm_name option[value='CHILE CRECE CONTIGO']").hide();
		$("#programm_name option[value='OTROS PROGRAMAS SSI']").hide();
		$("#programm_name option[value='LISTA ESPERA']").hide();
		$("#programm_name option[value='CAMPAÑA INVIERNO']").hide();
		$("#programm_name option[value='SENDA']").hide();

		$("#programm_name option[value='ADP DIRECTOR']").hide();
		$("#programm_name option[value='SENDA']").hide();
		$("#programm_name option[value='SENDA LEY ALCOHOLES']").hide();
		$("#programm_name option[value='SENDA UHCIP']").hide();
		$("#programm_name option[value='SENDA PSIQUIATRIA ADULTO']").hide();
		$("#programm_name option[value='SENADIS']").hide();
		$("#programm_name option[value='SUBT.31']").hide();

		$("#programm_name option[value='CONSULTORIO DE LLAMADA']").hide();
		$("#programm_name option[value='33 MIL HORAS']").hide();
		$("#programm_name option[value='DFL']").hide();
		$("#programm_name option[value='TURNOS VACANTES']").hide();
		$("#programm_name option[value='OTROS PROGRAMAS HETG']").hide();
		$("#programm_name option[value='CAMPAÑA INVIERNO']").hide();
		$("#programm_name option[value='PABELLON TARDE']").hide();
		$("#programm_name option[value='PABELLON GINE']").hide();
		$("#programm_name option[value='TURNO DE RESIDENCIA']").hide();
		$("#programm_name option[value='SENDA']").hide();



		$('#program_contract_type').on('change', function() {

			if (this.value == "Horas") {
				$('#for_daily_hours').val("");
				$('#for_nightly_hours').val("");
				$('#for_daily_hours').attr('readonly', true);
				$('#for_nightly_hours').attr('readonly', true);
				$('#for_weekly_hours').attr('disabled', 'disabled');
				$("#control_turnos").show();

				$("#working_day_type option[value='DIURNO']").hide();
				$("#working_day_type option[value='TERCER TURNO']").hide();
				$("#working_day_type option[value='TERCER TURNO - MODIFICADO']").hide();
				$("#working_day_type option[value='CUARTO TURNO']").hide();
				$("#working_day_type option[value='CUARTO TURNO - MODIFICADO']").hide();
				$("#working_day_type option[value='DIARIO']").hide();
				$("#working_day_type option[value='QUIRURGICO']").hide();

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

				$("#working_day_type option[value='DIURNO']").show();
				$("#working_day_type option[value='TERCER TURNO']").show();
				$("#working_day_type option[value='TERCER TURNO - MODIFICADO']").show();
				$("#working_day_type option[value='CUARTO TURNO']").show();
				$("#working_day_type option[value='CUARTO TURNO - MODIFICADO']").show();
				$("#working_day_type option[value='DIARIO']").show();
				$("#working_day_type option[value='QUIRURGICO']").show();

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
			$('#schedule_detail').attr('disabled', 'disabled');
			if (this.value == "HORA MÉDICA") {
				$('#rrhh_team').val('Residencia Médica');
				$('#rrhh_team').selectpicker('refresh');
			}
			if (this.value == "DIURNO PASADO A TURNO") {
				if ($('#program_contract_type').val() == "Horas") {
					$('#contractual_condition').removeAttr('disabled');
				}else{
					$('#contractual_condition').attr('disabled', 'disabled');
				}
			}else{
				$('#contractual_condition').attr('disabled', 'disabled');
			}
			if (this.value == "DIURNO") {
				$('#schedule_detail').removeAttr('disabled');
			}

			if (this.value == "DIARIO") {
				$('#for_weekly_hours').attr('disabled', 'disabled');
			}
			// else{
			// 	$('#for_weekly_hours').removeAttr('disabled');
			// }
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



	$('#type').on('change', function() {
		var value = this.value;
		if (value == "Suma alzada") {

			$("#programm_name option[value='Covid19-APS No Médicos']").hide();
			$("#programm_name option[value='Covid19-APS Médicos']").hide();
			$("#programm_name option[value='Covid19 No Médicos']").hide();
			$("#programm_name option[value='Covid19 Médicos']").hide();
			$('#digera_strategy').attr('disabled', 'disabled');


			$("#id_descripcion_servicio").hide();


			$("#div_hsa_schedule").show();
			$("#div_covid_schedule").hide();

			$('#objectives').removeAttr('disabled');
			$("#objectives").prop('required',true);
			//$('#objectives').removeAttr('disabled');
			$('#subt31').removeAttr('disabled');
			$("#div_subt31").show();
			// $('#resolve').removeAttr('disabled');
			$('#additional_benefits').removeAttr('disabled');
			$("#div_objectives").show();
			// $("#div_resolve").show();
			$("#div_additional_benefits").show();


			if ({{Auth::user()->organizationalUnit->establishment_id}} == 1) {
				$("#programm_name option[value='PRAPS']").hide();
				$("#programm_name option[value='PESPI']").hide();
				$("#programm_name option[value='CHILE CRECE CONTIGO']").hide();
				$("#programm_name option[value='OTROS PROGRAMAS SSI']").hide();
				$("#programm_name option[value='LISTA ESPERA']").hide();
				$("#programm_name option[value='CAMPAÑA INVIERNO']").hide();

				$("#programm_name option[value='ADP DIRECTOR']").hide();
				$("#programm_name option[value='SENDA']").hide();
				$("#programm_name option[value='SENDA LEY ALCOHOLES']").hide();
				$("#programm_name option[value='SENDA UHCIP']").hide();
				$("#programm_name option[value='SENDA PSIQUIATRIA ADULTO']").hide();
				$("#programm_name option[value='SENADIS']").hide();
				$("#programm_name option[value='SUBT.31']").hide();

				$("#programm_name option[value='CONSULTORIO DE LLAMADA']").show();
				$("#programm_name option[value='33 MIL HORAS']").show();
				$("#programm_name option[value='DFL']").show();
				$("#programm_name option[value='TURNOS VACANTES']").show();
				$("#programm_name option[value='OTROS PROGRAMAS HETG']").show();
				$("#programm_name option[value='CAMPAÑA INVIERNO']").show();
				$("#programm_name option[value='PABELLON TARDE']").show();
				$("#programm_name option[value='PABELLON GINE']").show();
				$("#programm_name option[value='TURNO DE RESIDENCIA']").show();
				$("#programm_name option[value='SENDA']").show();



			}else{
				$("#programm_name option[value='PRAPS']").show();
				$("#programm_name option[value='PESPI']").show();
				$("#programm_name option[value='CHILE CRECE CONTIGO']").show();
				$("#programm_name option[value='OTROS PROGRAMAS SSI']").show();
				$("#programm_name option[value='LISTA ESPERA']").show();
				$("#programm_name option[value='CAMPAÑA INVIERNO']").show();

				$("#programm_name option[value='ADP DIRECTOR']").show();
				$("#programm_name option[value='SENDA']").show();
				$("#programm_name option[value='SENDA LEY ALCOHOLES']").show();
				$("#programm_name option[value='SENDA UHCIP']").show();
				$("#programm_name option[value='SENDA PSIQUIATRIA ADULTO']").show();
				$("#programm_name option[value='SENADIS']").show();
				$("#programm_name option[value='SUBT.31']").show();

				$("#programm_name option[value='CONSULTORIO DE LLAMADA']").hide();
				$("#programm_name option[value='33 MIL HORAS']").hide();
				$("#programm_name option[value='DFL']").hide();
				$("#programm_name option[value='TURNOS VACANTES']").hide();
				$("#programm_name option[value='OTROS PROGRAMAS HETG']").hide();
				$("#programm_name option[value='CAMPAÑA INVIERNO']").hide();
				$("#programm_name option[value='PABELLON TARDE']").hide();
				$("#programm_name option[value='PABELLON GINE']").hide();
				$("#programm_name option[value='TURNO DE RESIDENCIA']").hide();
//				$("#programm_name option[value='SENDA']").hide();
			}
		}
		else
		{
			$("#div_hsa_schedule").hide();
			$("#div_covid_schedule").show();
			$("#programm_name option[value='Covid19-APS No Médicos']").show();
			$("#programm_name option[value='Covid19-APS Médicos']").show();
			$("#programm_name option[value='Covid19 No Médicos']").show();
			$("#programm_name option[value='Covid19 Médicos']").show();
			$('#digera_strategy').removeAttr('disabled');


			$("#id_descripcion_servicio").show();

			$('#objectives').attr('disabled', 'disabled');
			$("#objectives").prop('required',false);
			// $('#resolve').attr('disabled', 'disabled');
			$('#additional_benefits').attr('disabled', 'disabled');
			$("#div_objectives").hide();
			// $("#div_resolve").hide();
			$("#div_additional_benefits").hide();

			$("#programm_name option[value='PRAPS']").hide();
			$("#programm_name option[value='PESPI']").hide();
			$("#programm_name option[value='CHILE CRECE CONTIGO']").hide();
			$("#programm_name option[value='OTROS PROGRAMAS SSI']").hide();
			$("#programm_name option[value='LISTA ESPERA']").hide();
			$("#programm_name option[value='CAMPAÑA INVIERNO']").hide();

			$("#programm_name option[value='ADP DIRECTOR']").hide();
			$("#programm_name option[value='SENDA']").hide();
			$("#programm_name option[value='SENDA LEY ALCOHOLES']").hide();
			$("#programm_name option[value='SENDA UHCIP']").hide();
			$("#programm_name option[value='SENDA PSIQUIATRIA ADULTO']").hide();
			$("#programm_name option[value='SENADIS']").hide();
			$("#programm_name option[value='SUBT.31']").hide();

			$("#programm_name option[value='CONSULTORIO DE LLAMADA']").hide();
			$("#programm_name option[value='33 MIL HORAS']").hide();
			$("#programm_name option[value='DFL']").hide();
			$("#programm_name option[value='TURNOS VACANTES']").hide();
			$("#programm_name option[value='OTROS PROGRAMAS HETG']").hide();
			$("#programm_name option[value='CAMPAÑA INVIERNO']").hide();
			$("#programm_name option[value='PABELLON TARDE']").hide();
			$("#programm_name option[value='PABELLON GINE']").hide();
			$("#programm_name option[value='TURNO DE RESIDENCIA']").hide();
		}
	});



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

	    var run = $("#for_user_id").val();
	    var dv  = $("#for_dv").val();
	    var url = '{{route('webservices.fonasa')}}/?run='+run+'&dv='+dv;

	    $.getJSON(url, function(data) {
	        if(data){
	            document.getElementById("for_name").value = data.name;
	            document.getElementById("for_fathers_family").value = data.fathers_family;
	            document.getElementById("for_mothers_family").value = data.mothers_family;
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
	            document.getElementById("for_name").value = "";
	            document.getElementById("for_fathers_family").value = "";
	            document.getElementById("for_mothers_family").value = "";
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

			var start_date = new Date(shift_start_date + ' ' + start_hour);
			var end_date = new Date(shift_end_date + ' ' + end_hour);

			if (start_date > end_date) {
				alert("La fecha de salida es menor a la fecha de inicio, revise la información.");
				return;
			}

			const diffTime = Math.abs(start_date - end_date); //diffTime/3600000

			var observation = $("#observation").val();
      var markup = "<tr><td><input type='checkbox' name='record'></td><td> <input type='hidden' class='form-control' name='shift_start_date[]' id='shift_start_date' value='"+ shift_start_date +"'>"+ shift_start_date +"</td><td> <input type='hidden' class='form-control' name='shift_start_hour[]' id='start_hour' value='"+ start_hour +"'>" + start_hour + "</td><td> <input type='hidden' class='form-control' name='shift_end_date[]' id='shift_end_date' value='"+ shift_end_date +"'>"+ shift_end_date +"</td><td> <input type='hidden' class='form-control' name='shift_end_hour[]' id='end_hour' value='"+ end_hour +"'>" + end_hour + "</td><td>" + diffTime/3600000 + "</td><td> <input type='hidden' class='form-control' name='shift_observation[]' id='observation' value='"+ observation +"'>" + observation + "</td></tr>";
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


	$("#alias_dias_descanzo").click(function(){
		$('#additional_benefits').append("Derecho a días de descanso, correspondiente a 20 días hábiles, después de un año de prestación de servicio continúo en calidad de honorario, sin opción de acumulación.\n\n");
	});
	$("#alias_ausentarse_motivos_particulares").click(function(){
		$('#additional_benefits').append("Permisos para ausentarse de sus labores por motivos particulares hasta por seis días hábiles en el año, con goce de honorarios. Estos permisos podrán fraccionarse por días o medios días y serán resueltos por la Coordinadora del área correspondiente.\n\n");
	});
	$("#alias_capacitacion").click(function(){
		$('#additional_benefits').append("Acceso a aquellos programas de capacitación que no signifique un costo para el Servicio de Salud, siempre y cuando éstos sean atingentes a su área de desempeño. Las capacitaciones se deben enmarcar en curso, talleres, seminarios, etc., excluyéndose los cursos de perfeccionamiento. Además, se debe establecer la obligación de devolución y replica de los cursos.\n\n");
	});
	$("#alias_fiestas_patrias").click(function(){
		$('#additional_benefits').append("Aguinaldo de fiestas Patrias, homologado al monto establecido en la ley de reajuste vigente en el mes de pago (septiembre).\n\n");
	});
	$("#alias_navidad").click(function(){
		$('#additional_benefits').append("Aguinaldo de Navidad, homologado al monto establecido en la ley de reajuste vigente en el mes de pago (diciembre).\n\n");
	});
	$("#alias_viaticos").click(function(){
		$('#additional_benefits').append("El profesional tendrá derecho al pago de un honorario adicional cuando para el desarrollo de sus prestaciones deba ausentarse del lugar de desempeño, autorizado por la Dirección del Servicio de Salud Iquique.\n\n");
	});
	$("#alias_devolucion").click(function(){
		$('#additional_benefits').append("El prestador de servicios, podrá solicitar permisos de descansos complementarios para ausentarse de sus labores por motivos particulares, siempre qué por la naturaleza de sus servicios y previa autorización de su Jefatura, deban realizar prestaciones de servicios, fuera de la jornada  que estas estén ajustadas a los procedimientos de programación y autorización de los funcionarios.\n\n");
	});

</script>
@endsection
