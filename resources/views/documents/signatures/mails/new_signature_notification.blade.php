@extends('layouts.mail')

@section('content')

    <div style="text-align: justify;">
        <p>Se encuentra disponible un nuevo documento para su firma en iOnline.</p>
        <p> <strong>Tipo:</strong> {{ $signaturesFlow->signature->document_type }}</p>
        <p> <strong>Número Solicitud:</strong> {{ $signaturesFlow->signature->id }}</p>
        <a href="{{route('documents.signatures.index', 'pendientes')}}">Ir a firmar</a>
        <br><br>
        Saludos cordiales.
    </div>

@endsection

@section('firmante', 'Servicio de Salud Iquique')

@section('linea1', 'Anexo Minsal: 579502 - 579503')

{{--@section('linea2', 'Teléfono: +56 (57) 409502 - 409503')--}}

{{--@section('linea3', 'opartes.ssi@redsalud.gob.cl')--}}
