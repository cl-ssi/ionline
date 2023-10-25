@extends('layouts.mail')

@section('content')

    <div style="text-align: justify;">
        <p> Estimado(a) <b>{{$openHour->patient->shortName}}</b>,</p>
        <p> Se ha reservado una hora de {{$openHour->activityType->name}} con el profesional <b>{{$openHour->profesional->shortName}}</b> </p>
        <p> La reserva se encuentra realizada para <b>{{$openHour->start_date->format('Y-m-d')}}</b> a las <b>{{$openHour->start_date->format('H:i')}}</b>. Se solicita llegar puntual a su hora.</p>
        <p> Si no puede asistir, rogamos contactar a la Unidad de Salud del Trabajador para reagendar o cancelar su hora.</p>
    </div>

@endsection

@section('firmante', 'Servicio de Salud Tarapacá')

@section('linea1', 'Anexo Minsal: 579502 - 579503')