@extends('layouts.app')

@section('title', 'Editar Solicitud de Contratación')

@section('content')

@include('service_requests.partials.nav')

<h3>Editar de Contratación de Servicios</h3>

  @can('Service Request: additional data rrhh')

    <form method="POST" action="{{ route('rrhh.service-request.update', $serviceRequest) }}" enctype="multipart/form-data">

  @else

    @if($serviceRequest->where('user_id', Auth::user()->id)->orwhere('responsable_id',Auth::user()->id)->count() > 0)
      <form method="POST" action="{{ route('rrhh.service-request.update', $serviceRequest) }}" enctype="multipart/form-data">
    @else
      <!-- si existe una firma, no se deja modificar solicitud -->
      @if($serviceRequest->SignatureFlows->where('type','!=','creador')->where('type','!=','Responsable')->whereNotNull('status')->count() > 0)
        <form>
      @else
        <form method="POST" action="{{ route('rrhh.service-request.update', $serviceRequest) }}" enctype="multipart/form-data">
      @endif
    @endif

  @endcan



  @csrf
  @method('PUT')

	<div class="form-row">

    <fieldset class="form-group col-6 col-md-2">
		    <label for="for_program_contract_type">Tipo</label>
		    <select name="program_contract_type" id="program_contract_type" class="form-control" required>
          <!-- <option value="Semanal" @if($serviceRequest->program_contract_type == 'Semanal') selected @endif >Semanal</option> -->
          <option value="Mensual" @if($serviceRequest->program_contract_type == 'Mensual') selected @endif >Mensual</option>
          <option value="Horas" @if($serviceRequest->program_contract_type == 'Horas') selected @endif >Horas</option>
          <!-- <option value="Otro" @if($serviceRequest->program_contract_type == 'Otro') selected @endif >Otro</option> -->
        </select>
		</fieldset>

    	<fieldset class="form-group col-6 col-md-2">
		    <label for="for_name">Origen Financiamiento</label>
		    <select name="type" class="form-control" id="type" required>
          <option style="background-color:#F5A7A7;" value="Covid" @if($serviceRequest->type == 'Covid') selected @endif>Covid (Sólo 2021)</option>
          <option style="background-color:#8fbc8f;" value="Suma alzada"  @if($serviceRequest->type == 'Suma alzada') selected @endif>Suma alzada</option>
          <!-- <option value="Genérico" @if($serviceRequest->type == 'Genérico') selected @endif >Honorarios - Genérico</option> -->
        </select>
		</fieldset>

		<fieldset class="form-group col-6 col-md-4">
			<label for="for_users">Responsable</label>
			<select name="responsable_id" id="responsable_id" class="form-control selectpicker" data-live-search="true" required="" data-size="5" disabled>
				@foreach($users as $key => $user)
					<option value="{{$user->id}}" @if($user->id == $serviceRequest->SignatureFlows->where('sign_position',1)->first()->responsable_id) selected @endif >{{$user->getFullNameAttribute()}}</option>
				@endforeach
			</select>
		</fieldset>

		<fieldset class="form-group col-6 col-md-4">
			<label for="for_users">Supervisor</label>
			<select name="users[]" id="users" class="form-control selectpicker" data-live-search="true" required="" data-size="5" disabled>
				@foreach($users as $key => $user)
					<option value="{{$user->id}}" @if($user->id == $serviceRequest->SignatureFlows->where('sign_position',2)->first()->responsable_id) selected @endif >{{$user->getFullNameAttribute()}}</option>
				@endforeach
			</select>
		</fieldset>

    <fieldset class="form-group col-6 col-md-4">
		    <label for="for_subdirection_ou_id">Subdirección</label>
				<select class="form-control selectpicker" data-live-search="true" name="subdirection_ou_id" required="" data-size="5" id="subdirection_ou_id">
          @foreach($subdirections as $key => $subdirection)
            <option value="{{$subdirection->id}}" @if($serviceRequest->subdirection_ou_id == $subdirection->id) selected @endif >{{$subdirection->name}}</option>
          @endforeach
        </select>
		</fieldset>

    	<fieldset class="form-group col-6 col-md-4">
		    <label for="for_responsability_center_ou_id">Centro de Responsabilidad</label>
				<select class="form-control selectpicker" data-live-search="true" name="responsability_center_ou_id" required="" data-size="5" id="responsability_center_ou_id">
			@foreach($responsabilityCenters as $key => $responsabilityCenter)
				<option value="{{$responsabilityCenter->id}}" @if($serviceRequest->responsability_center_ou_id == $responsabilityCenter->id) selected @endif >{{$responsabilityCenter->name}}</option>
			@endforeach
        	</select>
		</fieldset>


	</div>

  <div class="form-row">

    @foreach($serviceRequest->SignatureFlows->where('sign_position','>',2)->where('status','!=',2)->sortBy('sign_position') as $key => $signatureFlows)

      <fieldset class="form-group col-sm-4">
  				<label for="for_users">{{$signatureFlows->employee}}</label>
  				<select name="users[]" id="users" class="form-control selectpicker" data-live-search="true" required="" data-size="5" disabled>
  					@foreach($users as $key => $user)
  						<option value="{{$user->id}}" @if($user->id == $signatureFlows->responsable_id) selected @endif >{{$user->getFullNameAttribute()}}</option>
  					@endforeach
  				</select>
  		</fieldset>

    @endforeach

  </div>

  <br>

  <div class="card border border-danger">
    <div class="card-body">
      <div class="form-row">

        <fieldset class="form-group col-8 col-md-3">
            <label for="for_rut">Rut</label>
            <input type="text" class="form-control" id="for_rut" required="required"
              value="{{ $serviceRequest->employee->id }}" disabled>
        </fieldset>

        <fieldset class="form-group col-4 col-md-1">
            <label for="for_dv">Digito</label>
            <input type="text" class="form-control" id="for_dv" disabled
              value="{{ $serviceRequest->employee->dv }}">
        </fieldset>

        <fieldset class="form-group col-12 col-md-8">
            <label for="for_name">Nombre completo</label>
            <input type="text" class="form-control" id="for_name" required="required"
              value="{{ $serviceRequest->employee->getFullNameAttribute() }}" disabled>
        </fieldset>

      </div>

      <div class="form-row">

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_nationality">Nacionalidad</label>
            <select name="nationality" class="form-control" disabled>
              <option value=""></option>
              @foreach($countries as $key => $country)
                <option value="{{$country->id}}" @if($serviceRequest->employee->country_id == $country->id) selected @endif>{{$country->name}}</option>
              @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-5">
            <label for="for_address">Dirección</label>
            <input type="text" class="form-control" id="foraddress" name="address" value="{{$serviceRequest->address}}">
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_phone_number">Número telefónico</label>
            <input type="text" class="form-control" id="for_phone_number" name="phone_number" value="{{$serviceRequest->phone_number}}">
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_email">Correo electrónico</label>
            <input type="text" class="form-control" id="for_email" name="email" value="{{$serviceRequest->email}}">
        </fieldset>

      </div>
    </div>
  </div>

  <br>

  <div class="form-row">

    <fieldset class="form-group col-6 col-md-3">
		    <label for="for_name">Tipo de Contrato</label>
		    <select name="contract_type" class="form-control" required>
          <option value="NUEVO" @if($serviceRequest->contract_type == 'NUEVO') selected @endif >Nuevo</option>
          <option value="ANTIGUO" @if($serviceRequest->contract_type == 'ANTIGUO') selected @endif>Antiguo</option>
          <option value="CONTRATO PERM" @if($serviceRequest->contract_type == 'CONTRATO PERM') selected @endif>Permanente</option>
          <option value="PRESTACION" @if($serviceRequest->contract_type == 'PRESTACION') selected @endif>Prestación</option>
        </select>
		</fieldset>

    <fieldset class="form-group col-6 col-md-3">
		    <label for="for_request_date">Fecha Solicitud</label>
		    <input type="date" class="form-control" id="for_request_date" name="request_date" required value="{{\Carbon\Carbon::parse($serviceRequest->request_date)->format('Y-m-d')}}" min="2020-01-01" max="2022-12-31">
		</fieldset>

    <fieldset class="form-group col-6 col-md-3">
		    <label for="for_start_date">F.Inicio de Contrato</label>
		    <input type="date" class="form-control" id="for_start_date" name="start_date" required value="{{\Carbon\Carbon::parse($serviceRequest->start_date)->format('Y-m-d')}}" min="2020-01-01" max="2022-12-31">
		</fieldset>

    <fieldset class="form-group col-6 col-md-3">
		    <label for="for_end_date">F.Fin de Contrato</label>
		    <input type="date" class="form-control" id="for_end_date" name="end_date" required value="{{\Carbon\Carbon::parse($serviceRequest->end_date)->format('Y-m-d')}}" min="2020-01-01" max="2022-12-31">
		</fieldset>

  </div>

  <hr>

	<div class="form-row">

		<fieldset class="form-group col-12 col-md-4">
			<label for="for_establishment_id">Establecimiento</label>
			<select name="establishment_id" class="form-control" required>
			<option value=""></option>
			@foreach($establishments as $key => $establishment)
				<option value="{{$establishment->id}}" @if($serviceRequest->establishment_id == $establishment->id) selected @endif>{{$establishment->name}}</option>
			@endforeach
			</select>
		</fieldset>

		<fieldset class="form-group col-6 col-md-3">
			<label for="for_profession_id">Profesión</label>
			<select name="profession_id" class="form-control" required id="profession_id">
				<option value=""></option>
			@foreach($professions as $profession)
				<option value="{{$profession->id}}" @if($serviceRequest->profession_id == $profession->id) selected @endif>{{$profession->name}}</option>
			@endforeach
			</select>
		</fieldset>

		<fieldset class="form-group col-6 col-md-2">
		    <label for="for_weekly_hours">Hrs.Semanales</label>
		    <select name="weekly_hours" class="form-control" id="for_weekly_hours" required>
				<option value=""></option>
				<option value="44" @if($serviceRequest->weekly_hours == 44) selected @endif>44</option>
				<option value="33" @if($serviceRequest->weekly_hours == 33) selected @endif>33</option>
				<option value="30" @if($serviceRequest->weekly_hours == 30) selected @endif>30</option>
				<option value="28" @if($serviceRequest->weekly_hours == 28) selected @endif>28</option>
				<option value="22" @if($serviceRequest->weekly_hours == 22) selected @endif>22</option>
				<option value="20" @if($serviceRequest->weekly_hours == 20) selected @endif>20</option>
				<option value="16" @if($serviceRequest->weekly_hours == 16) selected @endif>16</option>
				<option value="15" @if($serviceRequest->weekly_hours == 15) selected @endif>15</option>
				<option value="11" @if($serviceRequest->weekly_hours == 11) selected @endif>11</option>
				<option value="9" @if($serviceRequest->weekly_hours == 9) selected @endif>9</option>
				<option value="8.5" @if($serviceRequest->weekly_hours == 8.5) selected @endif>8.5</option>
				<option value="7.5" @if($serviceRequest->weekly_hours == 7.5) selected @endif>7.5</option>
				<option value="5" @if($serviceRequest->weekly_hours == 5) selected @endif>5</option>
				<option value="4" @if($serviceRequest->weekly_hours == 4) selected @endif>4</option>
				<option value="3" @if($serviceRequest->weekly_hours == 3) selected @endif>3</option>
			</select>
		</fieldset>

		<fieldset class="form-group col-6 col-md-3">
		    <label for="for_working_day_type">Jornada de Trabajo</label>
		    <select name="working_day_type" class="form-control" id="working_day_type" required>
				<!-- <option value="08:00 a 16:48 hrs (L-M-M-J-V)" @if($serviceRequest->working_day_type == '08:00 a 16:48 hrs (L-M-M-J-V)') selected @endif >08:00 a 16:48 hrs (L-M-M-J-V)</option> -->
				<option value="DIURNO" @if($serviceRequest->working_day_type == 'DIURNO') selected @endif >DIURNO</option>
				<option value="VESPERTINO" @if($serviceRequest->working_day_type == 'VESPERTINO') selected @endif >VESPERTINO</option>
				<option value="TERCER TURNO" @if($serviceRequest->working_day_type == 'TERCER TURNO') selected @endif >TERCER TURNO</option>
				<option value="TERCER TURNO - MODIFICADO" @if($serviceRequest->working_day_type == 'TERCER TURNO - MODIFICADO') selected @endif >TERCER TURNO - MODIFICADO</option>
				<option value="CUARTO TURNO" @if($serviceRequest->working_day_type == 'CUARTO TURNO') selected @endif >CUARTO TURNO</option>
				<option value="CUARTO TURNO - MODIFICADO" @if($serviceRequest->working_day_type == 'CUARTO TURNO - MODIFICADO') selected @endif >CUARTO TURNO - MODIFICADO</option>

				<option value="DIURNO PASADO A TURNO" @if($serviceRequest->working_day_type == 'DIURNO PASADO A TURNO') selected @endif >DIURNO PASADO A TURNO</option>
				<option value="HORA MÉDICA" @if($serviceRequest->working_day_type == 'HORA MÉDICA') selected @endif >HORA MÉDICA</option>
				<option value="HORA EXTRA" @if($serviceRequest->working_day_type == 'HORA EXTRA') selected @endif>HORA EXTRA</option>
				<option value="TURNO EXTRA" @if($serviceRequest->working_day_type == 'TURNO EXTRA') selected @endif>TURNO EXTRA</option>

				<option value="TURNO DE REEMPLAZO" @if($serviceRequest->working_day_type == 'TURNO DE REEMPLAZO') selected @endif>TURNO DE REEMPLAZO</option>

				<option value="OTRO" @if($serviceRequest->working_day_type == 'OTRO') selected @endif >OTRO</option>

				<option value=""></option>
				<option value="DIARIO" @if($serviceRequest->working_day_type == 'DIARIO') selected @endif>DIARIO</option>
        	</select>
		</fieldset>
		
		<fieldset class="form-group col-12 col-md-12">
		    <label for="for_working_day_type_other">Otro <small>(Saldrá en la resolución luego del horario)</small></label>
		    <input type="text" class="form-control" id="for_working_day_type_other" placeholder="" name="working_day_type_other" value="{{ $serviceRequest->working_day_type_other }}">
		</fieldset>

	</div>

  <div class="form-row">

    <fieldset class="form-group col">
        <label for="for_service_description">Descripción Servicio*</label>
        <textarea id="service_description" name="service_description" class="form-control" rows="5" required>{{ $serviceRequest->service_description }}</textarea>
    </fieldset>

  </div>

  <!-- <div class="card" id="control_turnos">
    <div class="card-header">
      Control de Turnos
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        <div class="form-row">
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

              @can('Service Request: additional data rrhh')

                <button type="button" class="btn btn-primary form-control add-row" id="shift_button_add" formnovalidate="formnovalidate">Ingresar</button>

              @else

                @if($serviceRequest->where('user_id', Auth::user()->id)->orwhere('responsable_id',Auth::user()->id)->count() > 0)
                  @if($serviceRequest->SignatureFlows->where('type','!=','creador')->whereNotNull('status')->count() > 0)
                    <button type="button" class="btn btn-primary form-control add-row" id="shift_button_add" formnovalidate="formnovalidate" disabled>Ingresar</button>
                  @else
                    <button type="button" class="btn btn-primary form-control add-row" id="shift_button_add" formnovalidate="formnovalidate">Ingresar</button>
                  @endif
                @else
                  <button type="button" class="btn btn-primary form-control add-row" id="shift_button_add" formnovalidate="formnovalidate" disabled>Ingresar</button>
                @endif

              @endcan

          </fieldset>
        </div>

        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Entrada</th>
                    <th>H.Inicio</th>
                    <th>Salida</th>
                    <th>H.Término</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
              @foreach($serviceRequest->shiftControls as $key => $shiftControl)
                <tr>
                  <td><input type='checkbox' name='record'></td>
                  <td><input type="hidden" class="form-control" name="shift_start_date[]" value="{{Carbon\Carbon::parse($shiftControl->start_date)->format('Y-m-d')}}">{{Carbon\Carbon::parse($shiftControl->start_date)->format('Y-m-d')}}</td>
                  <td><input type="hidden" class="form-control" name="shift_start_hour[]" value="{{Carbon\Carbon::parse($shiftControl->start_date)->format('H:i')}}">{{Carbon\Carbon::parse($shiftControl->start_date)->format('H:i')}}</td>
                  <td><input type="hidden" class="form-control" name="shift_end_date[]" value="{{Carbon\Carbon::parse($shiftControl->end_date)->format('Y-m-d')}}">{{Carbon\Carbon::parse($shiftControl->end_date)->format('Y-m-d')}}</td>
                  <td><input type="hidden" class="form-control" name="shift_end_hour[]" value="{{Carbon\Carbon::parse($shiftControl->end_date)->format('H:i')}}">{{Carbon\Carbon::parse($shiftControl->end_date)->format('H:i')}}</td>
                  <td><input type="hidden" class="form-control" name="shift_observation[]" value="{{$shiftControl->observation}}">{{$shiftControl->observation}}</td>
                </tr>
              @endforeach
            </tbody>
        </table>

        @can('Service Request: additional data rrhh')

          <button type="button" class="btn btn-danger delete-row">Eliminar filas</button>

        @else

          @if($serviceRequest->where('user_id', Auth::user()->id)->orwhere('responsable_id',Auth::user()->id)->count() > 0)
            @if($serviceRequest->SignatureFlows->where('type','!=','creador')->whereNotNull('status')->count() > 0)
              <button type="button" class="btn btn-danger delete-row" disabled>Eliminar filas</button>
            @else
              <button type="button" class="btn btn-danger delete-row">Eliminar filas</button>
            @endif
          @else
            <button type="button" class="btn btn-danger delete-row" disabled>Eliminar filas</button>
          @endif

        @endcan

      </li>
    </ul>
  </div> -->

