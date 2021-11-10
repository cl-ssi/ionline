@extends('layouts.app')

@section('title', 'Formularios de Requerimientos')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css"/>

<h4 class="mb-3">Formulario de Requerimiento - Autorización Jefatura</h4>

@include('request_form.nav')

<div class="row">
  <div class="col-sm-8">
    <div class="table-responsive">
        <h6><i class="fas fa-info-circle"></i> Detalle Formulario</h6>
        <table class="table table-sm table-striped table-bordered">
            <!-- <thead>
                <tr class="table-active">
                    <th colspan="2">Formulario Contratación de Personal </th>
                </tr>
            </thead> -->
            <tbody class="small">
                <tr>
                    <th class="table-active" style="width: 33%">Gasto Estimado</th>
                    <td>${{ $requestForm->estimated_expense }}</td>
                </tr>
                <tr>
                    <th class="table-active" scope="row">Nombre del Solicitante</th>
                    <td>{{ $requestForm->creator->getFullNameAttribute()}}</td>
                </tr>
                <tr>
                    <th class="table-active" scope="row">Unidad Organizacional</th>
                    <td>{{ $requestForm->organizationalUnit->name}}</td>
                </tr>
                <tr>
                    <th class="table-active" scope="row">Mecanismo de Compra</th>
                    <td>{{ $requestForm->getPurchaseMechanism()}}</td>
                </tr>
                <tr>
                    <th class="table-active" scope="row">Programa Asociado</th>
                    <td>{{ $requestForm->program }}</td>
                </tr>
                <tr>
                    <th class="table-active" scope="row">Justificación de Adquisición</th>
                    <td>{{ $requestForm->justification }}</td>
                </tr>
                <tr>
                    <th class="table-active" scope="row">Fecha de Creación</th>
                    <td>{{ $requestForm->created_at }}</td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
    <div class="col-sm-4">
        <h6><i class="fas fa-paperclip"></i> Adjuntos</h6>
        <div class="list-group">
            @foreach($requestForm->requestFormFiles as $file)
              <a href="#" class="list-group-item list-group-item-action py-2 small">
                <i class="fas fa-file"></i> {{ $file->name }} -
                <i class="fas fa-calendar-day"></i> {{ $file->created_at->format('d-m-Y H:i') }}</a>
            @endforeach
        </div>
    </div>
</div>


<br>



<br>

<div class="table-responsive">
    <h6><i class="fas fa-info-circle"></i> Lista de Bienes y/o Servicios</h6>
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
</div>

<livewire:request-form.authorization :requestForm="$requestForm" :eventType="$eventType" >

@endsection
