@extends('layouts.bt4.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<div class="alert alert-info alert-sm" role="alert">
    <div class="row">
        <div class="col-sm">
            <i class="fas fa-info-circle"></i> <b>Fecha límite para la emisión de formularios de requerimientos para nuevos procesos de compra</b>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8 text-justify">
            <br />
            Todos los formularios de requerimientos para nuevos procesos de compra deberán emitirse a más 
            tardar el <b>30 de septiembre de 2024</b>. Es importante destacar que los formularios de requerimientos 
            de suministro mensual no están sujetos a esta fecha límite, de igual que los formularios de requerimientos 
            de presupuestos de programas o proyectos asignados posterior al 30-09-2024.
        </div>
        <div class="col-sm-4">
            <br />
            <a class="btn btn-light btn-sm float-right" href="{{ route('request_forms.circular_3650_2024') }}"
                target="blank">
                <i class="far fa-file-pdf"></i> Descargar circular aquí
            </a>
        </div>
    </div>
</div>

<h4 class="mb-3">Formularios de Requerimiento - Bandeja de Entrada</h4>

@include('request_form.partials.nav')

@if(count($my_requests) > 0 || count($my_pending_requests) > 0 || count($my_ou) > 0)

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

@if(count($my_pending_requests) > 0)
</div>
    <div class="col">
    <h6><i class="fas fa-inbox"></i> Mis formularios pendientes de aprobación</h6>
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
            <th>Items</th>
            <th>Presupuesto</th>
            <th>Etapas de aprobación</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($my_pending_requests as $requestForm)
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
              {{ $requestForm->userOrganizationalUnit->name ?? '' }}
            </td>          
            <td align="center">{{ $requestForm->quantityOfItems() }}</td>
            <td class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
            <td class="text-center">
              @if($requestForm->eventRequestForms->count() > 0)
                  @foreach($requestForm->eventRequestForms as $sign)
                      @if($sign->status == 'pending')
                      <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                          @if($sign->event_type != 'pre_finance_event') title="{{ $sign->signerOrganizationalUnit->name }}" @else title="Refrendación Presupuestaria" @endif>
                          <i class="fas fa-clock fa-2x"></i>
                      </span>
                      @endif
                      @if($sign->status == 'approved')
                      <span style="color: green;" class="d-inline-block" tabindex="0" data-toggle="tooltip"
                          @if($sign->event_type != 'pre_finance_event') title="{{ $sign->signerOrganizationalUnit->name }}" @else title="Refrendación Presupuestaria" @endif>
                          <i class="fas fa-check-circle fa-2x"></i>
                      </span>
                      @endif
                      @if($sign->status == 'rejected')
                      <span style="color: Tomato;" class="d-inline-block" tabindex="0" data-toggle="tooltip"
                          @if($sign->event_type != 'pre_finance_event') title="{{ $sign->signerOrganizationalUnit->name }}" @else title="Refrendación Presupuestaria" @endif>
                          <i class="fas fa-times-circle fa-2x"></i>
                      </span>
                      @endif
                      @if($sign->status == 'does_not_apply')
                      <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                          @if($sign->event_type != 'pre_finance_event') title="{{ $sign->signerOrganizationalUnit->name }}" @else title="Refrendación Presupuestaria" @endif>
                          <i class="fas fa-ban fa-2x"></i>
                      </span>
                      @endif
                  @endforeach
              @else
                  <i class="fas fa-save fa-2x"></i>
              @endif
            </td>
            <td>
              @if($requestForm->canEdit())
              <a href="{{ route('request_forms.edit', $requestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
              @else
              <a href="{{ route('request_forms.show', $requestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-eye"></i></a>
              @endif
              @if($requestForm->canDelete())
              <a href="#" data-href="{{ route('request_forms.destroy', $requestForm->id) }}" data-id="{{ $requestForm->id }}" class="btn btn-outline-secondary btn-sm text-danger" title="Eliminar" data-toggle="modal" data-target="#confirm" role="button">
                <i class="fas fa-trash"></i></a>
              @endif
              @if($requestForm->hasFinanceEventPending() && App\Models\Parameters\Parameter::get('app', 'legacyModeESign'))
              <a href="{{ route('request_forms.create_view_document', [$requestForm->id, 11]) }}" class="btn btn-outline-secondary btn-sm" title="Selección" target="_blank"><i class="fas fa-file"></i></a> 
              <form method="POST" action="{{ route('request_forms.upload_form_document', $requestForm->id)}}" enctype="multipart/form-data">
                  @csrf
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="docSigned" id="docSigned" accept=".pdf" style="width: 250px" required>
                    </div>
                    <div class="input-group-append">
                      <button name="id" value="{{ $requestForm->id }}" class="btn btn-sm btn-outline-secondary">
                          <i class="fas fa-fw fa-upload"></i>
                      </button>
                    </div>
                  </div>
              </form>
              @endif
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
  <h6><i class="fas fa-inbox"></i> Mis formularios pendientes de aprobación</h6>
  <div class="card mb-3 bg-light">
    <div class="card-body">
      No hay formularios de requerimiento en progreso.
    </div>
  </div>
</div>
@endif

@if(count($my_requests) > 0)
</div>
<div class="col">
  <h6><i class="fas fa-archive"></i> Mis formularios aprobados, cerrados o rechazados</h6>
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
          <th>Presupuesto</th>          
          <th>Etapas de aprobación</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($my_requests as $requestForm)
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
            @if($requestForm->purchasingProcess)
            <span class="badge badge-{{$requestForm->purchasingProcess->getColor()}}">{{$requestForm->purchasingProcess->status->getLabel()}}</span>
            @else
            <span class="badge badge-warning">En proceso</span>
            @endif
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
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                  @if($sign->event_type != 'pre_finance_event') title="{{ $sign->signerOrganizationalUnit->name }}" @else title="Refrendación Presupuestaria" @endif">
                    <i class="fas fa-clock fa-2x"></i>
                </span>
            @endif
            @if($sign->status == 'approved')
            <span style="color: green;" class="d-inline-block" tabindex="0" data-toggle="tooltip"
              @if($sign->event_type != 'pre_finance_event') title="{{ $sign->signerOrganizationalUnit->name }}" @else title="Refrendación Presupuestaria" @endif">
                <i class="fas fa-check-circle fa-2x"></i>
            </span>
            @endif
            @if($sign->status == 'rejected')
            <span style="color: Tomato;" class="d-inline-block" tabindex="0" data-toggle="tooltip"
              @if($sign->event_type != 'pre_finance_event') title="{{ $sign->signerOrganizationalUnit->name }}" @else title="Refrendación Presupuestaria" @endif">
                <i class="fas fa-times-circle fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
            </span>
            @endif
            @if($sign->status == 'does_not_apply')
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
              @if($sign->event_type != 'pre_finance_event') title="{{ $sign->signerOrganizationalUnit->name }}" @else title="Refrendación Presupuestaria" @endif">
                <i class="fas fa-ban fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
            </span>
            @endif
            @endforeach
          </td>
          <td>
            <a href="{{ route('request_forms.show', $requestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-eye"></i>
            </a>
            @if($requestForm->canEdit())
            <a href="{{ route('request_forms.edit', $requestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
            @endif
            
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
    {{ $my_requests->links() }}
  </div>
</div>
@else
</div>
<div class="col">
  <h6><i class="fas fa-inbox"></i> Mis formularios aprobados, cerrados o rechazados</h6>
  <div class="card mb-3 bg-light">
    <div class="card-body">
      No hay formularios de requerimiento aprobados, finalizados o rechazados.
    </div>
  </div>
</div>
@endif

@if(count($my_ou) > 0)
</div>
<div class="col">
  <h6><i class="fa fa-sitemap"></i> Formularios desde mi unidad organizacional</h6>
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
          <th>Presupuesto</th>
          <th>Etapas de aprobación</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($my_ou as $requestForm)
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
            @if($requestForm->purchasingProcess)
            <span class="badge badge-{{$requestForm->purchasingProcess->getColor()}}">{{$requestForm->purchasingProcess->status->getLabel()}}</span>
            @else
            <span class="badge badge-warning">En proceso</span>
            @endif
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
            @if($requestForm->eventRequestForms->count() > 0)
                @foreach($requestForm->eventRequestForms as $sign)
                @if($sign->status == 'pending' || $sign->status == NULL)
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                  @if($sign->event_type != 'pre_finance_event') title="{{ $sign->signerOrganizationalUnit->name }}" @else title="Refrendación Presupuestaria" @endif">
                    <i class="fas fa-clock fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
                </span>
                @endif
                @if($sign->status == 'approved')
                <span style="color: green;" class="d-inline-block" tabindex="0" data-toggle="tooltip"
                  @if($sign->event_type != 'pre_finance_event') title="{{ $sign->signerOrganizationalUnit->name }}" @else title="Refrendación Presupuestaria" @endif">
                    <i class="fas fa-check-circle fa-2x"></i>
                </span>
                @endif
                @if($sign->status == 'rejected')
                <span style="color: Tomato;" class="d-inline-block" tabindex="0" data-toggle="tooltip"
                  @if($sign->event_type != 'pre_finance_event') title="{{ $sign->signerOrganizationalUnit->name }}" @else title="Refrendación Presupuestaria" @endif">
                    <i class="fas fa-times-circle fa-2x"></i>
                </span>
                @endif
                @if($sign->status == 'does_not_apply')
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                  @if($sign->event_type != 'pre_finance_event') title="{{ $sign->signerOrganizationalUnit->name }}" @else title="Refrendación Presupuestaria" @endif">
                    <i class="fas fa-ban fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
                </span>
                @endif
                @endforeach
            @else
                <i class="fas fa-save fa-2x"></i>
            @endif
          </td>
          <td>
            <a href="{{ route('request_forms.show', $requestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-eye"></i>
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
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $my_ou->links() }}
  </div>
</div>



@endif



@else
<div class="card">
  <div class="card-body">
    No hay formularios de requerimiento para mostrar.
  </div>
</div>
@endif

@include('request_form.partials.modals.confirm_delete')

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
