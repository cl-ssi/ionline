@extends('layouts.mail')

@section('content')

    <div style="text-align: justify;">
        <p> {{ucfirst("{$requirementEvent->requirement->status} Requerimiento N°{$requirementEvent->requirement->id}")}}.</p>
        <p> <strong>Asunto:</strong> {{$requirementEvent->requirement->subject}}.</p>
        <p> <strong>Requerimiento:</strong> {{$requirementEvent->requirement->events->where('status', 'creado')->first()->body }}.</p>
        <p> <strong>Respuesta:</strong> {{$requirementEvent->body}}</p>
        <p> <a href="{{route('requirements.show', $requirementEvent->requirement->id)}}">Ir a requerimiento</a></p>
        <br>
        Saludos cordiales.
    </div>

@endsection

@section('firmante', 'Servicio de Salud Iquique')

@section('linea1', 'Anexo Minsal: 579502 - 579503')

{{--@section('linea2', 'Teléfono: +56 (57) 409502 - 409503')--}}

{{--@section('linea3', 'opartes.ssi@redsalud.gob.cl')--}}
