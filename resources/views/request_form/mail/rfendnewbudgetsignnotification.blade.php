@extends('layouts.mail')

@section('content')

<div style="text-align: justify;">

  <h4>Estimados/as: </h4>

  <br>

  <p>A través del presente, se informa que la solicitud de nuevo presupuesto para formulario de requerimiento de compras
    ha sido aprobado, el cual se encuentra disponible para continuar el proceso de compra.
  </p>

  <ul>
      <li><strong>Nº Solicitud</strong>: {{ $req->id }}</li>
      <li><strong>Folio</strong>: {{ $req->folio }}</li>
      <li><strong>Nombre Formulario</strong>: {{ $req->name }}</li>
      <li><strong>Fecha Solicitud</strong>: {{ $req->eventSignatureDate('budget_event', 'approved') }}</li>
      <li><strong>Solicitado por</strong>: {{ $req->eventPurchaserNewBudget()->FullName }}</li>
  </ul>

  <hr>

  <ul>
      <li><strong>Creado por</strong>: {{ $req->user->FullName }}</li>
      <li><strong>Unidad Organizacional</strong>: {{ $req->userOrganizationalUnit->name }}</li>
      <li><strong>Administrador de Contrato</strong>: {{ $req->contractManager->FullName }}</li>
      <li><strong>Comprador asignado</strong>: {{ $req->purchasers()->first()->FullName }}</li>
  </ul>

  <br>

  <p>Para mayor información favor ingresar a su Bandeja de Solicitudes en iOnline.</p>

  <br>

  <p>Esto es un mensaje automático de: {{ env('APP_NAME') }} -  {{ env('APP_SS') }}.</p>

</div>

@endsection
