@extends('layouts.bt4.app')

@section('title', 'Lista de Programas')

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Programación Numérica {{$year}}
<form class="form-inline float-right small" method="GET" action="{{ route('programmings.index') }}">
    <select name="year" class="form-control" onchange="this.form.submit()">
                    @foreach(range(2021, date('Y') + 1) as $anio)
                        <option value="{{ $anio }}" {{ request()->year == $anio || $year == $anio ? 'selected' : '' }}>{{ $anio }}</option>
                    @endforeach
    </select>
</form>
</h3>
<!-- PERMISOS -->
@php($canStatus = auth()->user()->can('Programming: status'))
@php($canEdit = auth()->user()->can('Programming: edit'))
@php($canViewPH = auth()->user()->can('ProfessionalHour: view'))
@php($canViewPD = auth()->user()->can('ProgrammingDay: view'))
@php($canViewItem = auth()->user()->can('ProgrammingItem: view'))
<!-- Permiso para crear nueva programación númerica -->
@can('Programming: create')
<a href="{{ route('programmings.create') }}" class="btn btn-info mb-4">Comenzar Nueva Programación</a>
@endcan

@if($request->year == 2022 || $year == 2022)
<div class="float-right text-center">
<h5>Tiempo Restante</h5>
<div id="timer"></div>
</div>
@endif

</div> <!-- close main div -->

<div class="container-fluid">

