@extends('layouts.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
<h4 class="mb-3">Formularios de Requerimiento - Bandeja de Entrada</h4>

@include('request_form.partials.nav')

@if(count($request_forms) > 0)
</div>
<div class="col">
  <h6><i class="fas fa-archive"></i> Formularios creados, aprobados y rechazados</h6>
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
          <th style="width: 7%">Fecha de Aprobación</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($request_forms as $requestForm)
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
            @if($requestForm->purchasingProcess)
            <span class="badge badge-{{$requestForm->purchasingProcess->getColor()}}">{{$requestForm->purchasingProcess->getStatus()}}</span>
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
          <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>          
          <td>{{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}<br>
            {{ $requestForm->SubtypeValue }}
          </td>
          <td>{{ $requestForm->name }}</td>
          <td>{{ $requestForm->user ? $requestForm->user->FullName : 'Usuario eliminado' }}<br>
            {{ $requestForm->userOrganizationalUnit ? $requestForm->userOrganizationalUnit->name : 'Usuario eliminado' }}
          </td>
          <td>{{ $requestForm->purchasers->first()->FullName ?? 'No asignado' }}</td>
          <td align="center">{{ $requestForm->quantityOfItems() }}</td>
          <td align="center">{{ $requestForm->created_at->diffForHumans() }}</td>
          <td class="text-center">
            @if($requestForm->eventRequestForms->count() > 0)
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
            @else
                <i class="fas fa-save fa-2x"></i>
            @endif
          </td>
          <td>{{ $requestForm->eventRequestForms->where('signer_user_id', Auth::user()->id)->last()->signature_date??'No se ha firmado Documento' }}</td>

          <td>
            <a href="{{ route('request_forms.show', $requestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Mostrar"><i class="fas fa-eye"></i>
            </a>
            @if(Auth()->user()->hasPermissionTo('Request Forms: all'))
            <a href="{{ route('request_forms.edit', $requestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Edición"><i class="fas fa-edit"></i>
            </a>
            @endif
            @if($requestForm->signatures_file_id)
            @if($requestForm->signatures_file_id == 11)
            <a class="btn btn-info btn-sm" title="Ver Formulario de Requerimiento firmado" href="{{ route('request_forms.show_file', $requestForm->requestFormFiles->first() ?? 0) }}" target="_blank" title="Certificado">
              <i class="fas fa-file-contract"></i>
            </a>
            @else
            <a class="btn btn-info btn-sm" title="Ver Formulario de Requerimiento firmado" href="{{ route('request_forms.signedRequestFormPDF', [$requestForm, 1]) }}" target="_blank" title="Certificado">
              <i class="fas fa-file-contract"></i>
            </a>
            @endif
            @if($requestForm->old_signatures_file_id)
            <a class="btn btn-secondary btn-sm" title="Ver Formulario de Requerimiento Anterior firmado" href="{{ route('request_forms.signedRequestFormPDF', [$requestForm, 0]) }}" target="_blank" title="Certificado">
              <i class="fas fa-file-contract"></i>
            </a>
            @endif

            @if(Auth()->user()->hasPermissionTo('Request Forms: all') && Str::contains($requestForm->subtype, 'tiempo'))
            <a onclick="return confirm('¿Está seguro/a de crear nuevo formulario de ejecución inmediata?')" href="{{ route('request_forms.create_provision', $requestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Nuevo formulario de ejecución inmediata"><i class="fas fa-plus"></i>
            </a>
            @endif
            @endif
            @if(Auth()->user()->hasPermissionTo('Request Forms: all') && $requestForm->PurchasingProcess)
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
              <a href="{{ route('request_forms.supply.purchase', $requestForm) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-shopping-cart"></i></a>
            </span>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{$request_forms->links()}}
</div>
@else
</div>
<div class="col">
  <h6><i class="fas fa-inbox"></i> Formularios creados, aprobados y rechazados</h6>
  <div class="card mb-3 bg-light">
    <div class="card-body">
      No hay formularios de requerimiento creados, aprobados y rechazados.
    </div>
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
