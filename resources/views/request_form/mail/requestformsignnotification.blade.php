@extends('layouts.mail')

@section('content')

<div style="text-align: justify;">

  <h4>Estimado/a: </h4>

  <br>

  <p>A través del presente, se informa que se encuentra disponible en {{ env('APP_NAME') }}
    un formulario de requerimiento de compras correspondiente a su Unidad Organizacional {{$req->edited ? 'que fue re-ingresado con cambios': ''}}, favor ingresar
    al módulo de <strong>Abastecimento</strong> para aceptar o declinar la Solicitud.
  </p>

  <ul>
      <li><strong>Nº Solicitud</strong>: {{ $req->id }}</li>
      <li><strong>Fecha Solicitud</strong>: {{ $req->edited ? $req->updated_at->format('d-m-Y H:i:s') : $req->created_at->format('d-m-Y H:i:s') }}</li>
      <li><strong>Nombre Solicitud</strong>: {{ $req->name }}</li>
      <li><strong>Tipo de Visación</strong>: {{ $event->EventTypeValue }}</li>
  </ul>

  <hr>

  <ul>
      <li><strong>Solicitado por</strong>: {{ $req->user->fullName }}</li>
      <li><strong>Unidad Organizacional</strong>: {{ $req->userOrganizationalUnit->name }}</li>
      <li><strong>Administrador de Contrato</strong>: {{ $req->contractManager->fullName }}</li>
  </ul>

  <br>

  <p>Para mayor información favor ingresar a su Bandeja de Solicitudes en iOnline.</p>

  <br>

  <p>Esto es un mensaje automático de: {{ env('APP_NAME') }} -  {{ env('APP_SS') }}.</p>

</div>

@endsection
