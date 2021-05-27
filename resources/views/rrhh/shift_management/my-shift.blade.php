@extends('layouts.app')

@section('title', 'Gestion de Turnos')

@section('content')
<style type="text/css">
	.scroll {
    max-height: 200px;
    overflow-y: auto;
}
</style>
<!--Menu de Filtros  -->
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link " aria-current="page" href="{{ route('rrhh.shiftManag.index') }}">Gestión de Turnos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link"  href="{{ route('rrhh.shiftsTypes.index') }}">Tipos de Turnos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="{{ route('rrhh.shiftManag.myshift') }}">Mi Turno</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Turnos Disponibles</a>
  </li>
</ul>

<div>
	 <div class="col-md-6">
          <h3> Mi de Turno </h3>
     </div>
<div class="scroll">
    @if(!$myConfirmationEarrings)
	<div class="alert alert-info">
  		<strong>Ninguna</strong> confirmación pendiente!.
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
                        $q->where('user_id',Auth::user()->id);
                    })->get() )

                    @php  

                        $dayInTheSame = App\Models\Rrhh\ShiftUserDay::where("day",$day->day)->whereHas("ShiftUser",  function($q){
                            $q->where('user_id',Auth::user()->id);
                        })->get();
                         $dayInTheSame =  $dayInTheSame[0];
                    @endphp
                  <i style="color:{{ ($dayInTheSame->working_day == 'F') ? 'green' :'red' }}"> Ese día tienes asignado {{$dayInTheSame->working_day}} - {{$tiposJornada[$dayInTheSame->working_day]}} </i>
                @else
                    Ese día tienes asignado N/A 

                @endif
                </p>
    		</i>
    		<div class="pull-right"><a href="#" class="btn btn-primary ">Confirmar <i class="fa fa-check"></i></a>
    		<a href="#" class="btn btn-danger pull-right"><b>X</b> </a></div>
  		</div>
	</div>
@endforeach
@endif

    

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

</div>
@endsection

@section('custom_js')

<!-- TODO: que hace esto? -->

@endsection