@if($serviceRequest->fulfillments->count()>0)
  @if($serviceRequest->working_day_type != "DIARIO")
    @livewire('service-request.shifts-control', ['fulfillment' => $serviceRequest->fulfillments->first()])
  @endif
@endif

  <br>

	<div class="form-row">

    	<fieldset class="form-group col-6 col-md">
		    <label for="for_programm_name">Nombre Programa</label>
		    <!-- <input type="text" class="form-control" id="for_programm_name" placeholder="" name="programm_name" value="{{ $serviceRequest->programm_name }}"> -->
        	<select name="programm_name" class="form-control">
				<option value=""></option>
				<option value="Covid19-APS No Médicos" @if($serviceRequest->programm_name == 'Covid19-APS No Médicos') selected @endif >Covid19-APS No Médicos</option>
				<option value="Covid19-APS Médicos" @if($serviceRequest->programm_name == 'Covid19-APS Médicos') selected @endif>Covid19-APS Médicos</option>
				<option value="Covid19 No Médicos" @if($serviceRequest->programm_name == 'Covid19 No Médicos') selected @endif>Covid19 No Médicos</option>
				<option value="Covid19 Médicos" @if($serviceRequest->programm_name == 'Covid19 Médicos') selected @endif>Covid19 Médicos</option>

				@if(Auth::user()->organizationalUnit->establishment_id == 1)
				<option value="Covid 2022" @if($serviceRequest->programm_name == 'Covid 2022') selected @endif>Covid 2022</option>
				<option value="CONSULTORIO DE LLAMADA" @if($serviceRequest->programm_name == 'CONSULTORIO DE LLAMADA') selected @endif>CONSULTORIO DE LLAMADA</option>
				<option value="33 MIL HORAS" @if($serviceRequest->programm_name == '33 MIL HORAS') selected @endif>33 MIL HORAS</option>
				<option value="DFL" @if($serviceRequest->programm_name == 'DFL') selected @endif>DFL</option>
				<option value="TURNOS VACANTES" @if($serviceRequest->programm_name == 'TURNOS VACANTES') selected @endif>TURNOS VACANTES</option>
				<option value="OTROS PROGRAMAS HETG" @if($serviceRequest->programm_name == 'OTROS PROGRAMAS HETG') selected @endif>OTROS PROGRAMAS HETG</option>
				<option value="CAMPAÑA INVIERNO" @if($serviceRequest->programm_name == 'CAMPAÑA INVIERNO') selected @endif>CAMPAÑA INVIERNO</option>
				<option value="PABELLON TARDE" @if($serviceRequest->programm_name == 'PABELLON TARDE') selected @endif>PABELLON TARDE</option>
				<option value="PABELLON GINE" @if($serviceRequest->programm_name == 'PABELLON GINE') selected @endif>PABELLON GINE</option>
				<option value="TURNO DE RESIDENCIA" @if($serviceRequest->programm_name == 'TURNO DE RESIDENCIA') selected @endif>TURNO DE RESIDENCIA</option>
				<option value="SENDA" @if($serviceRequest->programm_name == 'SENDA') selected @endif>SENDA</option>

				@else
				<option value="PRAPS" @if($serviceRequest->programm_name == 'PRAPS') selected @endif>PRAPS</option>
				<option value="PESPI" @if($serviceRequest->programm_name == 'PESPI') selected @endif>PESPI</option>
				<option value="CHILE CRECE CONTIGO" @if($serviceRequest->programm_name == 'CHILE CRECE CONTIGO') selected @endif>CHILE CRECE CONTIGO</option>
				<option value="OTROS PROGRAMAS SSI" @if($serviceRequest->programm_name == 'OTROS PROGRAMAS SSI') selected @endif>OTROS PROGRAMAS SSI</option>
				<option value="LISTA ESPERA" @if($serviceRequest->programm_name == 'LISTA ESPERA') selected @endif>LISTA ESPERA</option>
				<option value="CAMPAÑA INVIERNO" @if($serviceRequest->programm_name == 'CAMPAÑA INVIERNO') selected @endif>CAMPAÑA INVIERNO</option>

				<option value="ADP DIRECTOR" @if($serviceRequest->programm_name == 'ADP DIRECTOR') selected @endif>ADP DIRECTOR</option>
				<option value="SENDA" @if($serviceRequest->programm_name == 'SENDA') selected @endif>SENDA</option>
				<option value="SENDA LEY ALCOHOLES" @if($serviceRequest->programm_name == 'SENDA LEY ALCOHOLES') selected @endif>SENDA LEY ALCOHOLES</option>
				<option value="SENDA UHCIP" @if($serviceRequest->programm_name == 'SENDA UHCIP') selected @endif>SENDA UHCIP</option>
				<option value="SENDA PSIQUIATRIA ADULTO" @if($serviceRequest->programm_name == 'SENDA PSIQUIATRIA ADULTO') selected @endif>SENDA PSIQUIATRIA ADULTO</option>
				<option value="SENADIS" @if($serviceRequest->programm_name == 'SENADIS') selected @endif>SENADIS</option>
				<option value="SUBT.31" @if($serviceRequest->programm_name == 'SUBT.31') selected @endif>SUBT.31</option>
				@endif

        	</select>
		</fieldset>


		<fieldset class="form-group col-12 col-md-3">
			<label for="for_digera_strategy">Estrategia Digera Covid</label>
			<select name="digera_strategy" class="form-control" id="digera_strategy">
			<option value=""></option>
			<option value="Camas MEDIAS Aperturadas" @if($serviceRequest->digera_strategy == "Camas MEDIAS Aperturadas") selected @endif>Camas MEDIAS Aperturadas</option>
			<option value="Camas MEDIAS Complejizadas" @if($serviceRequest->digera_strategy == "Camas MEDIAS Complejizadas") selected @endif>Camas MEDIAS Complejizadas</option>
			<option value="Camas UCI Aperturadas" @if($serviceRequest->digera_strategy == "Camas UCI Aperturadas") selected @endif>Camas UCI Aperturadas</option>
			<option value="Camas UCI Complejizadas" @if($serviceRequest->digera_strategy == "Camas UCI Complejizadas") selected @endif>Camas UCI Complejizadas</option>
			<option value="Camas UTI Aperturadas" @if($serviceRequest->digera_strategy == "Camas UTI Aperturadas") selected @endif>Camas UTI Aperturadas</option>
			<option value="Camas UTI Complejizadas" @if($serviceRequest->digera_strategy == "Camas UTI Complejizadas") selected @endif>Camas UTI Complejizadas</option>
			<option value="Cupos Hosp. Domiciliaria" @if($serviceRequest->digera_strategy == "Cupos Hosp. Domiciliaria") selected @endif>Cupos Hosp. Domiciliaria</option>
			<option value="Refuerzo Anatomía Patologica" @if($serviceRequest->digera_strategy == "Refuerzo Anatomía Patologica") selected @endif>Refuerzo Anatomía Patologica</option>
			<option value="Refuerzo Laboratorio" @if($serviceRequest->digera_strategy == "Refuerzo Laboratorio") selected @endif>Refuerzo Laboratorio</option>
			<option value="Refuerzo SAMU" @if($serviceRequest->digera_strategy == "Refuerzo SAMU") selected @endif>Refuerzo SAMU</option>
			<option value="Refuerzo UEH" @if($serviceRequest->digera_strategy == "Refuerzo UEH") selected @endif>Refuerzo UEH</option>
			<option value="Migración Colchane" @if($serviceRequest->digera_strategy == "Migración Colchane") selected @endif>Migración Colchane</option>
			</select>
		</fieldset>

		<fieldset class="form-group col-6 col-md">
			<label for="for_contractual_condition">Calidad Contractual</label>
			<select name="contractual_condition" class="form-control">
			<option value=""></option>
			<option value="SUPLENTE" @if($serviceRequest->contractual_condition == 'SUPLENTE') selected @endif >SUPLENTE</option>
			<option value="CONTRATA" @if($serviceRequest->contractual_condition == 'CONTRATA') selected @endif>CONTRATA</option>
			<option value="TITULAR" @if($serviceRequest->contractual_condition == 'TITULAR') selected @endif>TITULAR</option>
			<!-- <option value="HONORARIO COVID" @if($serviceRequest->contractual_condition == 'HONORARIO COVID') selected @endif>HONORARIO COVID</option>
			<option value="SUMA ALZADA" @if($serviceRequest->contractual_condition == 'SUMA ALZADA') selected @endif>SUMA ALZADA</option> -->
			</select>
		</fieldset>

    @if(
    $serviceRequest->schedule_detail == 'DIURNO DE LUNES A JUEVES (DESDE LAS 08:00 HRS HASTA LAS 17:00 HRS) Y VIERNES (DESDE LAS 08:00 HRS HASTA LAS 16:00 HRS)'
    or
    $serviceRequest->schedule_detail == 'DIURNO DE LUNES A JUEVES (DESDE LAS 08:30 HRS HASTA LAS 17:30 HRS) Y VIERNES (DESDE LAS 08:30 HRS HASTA LAS 16:30 HRS)'
    or
    $serviceRequest->schedule_detail == 'FLEXIBILIDAD HORARIA DE LUNES A VIERNES (INGRESO ENTRE 07:30 HRS A 09:00 HRS Y SALIDA DEPENDIENDO DE LA HORA DE LLEGADA)'
    )
		<fieldset class="form-group col-3" id="div_covid_schedule">
			<label for="for_schedule_detail">Detalle de horario</label>
			<select name="schedule_detail" class="form-control" id="schedule_detail">
				<option value=""></option>
				<option value="DIURNO DE LUNES A VIERNES (DESDE LAS 08:00 HRS HASTA LAS 16:48 HRS)" @if($serviceRequest->schedule_detail == "DIURNO DE LUNES A VIERNES (DESDE LAS 08:00 HRS HASTA LAS 16:48 HRS)") selected @endif>DIURNO DE LUNES A VIERNES (DESDE LAS 08:00 HRS HASTA LAS 16:48 HRS)</option>
				<option value="DIURNO DE LUNES A JUEVES (DESDE LAS 08:00 HRS HASTA LAS 17:00 HRS) Y VIERNES (DESDE LAS 08:00 HRS HASTA LAS 16:00 HRS)" @if($serviceRequest->schedule_detail == "DIURNO DE LUNES A JUEVES (DESDE LAS 08:00 HRS HASTA LAS 17:00 HRS) Y VIERNES (DESDE LAS 08:00 HRS HASTA LAS 16:00 HRS)") selected @endif>DIURNO DE LUNES A JUEVES (DESDE LAS 08:00 HRS HASTA LAS 17:00 HRS) Y VIERNES (DESDE LAS 08:00 HRS HASTA LAS 16:00 HRS)</option>
				<option value="DIURNO DE LUNES A JUEVES (DESDE LAS 08:30 HRS HASTA LAS 17:30 HRS) Y VIERNES (DESDE LAS 08:30 HRS HASTA LAS 16:30 HRS)" @if($serviceRequest->schedule_detail == "DIURNO DE LUNES A JUEVES (DESDE LAS 08:30 HRS HASTA LAS 17:30 HRS) Y VIERNES (DESDE LAS 08:30 HRS HASTA LAS 16:30 HRS)") selected @endif>DIURNO DE LUNES A JUEVES (DESDE LAS 08:30 HRS HASTA LAS 17:30 HRS) Y VIERNES (DESDE LAS 08:30 HRS HASTA LAS 16:30 HRS)</option>
				<option value="FLEXIBILIDAD HORARIA DE LUNES A VIERNES (INGRESO ENTRE 07:30 HRS A 09:00 HRS Y SALIDA DEPENDIENDO DE LA HORA DE LLEGADA)" @if($serviceRequest->schedule_detail == "FLEXIBILIDAD HORARIA DE LUNES A VIERNES (INGRESO ENTRE 07:30 HRS A 09:00 HRS Y SALIDA DEPENDIENDO DE LA HORA DE LLEGADA)") selected @endif>FLEXIBILIDAD HORARIA DE LUNES A VIERNES (INGRESO ENTRE 07:30 HRS A 09:00 HRS Y SALIDA DEPENDIENDO DE LA HORA DE LLEGADA)</option>
			</select>
		</fieldset>

    @else
    	<fieldset class="form-group col-12 col-md-3" id="div_hsa_schedule">
			<label for="for_hsa_schedule_detail">Detalle de Horario HSA</label>
			<input type="text" class="form-control" id="for_hsa_schedule_detail" value="{{$serviceRequest->schedule_detail}}" name="hsa_schedule_detail">
		</fieldset>
    @endif

	</div>

	<div class="form-row">

		<fieldset class="form-group col-12 col-md">
			<label for="for_estate">Estamento al que corresponde CS</label>
			<select name="estate" class="form-control" required>
				<option value="Profesional Médico" @if($serviceRequest->estate == 'Profesional Médico') selected @endif >Profesional Médico</option>
				<option value="Profesional" @if($serviceRequest->estate == 'Profesional') selected @endif >Profesional</option>
				<option value="Técnico" @if($serviceRequest->estate == 'Técnico') selected @endif >Técnico</option>
				<option value="Administrativo" @if($serviceRequest->estate == 'Administrativo') selected @endif >Administrativo</option>
				<option value="Farmaceutico" @if($serviceRequest->estate == 'Farmaceutico') selected @endif >Farmaceutico</option>
				<option value="Odontólogo" @if($serviceRequest->estate == 'Odontólogo') selected @endif >Odontólogo</option>
				<option value="Bioquímico" @if($serviceRequest->estate == 'Bioquímico') selected @endif >Bioquímico</option>
				<option value="Auxiliar" @if($serviceRequest->estate == 'Auxiliar') selected @endif >Auxiliar</option>
				<option value="Otro (justificar)" @if($serviceRequest->estate == 'Otro (justificar)') selected @endif >Otro (justificar)</option>
			</select>
		</fieldset>

		<fieldset class="form-group col-12 col-md-6">
			<label for="for_estate_other">Detalle estamento</label>
			<input type="text" class="form-control" id="for_estate_other" placeholder="" name="estate_other" value="{{ $serviceRequest->estate_other }}">
		</fieldset>

		<fieldset class="form-group col-6 col-md-3">
			<label for="for_rrhh_team">Equipo RRHH</label>
			<select name="rrhh_team" class="form-control">
			<option value=""></option>
			<option value="Residencia Médica" @if($serviceRequest->rrhh_team == "Residencia Médica") selected @endif>Residencia Médica</option>
			<option value="Médico Diurno" @if($serviceRequest->rrhh_team == "Médico Diurno") selected @endif>Médico Diurno</option>
			<option value="Enfermera Supervisora" @if($serviceRequest->rrhh_team == "Enfermera Supervisora") selected @endif>Enfermera Supervisora</option>
			<option value="Enfermera Diurna" @if($serviceRequest->rrhh_team == "Enfermera Diurna") selected @endif>Enfermera Diurna</option>
			<option value="Enfermera Turno" @if($serviceRequest->rrhh_team == "Enfermera Turno") selected @endif>Enfermera Turno</option>
			<option value="Kinesiólogo Diurno" @if($serviceRequest->rrhh_team == "Kinesiólogo Diurno") selected @endif>Kinesiólogo Diurno</option>
			<option value="Kinesiólogo Turno" @if($serviceRequest->rrhh_team == "Kinesiólogo Turno") selected @endif>Kinesiólogo Turno</option>
			<option value="Téc.Paramédicos Diurno" @if($serviceRequest->rrhh_team == "Téc.Paramédicos Diurno") selected @endif>Téc.Paramédicos Diurno</option>
			<option value="Téc.Paramédicos Turno" @if($serviceRequest->rrhh_team == "Téc.Paramédicos Turno") selected @endif>Téc.Paramédicos Turno</option>
			<option value="Auxiliar Diurno" @if($serviceRequest->rrhh_team == "Auxiliar Diurno") selected @endif>Auxiliar Diurno</option>
			<option value="Auxiliar Turno" @if($serviceRequest->rrhh_team == "Auxiliar Turno") selected @endif>Auxiliar Turno</option>
			<option value="Terapeuta Ocupacional" @if($serviceRequest->rrhh_team == "Terapeuta Ocupacional") selected @endif>Terapeuta Ocupacional</option>
			<option value="Químico Farmacéutico" @if($serviceRequest->rrhh_team == "Químico Farmacéutico") selected @endif>Químico Farmacéutico</option>
			<option value="Bioquímico" @if($serviceRequest->rrhh_team == "Bioquímico") selected @endif>Bioquímico</option>
			<option value="Fonoaudiologo" @if($serviceRequest->rrhh_team == "Fonoaudiologo") selected @endif>Fonoaudiologo</option>

			<option value="Administrativo Diurno" @if($serviceRequest->rrhh_team == "Administrativo Diurno") selected @endif>Administrativo Diurno</option>
			<option value="Administrativo Turno" @if($serviceRequest->rrhh_team == "Administrativo Turno") selected @endif>Administrativo Turno</option>
			<option value="Biotecnólogo Turno" @if($serviceRequest->rrhh_team == "Biotecnólogo Turno") selected @endif>Biotecnólogo Turno</option>
			<option value="Matrona Turno" @if($serviceRequest->rrhh_team == "Matrona Turno") selected @endif>Matrona Turno</option>
			<option value="Matrona Diurno" @if($serviceRequest->rrhh_team == "Matrona Diurno") selected @endif>Matrona Diurno</option>
			<option value="Otros técnicos" @if($serviceRequest->rrhh_team == "Otros técnicos") selected @endif>Otros técnicos</option>
			<option value="Psicólogo" @if($serviceRequest->rrhh_team == "Psicólogo") selected @endif>Psicólogo</option>
			<option value="Tecn. Médico Diurno" @if($serviceRequest->rrhh_team == "Tecn. Médico Diurno") selected @endif>Tecn. Médico Diurno</option>
			<option value="Tecn. Médico Turno" @if($serviceRequest->rrhh_team == "Tecn. Médico Turno") selected @endif>Tecn. Médico Turno</option>
			<option value="Trabajador Social" @if($serviceRequest->rrhh_team == "Trabajador Social") selected @endif>Trabajador Social</option>

			<option value="Nutricionista Diurno" @if($serviceRequest->rrhh_team == "Nutricionista Diurno") selected @endif>Nutricionista Diurno</option>
						<option value="Prevencionista de Riesgo" @if($serviceRequest->rrhh_team == "Prevencionista de Riesgo") selected @endif>Prevencionista de Riesgo</option>

			<option value="Nutricionista turno" @if($serviceRequest->rrhh_team == "Nutricionista turno") selected @endif>Nutricionista turno</option>
			<option value="Informático" @if($serviceRequest->rrhh_team == "Informático") selected @endif>Informático</option>
			<option value="Ingeniero" @if($serviceRequest->rrhh_team == "Ingeniero") selected @endif>Ingeniero</option>


			<option value="Técnico en rehabilitación" @if($serviceRequest->rrhh_team == "Técnico en rehabilitación") selected @endif>Técnico en rehabilitación</option>
			<option value="Psiquiatra" @if($serviceRequest->rrhh_team == "Psiquiatra") selected @endif>Psiquiatra</option>
			<option value="Monitor/a" @if($serviceRequest->rrhh_team == "Monitor/a") selected @endif>Monitor/a</option>
			<option value="Preparador físico" @if($serviceRequest->rrhh_team == "Preparador físico") selected @endif>Preparador físico</option>

			<option value="Médico por prestación" @if($serviceRequest->rrhh_team == "Médico por prestación") selected @endif>Médico por prestación</option>
			</select>
		</fieldset>

	</div>


	<div class="form-row" id="div_objectives" style="display: none">
		<fieldset class="form-group col">
			<label for="for_estate">Objetivos</label>
			<textarea id="objectives" name="objectives" class="form-control" rows="4" cols="50">{{ $serviceRequest->objectives }}</textarea>
		</fieldset>
	</div>

	<!-- <div class="form-row" id="div_resolve">
		<fieldset class="form-group col">
				<label for="for_estate">Resuelvo</label>
				<textarea id="resolve" name="resolve" class="form-control" rows="4" cols="50">{{ $serviceRequest->resolve }}</textarea>
		</fieldset>
	</div> -->

  <div class="form-row" id="div_subt31" style="display: none">
		<fieldset class="form-group col">
				<label for="for_subt31">Subtitulo 31<small>(Aparecerá en resolución, luego del texto "El gasto corresponde")</small></label>
				<textarea id="subt31" name="subt31" class="form-control" rows="4" cols="50" disabled>{{ $serviceRequest->subt31 }}</textarea>
		</fieldset>
	</div>

  <div class="form-row">
		<fieldset class="form-group col">
				<label for="for_estate">Aguinaldos (se inserta en cláusula 8va)</label>
				<textarea name="bonus_indications" class="form-control" rows="4" cols="50">{{ html_entity_decode($serviceRequest->bonus_indications) }}</textarea>
		</fieldset>
	</div>

  <div class="form-row" id="div_additional_benefits" style="display: none">
		<fieldset class="form-group col">
				<label for="for_estate">Beneficios adicionales (se inserta en cláusula 14)</label>
				<textarea id="additional_benefits" name="additional_benefits" class="form-control" rows="4" cols="50">{{ html_entity_decode($serviceRequest->additional_benefits) }}</textarea>

        <button type="button" class="btn btn-outline-primary btn-sm" id="alias_dias_descanzo">Días de descanso</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_ausentarse_motivos_particulares">Ausentarse por motivos particulares</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_capacitacion">Capacitación</button>
        @if(Auth::user()->organizationalUnit->establishment_id == 1)
				@else
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_fiestas_patrias">Aguinaldo fiestas patrias</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="alias_navidad">Aguinaldo navidad</button>
        <button type="button" class="btn btn-outline-primary btn-sm" id="alias_viaticos">Viaticos</button>
        @endif
        <button type="button" class="btn btn-outline-primary btn-sm" id="alias_devolucion">Devolución de tiempo</button>

		</fieldset>
	</div>

  <div class="form-row">
    <fieldset class="form-group col-12 col-md-9">

    </fieldset>

    <fieldset class="form-group col-12 col-md-2">
        <label for="for_digera_strategy">Observaciones</label>
        <input type="text" class="form-control" name="observation" value="{{$serviceRequest->observation}}">
    </fieldset>

    <fieldset class="form-group col-12 col-md-1">
        <label for="for_digera_strategy"><br></label>
        <div>

        @can('Service Request: additional data rrhh')
          <button type="submit" class="btn btn-primary">Guardar</button>
        @else
          <!-- solo el creador de la solicitud puede editar  -->
          @if($serviceRequest->where('user_id', Auth::user()->id)->orwhere('responsable_id',Auth::user()->id)->count() > 0)
            <!-- si existe una firma, no se deja modificar solicitud -->
            @if($serviceRequest->SignatureFlows->where('type','!=','creador')->where('type','!=','Responsable')->whereNotNull('status')->count() > 0)
              <button type="submit" class="btn btn-primary" disabled>Guardar</button>
            @else
              <button type="submit" class="btn btn-primary">Guardar</button>
            @endif
          @else
            <button type="submit" class="btn btn-primary" disabled>Guardar</button>
          @endif
        @endcan
        </div>
    </fieldset>
  </div>


  @can('Service Request: additional data rrhh')

  @else
    <!-- solo el creador de la solicitud puede editar  -->
    @if($serviceRequest->where('user_id', Auth::user()->id)->orwhere('responsable_id',Auth::user()->id)->count() > 0)
      <!-- si existe una firma, no se deja modificar solicitud -->
      @if($serviceRequest->SignatureFlows->where('type','!=','creador')->where('type','!=','Responsable')->whereNotNull('status')->count() > 0)
        <div class="alert alert-warning" role="alert">
          No se puede modificar hoja de ruta ya que existen visaciones realizadas.
        </div>
      @else
      @endif
    @else
    @endif
  @endcan



  <br>

  </form>

  @canany(['Service Request: additional data rrhh'])
  <form method="POST" action="{{ route('rrhh.service-request.update_aditional_data', $serviceRequest) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="card border-danger mb-3">
    <div class="card-header bg-danger text-white">
      Datos adicionales - RRHH
    </div>
      <div class="card-body">

        <div class="form-row">

          <fieldset class="form-group col-6 col-md-3">
					    <label for="for_name">N°Contrato</label>
              <input type="text" class="form-control" name="contract_number"
                value="{{$serviceRequest->contract_number}}">
					</fieldset>

          <fieldset class="form-group col-6 col-md-3">
					    <label for="for_resolution_number">N° Resolución</label>
              <input type="text" class="form-control" name="resolution_number"
                value="{{$serviceRequest->resolution_number}}">
					</fieldset>

          <fieldset class="form-group col-6 col-md-3">
              <label for="for_resolution_date">Fecha Resolución</label>
              <input type="date" class="form-control" id="for_resolution_date"
                name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
          </fieldset>

          <fieldset class="form-group col-6 col-md-2">
            <label for="for_sirh_contract_registration">&nbsp;</label>
            <div>
              @if($serviceRequest->type == "Covid")
                <a href="{{ route('rrhh.service-request.report.resolution-pdf', $serviceRequest) }}"
                  class="btn btn-outline-secondary" target="_blank" title="Resolución">
                <span class="fas fa-file-pdf" aria-hidden="true"></span></a>
              @else
                <a href="{{ route('rrhh.service-request.report.resolution-pdf-hsa', $serviceRequest) }}"
                  class="btn btn-outline-secondary btn-sm" target="_blank">
                <span class="fas fa-file" aria-hidden="true"></span></a>
              @endif
            </div>
          </fieldset>

        </div>

        <div class="form-row">

          <fieldset class="form-group col-6 col-md-3">
					    <label for="for_net_amount">Monto Mensualizado</label>
              <input type="text" class="form-control" name="net_amount" value="{{$serviceRequest->net_amount}}" required>
					</fieldset>

          <fieldset class="form-group col-6 col-md-3">
					    <label for="for_gross_amount">Monto Bruto/Valor Hora</label>
              <input type="text" class="form-control" name="gross_amount" value="{{$serviceRequest->gross_amount}}">
					</fieldset>

          <fieldset class="form-group col-6 col-md-2">
              <label for="for_sirh_contract_registration">Registrado en SIRH</label>
              <select name="sirh_contract_registration" class="form-control">
                <option value=""></option>
                <option value="1"  @if($serviceRequest->sirh_contract_registration == '1') selected @endif>Sí</option>
                <option value="0"  @if($serviceRequest->sirh_contract_registration == '0') selected @endif>No</option>
              </select>
          </fieldset>

          <fieldset class="form-group col">
            <label for="">&nbsp;</label>
            <div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </fieldset>

        </div>

        <fieldset class="form-group form-check">
          <input type="checkbox"
            class="form-check-input"
            name="signature_page_break"
            value="1" id="forbreakPage"
            {{ ($serviceRequest->signature_page_break)?'checked':'' }}>

          <label class="form-check-label" for="forbreakPage">Salto de página en firmas</label>
        </fieldset>

      </div>

  </div>

  <br>
  </form>
  @endcan

  <!--
  @canany(['Service Request: additional data finanzas'])
  <form method="POST" action="{{ route('rrhh.service-request.update_aditional_data', $serviceRequest) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="card border-info mb-3">
    <div class="card-header bg-info text-white">
      Datos adicionales - Finanzas
    </div>
      <div class="card-body">

        <div class="form-row">
          <fieldset class="form-group col-5 col-md-2">
					    <label for="for_resolution_number">N° Resolución</label>
              <input type="text" class="form-control" disabled name="resolution_number" value="{{$serviceRequest->resolution_number}}">
					</fieldset>

          <fieldset class="form-group col-7 col-md-3">
              <label for="for_resolution_date">Fecha Resolución</label>
              <input type="date" class="form-control" id="for_resolution_date" disabled name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
          </fieldset>
        </div>

        <div class="form-row">

          <fieldset class="form-group col-6 col-md-2">
              <label for="for_bill_number">N° Boleta</label>
              <input type="text" class="form-control" name="bill_number" value="{{$serviceRequest->bill_number}}">
          </fieldset>

          <fieldset class="form-group col-6 col-md-2">
              <label for="for_total_hours_paid">Tot. hrs pagadas per.</label>
              <input type="text" class="form-control" name="total_hours_paid" value="{{$serviceRequest->total_hours_paid}}">
          </fieldset>

          <fieldset class="form-group col-6 col-md-2">
              <label for="for_total_paid">Total pagado</label>
              <input type="text" class="form-control" name="total_paid" value="{{$serviceRequest->total_paid}}">
          </fieldset>

          <fieldset class="form-group col-6 col-md-3">
              <label for="for_payment_date">Fecha pago</label>
              <input type="date" class="form-control" id="for_payment_date" name="payment_date" required @if($serviceRequest->payment_date) value="{{$serviceRequest->payment_date->format('Y-m-d')}}" @endif>
          </fieldset>

          <fieldset class="form-group col-6 col-md-3">
            <label for="">&nbsp;</label>
            <div>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </fieldset>

        </div>



      </div>

  </div>

  <br>
  </form>
  @endcan
  -->


  @canany(['Service Request: additional data oficina partes'])
  <form method="POST" action="{{ route('rrhh.service-request.update_aditional_data', $serviceRequest) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="card border-success mb-3">
    <div class="card-header bg-success text-white">
      Datos adicionales - Oficina de Partes
    </div>
      <div class="card-body">

        <div class="form-row">

          <fieldset class="form-group col-5 col-md-2">
					    <label for="for_resolution_number">N° Resolución</label>
              <input type="text" class="form-control" name="resolution_number" value="{{$serviceRequest->resolution_number}}">
					</fieldset>

          <fieldset class="form-group col-7 col-md-3">
              <label for="for_resolution_date">Fecha Resolución</label>
              <input type="date" class="form-control" id="for_resolution_date" name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
          </fieldset>

          <fieldset class="form-group col-5 col-md-2">
            <label for="">&nbsp;</label>
            <div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </fieldset>
        </div>
      </div>
  </div>

  </form>
  @endcan

