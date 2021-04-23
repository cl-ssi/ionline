@extends('layouts.app')

@section('title', 'Calendarios')

@section('content')

<h3 class="mb-3">Calendarios</h3>

<!-- Nav tabs -->
<ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Videoconferencia</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Vehículos</a>
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane" id="home" role="tabpanel" aria-labelledby="home-tab">
        Seleccione su agenda.
    </div>
    <div class="tab-pane active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <iframe src="https://calendar.google.com/calendar/b/3/embed?title=Sala%20de%20Videoconferencia&amp;showCalendars=0&amp;showTz=0&amp;mode=WEEK&amp;height=600&amp;wkst=2&amp;bgcolor=%23FFFFFF&amp;src=hjf5qbbq8hb1it8a849aau1bgs%40group.calendar.google.com&amp;color=%235A6986&amp;ctz=America%2FSantiago" style="border-width:0" width="1100" height="600" frameborder="0" scrolling="no"></iframe>
    </div>
    <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
        <iframe src="https://calendar.google.com/calendar/embed?title=Agenda%20de%20veh%C3%ADculos&amp;showCalendars=0&amp;showTz=0&amp;height=600&amp;wkst=2&amp;hl=es_419&amp;bgcolor=%23FFFFFF&amp;src=servicios.generales.dssi%40gmail.com&ctz=America%2FSantiago" style="border-width:0" width="1100" height="600" frameborder="0" scrolling="no"></iframe>
    </div>
</div>




<?php /*
<style>
.col {
    border: 1px solid black;
    border-bottom: 0px;
}
.colx {
    border: 1px dotted black;
    border-bottom: 0px;
}
</style>

<div class="row">
    <div class="col">
        Horario
    </div>
    <div class="col">
        Lun 25
    </div>
    <div class="col">
        Mar 26
    </div>
    <div class="col">
        Mie 27
    </div>
    <div class="col">
        Jue 28
    </div>
    <div class="col">
        Vie 29
    </div>
    <div class="col">
        Sab 30
    </div>
    <div class="col">
        Dom 1
    </div>
</div>

@foreach(['08:00','08:15','08:30','08:45','09:00','09:15','09:30','09:45','10:00','10:15','10:30','10:45','11:00','11:15','11:30','11:45','12:00','12:15','12:30','12:45','13:00','13:15','13:30','13:45'
        ,'14:00','14:15','14:30','14:45','15:00','15:15','15:30','15:45','16:00','16:15','16:30','16:45','17:00'] as $bloque)
    <div class="row small">
        <div class="col">
            {{ $bloque }}
        </div>
        <div class="col">

        </div>
        <div class="col">

        </div>
        <div class="col">

        </div>
        <div class="col">

        </div>
        <div class="col">

        </div>
        <div class="col">

        </div>
        <div class="col">

        </div>
    </div>
@endforeach





<div class="row small">
    <div class="col">
        17:15
    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col colx">
VC:CAMPAÑA INVIERNO
    </div>
</div>

<div class="row small">
    <div class="col">
        17:30
    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
</div>

<div class="row small">
    <div class="col">
        17:45
    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
</div>
*/
?>
@endsection
