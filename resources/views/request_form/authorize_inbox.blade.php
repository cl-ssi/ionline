@extends('layouts.app')

@section('title', 'Planes Comunales')

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
      @foreach($myRequestForms as $myRequestForm)
        @foreach($myRequestForm->requestformevents as $event)
          @if($event->type == 'status' && $event->StatusName == 'Aprobado por solicitante')
            @if($loop->last)
            <tr>
                <td>{{ $myRequestForm->id }}</td>
                <td>{{ $myRequestForm->TypeName }}</td>
                <td>{{ $myRequestForm->user ? $myRequestForm->user->FullName : 'Usuario eliminado' }}</td>
                <td>{{ $myRequestForm->admin_id ? $myRequestForm->admin->FullName : 'Usuario eliminado' }}</td>
                <td>{{ $myRequestForm->justification }}</td>
                <td>{{ $event->StatusName }}</td>
                <td>{{ $myRequestForm->CreationDate }}</td>
                <td>{{ $myRequestForm->ElapsedTime }}</td>
                <td>{{ $myRequestForm->EndDate }}</td>
                <td>
                  <a href="{{ route('request_forms.edit', $myRequestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Ir">
                  <span class="fas fa-edit" aria-hidden="true"></span></a>
                </td>
                <td>
                  <a href="{{ route('request_forms.record', $myRequestForm->id) }}"
                    class="btn btn-outline-secondary btn-sm" target="_blank">
                  <span class="fas fa-file" aria-hidden="true"></span></a>
                </td>
            </tr>
            @endif
          @endif
        @endforeach
      @endforeach
  </tbody>
</table>

<h5 class="mb-3">Formularios Aprobados, Cerrados o Rechazados.</h5>

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
      @foreach($myRequestForms as $myRequestForm)
        @foreach($myRequestForm->requestformevents as $event)
          @if($event->type == 'status' && ($event->StatusName == 'Aprobado por jefatura'|| $event->StatusName == 'Aprobado por finanzas' ||
                                            $event->StatusName == 'Cerrado' || $event->StatusName == 'Rechazado'))
            @if($loop->last)
            <tr>
                <td>{{ $myRequestForm->id }}</td>
                <td>{{ $myRequestForm->TypeName }}</td>
                <td>{{ $myRequestForm->user ? $myRequestForm->user->FullName : 'Usuario eliminado' }}</td>
                <td>{{ $myRequestForm->admin_id ? $myRequestForm->admin->FullName : 'Usuario eliminado' }}</td>
                <td>{{ $myRequestForm->justification }}</td>
                <td>{{ $event->StatusName }}</td>
                <td>{{ $myRequestForm->CreationDate }}</td>
                <td>{{ $myRequestForm->ElapsedTime }}</td>
                <td>{{ $myRequestForm->EndDate }}</td>
                <td>
                  <a href="{{ route('request_forms.edit', $myRequestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Ir">
                  <span class="fas fa-edit" aria-hidden="true"></span></a>
                </td>
                <td>
                  <a href="{{ route('request_forms.record', $myRequestForm->id) }}"
                    class="btn btn-outline-secondary btn-sm" target="_blank">
                  <span class="fas fa-file" aria-hidden="true"></span></a>
                </td>
            </tr>
            @endif
          @endif
        @endforeach
      @endforeach
  </tbody>
</table>

@endsection

@section('custom_js')

@endsection

@section('custom_js_head')

@endsection
