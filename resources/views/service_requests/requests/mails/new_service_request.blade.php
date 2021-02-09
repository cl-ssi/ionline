@extends('layouts.mail')

@section('content')

<div style="text-align: justify;">
  <p>Junto con saludar cordialmente.</p>
  <p>Se informa la creación de la solicitud de contratación de honorarios nro <b>{{$serviceRequest->id}}</b>.</p>
  <p> <strong>Tipo:</strong> {{ $serviceRequest->type }}</p>
  <p> <strong>Fecha solicitud:</strong> {{ \Carbon\Carbon::parse($serviceRequest->request_date)->format('d-m-Y') }}</p>
  <p> <strong>Rut:</strong> {{ $serviceRequest->rut }}</p>
  <p> <strong>Funcionario: </strong> {{ $serviceRequest->name }} </p>
  <p> <strong>Fecha inicio:</strong> {{ \Carbon\Carbon::parse($serviceRequest->start_date)->format('d-m-Y') }}</p>
  <p> <strong>Fecha término:</strong> {{ \Carbon\Carbon::parse($serviceRequest->end_date)->format('d-m-Y') }}</p>
  <br>
  Para acceder a la solicitud, haga click <a href="https://i.saludiquique.cl/rrhh/service_requests/{{$serviceRequest->id}}/edit"><i class="far fa-hand-point-right"></i> Aquí</a>
  <br>
  <br>
  Saludos cordiales.
</div>

@endsection

<!-- @section('firmante', 'Oficina de Partes')

@section('linea1', 'Anexo Minsal: 579502 - 579503')

@section('linea2', 'Teléfono: +56 (57) 409502 - 409503')

@section('linea3', 'opartes.ssi@redsalud.gob.cl') -->
