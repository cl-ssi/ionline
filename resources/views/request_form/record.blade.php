@extends('layouts.report')

@section('title', "Formulario de requerimiento")

@section('content')

<?php setlocale(LC_ALL, 'es_CL.UTF-8');?>

<div>
    <div style="width: 49%; display: inline-block;">
        <div class="siete" style="padding-top: 3px;">
            SUBDIRECCION ADMINISTRATIVA
        </div>
        <div class="siete" style="padding-top: 3px;">
            <i>DEPTO. ABASTECIMIENTO Y LOGISTICA</i>
        </div>
    </div>
    <div class="right" style="width: 49%; display: inline-block;">
         Iquique,   @foreach($requestForm->requestformevents as $event)
                        @if($event->type == "status" && $event->StatusName == "Nuevo")
                            {{ $event->CreationDateFormat }}
                        @endif
                    @endforeach <br>

    </div>
</div><br>

<div class="titulo">FORMULARIO REQUERIMIENTO N° {{ $requestForm->id }}</div><br>

<div style="padding-bottom: 8px;">
   <u><strong>Información General</strong></u>
</div>

<table class="siete">
    <tr>
        <td class="plomo" style="width:40%">Gasto Estimado o presupuesto programado</td>
        <td>${{ $requestForm->FormatEstimatedExpense }}</td>
    </tr>
    <tr >
        <td class="plomo">Nombre Administrador de Contrato/Servicios</td>
        <td>{{ $requestForm->admin ? $requestForm->admin->FullName : 'Usuario eliminado' }}</td>
    </tr>
    <tr>
        <td class="plomo">Programa Asociado</td>
        <td>{{ $requestForm->program }}</td>
    </tr>
    <tr>
        <td class="plomo">Justificación en Breve (Adjuntar respaldo)</td>
        <td>{{ $requestForm->justification }}</td>
    </tr>
</table><br><br>

@if($requestForm->type_form === 'item')
    <div style="padding-bottom: 8px;">
       <u><strong>Formulario Requerimiento Bienes y/o Servicios</strong></u>
    </div>

    <table class="ocho">
        <thead>
            <tr class="center plomo">
                <th>N°</th>
                <th>Item</th>
                <th>Cantidad</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requestForm->items as $key => $item)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $item->item }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->specification }}</td>
            </tr>
            @endforeach
        </tbody>
    </table><br><br>
@endif

@if($requestForm->type_form === 'passage')
<div style="padding-bottom: 8px;">
   <u><strong>Formulario Requerimiento Pasajes Aéreos</strong></u>
</div>

<table class="siete">
    <thead>
        <tr class="center plomo">
            <th>Nombre</th>
            <th>Rut</th>
            <th>F.Nacimiento</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Tramo</th>
            <th>F.ida</th>
            <th>F.Regreso</th>
            <th>Tipo Equipaje</th>
        </tr>
    </thead>
    <tbody>
      <tr>
          <td>--</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
      </tr>
    </tbody>
</table><small>Nota: Adjuntar V°B° Director y programa de la actividad</small><br><br>
@endif

<table class="ocho">
  <tr>
    <th COLSPAN=2>SOLICITA</th>
    <th COLSPAN=2>AUTORIZA</th>
  </tr>
  <tr>
    <td>Nombre</td><td>{{ $requestForm->whorequest->FullName ?? '' }}</td><td>Nombre</td><td>{{ $requestForm->whoauthorize->FullName ?? '' }}</td>
  </tr>
  <tr>
    <td>Cargo</td><td>{{ $requestForm->whorequest_position ?? '' }}</td><td>Cargo</td><td>{{ $requestForm->whoauthorize_position ?? '' }}</td>
  </tr>
  <tr>
    <td>Fecha de Aprobación</td><td>
        @if($requestForm->StatusName === 'Nuevo' && $requestForm->whorequest_id == Auth::user()->id)
            ...
        @else
            @foreach($requestForm->requestformevents as $event)
                @if($event->type == "status" && $event->StatusName == "Aprobado por solicitante")
                  {{ $event->CreationDate }}
                @endif
            @endforeach
        @endif
    </td>
    <td>Firma</td><td>
        @if($requestForm->StatusName === 'Aprobado por solicitante' &&
          in_array($requestForm->whoauthorize_unit_id, App\Utilities::getPermissionSignaureAuthorize()))
            ...
        @else
            @foreach($requestForm->requestformevents as $event)
                @if($event->type == "status" && $event->StatusName == "Aprobado por jefatura")
                  {{ $event->CreationDate }}
                @endif
            @endforeach
        @endif
    </td>
  </tr>
</table><br><br>

<div style="padding-bottom: 8px;">
   <u><strong>Uso Exclusivo Departamento Gestión Financiera:</strong></u>
</div>

<div style="border:1px solid black;">

  <div style="font-size: 0.8rem;text-align: center;font-weight: bold;padding: 14px 0 6px;">CERTIFICADO REFRENDACION PRESUPUESTARIA</div><br>
  <table class="siete" style="width:80%;" align="center">
      <tr>
          <td class="plomo" style="width:40%">PROGRAMA ASOCIADO</td>
          <td></td>
      </tr>
      <tr >
          <td class="plomo">Folio Requerimiento - SIGFE</td>
          <td></td>
      </tr>
      <tr>
          <td class="plomo">Folio Compromiso SIGFE - ID - OC</td>
          <td></td>
      </tr>
      <tr>
          <td class="plomo">Ítem Presupuestario</td>
          <td></td>
      </tr>
      <tr>
          <td class="plomo">Monto $</td>
          <td></td>
      </tr>
      <tr>
          <td class="plomo">Fecha</td>
          <td></td>
      </tr>
      <tr>
          <td class="plomo">Saldo del programa</td>
          <td></td>
      </tr>
  </table>
  <table class="siete" style="width:80%;" align="center">
    <tr>
      <th COLSPAN=2>AUTORIZA</th>
    </tr>
    <tr>
      <td>Nombre:</td><td></td>
    </tr>
    <tr>
      <td>Cargo:</td><td></td>
    </tr>
    <tr>
      <td>Firma:</td><td></td>
    </tr>
  </table>
</div>

@endsection
