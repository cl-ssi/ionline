@extends('layouts.mail')

@section('content')

    <div style="text-align: justify;">
        <p>Se encuentra disponible un nuevo Mensaje en su formulario de Requerimiento</p>
        <p> <strong>Número Solicitud Formulario de Requerimiento:</strong> {{ $requestformmessage->requestForm->id??'' }}</p>
        <p> <strong>Usuario Digitador de Mensaje:</strong> {{ $requestformmessage->user->fullName??'' }}</p>
        <p> <strong>Mensaje:</strong> {!! $requestformmessage->message !!}</p>
        <br><br>
        Saludos cordiales.
    </div>

@endsection

@section('firmante', 'Servicio de Salud Tarapacá')

@section('linea1', 'Anexo Minsal: 579502 - 579503')