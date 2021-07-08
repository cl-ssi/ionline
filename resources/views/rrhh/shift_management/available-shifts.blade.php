@extends('layouts.app')

@section('title', 'Gestion de Turnos')

@section('content')

	@include("rrhh.shift_management.tabs", array('actuallyMenu' => 'availableShifts'))

	<h3>Turnos Disponibles</h3>
	<br>

		<form method="post" action="{{ route('rrhh.shiftManag.availableShifts') }}" >
        	@csrf
        	{{ method_field('post') }}  <!-- equivalente a: @method('POST') -->

        	<!-- Menu de Filtros  -->
			<div class="form-row">
            	<!-- <div class="form-group col-md-5" >
                	<label for="for_name">Unidad organizacional</label>
                	<select class="form-control selectpicker"  id="for_orgunitFilter" name="orgunitFilter" data-live-search="true" required
                            data-size="5">
                        @foreach($ouRoots as $ouRoot)
                            @if($ouRoot->name != 'Externos')
                                <option value="{{ $ouRoot->id }}"  {{($ouRoot->id==$actuallyOrgUnit->id)?'selected':''}}> 
                                {{($ouRoot->id ?? '')}}-{{ $ouRoot->name }}
                                </option>
                                @foreach($ouRoot->childs as $child_level_1)
                                    <option value="{{ $child_level_1->id }}" {{($child_level_1->id==$actuallyOrgUnit->id)?'selected':''}}>
                                        &nbsp;&nbsp;&nbsp;
                                        {{($child_level_1->id ?? '')}}-{{ $child_level_1->name }}
                                    </option>
                                    @foreach($child_level_1->childs as $child_level_2)
                                        <option value="{{ $child_level_2->id }}" {{($child_level_2->id==$actuallyOrgUnit->id)?'selected':''}}>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{($child_level_2->id ?? '')}}-{{ $child_level_2->name }}
                                        </option>
                                        @foreach($child_level_2->childs as $child_level_3)
                                            <option value="{{ $child_level_3->id }}" {{($child_level_3->id==$actuallyOrgUnit->id)?'selected':''}}>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                {{($child_level_3->id ?? '')}}-{{ $child_level_3->name }}
                                            </option>
                                            @foreach($child_level_3->childs as $child_level_4)
                                                <option value="{{ $child_level_4->id }}" {{($child_level_4->id==$actuallyOrgUnit->id)?'selected':''}}>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{($child_level_4->id ?? '')}}-{{ $child_level_4->name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endif
                        @endforeach
                    </select>
            	</div> -->

   				<div class="form-group col-md-2">	
                	<label for="for_name">Año</label>
                	<select class="form-control" id="for_yearFilter" name="yearFilter">
                    	@for($i = (intval($actuallyYear)-2); $i< (intval($actuallyYear) + 4); $i++)
                        	<option value="{{$i}}" {{ ($i == $actuallyYear )?"selected":"" }}> {{$i}}</option>
                    	@endfor	
                	</select>
            	</div>

            	<div class="form-group col-md-2">    	
                	<label for="for_name">Mes</label>
                	<select class="form-control" id="for_monthFilter" name="monthFilter">
                    	@foreach($months AS $index => $month)
                        	<option value="{{ $index }}" {{ ($index == $actuallyMonth )?"selected":"" }}>{{$loop->iteration}} - {{$month}} </option>
                    	@endforeach
                	</select> 		
            	</div>

            	<div class="form-group col-md-1">
                	<label for="for_submit">&nbsp;</label>
                	<button type="submit" class="btn btn-primary form-control">Filtrar  </button>
            	</div>
        	</div>
  		</form>
	<br>

	<h5><b>Disponibles:</b></h5>
	<br>
	@if( sizeof ( $availableDays ) < 1 )
		<div class="alert alert-primary" role="alert">
			Sin días disponibles para solicitar
		</div>
	@endif
	<div class="card " >
  		<ul class="list-group list-group-flush overflow-auto">
    	<!-- 	<li class="list-group-item">
    			<b>Propietario</b>
    			<p>18.004.474-4 - Armando Barra Perez</p>
    			
    			<b>Día</b>
    			<p> 05/07/2021, Jornada: L - Larga</p>
    			<button class="btn btn-success">Solicitar</button>

    		</li>
    		<li class="list-group-item">
    			<b>Propietario</b>
    			<p>18.004.474-4 - Armando Barra Perez</p>
    			
    			<b>Día</b>
    			<p> 05/07/2021, Jornada: L - Larga</p>
    			<button class="btn btn-success">Solicitar</button>

    		</li>  		
    		<li class="list-group-item">
    			<b>Propietario</b>
    			<p>18.004.474-4 - Armando Barra Perez</p>
    			
    			<b>Día</b>
    			<p> 05/07/2021, Jornada: L - Larga</p>
    			<button class="btn btn-success">Solicitar</button>

    		</li> -->

			@php
				$i=0;
			@endphp
    		@foreach($availableDays as $aDay )

				@if( null !==  \App\Models\Rrhh\UserRequestOfDay::where("user_id",\Auth::id())->first()     )

				@else

    			@php
    				$i++;
    			@endphp
    			@php
                    $dayFormated = \Carbon\Carbon::createFromFormat('Y-m-d', $aDay->day, 'Europe/London');  
                @endphp
    			
    			@php
								
					$dayWithCarbon = \Carbon\Carbon::createFromFormat('Y-m-d',  $aDay->day, 'Europe/London');
				@endphp
    			<li class="list-group-item ">
    			<div class="row row-striped">
    				<div class="col-2 text-right">
						<h1 class="display-4"><span class="badge badge-secondary">{{ $dayWithCarbon->day }}</span></h1>
						<h2>{{ strtoupper ( substr ( $months [ $dayWithCarbon->month ], 0, 3 ) ) }} </h2>
					</div>
					<div class="col-10">
						<h3 class="text-uppercase"><strong>Jornada: {{$aDay->working_day }}- {{ $tiposJornada[ $aDay->working_day ] }}</strong></h3>
						<ul class="list-inline">
							
				    		<li class="list-inline-item"><i style="color:red" class="fa fa-calendar-o" aria-hidden="true"></i>  {{ $weekMap [ $dayWithCarbon->dayOfWeek ] }}</li>
							<li class="list-inline-item"><i style="color:red" class="fa fa-clock-o" aria-hidden="true"></i> 12:30 PM - 2:00 PM</li>
							<li class="list-inline-item"><i style="color:blue" class="fa fa-location-arrow info" aria-hidden="true"></i> Hospital Dr. Ernesto Torres Galdames</li>
						</ul>

    					<b>Propietario</b>
						<p>{{$aDay->ShiftUser->user->runFormat()}} -  {{$aDay->ShiftUser->user->getFullNameAttribute()}} </p>
    					<b>Comentario</b>
						<p>{{$aDay->commentary}}</p>
						
						
						@if( null !==  \App\Models\Rrhh\UserRequestOfDay::where("user_id",\Auth::id())->first()     )
							Solicitado el {{\App\Models\Rrhh\UserRequestOfDay::where("user_id",\Auth::id())->first()->created_at}}
							<small> <i class="fa fa-user"></i> {{ count( $aDay->Solicitudes ) }} Solicitudes.</small>
								
						@else

							<form method="post" action="{{ route('rrhh.shiftManag.availableShifts.applyfor') }}" >
        						@csrf
        						{{ method_field('post') }}
        						<input type="hidden" name="idShiftUserDay" value="{{$aDay->id}}">
								<button class="btn btn-success">Solicitar</button>
								<small> <i class="fa fa-user"></i> {{ count( $aDay->Solicitudes ) }} Solicitudes.</small>
							</form>

						@endif
					</div>
				</div>
    			</li>

    			@endif
    			

    		@endforeach
    		@if( $i == 0 &&   sizeof (  $availableDays ) > 0 )
				<div class="alert alert-primary" role="alert">
					Sin días disponibles para solicitar
				</div>
			@endif
  		</ul>
	</div>
	<br>

	<h5><b>Mis solicitudes:</b></h5>
	<br>
	
	{{--$misSolicitudes --}}
	@if( count ( $misSolicitudes ) < 0)
		<div class="alert alert-primary" role="alert">
			Sin registro de solicitudes realizadas este mes
		</div>
	@endif
	<br>

	<div class="card overflow-auto"  >
  		<ul class="list-group list-group-flush">
  			 @foreach( $misSolicitudes as $solicitud)
  			 	<li class="list-group-item">
    				<b>Propietario</b>
    				<p>{{$solicitud->user->runFormat()}} -  {{$solicitud->user->getFullNameAttribute()}} </p>
    			
    				<b>Día</b>
    				<p> {{ $solicitud->ShiftUserDay->day }}, Jornada: {{ $solicitud->ShiftUserDay->working_day}} - {{ $tiposJornada [ $solicitud->ShiftUserDay->working_day ] }}</p>

    				<b>Solicitud</b>
    				<p> Solicitado en {{ $solicitud->created_at}}</p>
    				<b>Estado</b>
    				<p style="color:{{$solicitud->statusColor()}}"> {{ strtoupper( $solicitud->status ) }}</p>
    				@if($solicitud->status == "pendiente")
    					<form  method="post" action="{{ route('rrhh.shiftManag.availableShifts.cancelRequest') }}" >
							@csrf
        					{{ method_field('post') }}
    						<input type="hidden" name="solicitudId" value="{{$solicitud->id}}">
    						<button class="btn btn-danger">Cancelar</button>
    					</form>
    				@endif
    			</li>
  			 @endforeach
    		<!-- <li class="list-group-item">
    			<b>Propietario</b>
    			<p>18.004.474-4 - Armando Barra Perez</p>
    			
    			<b>Día</b>
    			<p> 05/07/2021, Jornada: L - Larga</p>

    			<b>Solicitud</b>
    			<p> Solicitado en 05/07/2021 20:30:00</p>
    			<b>Estado</b>
    			<p style="color:yellow"> Espera de confirmacion</p>
    			<button class="btn btn-danger">Cancelar</button>
    		</li>
    		<li class="list-group-item">
    			<b>Propietario</b>
    			<p>18.004.474-4 - Armando Barra Perez</p>
    			
    			<b>Día</b>
    			<p> 05/07/2021, Jornada: L - Larga</p>

    			<b>Solicitud</b>
    			<p> Solicitado en 05/07/2021 20:30:00</p>
    			<b>Estado</b>
    			<p style="color:red"> Rechazado</p>
    		</li>
    		<li class="list-group-item">
    			<b>Propietario</b>
    			<p>18.004.474-4 - Armando Barra Perez</p>
    			
    			<b>Día</b>
    			<p> 05/07/2021, Jornada: L - Larga</p>

    			<b>Solicitud</b>
    			<p> Solicitado en 05/07/2021 20:30:00</p>
    			<b>Estado</b>
    			<p style="color:green"> Confirmado</p>
    		</li> -->
    		{{--json_encode($availableDays)--}}
  		</ul>
	</div>

	<br>

	<h5><b>Solicitudes pendientes de aprobar:</b></h5>
	<br>
	<div class="card overflow-auto"  >

		@if( count ( $solicitudesPorAprobar ) < 1)
			<div class="alert alert-primary" role="alert">
				Sin registro de solicitudes pendientes de aprobar
			</div>
		@endif

  		<ul class="list-group list-group-flush">
<!-- 			<li class="list-group-item">
    			<b>ID:#1</b>
				<br>
    			<b>Propietario</b>
    			<p>18.004.474-4 - Armando Barra Perez</p>
    			
    			<b>Día</b>
    			<p> 05/07/2021, Jornada: L - Larga</p>

    			<b>Solicitud</b>
    			<p> Solicitado en 05/07/2021 20:30:00</p>
    			<b>Estado</b>
    			<p style="color:yellow"> Espera de confirmacion</p>
    			<form  method="post" action="{{route('rrhh.shiftManag.availableShifts.cancelRequest') }}" >
					@csrf
        			{{ method_field('post') }}
    				<input type="hidden" name="solicitudId" value="{{ route('rrhh.shiftManag.availableShifts.approvalRequest') }}">
    				<button class="btn btn-success">Aprobar <i class="fa fa-check"></i></button>
				</form>
				<form  method="post" action="{{route('rrhh.shiftManag.availableShifts.cancelRequest') }}" >
					@csrf
        			{{ method_field('post') }}
    				<input type="hidden" name="solicitudId" value="{{ route('rrhh.shiftManag.availableShifts.rejectRequest') }}">
    				<button class="btn btn-danger">Rechazar <i class="fa fa-cancel"></i></button>
    			</form>
    		</li>
 -->
    		@foreach($solicitudesPorAprobar as $solPending)
    			<li class="list-group-item">
    				<b>ID:#1</b>
					<br>
    				<b>Propietario</b>
    				<p>18.004.474-4 - Armando Barra Perez</p>
    			
    				<b>Día</b>
    				<p> 05/07/2021, Jornada: L - Larga</p>

    				<b>Solicitud</b>
    				<p> Solicitado en 05/07/2021 20:30:00</p>
    				<b>Estado</b>
    				<p style="color:yellow"> Espera de confirmacion</p>
    				<form  method="post" action="{{route('rrhh.shiftManag.availableShifts.cancelRequest') }}" >
						@csrf
        				{{ method_field('post') }}
    					<input type="hidden" name="solicitudId" value="{{ route('rrhh.shiftManag.availableShifts.approvalRequest') }}">
    					<button class="btn btn-success">Aprobar <i class="fa fa-check"></i></button>
					</form>
					<form  method="post" action="{{route('rrhh.shiftManag.availableShifts.cancelRequest') }}" >
						@csrf
        				{{ method_field('post') }}
    					<input type="hidden" name="solicitudId" value="{{ route('rrhh.shiftManag.availableShifts.rejectRequest') }}">
    					<button class="btn btn-danger">Rechazar <i class="fa fa-cancel"></i></button>
    				</form>
    			</li>
    		@endforeach
		</ul>
	</div>
@endsection

