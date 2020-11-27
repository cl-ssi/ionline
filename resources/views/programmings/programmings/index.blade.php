@extends('layouts.app')

@section('title', 'Lista de Programas')

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Programación Númerica</h3> 
 <!-- Permiso para crear nueva programación númerica -->
 @can('Programming: create')
    <a href="{{ route('programmings.create') }}" class="btn btn-info mb-4">Comenzar Nueva Programación</a>
 @endcan
<div class="float-right text-center">
<h5>Tiempo Restante</h5>
<div id="timer"></div>
</div>

<div class="table-responsive"> 
    <table class="table table-sm " width="100%">
        <thead>
            <tr class="small ">
                @can('Programming: status')<th class="text-left align-middle table-dark" >Estado</th>@endcan
                @can('Programming: edit')<th class="text-left align-middle table-dark" ></th>@endcan
                <th class="text-left align-middle table-dark" >Id</th> 
                <th class="text-left align-middle table-dark" >Comuna</th>
                <th class="text-left align-middle table-dark" >Establecimiento</th>
                <th class="text-left align-middle table-dark" >Año</th>
                <th class="text-center align-middle table-dark">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($programmings as $programming)
            <tr class="small">
            <!-- Permiso para Activar o Desactivar programación númerica -->
            @can('Programming: status')
                <td >
                    <button class="btn btb-flat  btn-light" data-toggle="modal"
                        data-target="#updateModalRect"
                        data-programming_id="{{ $programming->id }}"
                        data-status="{{ $programming->status }}"
                        data-formaction="{{ route('programmingStatus.update', $programming->id)}}">
                        @if($programming->status == 'active')
                            <i class="fas fa-circle text-success "></i>
                        @elseif($programming->status == 'inactive')
                            <i class="fas fa-circle text-danger "></i>
                        @endif
                    
                    </button>
                </td>
            @endcan
            <!-- Permiso para editar programación númerica -->
            @can('Programming: edit')
                <td ><a href="{{ route('programmings.show', $programming->id) }}" class="btn btb-flat btn-sm btn-light" >
                    <i class="fas fa-edit"></i></a>
                </td>
            @endcan
                <td >{{ $programming->id }}</td>
                <td>{{ $programming->commune }}</td>
                <td>{{ $programming->establishment_type }} {{ $programming->establishment }}</td>
                <td>{{ $programming->year }}</td>
                <td class="text-right ">
                <!-- Permiso para asignar profesionales a la programación númerica en proceso -->
                @can('ProfessionalHour: view')
                    <a href="{{ route('professionalhours.index', ['programming_id' => $programming->id]) }}" class="btn btb-flat btn-sm btn-secondary">
                        <i class="fas fa-user-tag small"></i>
                        <span class="small d-none d-sm-none d-md-inline">Profesionales</span> 
                    </a>
                @endcan
                <!-- Permiso para paremtrizar los días habiles anuales en la programación númerica en proceso -->
                @can('ProgrammingDay: view')
                    <a href="{{ route('programmingdays.index',['programming_id' => $programming->id]) }}"  class="btn btb-flat btn-sm btn-secondary" >
                        <i class="fas fa-calendar-alt small"></i>
                        <span class="small d-none d-sm-none d-md-inline">Días a Programar</span> 
                    </a>
                @endcan
                <!-- Permiso para gestionar actividades en la programación númerica en proceso -->
                @can('ProgrammingItem: view')
                    <a href="{{ route('programmingitems.index', ['programming_id' => $programming->id]) }}" class="btn btb-flat btn-sm btn-info" >
                        <i class="fas fa-tasks small"></i>
                        <span class="small d-none d-sm-none d-md-inline">Actividades</span> 
                    </a>
                @endcan
            
                </td> 
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

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
var countDownDate = new Date("Dec 1, 2020 00:00:00").getTime();

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



