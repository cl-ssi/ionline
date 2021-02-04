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
		    <label for="for_type">Tipo</label>
		    <select name="type" class="form-control" required>
					<option value="Covid">Honorarios - Covid</option>
          <option value="Genérico">Honorarios - Genérico</option>
        </select>
		</fieldset>

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
				<select class="form-control selectpicker" data-live-search="true" name="responsability_center_ou_id" required data-size="5">
					<option value=""></option>
          @foreach($responsabilityCenters as $key => $responsabilityCenter)
            <option value="{{$responsabilityCenter->id}}">{{$responsabilityCenter->name}}</option>
          @endforeach
        </select>
		</fieldset>

	</div>

	<div class="row">

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
				<label for="for_users">Jefe Directo</label>
				<select name="users[]" id="users" class="form-control selectpicker" data-live-search="true" data-size="5" required>
					<option value=""></option>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
		</fieldset>

		<fieldset class="form-group col">
				<label for="for_users">Subdirector(a)</label>
				<select name="users[]" id="subdirector_medico" class="form-control selectpicker" data-live-search="true" data-size="5">
					<option value=""></option>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id != "9882506" && $user->id != "13835321") disabled @endif>{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
				<!-- modificar rut por el que corresponda -->
				<!-- <input type="hidden" name="users[]" value="9882506" /> -->
		</fieldset>

		<!-- <fieldset class="form-group col">
				<label for="for_users">Subdirector Médico</label>
				<select name="users[]" id="prueba" class="form-control" >
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id == "9882506") selected disabled @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
		</fieldset> -->

		<fieldset class="form-group col">
				<label for="for_users">S.D.G.A SSI</label>
				<select name="users[]" id="sdga_servicio" class="form-control selectpicker" data-live-search="true" required="" data-size="5" readonly>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id == "14104369") selected @else disabled @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
				<!-- <input type="hidden" name="users[]" value="14104369" /> -->
		</fieldset>

	</div>
	<div class="row">

		<fieldset class="form-group col">
				<label for="for_users">S.G.D.P Hospital</label>
				<select name="users[]" id="jefe_finanzas" class="form-control selectpicker" data-live-search="true" required="" data-size="5" readonly>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id == "9018101") selected @else disabled @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
				<!-- <input type="hidden" name="users[]" value="9018101" /> -->
		</fieldset>

		<fieldset class="form-group col">
				<label for="for_users">Jefe Finanzas</label>
				<select name="users[]" id="jefe_finanzas" class="form-control selectpicker" data-live-search="true" required="" data-size="5" readonly>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id == "13866194") selected @else disabled @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
				<!-- <input type="hidden" name="users[]" value="13866194" /> -->
		</fieldset>

		<fieldset class="form-group col">
				<label for="for_users">S.G.D.P Hospital</label>
				<select name="users[]" id="jefe_finanzas" class="form-control selectpicker" data-live-search="true" required="" data-size="5" readonly>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id == "15685508") selected @else disabled @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
				<!-- <input type="hidden" name="users[]" value="15685508" /> -->
		</fieldset>

		<fieldset class="form-group col">
				<label for="for_users">Director</label>
				<select name="users[]" id="director" class="form-control selectpicker" data-live-search="true" required="" data-size="5" readonly>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id == "14101085") selected @else disabled @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
				<!-- <input type="hidden" name="users[]" value="14101085" /> -->
		</fieldset>

	</div>

	<br>

	<div class="border border-info rounded">
  <div class="row ml-1 mr-1">

		<fieldset class="form-group col">
        <label for="for_run">Run (sin DV)</label>
        <input type="number" min="1" max="50000000" class="form-control" id="for_run" name="run" required>
    </fieldset>

    <fieldset class="form-group col-1">
        <label for="for_dv">Digito</label>
        <input type="text" class="form-control" id="for_dv" name="dv" readonly>
    </fieldset>

		<fieldset class="form-group col-1">
        <label for="">&nbsp;</label>
        <button type="button" id="btn_fonasa" class="btn btn-outline-success">Fonasa&nbsp;</button>
    </fieldset>

    <fieldset class="form-group col">
		    <label for="for_name">Nombre completo</label>
		    <input type="text" class="form-control" id="name" placeholder="" name="name" required="required">
		</fieldset>

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

  </div>

	<div class="row ml-1 mr-1">

    <fieldset class="form-group col-4">
		    <label for="for_address">Dirección</label>
		    <input type="text" class="form-control" id="foraddress" placeholder="" name="address">
		</fieldset>

    <fieldset class="form-group col-4">
		    <label for="for_phone_number">Número telefónico</label>
		    <input type="text" class="form-control" id="for_phone_number" placeholder="" name="phone_number">
		</fieldset>

		<fieldset class="form-group col-4">
		    <label for="for_email">Correo electrónico</label>
		    <input type="text" class="form-control" id="for_email" placeholder="" name="email">
		</fieldset>

	</div>
	</div>
	<br>


  <div class="row">

		<fieldset class="form-group col">
		    <label for="for_request_date">Fecha Solicitud</label>
		    <input type="date" class="form-control" id="for_request_date" name="request_date" max="2030-12-31" required>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_start_date">Fecha de Inicio</label>
		    <input type="date" class="form-control" id="for_start_date" name="start_date" max="2030-12-31" required>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_end_date">Fecha de Término</label>
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
    </fieldset>

  </div>

  <div class="row">

    <fieldset class="form-group col">
		    <label for="for_programm_name">Nombre del programa</label>
		    <!-- <input type="text" class="form-control" id="for_programm_name" placeholder="" name="programm_name"> -->
        <select name="programm_name" class="form-control" required>
					<option value=""></option>
          <option value="Covid19-APS No Médicos">Covid19-APS No Médicos</option>
          <option value="Covid19-APS Médicos">Covid19-APS Médicos</option>
          <option value="Covid19 No Médicos">Covid19 No Médicos</option>
          <option value="Covid19 Médicos">Covid19 Médicos</option>
        </select>
		</fieldset>

    <!-- <fieldset class="form-group col">
		    <label for="for_other">Otro</label>
		    <select name="other" class="form-control" required>
          <option value="Brecha">Brecha</option>
          <option value="LM:LICENCIAS MEDICAS">LM:LICENCIAS MEDICAS</option>
          <option value="HE:HORAS EXTRAS">HE:HORAS EXTRAS</option>
        </select>
		</fieldset> -->

    <!-- <fieldset class="form-group col">
		    <label for="for_normal_hour_payment">Pago Hora Normal</label>
		    <select name="normal_hour_payment" class="form-control">
          <option value=""></option>
          <option value="MACROZONA">MACROZONA</option>
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_amount">Valor $</label>
		    <input type="number" class="form-control" id="for_amount" placeholder="" name="amount">
		</fieldset> -->

  </div>

  <div class="row">

    <fieldset class="form-group col">
		    <label for="for_program_contract_type">Tipo de Contratación</label>
		    <select name="program_contract_type" class="form-control" id="program_contract_type" required>
					<option value=""></option>
          <option value="Semanal">Semanal</option>
          <option value="Mensual">Mensual</option>
					<option value="Horas">Horas</option>
          <option value="Otro">Otro</option>
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
								<input type="date" class="form-control" name="shift_start_date" id="shift_start_date">
						</fieldset>
						<fieldset class="form-group col">
								<label for="for_estate">Hora</label>
								<input type="time" class="form-control" name="start_hour" id="start_hour">
						</fieldset>
						<fieldset class="form-group col">
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
		    <label for="for_estate">Estamento al que corresponde CS</label>
		    <select name="estate" class="form-control" required>
					<option value=""></option>
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
					<option value=""></option>
          <option value="DIURNO">DIURNO</option>
          <option value="TERCER TURNO">TERCER TURNO</option>
					<option value="TERCER TURNO">TERCER TURNO - MODIFICADO</option>
          <option value="CUARTO TURNO">CUARTO TURNO</option>
					<option value="CUARTO TURNO">CUARTO TURNO - MODIFICADO</option>
					<option value="OTRO">OTRO</option>
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
<script src='{{asset("js/jquery.rut.chileno.js")}}'></script>
<script type="text/javascript">

	$( document ).ready(function() {

		$("#control_turnos").hide();
		$('#program_contract_type').on('change', function() {
			if (this.value == "Horas") {
				$('#for_daily_hours').val("");
				$('#for_nightly_hours').val("");
				$('#for_daily_hours').attr('readonly', true);
				$('#for_nightly_hours').attr('readonly', true);
				$('#for_weekly_hours').attr('disabled', 'disabled');
				$("#control_turnos").show();
			}else{
				$('#for_daily_hours').attr('readonly', false);
				$('#for_nightly_hours').attr('readonly', false);
				$('#for_weekly_hours').removeAttr('disabled');
				$("#control_turnos").hide();
			}
		});

		//obtiene digito verificador
    $('input[name=run]').keyup(function(e) {
        var str = $("#for_run").val();
        $('#for_dv').val($.rut.dv(str));
    });
	});

	$('#subdirection_ou_id').on('change', function() {
		var value = this.value;
		//subdirección gestión del cuidado al paciente
		if (value == 85) {
			// $('#subdirector_medico option[value=13835321]').attr('selected', 'selected');
			// $('#subdirector_medico option[value=13835321]').prop('selected', 'selected');
			$('select[id=subdirector_medico]').val(13835321);
			$('#subdirector_medico').selectpicker('refresh');
		}
		if (value != 85) {
			// $('#subdirector_medico option[value=9882506]').attr('selected', 'selected');
			// $('#subdirector_medico option[value=9882506]').prop('selected', 'selected');
			$('select[id=subdirector_medico]').val(9882506);
			$('#subdirector_medico').selectpicker('refresh')
		}
	});

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

</script>
@endsection