<hr>

<form method="POST" action="{{ route('rrhh.service-request.signature-flow.store') }}" enctype="multipart/form-data">
@csrf


<div class="card">
  <div class="card-header">
    Aprobaciones de Solicitud
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="card-table table table-sm table-bordered small">
          <thead>
            <tr>
              <th scope="col">Fecha</th>
              <th scope="col">U.Organizacional</th>
              <th scope="col">Cargo</th>
              <th scope="col">Usuario</th>
              <th scope="col">Tipo</th>
              <th scope="col">Estado</th>
              <th scope="col">Observación</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $serviceRequest->created_at }}</td>
              <td>{!! optional($serviceRequest->creator->organizationalUnit)->name ?? '<span class="text-danger">SIN UNIDAD ORGANIZACIONAL</span>' !!}</td>
              <td>{{ $serviceRequest->creator->position }}</td>
              <td>{{ $serviceRequest->creator->getFullNameAttribute() }}</td>
              <td>Creador</td>
              <td>Creada</td>
              <td></td>
            </tr>
            <!-- aceptado o rechazado -->
            @if($serviceRequest->SignatureFlows->where('status',2)->count()==0)
              @foreach($serviceRequest->SignatureFlows->sortBy('sign_position') as $key => $SignatureFlow)
                @if($SignatureFlow->status === null)
                  <tr class="bg-light">
                @elseif($SignatureFlow->status === 0)
                  <tr class="bg-danger">
                @elseif($SignatureFlow->status === 1)
                  <tr>
                @elseif($SignatureFlow->status === 2)
                  <tr class="bg-warning">
                @endif
                   <td>{{ $SignatureFlow->signature_date}}</td>
                   <td>{!! optional($SignatureFlow->user->organizationalUnit)->name ?? '<span class="text-danger">SIN UNIDAD ORGANIZACIONAL</span>' !!}</td>
                   <td>{{ $SignatureFlow->user->position }}</td>
                   <td>{{ $SignatureFlow->user->getFullNameAttribute() }}</td>
                   @if($SignatureFlow->sign_position == 1)
                    <td>Responsable</td>
                   @elseif($SignatureFlow->sign_position == 2)
                    <td>Supervisor</td>
                   @else
                    <td>{{ $SignatureFlow->type }}</td>
                   @endif
                   <td>@if($SignatureFlow->status === null)
                       @elseif($SignatureFlow->status === 1) Aceptada
                       @elseif($SignatureFlow->status === 0) Rechazada
                       @elseif($SignatureFlow->status === 2) Devuelta
                       @endif
                  </td>
                   <td>{{ $SignatureFlow->observation }}</td>
                 </tr>

                 @if($SignatureFlow->status === 0 && $SignatureFlow->observation != null)
                 <tr>
                   <td class="text-right" colspan="6">Observación rechazo: {{$SignatureFlow->observation}}</td>
                 </tr>
                 @endif
             @endforeach
            @else
            <!-- devolucion -->
              @foreach($serviceRequest->SignatureFlows->sortBy('created_at') as $key => $SignatureFlow)
                @if($SignatureFlow->status === null)
                  <tr class="bg-light">
                @elseif($SignatureFlow->status === 0)
                  <tr class="bg-danger">
                @elseif($SignatureFlow->status === 1)
                  <tr>
                @elseif($SignatureFlow->status === 2)
                  <tr class="bg-warning">
                @endif
                   <td>{{ $SignatureFlow->signature_date}}</td>
                   <td>{{ $SignatureFlow->organizationalUnit->name}}</td>
                   <td>{{ $SignatureFlow->employee }}</td>
                   <td>{{ $SignatureFlow->user->getFullNameAttribute() }}</td>
                   <td>{{ $SignatureFlow->type }}</td>
                   <td>@if($SignatureFlow->status === null)
                       @elseif($SignatureFlow->status === 1) Aceptada
                       @elseif($SignatureFlow->status === 0) Rechazada
                       @elseif($SignatureFlow->status === 2) Devuelta
                       @endif
                  </td>
                   <td>{{ $SignatureFlow->observation }}</td>
                 </tr>

                 @if($SignatureFlow->status === 0 && $SignatureFlow->observation != null)
                 <tr>
                   <td class="text-right" colspan="6">Observación rechazo: {{$SignatureFlow->observation}}</td>
                 </tr>
                 @endif
             @endforeach
            @endif
          </tbody>
      </table>
      </div>

      <div class="form-row">
        <fieldset class="form-group col-12 col-md-3">
            <label for="for_name">Tipo</label>
            <input type="text" class="form-control" name="employee" value="{{$employee}}" readonly="readonly">
            <input type="hidden" class="form-control" name="service_request_id" value="{{$serviceRequest->id}}">
        </fieldset>
        <fieldset class="form-group col-12 col-md-3">
            <label for="for_name">Estado Solicitud</label>
            <select name="status" class="form-control">
              <option value="">Seleccionar una opción</option>
              <option value="1">Aceptar</option>
              <option value="0">Rechazar</option>
              <option value="2">Devolver</option>
            </select>
        </fieldset>
        <fieldset class="form-group col-12 col-md-4">
            <label for="for_observation">Observación</label>
            <input type="text" class="form-control" id="for_observation" placeholder="" name="observation">
        </fieldset>
        <fieldset class="form-group col-12 col-md-2">
          <label for="for_button"><br></label>
            <div>
            <button type="submit" id="for_button" class="btn btn-primary">Guardar</button>
          </div>
        </fieldset>
    </div>
  </div>
