@extends('layouts.app')

@section('title', 'Formulario de Requerimientos')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css"/>

<h3 class="mb-3">Formulario de Requerimiento</h3>

@include('request_form.nav')

<div class="card mx-0">
  <h5 class="card-header text-muted">Formulario de Requerimientos ID {{ $requestForm->id }}  -  Creado el {{ $requestForm->created_at }}</h5>
  <div class="card-body mx-4 px-0">

    <div class="row mx-3 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->
      <table class="table table-sm">
          <tr>
              <th scope="row">Gasto Estimado</th>
              <td class="align-middle">${{ $requestForm->estimated_expense }}</td>
          </tr>
          <tr>
              <th scope="row">Nombre del Solicitante</th>
              <td class="align-middle">{{ $requestForm->creator->getFullNameAttribute()}}</td>
          </tr>
          <tr>
              <th scope="row">Unidad Organizacional</th>
              <td class="align-middle">{{ $requestForm->organizationalUnit->name}}</td>
          </tr>
          <tr>
              <th scope="row">Jefatura para Aprobación</th>
              <td class="align-middle">{!! $manager !!}</td>
          </tr>
          <tr>
              <th scope="row">Mecanismo de Compra</th>
              <td class="align-middle">{{ $requestForm->getPurchaseMechanism()}}</td>
          </tr>
          <tr>
              <th scope="row">Programa Asociado</th>
              <td class="align-middle">{{ $requestForm->program }}</td>
          </tr>
          <tr>
              <th scope="row">Justificación de Adquisición</th>
              <td class="align-middle">{{ $requestForm->justification }}</td>
          </tr>
          <tr>
              <th scope="row">Archivos</th>
              <td class="align-middle">FILE01 - FILE02 - FILE03 - FILE04</td>
          </tr>
      </table>
    </div><!-- div para TABLA -->

    <div class="row mx-3 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->
      <h5 class="card-subtitle mt-0 mb-2 text-muted">Lista de Bienes y/o Servicios:</h5>
      <table class="table table-condensed table-hover table-bordered table-sm small">
        <thead>
          <tr>
            <th>Item</th>
            <th>ID</th>
            <th>Cod. Pres.</th>
            <th>Artículo</th>
            <th>UM</th>
            <th>Especificaciones Técnicas</th>
            <th>Archivo</th>
            <th>Cantidad</th>
            <th>Valor U.</th>
            <th>Impuestos</th>
            <th>Total Item</th>
            <th colspan="2">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($requestForm->itemRequestForms as $key => $item)
                  <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$item->id}}</td>
                      <td>{{$item->budgetItem->code.' - '.$item->budgetItem->name}}</td>
                      <td>{{$item->article}}</td>
                      <td>{{$item->unit_of_measurement}}</td>
                      <td>{{$item->specification}}</td>
                      <td>FILE</td>
                      <td>{{$item->quantity}}</td>
                      <td>{{$item->unit_value}}</td>
                      <td>{{$item->tax}}</td>
                      <td>{{$item->expense}}</td>
                      <td align="center">
                        <a class="btn btn-outline-secondary btn-sm" title="Editar" wire:click="editRequestService({{ $key }})"><i class="fas fa-pencil-alt"></i></a>
                      </td>
                      <td align="center">
                        <a class="btn btn-outline-secondary btn-sm" title="Eliminar" wire:click="deleteRequestService({{ $key }})"><i class="far fa-trash-alt"></i></a>
                      </td>
                  </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5" rowspan="2"></td>
            <td colspan="4">Cantidad de Items</td>
            <td colspan="4">{{count($requestForm->itemRequestForms)}}</td>
          </tr>
          <tr>
            <td colspan="4">Valor Total</td>
            <td colspan="4">{{$requestForm->estimated_expense}}</td>
          </tr>
        </tfoot>
      </table>
    </div><!-- DIV para TABLA-->

    <div class="row mx-1 mb-4 mt-0 pt-0 px-0">
        <div class="col">
            <a href="#" class="btn btn-secondary float-right">Eliminar</a>
            <button class="btn btn-primary float-right mr-3" type="button">
                <i class="fas fa-save"></i> Editar
            </button>
        </div>
    </div>

  </div><!-- card-body -->
</div><!-- card-principal -->



@endsection
