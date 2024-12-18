@extends('layouts.bt4.app')
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
            <table class="table table-sm table-hover table-bordered small">
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
                  <th>Etapas de aprobación</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                  @foreach($contract_manager_forms as $requestForm)
                        <tr>
                            <th>{{ $requestForm->id }} <br>
                                @switch($requestForm->status->getLabel())
                                    @case('Pendiente')
                                        <i class="fas fa-clock"></i>
                                        @break

                                    @case('Aprobado')
                                        <span style="color: green;">
                                          <i class="fas fa-check-circle" title="{{ $requestForm->status->getLabel() }}"></i>
                                        </span>
                                        @break

                                    @case('Rechazado')
                                        <a href="">
                                            <span style="color: Tomato;">
                                                <i class="fas fa-times-circle" title="{{ $requestForm->status->getLabel() }}"></i>
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
                            <td>
                                {{ $requestForm->created_at->format('d-m-Y H:i') }}<br>
                                {{ $requestForm->created_at->diffForHumans() }}
                            </td>
                            <td>{{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}<br>
                                {{ $requestForm->SubtypeValue }}</td>
                            <td>{{ $requestForm->name }}</td>
                            <td>{{ $requestForm->user ? $requestForm->user->fullName : 'Usuario eliminado' }}<br>
                                {{ $requestForm->userOrganizationalUnit ? $requestForm->userOrganizationalUnit->name : 'Usuario eliminado' }}
                            </td>
                            <td>{{ $requestForm->purchasers->first()->fullName ?? 'No asignado' }}</td>
                            <td align="center">{{ $requestForm->quantityOfItems() }}</td>
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
                                      @if($sign->status == 'does_not_apply')
                                          <i class="fas fa-ban fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
                                      @endif
                                  @endforeach
                              </td>
                            <td>
                              <a href="{{ route('request_forms.show', $requestForm->id) }}"
                                  class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-eye"></i>
                              </a>
                              @if($requestForm->signatures_file_id)
                                <a class="btn btn-info btn-sm" title="Ver Formulario de Requerimiento firmado" href="{{ $requestForm->signatures_file_id == 11 ? route('request_forms.show_file', $requestForm->requestFormFiles->last() ?? 0) : route('request_forms.signedRequestFormPDF', [$requestForm, 1]) }}" target="_blank" title="Certificado">
                                <i class="fas fa-file-contract"></i>
                                </a>
                              @endif

                              @if($requestForm->old_signatures_file_id)
                                <a class="btn btn-secondary btn-sm" title="Ver Formulario de Requerimiento Anterior firmado" href="{{ $requestForm->old_signatures_file_id == 11 ? route('request_forms.show_file', $requestForm->requestFormFiles->last() ?? 0) : route('request_forms.signedRequestFormPDF', [$requestForm, 0]) }}" target="_blank" title="Certificado">
                                <i class="fas fa-file-contract"></i>
                                </a>
                              @endif

                              @if($requestForm->signedOldRequestForms->isNotEmpty())
                                <a class="btn btn-secondary btn-sm" title="Ver Formulario de Requerimiento Anteriores firmados" href="{{ $requestForm->old_signatures_file_id == 11 ? route('request_forms.show_file', $requestForm->requestFormFiles->last() ?? 0) : route('request_forms.signedRequestFormPDF', [$requestForm, 0]) }}" target="_blank" data-toggle="modal" data-target="#history-fr-{{$requestForm->id}}">
                                <i class="fas fa-file-contract"></i>
                                </a>
                                @include('request_form.partials.modals.old_signed_request_forms')
                                @endif

                              @if(Str::contains($requestForm->subtype, 'tiempo') && !$requestForm->isBlocked() && $requestForm->status->value == 'approved')
                              <a onclick="return confirm('¿Está seguro/a de crear nuevo formulario de ejecución inmediata?') || event.stopImmediatePropagation()" data-toggle="modal" data-target="#processClosure-{{$requestForm->id}}" class="btn btn-outline-secondary btn-sm" title="Nuevo formulario de ejecución inmediata"><i class="fas fa-plus"></i>
                              </a>
                              @include('request_form.partials.modals.create_provision_period_select')
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
