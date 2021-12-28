@extends('layouts.app')

@section('title', $title)

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css"/>

<h4 class="mb-3">{{$title}}</h4>

@include('request_form.partials.nav')

<div class="row">
  <div class="col-sm-8">
    <div class="table-responsive">
        <h6><i class="fas fa-info-circle"></i> Detalle Formulario</h6>
        <table class="table table-sm table-striped table-bordered">
            <tbody class="small">
                <tr>
                    <th class="table-active" scope="row">Fecha de Creación</th>
                    <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                </tr>
                <tr>
                    <th class="table-active" style="width: 33%">Nombre</th>
                    <td>{{ $requestForm->name }}</td>
                </tr>
                <tr>
                    <th class="table-active" style="width: 33%">Gasto Estimado</th>
                    <td>${{ number_format($requestForm->estimated_expense,0,",",".") }}</td>
                </tr>
                <tr>
                    <th class="table-active" scope="row">Tipo de moneda</th>
                    <td>{{ $requestForm->type_of_currency}}</td>
                </tr>
                <tr>
                    <th class="table-active" scope="row">Nombre del Solicitante</th>
                    <td>{{ $requestForm->user->getFullNameAttribute()}}</td>
                </tr>
                <tr>
                    <th class="table-active" scope="row">Unidad Organizacional</th>
                    <td>{{ $requestForm->userOrganizationalUnit->name}}</td>
                </tr>
                <tr>
                    <th class="table-active" scope="row">Mecanismo de Compra</th>
                    <td>{{ $requestForm->getPurchaseMechanism()}}</td>
                </tr>
                <tr>
                    <th class="table-active" scope="row">Programa Asociado</th>
                    <td>{{ $requestForm->program }}</td>
                </tr>
                @if(in_array($eventType, ['finance_event', 'supply_event']))
                <tr>
                    <th class="table-active" scope="row">Folio SIGFE</th>
                    <td>{{ $requestForm->sigfe }}</td>
                </tr>
                @endif
                <tr>
                    <th class="table-active" scope="row">Justificación de Adquisición</th>
                    <td>{{ $requestForm->justification }}</td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
    <div class="col-sm-4">
        <h6><i class="fas fa-paperclip"></i> Adjuntos</h6>
        <div class="list-group">
            @foreach($requestForm->requestFormFiles as $requestFormFile)
              <a href="{{ route('request_forms.show_file', $requestFormFile) }}" class="list-group-item list-group-item-action py-2 small" target="_blank">
                <i class="fas fa-file"></i> {{ $requestFormFile->name }} -
                <i class="fas fa-calendar-day"></i> {{ $requestFormFile->created_at->format('d-m-Y H:i') }}</a>
            @endforeach
        </div>
    </div>
</div>

@if($eventType == 'pre_finance_event')

<livewire:request-form.prefinance-authorization :requestForm="$requestForm" :eventType="$eventType" >

@else

<br>



<br>

<div class="table-responsive">
    <h6><i class="fas fa-info-circle"></i> Lista de Bienes y/o Servicios</h6>
    <table class="table table-condensed table-hover table-bordered table-sm">
      <thead class="text-center small">
        <tr>
          <th>Item</th>
          <th>ID</th>
          <th>Artículo</th>
          <th>UM</th>
          <th>Especificaciones Técnicas</th>
          <th>Archivo</th>
          <th>Cantidad</th>
          <th>Valor U.</th>
          <th>Impuestos</th>
          <th>Total Item</th>
        </tr>
      </thead>
      <tbody class="small">
        @foreach($requestForm->itemRequestForms as $key => $itemRequestForm)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $itemRequestForm->id }}</td>
                    <td>{{ $itemRequestForm->article }}</td>
                    <td>{{ $itemRequestForm->unit_of_measurement }}</td>
                    <td>{{ $itemRequestForm->specification }}</td>
                    <td align="center">
                      @if($itemRequestForm->article_file)
                      <a href="{{ route('request_forms.show_item_file', $itemRequestForm) }}" target="_blank">
                        <i class="fas fa-file"></i>
                      @endif
                    </td>
                    <td align="right">{{ $itemRequestForm->quantity }}</td>
                    <td align="right">${{ number_format($itemRequestForm->unit_value,0,",",".") }}</td>
                    <td>{{ $itemRequestForm->tax }}</td>
                    <td align="right">${{ number_format($itemRequestForm->expense,0,",",".") }}</td>
                </tr>
        @endforeach
      </tbody>
      <tfoot class="text-right small">
        <tr>
          <td colspan="9">Valor Total</td>
          <td>${{ number_format($requestForm->estimated_expense,0,",",".") }}</td>
          <!-- <td colspan="3">Cantidad de Items</td>
          <td colspan="3">{{count($requestForm->itemRequestForms)}}</td> -->
        </tr>
      </tfoot>
    </table>
</div>

<livewire:request-form.authorization :requestForm="$requestForm" :eventType="$eventType" >

@endif

@endsection
