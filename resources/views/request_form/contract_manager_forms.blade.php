@extends('layouts.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<h4 class="mb-3">Formularios de Requerimiento asignados como administrador de contrato - Bandeja de Entrada</h4>

@include('request_form.partials.nav')

@if(count($contract_manager_forms) > 0)

    <!-- <fieldset class="form-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" class="form-control" id="forsearch" onkeyup="filter(1)" placeholder="Buscar un número de formulario" name="search" required="">
            <div class="input-group-append">
                <a class="btn btn-primary" href="{{ route('request_forms.create') }}"><i class="fas fa-plus"></i> Nuevo Formulario</a>
            </div>
        </div>
    </fieldset> -->

    </div>
        <div class="col">
            <h6><i class="fas fa-archive"></i> Formularios pendientes de aprobación, aprobados y/o rechazados</h6>
            <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered small">
              <thead>
                <tr class="text-center">
                  <th>ID</th>
                  <th>Folio</th>
                  <th style="width: 7%">Fecha Creación</th>
                  <th>Tipo / Mecanismo de Compra</th>
                  <th>Descripción</th>
                  <th>Usuario Gestor</th>
                  <th>Comprador</th>
                  <th>Items</th>
                  <th>Espera</th>
                  <th>Etapas de aprobación</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                  @foreach($contract_manager_forms as $requestForm)
                        <tr>
                            <th>{{ $requestForm->id }} <br>
                                @switch($requestForm->getStatus())
                                    @case('Pendiente')
                                        <i class="fas fa-clock"></i>
                                        @break

                                    @case('Aprobado')
                                        <span style="color: green;">
                                          <i class="fas fa-check-circle" title="{{ $requestForm->getStatus() }}"></i>
                                        </span>
                                        @break

                                    @case('Rechazado')
                                        <a href="">
                                            <span style="color: Tomato;">
                                                <i class="fas fa-times-circle" title="{{ $requestForm->getStatus() }}"></i>
                                            </span>
                                        </a>
                                        @break

                                @endswitch
                            </th>
                            <td>
                                  <a href="{{ route('request_forms.show', $requestForm->id) }}">{{ $requestForm->folio }}</a>
                                  @if($requestForm->father)
                                  <br>(<a href="{{ route('request_forms.show', $requestForm->father->id) }}">{{ $requestForm->father->folio }}</a>)
                                  @endif
                            </td>
                            <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}<br>
                                {{ $requestForm->SubtypeValue }}</td>
                            <td>{{ $requestForm->name }}</td>
                            <td>{{ $requestForm->user ? $requestForm->user->FullName : 'Usuario eliminado' }}<br>
                                {{ $requestForm->userOrganizationalUnit ? $requestForm->userOrganizationalUnit->name : 'Usuario eliminado' }}
                            </td>
                            <td>{{ $requestForm->purchasers->first()->FullName ?? 'No asignado' }}</td>
                            <td align="center">{{ $requestForm->quantityOfItems() }}</td>
                            <td align="center">{{ $requestForm->created_at->diffForHumans() }}</td>
                            <td class="text-center">
                                  @foreach($requestForm->eventRequestForms as $sign)
                                      @if($sign->status == 'pending' || $sign->status == NULL)
                                          <i class="fas fa-clock fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
                                      @endif
                                      @if($sign->status == 'approved')
                                          <span style="color: green;">
                                              <i class="fas fa-check-circle fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
                                          </span>
                                      @endif
                                      @if($sign->status == 'rejected')
                                          <span style="color: Tomato;">
                                              <i class="fas fa-times-circle fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
                                          </span>
                                      @endif
                                  @endforeach
                              </td>
                            <td>
                              <a href="{{ route('request_forms.show', $requestForm->id) }}"
                                  class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-eye"></i>
                              </a>
                              @if($requestForm->signatures_file_id)
                                  @if($requestForm->signatures_file_id == 11)
                                  <a class="btn btn-info btn-sm"
                                      title="Ver Formulario de Requerimiento firmado"
                                      href="{{ route('request_forms.show_file', $requestForm->requestFormFiles->first() ?? 0) }}"
                                      target="_blank" title="Certificado">
                                        <i class="fas fa-file-contract"></i>
                                  </a>
                                  @else
                                  <a class="btn btn-info btn-sm"
                                      title="Ver Formulario de Requerimiento firmado"
                                      href="{{ route('request_forms.signedRequestFormPDF', [$requestForm, 1]) }}"
                                      target="_blank" title="Certificado">
                                        <i class="fas fa-file-contract"></i>
                                  </a>
                                  @endif
                                  @if($requestForm->old_signatures_file_id)
                                  <a class="btn btn-secondary btn-sm"
                                      title="Ver Formulario de Requerimiento Anterior firmado"
                                      href="{{ route('request_forms.signedRequestFormPDF', [$requestForm, 0]) }}"
                                      target="_blank" title="Certificado">
                                        <i class="fas fa-file-contract"></i>
                                  </a>
                                  @endif
                              @endif
                            </td>
                        </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
          {{$contract_manager_forms->links()}}
        </div>
    @else
        <div class="card">
          <div class="card-body">
            No hay formularios de requerimiento para mostrar.
          </div>
        </div>
    @endif

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
