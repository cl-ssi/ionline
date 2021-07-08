@extends('layouts.app')

@section('title', 'Gestion de Turnos')

@section('content')

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


<!--Menu de Filtros  -->

@include("rrhh.shift_management.tabs", array('actuallyMenu' => 'indexTab'))
<!-- TODO: Que hace este div? -->
<div id="shiftapp">

    <div class="row mb-3 mt-2">
        <div class="col-md-6">
            <h3> Gestión de Turnos </h3>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{route('rrhh.shiftsTypes.downloadShiftInXls')}}" class="btn btn-outline-success btn-xs">
                <i class="fa fa-file-excel"></i>
            </a>
            <button type="button" class="btn btn-outline-danger btn-xs"><i class="fa fa-file-pdf"></i></button>
        </div>
    </div>


    <form method="post" action="{{ route('rrhh.shiftManag.indexF') }}" >
        @csrf
        {{ method_field('post') }}  <!-- equivalente a: @method('POST') -->

        <!-- Menu de Filtros  -->
        <div class="form-row">
            <div class="form-group col-md-5" >
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
            </div>

            <div class="form-group col-md-2">
                <label for="for_name" class="input-group-addon">Turnos</label>
              

                               
                <select class="form-control" id="for_turnFilter" name="turnFilter" >

                    <option value="0">0 - Todos</option>
                    @php
                        $index = 0;
                    @endphp
                    @foreach($sTypes as $st)
                       
                        @foreach($actuallyShiftMonthsList  as $key =>  $shiftMonth)
                            @foreach($shiftMonth as $sMonth)
                                @if($sMonth->shift_type_id == $st->id && $sMonth->user_id == auth()->user()->id && $sMonth->month == $actuallyMonth)
                                
                                    <option value="{{$st->id}}" {{($st->id==$actuallyShift->id)?'selected':''}}>{{$index}} - Solo {{$st->name}}</option>
                                    {{--json_encode($sMonth)--}}
                                @endif
                            @endforeach
                        @endforeach
                        @php
                            $index++;
                        @endphp
                    @endforeach
                    <!-- <option value="99">99 - Solo Turno Personalizado</option> -->
                </select>
            </div>

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


    <!-- Select con personal de la unidad  -->
    <h4 class="mt-2 mb-2">Agregar personal a turno</h4>

    <form method="POST" action="{{ route('rrhh.shiftsTypes.assign') }}" class="mb-3">
        @csrf
        @method('POST')
            
        <input hidden name="dateFrom" value="{{$actuallyYear}}-{{$actuallyMonth}}-01">
        <input hidden name="dateUp" value="{{$actuallyYear}}-{{$actuallyMonth}}-{{$days}}">
        <input hidden name="shiftId" value="{{$actuallyShift->id}}">
        <input hidden name="orgUnitId" value="{{$actuallyOrgUnit->id}}">
        
       
        <div class="form-row"> 	
            <div class="col-md-4">
                <label>Personal de"{{$actuallyOrgUnit->name}}"</label>
                <select class="selectpicker form-control" data-live-search="true" name="slcStaff">
                    <option> - </option>
                    @foreach($staff as $user)
                        <option value="{{$user->id}}">
                            {{$user->runFormat() }} - {{ $user->fullName }}
                        </option> 
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Grupo</label>
                <input type="text" class="form-control" name="groupname" 
                    value="{{strtoupper(html_entity_decode ($groupname))}}" placeholder="Sin grupo">
            </div>

             <div class="col-md-1">
                <label>Inicio</label>
                <select class="form-control" name="initial-serie">
                @if(isset($actuallyShift->day_series))
                    @php $currentSeries =  explode(",", $actuallyShift->day_series); @endphp
                    @for(  $i=0;$i< sizeof($currentSeries);$i++  )
                        
                       @if($currentSeries[$i]!="") 
                            <option value="{{$i}}">{{intval($i+1)}} - {{$currentSeries[$i]}}</option>
                        @endif
                    @endfor
                 @endif 
                </select>
            </div>
            <div class="col-md-2">
                <label>De</label>
                <input type="date" class="form-control" name="dateFromAssign" 
                    value="{{$actuallyYear}}-{{$actuallyMonth}}-01">
            </div>

            <div class="col-md-2 ">
                <label>Hasta</label>
                <input type="date" class="form-control" name="dateUpAssign" 
                    value="{{$actuallyYear}}-{{$actuallyMonth}}-{{$days}}">
            </div>
            
            <div class="col-md-1">
                <label>&nbsp;</label>
                <button class="btn btn-success form-control">
                    <i class="fas fa-user-plus"></i>
                </button>
            </div>
        </div>

    </form>


    <div class="row" class="small" style=" overflow: auto;white-space: nowrap;">
        <div class="col-md-2">
            
            @if($actuallyShift->id != 0)
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
                                -  
                                {{$actuallyShift->name}}

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
                            @livewire('rrhh.list-of-shifts')
                        </div>
                    </tbody>
                </table>
            @else
                @foreach($sTypes as $st)
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th rowspan="2">Personal</th>
                                <th class="calendar-day" colspan="{{$days}}">
                                    @foreach($months AS $index => $month)
                                        {{ ($index == $actuallyMonth )?$month:"" }}
                                    @endforeach

                                    {{$actuallyYear}}
                                    -  
                                    {{$st->name}}
                                </th>
                            </tr>
                            <tr>
                                @for($i = 1; $i <= $days; $i++) 
                                    @php
                                        $dateFiltered = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$i, 'Europe/London');  
                                    @endphp

                                    <th class="brless dia" 
                                        style="color:{{ ( ($dateFiltered->isWeekend() )?'red':( ($holidays->where('date',$dateFiltered)) ? 'red':'white')  )}}" >
                                       {{$i}}
                                    </th>
                                    <!-- <th class="brless dia">🌞</th> -->
                                    <!-- <th class="noche">🌒</th> -->
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @livewire('rrhh.list-of-shifts',["actuallyShift"=>$st]
                            )

                        </tbody>
                    </table>
                @endforeach
            @endif
        </div>
    </div>


     <ul class="nav nav-pills justify-content-end">
        @for($i=0;$i<sizeof($groupsnames);$i++)
            <li class="nav-item">

                    <a class="nav-link {{ (isset($groupname)  && $groupname == htmlentities($groupsnames[$i]))?'active':'' }}" aria-current="page" href="{{route('rrhh.shiftManag.index',htmlentities($groupsnames[$i]))}}">{{ ($groupsnames[$i]  == "")?"SIN GRUPO": strtoupper($groupsnames[$i] )}}</a>

            </li>

        @endfor
           
        </ul>

