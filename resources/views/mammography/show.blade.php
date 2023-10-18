@extends('layouts.bt4.guest')

@section('title', 'Horario de vacuna')

@section('content')

@if(empty($mammography->run))

    <div class="alert alert-danger">
        <h4 class="alert-heading">No está registrado en la nómina de vacunación,
            por favor contácte a su jefe directo.</h4>

    </div>

    <div class="alert alert-info mt-3" role="alert">
      NOTA: Si trabajas en HETG o DSSI y no alcanzaste a
      inscribirte indicado tu voluntad de vacunación o cambiaste de opinión y
      ahora si quieres vacunarte, debes indicarselo a tu jefatura.
      ¡ Tenemos pensado un día para los arrepentidos ¡
    </div>

    <div class="alert alert-info mt-3" role="alert">
        <ul>
            <li>Funcionario que ingresa a registro por su primera dosis,
                y no puede acceder debe tomar contacto con OIRS del Servicio de Salud</li>
            <li>Funcionarios que tengan que inmunizarse con segunda dosis, sólo deben
            agendar hora, ya que el día está fijado dentro de su carnet de vacunación
            (28 días posterior a su primera dosis).</li>
        </ul>
    </div>
@else
    <div class="alert alert-warning" role="alert">
      Si eres Mujer Mayor de 40 años, y no te has realizado la mamografía hace un año. <strong>Reserva tu hora Ya!!!</strong>
    </div>


    <h5 class="mb-3">Hola <strong>{{ $mammography->fullName() }}</strong>.</h5>

    <!-- <p>A continuación te entregamos la información correspondiente a tu reserva de cita para el examen de mamografía. -->

    <div class="card">
        <h5 class="card-header"><i class="fas fa-info-circle"></i> Información</strong></h5>
        <div class="card-body">
            <h5>Indicaciones:</h5>
            <ul>
                <li>No debe estar embarazada.</li>
                <li>Avisar si está amamantando.</li>
                <li>Venir sin desodorante, sin talco, ni cremas.</li>
                <li>No traer joyas, (Aros, Cadenas y/o gargantilla).</li>
                <li>De preferencia no usar vestido, privilegiar el uso de vestimenta de dos piezas.</li>
                <li>Es recomendable tomarse el examen después de su periodo menstrual.</li>
            </ul>
        </div>
    </div>

    <br>

    <!-- <div class="card">
        <h5 class="card-header"><i class="fas fa-calendar-day"></i> Agenda tu cita</strong></h5>
        <div class="card-body"> -->
            @livewire('mammography.book',['mammography' => $mammography])
        <!-- </div>
    </div> -->










@endif

@endsection

@section('custom_js')

@endsection
