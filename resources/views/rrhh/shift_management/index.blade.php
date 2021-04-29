@extends('layouts.app')
@section('title', 'Gestion de Turnos')

@section('content')

<style type="text/css">
	:root {
    font-size: 16px;
}

.table {
    border: solid 2px black;
    white-space: nowrap;
}

.table thead th {
    text-align: center;
    vertical-align: middle;
    border-bottom: none;
    border: none;
}

.brless {
    /* border-right: solid 1px transparent !important; */
}

.bless {border: none !important;}
.br {border-right: solid 1px #454d55 !important;}
.dia {
    opacity: 0.8;
}

.day {
    background-color: white;
    text-align: center;
}

.night {
    background-color: rgba(0, 0, 0, 0.2);
    text-align: center;
    border-right-color: black !important;
}

.calendar-day {
    font-size: 2rem;
    text-align: center;
    padding: 0!important;
}

.table th, .table td {padding: 0.5rem !important;}

.borderBottom {
    border-bottom: solid 2px #454d55 !important;
}

.bbd {
    border-top: none;
    border-left: none;
    border-right: none;
 
}

.bbn {
    border-top: none !important;
    border-left: none;
    border-right: solid 1px #454d55;
   
}
.bg-red {background-color: #ff5133;}
.bg-green {background-color: #00e63d;}
.bg-purple {background-color: #d57aff;}
.bg-red, .bg-green, .bg-purple {color: white;}


.turn-selected {
    background: #ff0000;
    color: #fff;
    padding: 3px 15px;
    border-radius: 50%;
  
}
.only-icon {
    background-color: Transparent;
    background-repeat:no-repeat;
    border: none;
    cursor:pointer;
    overflow: hidden;
    outline:none;
}
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div id="shiftapp">
	<br>
	<br>
<div class="form-group" >
	<!-- <div class="col-lg-12"> -->
		<h3> Gestión de Turnos 
  

   
        </h3>
		<form method="POST" class="form-horizontal shadow" action="{{ route('rrhh.shiftManag.index') }}">
			@csrf
    		@method('POST')
    		<!-- Menu de Filtros  -->
			<div class="row"> 
	
    			<div class="col-lg-3">
				<div class="input-group">
            	
            		<label for="for_name">U. ORGANIZACIONAL </label>
            		<select class="form-control" id="for_orgunitFilter" name="orgunitFilter">
            			<!-- <option>0 - Todos</option> -->
            			@foreach($cargos as $c)
            				<option value="{{$c->id}}" {{($c->id==$actuallyOrgUnit->id)?'selected':''}}>{{$loop->iteration}} - {{$c->name}} </option>
            			@endforeach
            		</select>
        	  	</div>
        		</div>
    			<div class=" col-lg-2">
				<div class="input-group">

            		<label for="for_name" class="input-group-addon">TURNOS </label>
            
            		<select class="form-control" id="for_turnFilter" name="turnFilter" >
            			<option value="0">0 - Todos</option>
            			@foreach($sTypes as $st)
            				<option value="{{$st->id}}" {{($st->id==$actuallyShift->id)?'selected':''}}>{{$loop->iteration}} - Solo {{$st->name}}</option>
            			@endforeach
            			<option value="99">99 - Solo Turno Personalizado</option>
            		</select>

        	  	</div>
        		</div>
        		<div class="col-lg-2">
				<div class="input-group">
            	
            		<label for="for_name">AÑO </label>
            		<select class="form-control" id="for_yearFilter" name="yearFilter">
            			@for($i = $actuallyYear; $i< (intval($actuallyYear) + 4); $i++)
            				<option value="{{$i}}"> {{$i}}</option>
            				
            			@endfor	
            		</select>
        	  	</div>
        		</div>
        		<div class="col-lg-2">
				<div class="input-group">
            	
            		<label for="for_name">MES </label>
            		<select class="form-control" id="for_monthFilter" name="monthFilter">
            			
            			@foreach($months AS $index => $month)
            				<option value="{{ $index }}" {{ ($index == $actuallyMonth )?"selected":"" }}>{{$loop->iteration}} - {{$month}} </option>
            			@endforeach
            			
            		</select>
        	  	</div>
        		</div>
        		<div class=" col-lg-1">
				<div class="input-group">
    				<button type="submit" class="btn btn-primary btn-xs">Filtrar</button>
    			</div>
        		</div>
        		<div class=" col-lg-2">
				<div class="input-group">
    				<a href="{{route('rrhh.shiftsTypes.downloadShiftInXls')}}" class="btn btn-outline-success btn-xs"><i class="fa fa-file-excel"></i></a>
    				<button type="button" class="btn btn-outline-danger btn-xs"><i class="fa fa-file-pdf"></i></button>

    			</div>
    			</div> 
			</div>
			</form>

    		<!-- Select con personal de la unidad  -->
			<br>
		<form method="POST" class="form-horizontal shadow" action="{{ route('rrhh.shiftsTypes.assign') }}">
			@csrf
    		@method('POST')

			
			
			<input hidden name="dateFrom" value="{{$actuallyYear}}-{{$actuallyMonth}}-01">
			<input hidden name="dateUp" value="{{$actuallyYear}}-{{$actuallyMonth}}-{{$days}}">
			<input hidden name="shiftId" value="{{$actuallyShift->id}}">
			<input hidden name="orgUnitId" value="{{$actuallyOrgUnit->id}}">
            <h4>Agregar personal a turno</h4>
			<div class="row"> 	
				<div class="col-lg-4 " style="margin-left: 10%">
					<label style="text-align: center;">Personal de"{{$actuallyOrgUnit->name}}"</label>
	            		<select class="find-personal-input form-control" name="slcStaff" style="text-align: center;" >
            				<option> - </option>
							@foreach($staff as $user)
            					<option value="{{$user->id}}">{{$user->runFormat() }} - {{$user->name}} {{$user->fathers_family}} {{$user->mothers_family}}</option> 

							@endforeach
            			</select>
        	  	</div>
                <div class="col-lg-2 ">
                    <label>De</label>
                    <input type="date" class="form-control" name="dateFromAssign" value="{{$actuallyYear}}-{{$actuallyMonth}}-01">
                </div>

                <div class="col-lg-2 ">
                    <label>Hasta</label>
                    <input type="date" class="form-control" name="dateUpAssign" value="{{$actuallyYear}}-{{$actuallyMonth}}-{{$days}}">
                </div>
				
                <div class="col-lg-2 " style="margin-top:20px">
            		<label style="text-align: center;"></label>
            		<button   class="btn btn-success"><i class="fas fa-user-plus"></i></button>
        	  	</div>
        	</div>
		</form>




</div>


	<!-- </div> -->
</div>
<div class="row  shadow" style=" overflow: auto;white-space: nowrap;">
	<div class="col-md-2">
        

        @if($actuallyShift->id != 0)
            <table class="table">
                <thead class="thead-dark">
                    <th rowspan="2">Personal</th>
                            <th class="calendar-day" colspan="{{$days}}">

                            	@foreach($months AS $index => $month)
            						{{ ($index == $actuallyMonth )?$month:"" }}
								@endforeach

								{{$actuallyYear}}
                            	-  
                                {{$actuallyShift->name}}
                        </th> 

                        <tr>
                            @for($i = 1; $i <= $days; $i++) 
                                    @php
                                    	 $dateFiltered = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$i, 'Europe/London');  
                                    @endphp
                                    <th class="brless dia" style="color:{{ ($dateFiltered->isWeekend() )?'red':'white'}}" >{{$i}}</th>
                                    <!-- <th class="brless dia">🌞</th> -->
                                    <!-- <th class="noche">🌒</th> -->
                            @endfor
                        </tr>
                </thead>
                <tbody>
                <div>
                    
                  
                    @livewire('rrhh.list-of-shifts', 
                        [
                            'staffInShift'=>$staffInShift,
                            'actuallyYear'=>$actuallyYear,
                            'actuallyMonth'=>$actuallyMonth,
                         
                            'days'=>$days
                        ]
                    )
                </div>
                  
                  
                </tbody>
            </table>
        
        @else
            @foreach($sTypes as $st)
                <table class="table">
                    <thead class="thead-dark">
                        <th rowspan="2">Personal</th>
                        <th class="calendar-day" colspan="{{$days}}">

                                @foreach($months AS $index => $month)
                                    {{ ($index == $actuallyMonth )?$month:"" }}
                                @endforeach

                                {{$actuallyYear}}
                                -  
                                {{$st->name}}
                        </th> 
                        <tr>
                            @for($i = 1; $i <= $days; $i++) 
                                    @php
                                         $dateFiltered = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$i, 'Europe/London');  
                                    @endphp
                                    <th class="brless dia" style="color:{{ ($dateFiltered->isWeekend() )?'red':'white'}}" >{{$i}}</th>
                                    <!-- <th class="brless dia">🌞</th> -->
                                    <!-- <th class="noche">🌒</th> -->
                            @endfor
                        </tr>
                    </thead>
                    <tbody>

                        @livewire('rrhh.list-of-shifts', 
                            [
                                'staffInShift'=>$staffInShift->where('shift_types_id', $st->id),
                                'actuallyYear'=>$actuallyYear,
                                'actuallyMonth'=>$actuallyMonth,
                                'days'=>$days
                            ]
                        )
                  
                  
                    </tbody>
                </table>
            @endforeach
        @endif
    </div>
</div>
</div>
    @livewire("rrhh.modal-edit-shift-user-day")
@endsection


@section('custom_js')


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">

	$(document).ready(function() {
    	$('.find-personal-input').select2();
	});

     
</script>

@endsection