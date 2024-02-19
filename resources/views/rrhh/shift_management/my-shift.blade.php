@extends('layouts.bt4.app')

@section('title', 'Gestion de Turnos')

@section('content')
<style type="text/css">
	.scroll {
    max-height: 200px;
    overflow-y: auto;
}
</style>
<!--Menu de Filtros  -->

<style type="text/css">
    :root {
        font-size: 16px;
    }

    .table {
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

    .btnShiftDay:hover {
        opacity: 0.5;
        filter:  alpha(opacity=50);
    }

    .btn-light { 
        border: 1px solid #ced4da; 
    }
     td {
        overflow:hidden;
    }
    .cellbutton {
        width: 30px;
       font-size: 13px;
    }
    .btn-full {
        display: block;
        width: 100%;
        height: 100%;
        margin:-1000px;
        padding: 1000px;
        font-weight: bold;
    }
  .deleteButton {
    color: red;
  }
  .deleteButton:hover {
        opacity: 0.5;
        filter:  alpha(opacity=50);
  }
</style>
@include("rrhh.shift_management.tabs", array('actuallyMenu' => 'MyShiftTab'))

<div>
	 <div class="col-md-6">
          <h3> Mi Turno </h3>
     </div>
<div class="scroll">
    @if(        $myConfirmationEarrings && json_encode($myConfirmationEarrings)=="{}")

	<div class="alert alert-info">
  		<strong>Ninguna</strong> confirmación de día extra pendiente!.
	</div>
    @else
        
        {{--json_encode($myConfirmationEarrings)--}}
        @foreach($myConfirmationEarrings as $day)
	       <div class="card ">
  		    <div class="card-body">
    		  <h5 class="card-title">Día Agregado</h5>
    		  <p class="card-text" style="margin-left: 101px"> 
    			<i>
    			<i class="fa fa-user"></i> <i class="fa fa-arrow-right"></i> 
    			<i class="fa fa-user"></i> 
    			El usuario {{ ($day->derived_from && $day->derived_from != "") ?  $day->DerivatedShift->ShiftUser->user->id : "" }} te asigno el día {{$day->day}}
    			<b style="background-color: yellow;color:gray"> {{$day->working_day}} </b> .  
                @if(  App\Models\Rrhh\ShiftUserDay::where("id","<>",$day->id)->where("day",$day->day)->whereHas("ShiftUser",  function($q){
                        $q->where('user_id',auth()->id());
                    })->get() )

                    @php  

                        $dayInTheSame = App\Models\Rrhh\ShiftUserDay::where("day",$day->day)->whereHas("ShiftUser",  function($q){
                            $q->where('user_id',auth()->id());
                        })->get();
                         $dayInTheSame =  $dayInTheSame[0];
                    @endphp
                  <i style="color:{{ ($dayInTheSame->working_day == 'F') ? 'green' :'red' }}"> Ese día tienes asignado {{$dayInTheSame->working_day}} - {{$tiposJornada[$dayInTheSame->working_day]}} </i>
                @else
                    Ese día tienes asignado N/A 

                @endif
                </p>
    		  </i>
            <div class="pull-right">
                <form action="{{ route('rrhh.shiftManag.myshift.confirmDay',[$day]) }}" >
                    @csrf
    		      <button class="btn btn-success ">Confirmar <i class="fa fa-check"></i></button>
                </form>
            </div>
            <div class="pull-right">
                <form action="{{ route('rrhh.shiftManag.myshift.rejectDay',[$day]) }}" >
                    @csrf
    		      <button class="btn btn-danger pull-right"><b>X</b> </button>
                </form>
            </div>       
  		</div>
	   </div>
        @endforeach
    @endif
</div>

<br>
<br>
	<form method="post" action="{{ route('rrhh.shiftManag.myshiftfiltered') }}" >
        @csrf
        {{ method_field('post') }}  <!-- equivalente a: @method('POST') -->

        <!-- Menu de Filtros  -->
        <div class="form-row">
            <div class="form-group col-md-2">	

            <h4 >Buscar:</h4> </div>
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
                <button type="submit" class="btn btn-primary form-control">Filtrar</button>
            </div>

        </div>

    </form>
     <table class="table table-sm table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th rowspan="2">Personal</th>
                            <th class="calendar-day" colspan="{{$days}}">

                                <a href="{{route('rrhh.shiftManag.prevMonth')}}"><-</a>

                                @foreach($months AS $index => $month)
                                    {{ ($index == $actuallyMonth )?$month:"" }}
                                @endforeach

                                {{$actuallyYear}}
                               

                                <a href=" {{route('rrhh.shiftManag.nextMonth')}}"  >-></a>        
                            </th> 
                        </tr>
                        <tr>
                            @for($i = 1; $i <= $days; $i++) 
                                @php
                                    $dateFiltered = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$i, 'Europe/London');  
                                @endphp
                                <th class="brless dia" 
                                    style="color:{{ ( ($dateFiltered->isWeekend() )?'red':( ( sizeof($holidays->where('date',$actuallyYear.'-'.$actuallyMonth.'-'.$i)) > 0 ) ? 'red':'white' ))}}" >
                                    <p style="font-size: 8px">{{$i}}</p>
                                </th>   
                                <!-- <th class="brless dia">🌞</th> -->
                                <!-- <th class="noche">🌒</th> -->
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <div>   
                            @livewire('rrhh.list-of-shifts', ["staffInShift"=>$myShifts])
                        </div>
                    </tbody>
                </table>
</div>
    
<style>
    td {
        overflow:hidden;
    }
    .cellbutton {
         width: 30px;
       font-size: 13px;
    }
    .btn-full {
        display: inherit;
        width: 100%;
        height: 100%;
        margin:-1000px;
        padding: 1000px;
        font-weight: bold;
    }
    .btn-full2 {
        display: inline;
        /*width: 100%;*/
        height: 100%;
        margin:-1000px;
        /*padding: 10px;*/
        font-weight: bold;
        /*font-size: 15px;*/
    }
</style>

@endsection
                            @livewire("rrhh.modal-edit-shift-user-day")

@section('custom_js')

<!-- TODO: que hace esto? -->

@endsection