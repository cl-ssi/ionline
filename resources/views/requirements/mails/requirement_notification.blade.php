@extends('layouts.mail')

@section('content')

    <div style="text-align: justify;">
        <p>Nuevo Requerimiento N° {{$requirement->id}}.</p>
        <p>{{$requirement->subject}}.</p>
        <p> <strong>Unidad:</strong> {{ $requirement->user->organizationalUnit->name }}</p>
        <p> <strong>Funcionario:</strong> {{ $requirement->user->fullName }}</p>
        <p> <strong>Fecha límite: </strong> {{ ($requirement->limit_at) ? $requirement->limit_at->format('d-m-Y H:i') : '-' }} </p>
        <br>
        Saludos cordiales.
    </div>

@endsection

@section('firmante', 'Servicio de Salud Iquique')

@section('linea1', 'Anexo Minsal: 579502 - 579503')

{{--@section('linea2', 'Teléfono: +56 (57) 409502 - 409503')--}}

{{--@section('linea3', 'opartes.ssi@redsalud.gob.cl')--}}
