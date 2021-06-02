@extends('layouts.app')

@section('title', 'Formulario de Requerimientos')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css"/>

<h4 class="mb-3">Formulario de Requerimiento - Autorización Abastecimiento</h4>

@include('request_form.nav')

<div class="card mx-0">
  <h6 class="card-header text-primary"><i class="fas fa-file-signature"></i> Formulario de Requerimiento N° {{ $requestForm->id }}</h6>
  <div class="card-body mx-4 px-0">

    <div class="row mx-3 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->
      <table class="table table-sm">
          <tr>
              <th class="text-muted" scope="row">Gasto Estimado</th>
              <td>${{ $requestForm->estimated_expense }}</td>
          </tr>
          <tr>
              <th class="text-muted" scope="row">Nombre del Solicitante</th>
              <td>{{ $requestForm->creator->getFullNameAttribute()}}</td>
          </tr>
          <tr>
              <th class="text-muted" scope="row">Unidad Organizacional</th>
              <td>{{ $requestForm->organizationalUnit->name}}</td>
          </tr>
          <tr>
              <th class="text-muted" scope="row">Mecanismo de Compra</th>
              <td>{{ $requestForm->getPurchaseMechanism()}}</td>
          </tr>
          <tr>
              <th class="text-muted" scope="row">Programa Asociado</th>
              <td>{{ $requestForm->program }}</td>
          </tr>
          <tr>
              <th class="text-muted" scope="row">Justificación de Adquisición</th>
              <td>{{ $requestForm->justification }}</td>
          </tr>
          <tr>
              <th class="text-muted" scope="row">Fecha de Creación</th>
              <td>{{ $requestForm->created_at }}</td>
          </tr>
          <tr>
              <th class="text-muted" scope="row">Archivos</th>
              <td>FILE01 - FILE02 - FILE03 - FILE04</td>
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
                      <td>{{$key+1}}</td>
                      <td>{{$item->id}}</td>
                      <td>{{$item->article}}</td>
                      <td>{{$item->unit_of_measurement}}</td>
                      <td>{{$item->specification}}</td>
                      <td>FILE</td>
                      <td>{{$item->quantity}}</td>
                      <td>{{$item->unit_value}}</td>
                      <td>{{$item->tax}}</td>
                      <td>{{$item->expense}}</td>
                  </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5" rowspan="2"></td>
            <td colspan="3">Cantidad de Items</td>
            <td colspan="3">{{count($requestForm->itemRequestForms)}}</td>
          </tr>
          <tr>
            <td colspan="3">Valor Total</td>
            <td colspan="3">{{$requestForm->estimated_expense}}</td>
          </tr>
        </tfoot>
      </table>
    </div><!-- DIV para TABLA-->

      <livewire:request-form.authorization :requestForm="$requestForm" :eventType="$eventType" >

  </div><!-- card-body -->
</div><!-- card-principal -->


@endsection
