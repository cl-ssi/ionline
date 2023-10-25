@extends('layouts.mail')

@section('content')

    <div style="text-align: justify;">
        <p> Estimado(a) <b>{{$openHour->patient->shortName}}</b>,</p>
        <p> Lamentablemente la reserva que tenía el para <b>{{$openHour->start_date->format('Y-m-d')}}</b> a las <b>{{$openHour->start_date->format('H:s')}}</b> con el profesional <b>{{$openHour->profesional->shortName}}</b> ha sido cancelada por fuerza mayor y no podrá ser atendido.</p>
        <p> Disculpando las molestias y en caso que siga requiriendo la atención, se le solicita pueda llamar (575767) o acercarse a nuestra unidad para reagendar</p>
    </div>

@endsection

@section('firmante', 'Servicio de Salud Tarapacá')

@section('linea1', 'Anexo Minsal: 579502 - 579503')