</div>


</form>


@can('Service Request: delete request')
  <br>
  <form method="POST" action="{{ route('rrhh.service-request.destroy-with-parameters') }}" enctype="multipart/form-data" class="d-inline">
      @csrf
      @method('POST')
      <input type="hidden" name="id" value="{{$serviceRequest->id}}">

      <div class="form-row">
        <div class="form-group col-12 col-sm-6">
          <div>
            <input type="text" class="form-control" name="observation" placeholder="Observación">
          </div>
        </div>
        <div class="form-group col-6 col-sm-3">
          <div>
            <button type="submit" class="btn btn-danger">Eliminar solicitud</button>
          </div>
        </div>
      </div>

  </form>
@endcan

    @canany(['Service Request: audit'])
    <br /><hr />
    <div style="height: 300px; overflow-y: scroll;">
        @include('service_requests.requests.partials.audit', ['audits' => $serviceRequest->audits] )
    </div>

    <br /><hr />
    <div style="height: 300px; overflow-y: scroll;">
      @foreach($serviceRequest->SignatureFlows as $signatureFlow)
        @include('service_requests.requests.partials.audit', ['audits' => $signatureFlow->audits] )
      @endforeach
    </div>
    @endcanany

@endsection

@section('custom_js')
<script type="text/javascript">

	$( document ).ready(function() {



    //temporal, solicitado por eduardo
    if ($('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Departamento de Salud Ocupacional" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Extensión Hospital -Estadio" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Sección Administrativa Honorarios Covid" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Servicio de Cirugía" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Servicio de Ginecología y Obstetricia" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Servicio de Medicina" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Unidad de Alimentación y Nutrición" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Unidad de Gestión de Camas" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Unidad de Ginecología" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Unidad de Medicina Física y Rehabilitación" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Unidad de Movilización" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Unidad de Salud Ocupacional" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Unidad Imagenología") {
      $('#digera_strategy').val("Camas MEDIAS Complejizadas");
    }

    if ($('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Servicio de Anestesia y Pabellones" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Servicio Unidad Paciente Crítico Adulto" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Servicio Unidad Paciente Crítico Pediatrico"){
      $('#digera_strategy').val("Camas UCI Complejizadas");
    }

    if ($('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Unidad de Hospitalización Domiciliaria"){
      $('#digera_strategy').val("Cupos Hosp. Domiciliaria");
    }

    if ($('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Subdirección de Gestion Asistencial / Subdirección Médica" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Unidad Laboratorio Clínico"){
      $('#digera_strategy').val("Refuerzo Laboratorio");
    }

    if ($('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Establecimientos de Red de Urgencias"){
      $('#digera_strategy').val("Refuerzo SAMU");
    }

    if ($('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Consultorio General Urbano Dr. Hector Reyno" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Servicio de Emergencia Hospitalaria" ||
        $('select[id=responsability_center_ou_id] option').filter(':selected').text() == "Servicio Urgencia Ginecoobstetricia"){
      $('#digera_strategy').val("Refuerzo UEH");
    }





    if ($('select[id=responsability_center_ou_id] option').filter(':selected').text() == "xxx") {
      $('#digera_strategy').val("xxx");
    }

    if ($('#program_contract_type').val() == "Horas") {
      $("#control_turnos").show();
      $('#for_weekly_hours').attr('disabled', 'disabled');
    }else{
      $("#control_turnos").hide();
      $('#for_weekly_hours').removeAttr('disabled');

      if ($('#working_day_type').val() == "DIARIO") {
        $("#control_turnos").show();
        $('#for_weekly_hours').attr('disabled', 'disabled');
      }
    }


		// $('#program_contract_type').on('change', function() {
		// 	if (this.value == "Horas") {
		// 		$('#for_daily_hours').val("");
		// 		$('#for_nightly_hours').val("");
		// 		$('#for_daily_hours').attr('readonly', true);
		// 		$('#for_nightly_hours').attr('readonly', true);
    //     $('#for_weekly_hours').attr('disabled', 'disabled');
		// 		$("#control_turnos").show();
		// 	}else{
		// 		$('#for_daily_hours').attr('readonly', false);
		// 		$('#for_nightly_hours').attr('readonly', false);
    //     $('#for_weekly_hours').removeAttr('disabled');
		// 		$("#control_turnos").hide();
		// 	}
		// });

  	// $(".add-row").click(function(){
    //     var shift_start_date = $("#shift_start_date").val();
    //     var start_hour = $("#start_hour").val();
    //     var shift_end_date = $("#shift_end_date").val();
    //     var end_hour = $("#end_hour").val();
  	// 		var observation = $("#observation").val();
    //     var markup = "<tr><td><input type='checkbox' name='record'></td><td> <input type='hidden' class='form-control' name='shift_start_date[]' id='shift_start_date' value='"+ shift_start_date +"'>"+ shift_start_date +"</td><td> <input type='hidden' class='form-control' name='shift_start_hour[]' id='start_hour' value='"+ start_hour +"'>" + start_hour + "</td><td> <input type='hidden' class='form-control' name='shift_end_date[]' id='shift_end_date' value='"+ shift_end_date +"'>"+ shift_end_date +"</td><td> <input type='hidden' class='form-control' name='shift_end_hour[]' id='end_hour' value='"+ end_hour +"'>" + end_hour + "</td><td> <input type='hidden' class='form-control' name='shift_observation[]' id='observation' value='"+ observation +"'>" + observation + "</td></tr>";
    //     $("table tbody").append(markup);
    // });
    //
  	// // Find and remove selected table rows
    // $(".delete-row").click(function(){
    //     $("table tbody").find('input[name="record"]').each(function(){
    //     	if($(this).is(":checked")){
    //             $(this).parents("tr").remove();
    //         }
    //     });
    // });

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
  			$('#Subdirector').val(12621281); //PERDRO IRIONDO: 9882506
  			$('#Subdirector').selectpicker('refresh');

  			$('#SubdirectorTurnos').val(12621281); //PERDRO IRIONDO: 9882506
  			$('#SubdirectorTurnos').selectpicker('refresh');
  		}
  	});

  	$('#type').on('change', function() {
      //alert("");
  		var value = this.value;
  		if (value == "Suma alzada") {

  			$("#programm_name option[value='Covid19-APS No Médicos']").hide();
  			$("#programm_name option[value='Covid19-APS Médicos']").hide();
  			$("#programm_name option[value='Covid19 No Médicos']").hide();
  			$("#programm_name option[value='Covid19 Médicos']").hide();
  			$('#digera_strategy').attr('disabled', 'disabled');


        $("#div_hsa_schedule").show();
			  $("#div_covid_schedule").hide();

        $('#objectives').removeAttr('disabled');
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
  			}
        else
        {
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

        $('#objectives').attr('disabled', 'disabled');
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

    $("#alias_dias_descanzo").click(function(){
  		$('#additional_benefits').append("Derecho a días de descanso, correspondiente a 20 días hábiles, después de un año de prestación de servicio continúo en calidad de honorario, sin opción de acumulación.\n\n");
  	});
  	$("#alias_ausentarse_motivos_particulares").click(function(){
  		$('#additional_benefits').append("Permisos para ausentarse de sus labores por motivos particulares hasta por seis días hábiles en el año, con goce de honorarios. Estos permisos podrán fraccionarse por días o medios días y serán resueltos por la Coordinadora del área correspondiente.\n\n");
  	});
  	$("#alias_capacitacion").click(function(){
      alert('aprete en capacitacion');
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



    if ($('#type').val() == "Suma alzada") {
      $('#type').trigger('change');
    }



  });
</script>
@endsection
