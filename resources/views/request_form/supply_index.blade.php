@extends('layouts.app')

@section('title', 'Formulario de requerimiento')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3 class="mb-3">Formularios de Requerimiento - Inbox Abastecimiento</h3>

@include('request_form.nav')

<h5 class="mb-3">Formularios Abiertos.</h5>

<table class="table table-condensed table-hover table-bordered table-sm small">
  <thead>
    <tr>
      <th>Nro.</th>
      <th>Tipo</th>
      <th>Usuario Gestor</th>
      <th>Justificación</th>
      <th>Fecha Creación</th>
      <th>Días de espera</th>
      <th>Fecha Cierre</th>
      <th colspan="2">Seleccione</th>
    </tr>
  </thead>
  <tbody>
      @foreach($requestForms as $requestForm)
            <tr>
                <td>{{ $requestForm->id }}</td>
                <td>{{ $requestForm->type_form }}</td>
                <td>{{ $requestForm->creator ? $requestForm->creator->FullName : 'Usuario eliminado' }}</td>
                <td>{{ $requestForm->justification }}</td>
                <td>{{ $requestForm->CreationDate }}</td>
                <td>{{ $requestForm->ElapsedTime }}</td>
                <td>{{ $requestForm->EndDate }}</td>
                <td>
                  <a href="{{ route('request_forms.supply_sign', $requestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Ir">
                  <span class="fas fa-edit" aria-hidden="true"></span></a>
                </td>
                <td>
                  <a href="#"
                    class="btn btn-outline-secondary btn-sm" target="_blank">
                  <span class="fas fa-file" aria-hidden="true"></span></a>
                </td>
            </tr>
      @endforeach
  </tbody>
</table>


<h5 class="mb-3">Formularios Cerrados o Rechazados.</h5>
<fieldset class="form-group">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" class="form-control" id="forsearch" onkeyup="filter(1)" placeholder="Buscar un número de formulario" name="search" required="">
        <div class="input-group-append">
            <a class="btn btn-primary" href="{{ route('request_forms.create') }}"><i class="fas fa-plus"></i> Nuevo Formulario</a>
        </div>
    </div>
</fieldset>


@endsection

@section('custom_js')

@endsection

@section('custom_js_head')

@endsection
