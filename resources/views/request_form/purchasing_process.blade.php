@extends('layouts.app')

@section('title', 'Formulario de Requerimientos')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css"/>

<h4 class="mb-3">Formulario de Requerimiento - Proceso de Compra</h4>

@include('request_form.nav')

<div class="card mx-0">
  <h6 class="card-header text-primary"><i class="fas fa-file-signature"></i> Formulario de Requerimiento N° {{ $requestForm->id }}</h6>
  <div class="card-body mx-4 px-0">

    <div class="container-fluid row mx-0 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->
      <table class="table table-condensed table-sm small">
          <tr class="d-flex">
              <th class="text-muted col-3" scope="row">Gasto Estimado</th>
              <td class="col-3">{{ $requestForm->estimatedExpense() }}</td>
              <th class="text-muted col-3" scope="row">Nombre del Solicitante</th>
              <td class="col-3">{{ $requestForm->creator->tinnyName()}}</td>
          </tr>

          <tr class="d-flex">
              <th class="text-muted col-3" scope="row">Unidad Organizacional</th>
              <td class="col-3">{{ $requestForm->organizationalUnit->getInitialsAttribute() }}</td>
              <th class="text-muted col-3" scope="row">Mecanismo de Compra</th>
              <td class="col-3">{{ $requestForm->getPurchaseMechanism()}}</td>
          </tr>

          <tr class="d-flex">
              <th class="text-muted col-3" scope="row">Programa Asociado</th>
              <td class="col-3">{{ $requestForm->program }}</td>
              <th class="text-muted col-3" scope="row">Folio Requerimiento SIGFE</th>
              <td class="col-3">{{ $requestForm->sigfe }}</td>
          </tr>

          <tr class="d-flex">
              <th class="text-muted col-3" scope="row">Justificación de Adquisición</th>
              <td class="col-3">{{ $requestForm->justification }}</td>
              <th class="text-muted col-3" scope="row">Fecha de Creación</th>
              <td class="col-3">{{ $requestForm->createdDate() }}</td>
          </tr>

          <tr class="d-flex">
              <th class="text-muted col-3" scope="row">Archivos</th>
              <td class="col-3">FILE01 - FILE02 - FILE03 - FILE04</td>
              <th class="text-muted col-3" scope="row">Tiempo transcurrido</th>
              <td class="col-3">{{ $requestForm->getElapsedTime() }}</td>
          </tr>

          <tr class="d-flex">
              <th class="text-muted col-3" scope="row">Aprobación Abastecimiento</th>
              <td class="col-3">{{ $requestForm->eventApprovedDate('supply_event') }}</td>
              <th class="text-muted col-3" scope="row">Visador Abastecimiento</th>
              <td class="col-3">{{ $requestForm->eventSignerName('supply_event') }}</td>
          </tr>

          <tr class="d-flex">
              <th class="text-muted col-3" scope="row"></th>
              <td class="col-3"></td>
              <th class="text-muted col-3" scope="row"></th>
              <td class="col-3"></td>
          </tr>
      </table>
    </div><!-- div para TABLA -->

    <div class="row mx-3 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->
      <h6 class="card-subtitle mt-0 mb-2 text-primary">Lista de Bienes y/o Servicios:</h6>
      <table class="table table-condensed table-hover table-bordered table-sm small">
        <thead>
          <tr>
            <th>Item</th>
            <th>ID</th>
            <th>Cod.Presup.</th>
            <th>Artículo</th>
            <th>UM</th>
            <th>Especificaciones Técnicas</th>
            <th>Archivo</th>
            <th>Cantidad</th>
            <th>Valor U.</th>
            <th>Impuestos</th>
            <th>Total Item</th>
          </tr>
        </thead>
        <tbody>
          @foreach($requestForm->itemRequestForms as $key => $item)
                  <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $item->id }}</td>
                      <td>{{ $item->budgetItem()->first()->fullName() }}</td>
                      <td>{{ $item->article }}</td>
                      <td>{{ $item->unit_of_measurement }}</td>
                      <td>{{ $item->specification }}</td>
                      <td>FILE</td>
                      <td align='right'>{{ $item->quantity }}</td>
                      <td align='right'>{{ $item->unit_value }}</td>
                      <td>{{ $item->tax }}</td>
                      <td align='right'>{{ $item->formatExpense() }}</td>
                  </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="7" rowspan="2"></td>
            <td colspan="2" align='right'>Cantidad de Items</td>
            <td colspan="2" align='right'>{{count($requestForm->itemRequestForms)}}</td>
          </tr>
          <tr>
            <td colspan="2" align='right'>Valor Total</td>
            <td colspan="2" align='right'>{{$requestForm->estimatedExpense()}}</td>
          </tr>
        </tfoot>
      </table>
    </div><!-- DIV para TABLA-->



  </div><!-- card-body -->
</div><!-- card-principal -->


@endsection
