@extends('layouts.app')

@section('title', 'Formulario de Requerimientos')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css"/>

<h4 class="mb-3">Formulario de Requerimiento - Autorización Refrendación Presupuestaria</h4>

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

      <livewire:request-form.prefinance-authorization :requestForm="$requestForm" :eventType="$eventType" >

  </div><!-- card-body -->
</div><!-- card-principal -->

@endsection
