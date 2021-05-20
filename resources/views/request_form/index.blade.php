@extends('layouts.app')

@section('title', 'Formulario de requerimiento')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h4 class="mb-3">Formularios de Requerimiento - Bandeja de Entrada</h4>

@include('request_form.nav')
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

        <div class="card border border-muted text-black bg-light mb-5">
          <div class="card-header text-primary h6">Formularios sin Aprobaciones</div>
          <div class="card-body">
            <table class="table table-striped table-sm small">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Tipo</th>
                  <th scope="col">Usuario Gestor</th>
                  <th scope="col">Justificación</th>
                  <th scope="col">Fecha Creación</th>
                  <th scope="col">Días de espera</th>
                  <th scope="col">Fecha Cierre</th>
                  <th scope="col" colspan="2">Seleccione</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($createdRequestForms as $requestForm)
                        <tr>
                            <th class="align-middle" scope="row">{{ $requestForm->id }}</td>
                            <td class="align-middle">{{ $requestForm->type_form }}</td>
                            <td class="align-middle">{{ $requestForm->creator ? $requestForm->creator->FullName : 'Usuario eliminado' }}</td>
                            <td class="align-middle">{{ $requestForm->justification }}</td>
                            <td class="align-middle">{{ $requestForm->CreationDate }}</td>
                            <td class="align-middle">{{ $requestForm->ElapsedTime }}</td>
                            <td class="align-middle">{{ $requestForm->EndDate }}</td>
                            <td class="align-middle">
                              <a href="{{ route('request_forms.edit', $requestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Ir">
                              <span class="fas fa-edit" aria-hidden="true"></span></a>
                            </td>
                            <td class="align-middle">
                              <a href="#"
                                class="btn btn-outline-secondary btn-sm" target="_blank">
                              <span class="fas fa-file" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                  @endforeach
              </tbody>
            </table>

          </div>
        </div>

        <h5 class="mb-3">Formularios en Progreso</h5>
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
              @foreach($inProgresRequestForms as $myRequestForm)
                    <tr>
                        <td>{{ $myRequestForm->id }}</td>
                        <td>{{ $myRequestForm->type_form }}</td>
                        <td>{{ $myRequestForm->creator ? $myRequestForm->creator->FullName : 'Usuario eliminado' }}</td>
                        <td>{{ $myRequestForm->justification }}</td>
                        <td>{{ $myRequestForm->CreationDate }}</td>
                        <td>{{ $myRequestForm->ElapsedTime }}</td>
                        <td>{{ $myRequestForm->EndDate }}</td>
                        <td>
                          <a href="{{ route('request_forms.edit', $myRequestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Ir">
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

        <h5 class="mb-3">Formularios Aprovados.</h5>
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
              @foreach($approvedRequestForms as $myRequestForm)
                    <tr>
                        <td>{{ $myRequestForm->id }}</td>
                        <td>{{ $myRequestForm->type_form }}</td>
                        <td>{{ $myRequestForm->creator ? $myRequestForm->creator->FullName : 'Usuario eliminado' }}</td>
                        <td>{{ $myRequestForm->justification }}</td>
                        <td>{{ $myRequestForm->CreationDate }}</td>
                        <td>{{ $myRequestForm->ElapsedTime }}</td>
                        <td>{{ $myRequestForm->EndDate }}</td>
                        <td>
                          <a href="{{ route('request_forms.edit', $myRequestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Ir">
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

        <h5 class="mb-3">Formularios Cerrados o Rechazados</h5>
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
              @foreach($rejectedRequestForms as $myRequestForm)
                    <tr>
                        <td>{{ $myRequestForm->id }}</td>
                        <td>{{ $myRequestForm->type_form }}</td>
                        <td>{{ $myRequestForm->creator ? $myRequestForm->creator->FullName : 'Usuario eliminado' }}</td>
                        <td>{{ $myRequestForm->justification }}</td>
                        <td>{{ $myRequestForm->CreationDate }}</td>
                        <td>{{ $myRequestForm->ElapsedTime }}</td>
                        <td>{{ $myRequestForm->EndDate }}</td>
                        <td>
                          <a href="{{ route('request_forms.edit', $myRequestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Ir">
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

@endsection
@section('custom_js')
@endsection
@section('custom_js_head')
@endsection
