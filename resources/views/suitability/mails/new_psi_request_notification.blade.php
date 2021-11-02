@extends('layouts.mail')

@section('content')

    <div style="text-align: justify;">
        <p>Se encuentra disponible un nueva Solicitud de idoneidad</p>
        <p> <strong>Número Solicitud:</strong> {{ $psirequest->id??'' }}</p>
        <p> <strong>Colegio:</strong> {{ $psirequest->school->name??'' }}</p>
        <p> <strong>Nombre Completo:</strong> {{ $psirequest->user->fullName??'' }}</p>
        <p> <strong>Cargo:</strong> {{$psirequest->job?? ''}}</p>        
        <br><br>
        Saludos cordiales.
    </div>

@endsection

@section('firmante', 'Servicio de Salud Iquique')

@section('linea1', 'Anexo Minsal: 579502 - 579503')

{{--@section('linea2', 'Teléfono: +56 (57) 409502 - 409503')--}}

{{--@section('linea3', 'opartes.ssi@redsalud.gob.cl')--}}
