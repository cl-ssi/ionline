@extends('layouts.mail')

@section('content')

<div style="text-align: justify;">
    <p>Junto con saludar cordialmente.</p>
    <p>Adjunto documento indicado para conocimiento y fines.</p>
    <p> <strong>Tipo:</strong> {{ $document->type }}</p>
    <p> <strong>Número:</strong> {{ $document->number }}</p>
    <p> <strong>Fecha del documento: </strong> {{ $document->date->format('d-m-Y') }} </p>
    <p> <strong>Archivo:</strong> SSI_{{ $document->type }}_{{ $document->number }}.pdf</p>
    <br>
    Saludos cordiales.
</div>

@endsection

@section('firmante', 'Oficina de Partes')

@section('linea1', 'Anexo Minsal: 579502 - 579503')

@section('linea2', 'Teléfono: +56 (57) 409502 - 409503')

@section('linea3', 'opartes.ssi@redsalud.gob.cl')