</div>

@livewire("rrhh.modal-edit-shift-user-day")


<!-- TODO: Ve si puedes implementar algo así para la tabla, 
    que al celda sea clickeable completamente
    abajo te dejé un ejemplo
    -->
    
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
        width: 100%;
        height: 100%;
        margin:-1000px;
        padding: 10px;
        font-weight: bold;
    }
</style>

<!-- 
<table class="table table-sm table-bordered mt-4">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>1</th>
            <th>2</th>
            <th class="text-danger">3</th>
            <th class="text-danger">4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>15.456.789-1 - Alvaro Torres Fuchslocher</td>
            <td class="cellbutton">
                <button class="btn btn-danger btn-full">
                    +
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-secondary btn-full">
                    -
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    N
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-warning btn-full">
                    L
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-secondary btn-full">
                    -
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    N
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-warning btn-full">
                    L
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-secondary btn-full">
                    -
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    N
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    L
                </button>
            </td>
        </tr>


        <tr>
            <td>18.123.123-9 - Armando Birra Xxxxx</td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    L
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    N
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-secondary btn-full">
                    -
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-warning btn-full">
                    -
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    L
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    N
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-secondary btn-full">
                    -
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-secondary btn-full">
                    -
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    L
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    N
                </button>
            </td>
        </tr>


        <tr>
            <td> 15.123.123-2 - Angelina Jolie Voight</td>
            <td class="cellbutton">
                <button class="btn btn-success btn-full">
                    +
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-success btn-full">
                    +
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    L
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    L
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    N
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    N
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-secondary btn-full">
                    -
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-secondary btn-full">
                    -
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    L
                </button>
            </td>
            <td class="cellbutton">
                <button class="btn btn-info btn-full">
                    L
                </button>
            </td>
        </tr>
    </tbody>
</table> -->
@endsection


@section('custom_js')

<!-- TODO: que hace esto? -->


@endsection