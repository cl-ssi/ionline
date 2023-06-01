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

@section('firmante', 'Servicio de Salud Tarapacá')

@section('linea1', 'Anexo Minsal: 579502 - 579503')
