@extends('layouts.app')
@section('title', 'Formulario de Requerimientos')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css"/>
<h4 class="mb-3">Formulario de Requerimiento - Edición de Formularios</h4>

@include('request_form.nav')

<div class="card mb-4">
  <h6 class="card-header text-primary"><i class="fas fa-info"></i> Información General</h6>
  <div class="card-body mx-4 px-0">

    <div class="row mx-1 mt-3 pt-0"> <!-- DIV para TABLA-->
      <table class="table table-hover table-sm small">
          <tr>
              <th scope="row" class="text-muted">Nombre del Solicitante</th>
              <td class="align-middle">{{ $requestForm->creator->getFullNameAttribute()}}</td>
          </tr>
          <tr>
              <th scope="row" class="text-muted">Unidad Organizacional</th>
              <td class="align-middle">{{ $requestForm->organizationalUnit->name}}</td>
          </tr>
          <tr>
              <th scope="row" class="text-muted">Jefatura para Aprobación</th>
              <td class="align-middle">{!! $manager !!}</td>
          </tr>
          <tr>
              <th scope="row" class="text-muted">Fecha de Creación</th>
              <td class="align-middle">{{ $requestForm->created_at }}</td>
          </tr>
          <tr>
              <th scope="row" class="text-muted">Archivos Asociados</th>
              <td class="align-middle">FILE01 - FILE02 - FILE03 - FILE04</td>
          </tr>
      </table>
    </div><!-- div para TABLA -->

  </div><!-- card-body -->
</div><!-- card-principal -->

<livewire:request-form.request-form-create :requestForm="$requestForm">

@endsection

@section('custom_js_head')
<style>
table {
border-collapse: collapse;
}
.brd-l {
 border-left: solid 1px #D6DBDF;
}
.brd-r {
border-right: solid 1px #D6DBDF;
}
.brd-b {
border-bottom: solid 1px #D6DBDF;
}
.brd-t {
border-top: solid 1px #D6DBDF;
}
oz {
  color: red;
  font-size: 60px;
  background-color: yellow;
  font-family: time new roman;
}
</style>
@endsection
