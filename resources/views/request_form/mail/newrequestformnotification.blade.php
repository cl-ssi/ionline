@extends('layouts.mail')

@section('content')

<div style="text-align: justify;">

  <h4>Estimado/a: </h4>

  <br>

  <p>A través del presente, se informa {{$req->edited ? 're-ingreso de' : 'ingreso de nuevo'}} formulario de requerimiento de compras:</p>

  <ul>
      <li><strong>Nº Solicitud</strong>: {{ $req->id }}</li>
      <li><strong>Fecha Solicitud</strong>: {{ $req->edited ? $req->updated_at->format('d-m-Y H:i:s') : $req->created_at->format('d-m-Y H:i:s') }}</li>
      <li><strong>Nombre Solicitud</strong>: {{ $req->name }}</li>
  </ul>

  <hr>

  <ul>
      <li><strong>Solicitado por</strong>: {{ $req->user->fullName }}</li>
      <li><strong>Unidad Organizacional</strong>: {{ $req->userOrganizationalUnit->name }}</li>
      <li><strong>Administrador de Contrato</strong>: {{ $req->contractManager->fullName }}</li>
  </ul>

  <br>

  <p>Esto es un mensaje automatico de: {{ env('APP_NAME') }} -  {{ env('APP_SS') }}.</p>



</div>

@endsection
