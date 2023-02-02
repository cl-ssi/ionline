@extends('layouts.mail')

@section('content')

    <div style="text-align: justify;">
        <p>Junto con saludar cordialmente.</p>
        <p>Adjunto documento indicado para conocimiento y fines.</p>
        <p> <strong>Tipo:</strong> {{ $signature->document_type }}</p>
        <p> <strong>Asunto:</strong> {{ $signature->subject }}</p>
        <br>
        Saludos cordiales.
    </div>

@endsection

@section('firmante', 'Servicio de Salud Iquique')

@section('linea1', 'Anexo Minsal: 579502 - 579503')

{{--@section('linea2', 'Teléfono: +56 (57) 409502 - 409503')--}}

{{--@section('linea3', 'opartes.ssi@redsalud.gob.cl')--}}
