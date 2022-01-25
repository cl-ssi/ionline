@extends('layouts.mail')

@section('content')

<div style="text-align: justify;">

  <h4>Estimado/a: </h4>

  <br>

  <p>A través del presente, se informa que se encuentra disponible en {{ env('APP_NAME') }}
    un formulario de requerimiento de compras pendiente de firma digital, favor ingresar
    al módulo de <strong>Abastecimento</strong> para firmar documento.
  </p>

  <ul>
      <li><strong>Nº Solicitud</strong>: {{ $req->id }}</li>
      <li><strong>Fecha Solicitud</strong>: {{ $req->created_at->format('d-m-Y H:i:s') }}</li>
      <li><strong>Nombre Solicitud</strong>: {{ $req->name }}</li>
  </ul>

  <hr>

  <ul>
      <li><strong>Solicitado por</strong>: {{ $req->user->FullName }}</li>
      <li><strong>Unidad Organizacional</strong>: {{ $req->userOrganizationalUnit->name }}</li>
      <li><strong>Administrador de Contrato</strong>: {{ $req->contractManager->FullName }}</li>
  </ul>

  <br>

  <p>Para mayor infromación favor ingresar a su Bandeja de Solicitudes en iOnline.</p>

  <br>

  <p>Esto es un mensaje automático de: {{ env('APP_NAME') }} -  {{ env('APP_SS') }}.</p>

</div>

@endsection
