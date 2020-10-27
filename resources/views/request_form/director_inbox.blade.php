@extends('layouts.app')

@section('title', 'Bandeja de Director')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3 class="mb-3">Formulario de Requerimiento N°1.</h3>

@include('request_form.nav')

<h5 class="mb-3">Formularios Pendientes de Aprobación.</h5>

<table class="table table-condensed table-hover table-bordered table-sm small">
  <thead>
    <tr>
      <th>Nro.</th>
      <th>Tipo</th>
      <th>Usuario Gestor</th>
      <th>Admin. Contrato</th>
      <th>Justificación</th>
      <th>Estado</th>
      <th>Fecha Creación</th>
      <th>Días de espera</th>
      <th>Fecha Cierre</th>
      <th colspan="2">Seleccione</th>
    </tr>
  </thead>
  <tbody>
      @foreach($rfs as $key => $rf)
      <tr>
          <td>{{ $rf->id }}</td>
          <td>{{ $rf->TypeName }}</td>
          <td>{{ $rf->user ? $rf->user->FullName : 'Usuario eliminado' }}</td>
          <td>{{ $rf->admin_id ? $rf->admin->FullName : 'Usuario eliminado' }}</td>
          <td>{{ $rf->justification }}</td>
          <td>{{ $rf->StatusName }}</td>
          <td>{{ $rf->CreationDate }}</td>
          <td>{{ $rf->ElapsedTime }}</td>
          <td>{{ $rf->EndDate }}</td>
          <td>
            <a href="{{ route('request_forms.edit', $rf->id) }}" class="btn btn-outline-secondary btn-sm" title="Ir">
            <span class="fas fa-edit" aria-hidden="true"></span></a>
          </td>
          <td>
            <a href="{{ route('request_forms.record', $rf->id) }}"
  						class="btn btn-outline-secondary btn-sm" target="_blank">
  					<span class="fas fa-file" aria-hidden="true"></span></a>
          </td>
      </tr>
  		@endforeach
  </tbody>
</table>

@endsection

@section('custom_js')

@endsection

@section('custom_js_head')

@endsection
