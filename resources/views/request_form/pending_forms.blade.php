@extends('layouts.bt4.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<h4 class="mb-3">Formularios de Requerimiento - Bandeja de Entrada pendientes por firmar</h4>

@include('request_form.partials.nav')

@if(count($my_forms_signed) > 0 || count($pending_forms_to_signs_manager) > 0 || count($not_pending_forms) || count($my_pending_forms_to_signs) > 0 || count($new_budget_pending_to_sign) > 0)

    {{--<fieldset class="form-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" class="form-control" id="forsearch" onkeyup="filter(1)" placeholder="Buscar un número de formulario" name="search" required="">
            <div class="input-group-append">
                <a class="btn btn-primary" href="{{ route('request_forms.create') }}"><i class="fas fa-plus"></i> Nuevo Formulario</a>
            </div>
        </div>
    </fieldset>--}}

    @if(count($my_pending_forms_to_signs) > 0)
    </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios pendientes de firma</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                  <thead class="small">
                    <tr class="text-center">
                      <th>ID</th>
                      <th>Folio</th>
                      <th style="width: 7%">Fecha Creación</th>
                      <th>Tipo / <br>Mecanismo de Compra</th>
                      <th>Descripción</th>
                      <th>Usuario Gestor</th>
                      <th>Items</th>
                      <th>Presupuesto</th>
                      <th>Etapas de aprobación</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="small">
                      @foreach($my_pending_forms_to_signs as $requestForm)
                            <tr>
                                <td>{{ $requestForm->id }} <br>
                                    @switch($requestForm->status->getLabel())
                                        @case('Pendiente')
                                            <i class="fas fa-clock"></i>
                                            @break

                                        {{--@case('complete')
                                            <span style="color: green;">
                                              <i class="fas fa-check-circle"></i>
                                            </span>
                                            @break --}}

                                    @endswitch
                                </td>
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
                                    {{ $requestForm->SubtypeValue }}
                                </td>
                                <td>{{ $requestForm->name }}</td>
                                <td>{{ $requestForm->user->fullName }}<br>
                                    {{ $requestForm->userOrganizationalUnit->name }}
                                </td>
                                <td align="center">{{ $requestForm->quantityOfItems() }}</td>
                                <td class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
                                <td class="text-center">
                                  @foreach($requestForm->eventRequestForms as $sign)
                                      @if($sign->status == 'pending')
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
                                <a href="{{ route('request_forms.sign', [$requestForm, $requestForm->firstPendingEvent()->event_type]) }}" class="btn btn-outline-primary btn-sm" title="Aceptar o Rechazar">
                                  <i class="fas fa-signature"></i>
                                </a>
                              </td>
                            </tr>
                      @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    @else
        </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios pendientes de firma</h6>
            <div class="card mb-3 bg-light">
              <div class="card-body">
                No hay formularios de requerimiento pendientes de firma.
              </div>
            </div>
        </div>
    @endif
    
    @if(count($secretaries) > 0){
    @if(count($pending_forms_to_signs_manager) > 0)
    </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios pendientes de firma desde secretaría</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                  <thead class="small">
                    <tr class="text-center">
                      <th>ID</th>
                      <th>Folio</th>
                      <th style="width: 7%">Fecha Creación</th>
                      <th>Tipo / <br>Mecanismo de Compra</th>
                      <th>Descripción</th>
                      <th>Usuario Gestor</th>
                      <th>Items</th>
                      <th>Presupuesto</th>
                      <th>Etapas de aprobación</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="small">
                      @foreach($pending_forms_to_signs_manager as $requestForm)
                            <tr>
                                <td>{{ $requestForm->id }} <br>
                                    @switch($requestForm->status->getLabel())
                                        @case('Pendiente')
                                            <i class="fas fa-clock"></i>
                                            @break

                                        {{--@case('complete')
                                            <span style="color: green;">
                                              <i class="fas fa-check-circle"></i>
                                            </span>
                                            @break --}}

                                    @endswitch
                                </td>
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
                                    {{ $requestForm->SubtypeValue }}
                                </td>
                                <td>{{ $requestForm->name }}</td>
                                <td>{{ $requestForm->user->fullName }}<br>
                                    {{ $requestForm->userOrganizationalUnit->name }}
                                </td>
                                <td align="center">{{ $requestForm->quantityOfItems() }}</td>
                                <td class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
                                <td class="text-center">
                                  @foreach($requestForm->eventRequestForms as $sign)
                                      @if($sign->status == 'pending')
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
                                    class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-eye"></i></a>
                              </td>
                            </tr>
                      @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    @else
        </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios pendientes de firma desde secretaría</h6>
            <div class="card mb-3 bg-light">
              <div class="card-body">
                No hay formularios de requerimiento pendientes de firma desde secretaría.
              </div>
            </div>
        </div>
    @endif
    @endif

    @if(array_intersect($events_type, ['pre_finance_event', 'finance_event', 'supply_event']))
    @if(count($new_budget_pending_to_sign) > 0)
    </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios con nuevo presupuesto pendiente de firma</h6>
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                  <thead class="small">
                    <tr class="text-center">
                      <th>ID</th>
                      <th>Folio</th>
                      <th style="width: 7%">Fecha Creación</th>
                      <th>Tipo / Mecanismo de Compra</th>
                      <th>Descripción</th>
                      <th>Usuario Gestor</th>
                      <th>Comprador</th>
                      <th>Items</th>
                      <th>Presupuesto</th>
                      <th>Etapas de aprobación</th>
                      <th style="width: 7%">Fecha de Aprobación</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="small">
                      @foreach($new_budget_pending_to_sign as $requestForm)
                            <tr>
                                <td>{{ $requestForm->id }}</td>
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
                                    {{ $requestForm->SubtypeValue }}
                                </td>
                                <td>{{ $requestForm->name }}</td>
                                <td>{{ $requestForm->user->fullName }}<br>
                                    {{ $requestForm->userOrganizationalUnit->name }}
                                </td>
                                <td>{{ $requestForm->purchasers->first()->fullName ?? 'No asignado' }}</td>
                                <td align="center">{{ $requestForm->quantityOfItems() }}</td>
                                <td class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
                                <td class="text-center">
                                  @foreach($requestForm->eventRequestForms as $sign)
                                      @if($sign->status == 'pending')
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
                              <td>{{ $requestForm->eventRequestForms->where('signer_user_id', auth()->id())->last()->signature_date?? 'No se ha firmado Documento' }}</td>
                              <td>
                                <a href="{{ route('request_forms.sign', [$requestForm, $requestForm->firstPendingEvent()->event_type]) }}" class="btn btn-outline-primary btn-sm" title="Aceptar o Rechazar">
                                  <i class="fas fa-signature"></i>
                                </a>
                              </td>
                            </tr>
                      @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    @else
        </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios con nuevo presupuesto pendiente de firma</h6>
            <div class="card mb-3 bg-light">
              <div class="card-body">
                No hay formularios de requerimiento con nuevo presupuesto pendientes de firma.
              </div>
            </div>
        </div>
    @endif
    @endif

    @if(count($my_forms_signed) > 0)
    </div>
        <div class="col">
            <h6><i class="fas fa-archive"></i> Mis formularios aprobados o rechazados</h6>
            <div class="table-responsive">
            <table class="table table-sm table-hover table-bordered">
              <thead class="small">
                <tr class="text-center">
                  <th>ID</th>
                  <th>Folio</th>
                  <th style="width: 7%">Fecha Creación</th>
                  <th>Tipo / Mecanismo de Compra</th>
                  <th>Descripción</th>
                  <th>Usuario Gestor</th>
                  <th>Comprador</th>
                  <th>Items</th>
                  <th>Presupuesto</th>
                  <th>Etapas de aprobación</th>
                  <th style="width: 7%">Fecha de Aprobación</th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="small">
                  @foreach($my_forms_signed as $requestForm)
                        <tr>
                            <th>{{ $requestForm->id }} <br>
                                @switch($requestForm->status->getLabel())
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
                            <td>
                                {{ $requestForm->created_at->format('d-m-Y H:i') }}<br>
                                {{ $requestForm->created_at->diffForHumans() }}
                            </td>
                            <td>{{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}<br>
                                    {{ $requestForm->SubtypeValue }}
                                </td>
                            <td>{{ $requestForm->name }}</td>
                            <td>{{ $requestForm->user ? $requestForm->user->fullName : 'Usuario eliminado' }}<br>
                                {{ $requestForm->userOrganizationalUnit ? $requestForm->userOrganizationalUnit->name : 'Usuario eliminado' }}
                            </td>
                            <td>{{ $requestForm->purchasers->first()->fullName ?? 'No asignado' }}</td>
                            <td align="center">{{ $requestForm->quantityOfItems() }}</td>
                            <td class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
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
                            <td>{{ $requestForm->eventRequestForms->where('signer_user_id', auth()->id())->last()->signature_date?? 'No se ha firmado Documento' }}

                            <td>
                                <a href="{{ route('request_forms.show', $requestForm->id) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-eye"></i></a>

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
                            </td>
                        </tr>
                  @endforeach
              </tbody>
            </table>
            {{$my_forms_signed->appends(Request::input())->links()}}
          </div>
        </div>
    @else
        </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Mis formularios firmados o rechazados</h6>
            <div class="card mb-3 bg-light">
                <div class="card-body">
                  No hay formularios de requerimiento firmados o rechazados.
                </div>
            </div>
        </div>
    @endif

    @if(array_intersect($events_type, ['pre_finance_event', 'finance_event', 'supply_event']))
        @if(count($not_pending_forms) > 0)
        </div>
            <div class="col">
                <h6><i class="fas fa-archive"></i> Formularios aprobados o rechazados</h6>
                <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                <thead class="small">
                    <tr class="text-center">
                    <th>ID</th>
                    <th>Folio</th>
                    <th style="width: 7%">Fecha Creación</th>
                    <th>Tipo / Mecanismo de Compra</th>
                    <th>Descripción</th>
                    <th>Usuario Gestor</th>
                    <th>Comprador</th>
                    <th>Items</th>
                    <th>Presupuesto</th>
                    <th>Etapas de aprobación</th>
                    <th style="width: 7%">Fecha de Aprobación</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody class="small">
                    @foreach($not_pending_forms as $requestForm)
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
                                <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}<br>
                                    {{ $requestForm->created_at->diffForHumans() }}</td>
                                <td>{{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}<br>
                                    {{ $requestForm->SubtypeValue }}
                                </td>
                                <td>{{ $requestForm->name }}</td>
                                <td>{{ $requestForm->user ? $requestForm->user->fullName : 'Usuario eliminado' }}<br>
                                    {{ $requestForm->userOrganizationalUnit ? $requestForm->userOrganizationalUnit->name : 'Usuario eliminado' }}
                                </td>
                                <td>{{ $requestForm->purchasers->first()->fullName ?? 'No asignado' }}</td>
                                <td align="center">{{ $requestForm->quantityOfItems() }}</td>
                                <td class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
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
                                <td>{{ $requestForm->eventRequestForms->where('signer_user_id', auth()->id())->last()->signature_date??'No se ha firmado Documento' }}</td>

                                <td>
                                    <a href="{{ route('request_forms.show', $requestForm->id) }}"
                                        class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-eye"></i></a>

                                        @if($requestForm->signatures_file_id)
                                        <a class="btn btn-info btn-sm" title="Ver Formulario de Requerimiento firmado" href="{{ $requestForm->signatures_file_id == 11 ? route('request_forms.show_file', $requestForm->requestFormFiles->first() ?? 0) : route('request_forms.signedRequestFormPDF', [$requestForm, 1]) }}" target="_blank" title="Certificado">
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
                                </td>
                            </tr>
                    @endforeach
                </tbody>
                </table>
                {{$not_pending_forms->appends(Request::input())->links()}}
            </div>
            </div>
        @else
            </div>
            <div class="col">
                <h6><i class="fas fa-inbox"></i> Formularios firmados o rechazados</h6>
                <div class="card mb-3 bg-light">
                    <div class="card-body">
                    No hay formularios de requerimiento firmados o rechazados.
                    </div>
                </div>
            </div>
        @endif
    @endif
@else
        <div class="card">
          <div class="card-body">
            No hay formularios de requerimiento para mostrar.
          </div>
        </div>
@endif

<!-- Modal -->
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="exampleModalLongTitle"><i class="fas fa-exclamation-triangle"></i> Eliminar Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p>Estás por eliminar un Formulario, este proceso es irreversible.</p>
        <p>Quieres continuar?</p>
        <p class="debug-url"></p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <a class="btn btn-danger btn-ok">Eliminar</a>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal -->

@endsection
@section('custom_js')
<script>
    $('#confirm').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

        $('.debug-url').html('<strong>Eliminar Formulario de Requerimiento ID ' + $(e.relatedTarget).data('id') + '</strong>');
    });
</script>
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
