@extends('layouts.mail')

@section('content')

<div style="text-align: justify;">

  <h4>Estimados/as: </h4>

  <br>

  <p>A través del presente, se informa que el <strong>Departamento de Gestión de Abastecimiento y Logística</strong>
    ha aprobado el formulario de requerimiento de compras, el cual se encuentra disponible para iniciar el proceso de compra.
  </p>

  <ul>
      <li><strong>Nº Solicitud</strong>: {{ $req->id }}</li>
      <li><strong>Folio</strong>: {{ $req->folio }}</li>
      <li><strong>Fecha Solicitud</strong>: {{ $req->created_at->format('d-m-Y H:i:s') }}</li>
      <li><strong>Nombre Solicitud</strong>: {{ $req->name }}</li>
  </ul>

  <hr>

  <ul>
      <li><strong>Solicitado por</strong>: {{ $req->user->fullName }}</li>
      <li><strong>Unidad Organizacional</strong>: {{ $req->userOrganizationalUnit->name }}</li>
      <li><strong>Administrador de Contrato</strong>: {{ $req->contractManager->fullName }}</li>
      <li><strong>Comprador asignado</strong>: {{ $req->purchasers()->first()->fullName }}</li>
  </ul>

  <br>

  <p>Para mayor información favor ingresar a su Bandeja de Solicitudes en iOnline.</p>

  <br>

  <p>Esto es un mensaje automático de: {{ env('APP_NAME') }} -  {{ env('APP_SS') }}.</p>

</div>

@endsection