<div class="table-responsive">
    <table class="table table-sm table-hover">
        <thead>
            <tr class="small ">
                @if($canStatus)<th class="text-left align-middle table-dark" >Estado</th>@endif
                @if($canEdit)<th class="text-left align-middle table-dark" >Editar</th>@endif
                <th class="text-left align-middle table-dark" >%</th> 
                <th class="text-left align-middle table-dark" >Obs.</th>
                <th class="text-left align-middle table-dark" >Act.<br>pte.</th>
                <th class="text-left align-middle table-dark" >Id</th> 
                <th class="text-left align-middle table-dark" >Comuna</th>
                <th class="text-left align-middle table-dark" >Establecimiento</th>
                {{--@if($request->year >= 2023 || $year >= 2023)
                <th class="text-left align-middle table-dark" ></th>
                @endif--}}
                <th class="text-left align-middle table-dark" >Año</th>
                <th class="text-center align-middle table-dark">Productos de Programación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($programmings as $programming)
            <tr class="small">
            <!-- Permiso para Activar o Desactivar programación númerica -->
            @if($canStatus)
                <td >
                    {{--<button class="btn btb-flat  btn-light" data-toggle="modal"
                        data-target="#updateModalRect"
                        data-programming_id="{{ $programming->id }}"
                        data-status="{{ $programming->status }}"
                        data-formaction="{{ route('programmingStatus.update', $programming->id)}}">
                        @if($programming->status == 'active')
                            <i class="fas fa-circle text-success "></i>
                        @elseif($programming->status == 'inactive')
                            <i class="fas fa-circle text-danger "></i>
                        @endif
                    
                    </button>--}}
                    @livewire('programmings.programming-status-toggle', ['programming' => $programming], key($programming->id))
                </td>
            @endif
            <!-- Permiso para editar programación númerica -->
            @if($canEdit)
                <td ><a href="{{ route('programmings.show', $programming->id) }}" class="btn btb-flat btn-sm btn-light" >
                    <i class="fas fa-edit"></i></a>
                </td>
            @endif
                <td > <span class="badge badge-info">{{ $total_tracers != 0 ? number_format(($programming->getCountActivities()/$total_tracers) *100, 0, ',', ' ') : 0}}%</span> </td>
                <td > <span class="badge badge-danger">{{ number_format($programming->countTotalReviewsBy('Not rectified') + $programming->pendingItems->count() + $programming->pendingIndirectItems->count(), 0, ',', ' ')}}</span> </td>
                <td > <span class="badge badge-warning">{{ number_format($programming->pendingItems->count() + $programming->pendingIndirectItems->count(), 0, ',', ' ')}}</span> </td>
                <td >
                {{ $programming->id }}</td>
                <td>{{ $programming->establishment->commune->name}}</td>
                <td>{{ $programming->establishment->type }} {{ $programming->establishment->name }}</td>
                {{--@if($request->year >= 2023 || $year >= 2023)
                <!-- Falta especificar los permisos para qienes pueden tener acceso a RRHH -->
                <td>
                    <a href="{{ route('programming.show_total_rrhh', $programming->id) }}" class="btn btb-flat btn-sm btn-success">
                        <span class="small d-none d-sm-none d-md-inline">Total RRHH</span> 
                    </a>
                </td>
                @endif--}}
                <td>{{ $programming->year }}</td>
                <td class="text-right ">
                <!-- Permiso para asignar profesionales a la programación númerica en proceso -->
                @if($canViewPH)
                    <a href="{{ route('professionalhours.index', ['programming_id' => $programming->id]) }}" class="btn btb-flat btn-sm btn-secondary">
                        <i class="fas fa-user-tag small"></i>
                        <span class="small d-none d-sm-none d-md-inline">Profesionales</span> 
                    </a>
                @endif
                <!-- Permiso para paremtrizar los días habiles anuales en la programación númerica en proceso -->
                @if($canViewPD)
                    <a href="{{ route('programmingdays.index',['programming_id' => $programming->id]) }}"  class="btn btb-flat btn-sm btn-secondary" >
                        <i class="fas fa-calendar-alt small"></i>
                        <span class="small d-none d-sm-none d-md-inline">Días a Programar</span> 
                    </a>
                @endif

                <!-- Planificación a partir del 2023 -->
                @if($request->year >= 2023 || $year >= 2023)
                    @if($canViewItem)
                    <a href="{{ route('participation.show', $programming) }}" class="btn btb-flat btn-sm btn-primary" >
                        <i class="fas fa-tasks small"></i>
                        <span class="small d-none d-sm-none d-md-inline">Participación</span> 
                    </a>
                    <!-- falta consultar por algun permiso para ver esta nueva seccion -->
                    <a href="{{ route('emergencies.show', $programming) }}" class="btn btb-flat btn-sm btn-warning" >
                        <i class="fas fa-exclamation-triangle small"></i>
                        <span class="small d-none d-sm-none d-md-inline">Emergencias-Desastres y Epidemiología</span> 
                    </a>
                    @endif
                @endif

                <!-- Permiso para gestionar actividades en la programación númerica en proceso -->
                @if($request->year >= 2023 || $year >= 2023)
                <!-- Permiso para gestionar actividades en la programación númerica en proceso a partir del 2023 -->
                @if($canViewItem)
                    <a href="{{ route('programmingitems.index', ['programming_id' => $programming->id, 'activity_type' => 'Directa']) }}" class="btn btb-flat btn-sm btn-info" >
                        <i class="fas fa-tasks small"></i>
                        <span class="small d-none d-sm-none d-md-inline">Act. directas</span> 
                    </a>
                @endif

                @if($canViewItem)
                    <a href="{{ route('programmingitems.index', ['programming_id' => $programming->id, 'activity_type' => 'Indirecta']) }}" class="btn btb-flat btn-sm btn-info" >
                        <i class="fas fa-tasks small"></i>
                        <span class="small d-none d-sm-none d-md-inline">Act. indirectas</span> 
                    </a>
                @endif
                @else
                @if($canViewItem)
                    <a href="{{ route('programmingitems.index', ['programming_id' => $programming->id]) }}" class="btn btb-flat btn-sm btn-info" >
                        <i class="fas fa-tasks small"></i>
                        <span class="small d-none d-sm-none d-md-inline">Actividades</span> 
                    </a>
                @endif
                @endif
                </td> 
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@can('TrainingItem: view')
<div class="table-responsive">
    <table class="table table-sm table-hover mx-auto w-auto">
        <thead>
            <tr class="small">
                <th class="text-left align-middle table-dark" >Comuna</th> 
                <th class="text-left align-middle table-dark" ></th>
            </tr>
        </thead>
        <tbody>
        @foreach($communeFiles as $communeFile)
        <tr class="small">
            <td class="align-middle">{{Str::after($communeFile->description, '-')}}</td>
            <td>
                <a href="{{ route('trainingitems.index', ['commune_file_id' => $communeFile->id]) }}" class="btn btb-flat btn-sm btn-light" >
                    <i class="fas fa-chalkboard-teacher small"></i> 
                    <span class="small">Capacitaciones</span> 
                </a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endcan

@include('programmings/programmings/modal_status_programming')
@endsection

@section('custom_js')

<script type="text/javascript">

$('#updateModalRect').on('show.bs.modal', function (event) {
    console.log("en modal");
    
    var button = $(event.relatedTarget) // Button that triggered the modal
    var modal  = $(this)

    modal.find('input[name="programming_id"]').val(button.data('programming_id'))
    modal.find('select[name="status"]').val(button.data('status'))

    var formaction  = button.data('formaction')
    modal.find("#form-edit").attr('action', formaction)
})

// Set the date we're counting down to
var countDownDate = new Date("Dec 1, 2021 00:00:00").getTime();

function timePart(val,text,color="black"){
  return `<h6 class="timer" style="color:${color};">${val}<div>${text}</div></h6>`
}

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

 // Display the result in the element with id="demo"

 let res = timePart(days,'Días') + timePart(hours,'Horas') + timePart(minutes,'Min.')  + timePart(seconds,'Seg.','red');
document.getElementById("timer").innerHTML = res

  // If the count down is finished, write some text 
 if (distance < 0) {
    clearInterval(x);

document.getElementById("timer").innerHTML = "Cerrado";
  }
}, 1000);

</script>
<style type="text/css">
.timer{
  display:inline-block;
  padding:10px;
}
</style>
@endsection



