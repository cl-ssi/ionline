@extends('layouts.mail')

@section('content')

<div style="text-align: justify;">

  <h4>Estimado/a: </h4>

  <br>

  <p>A través del presente, se informa que se asignó formulario de requerimiento de compras
    para gestión en {{ env('APP_NAME') }}, favor ingresar al módulo de <strong>Abastecimento</strong>
    para iniciar compra.
  </p>

  <ul>
      <li><strong>Nº Solicitud</strong>: {{ $req->id }}</li>
      <li><strong>Fecha Solicitud</strong>: {{ $req->created_at->format('d-m-Y H:i:s') }}</li>
      <li><strong>Nombre Solicitud</strong>: {{ $req->name }}</li>
      <li><strong>Administrador de Contrato</strong>: {{ $req->contractManager->FullName }}</li>
  </ul>

  <hr>

  <br>

  <p>Para mayor infromación favor ingresar a su Bandeja de Solicitudes en iOnline.</p>

  <br>

  <p>Esto es un mensaje automático de: {{ env('APP_NAME') }} -  {{ env('APP_SS') }}.</p>

</div>

@endsection
