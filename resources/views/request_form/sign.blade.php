@extends('layouts.app')

@section('title', $title)

@section('content')
@php($round_trips = ['round trip' => 'Ida y Vuelta', 'one-way only' => 'Solo Ida'])
@php($baggages    = ['handbag' => 'Bolso de Mano', 'hand luggage' => 'Equipaje de Cabina', 'baggage' => 'Equipaje de Bodega', 'oversized baggage' => 'Equipaje Sobredimensionado'])
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

<br>

<div class="table-responsive">
    <h6><i class="fas fa-signature"></i> Proceso de Firmas</h6>
    <table class="table table-sm table-striped table-bordered">
        <tbody class="text-center small">
            <tr>
              @foreach($requestForm->eventRequestForms as $event)
                <th>{{ $event->signerOrganizationalUnit->name }}</th>
              @endforeach
            </tr>
            <tr>
              @foreach($requestForm->eventRequestForms as $event)
                <td>
                  @if($event->StatusValue == 'Pendiente')
                    <span>
                      <i class="fas fa-clock"></i> {{ $event->StatusValue }} <br>
                    </span>
                  @endif
                  @if($event->StatusValue == 'Aprobado')
                    <span style="color: green;">
                      <i class="fas fa-check-circle"></i> {{ $event->StatusValue }} <br>
                    </span>
                    <i class="fas fa-user"></i> {{ $event->signerUser->FullName }}<br>
                    <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($event->signature_date)->format('d-m-Y H:i:s') }}<br>
                  @endif
                  @if($event->StatusValue == 'Rechazado')
                    <span style="color: Tomato;">
                      <i class="fas fa-times-circle"></i> {{ $event->StatusValue }} <br>
                    </span>
                    <i class="fas fa-user"></i> {{ $event->signerUser->FullName }}<br>
                    <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($event->signature_date)->format('d-m-Y H:i:s') }}<br>
                  @endif
                </td>
              @endforeach
            </tr>
        </tbody>
    </table>
</div>

@if($eventType == 'pre_finance_event')

<livewire:request-form.prefinance-authorization :requestForm="$requestForm" :eventType="$eventType" :round_trips="$round_trips" :baggages="$baggages" >

@else

<br>

@if($requestForm->type_form == 'Bienes y/o Servicios')



<div class="table-responsive">
    <h6><i class="fas fa-info-circle"></i> Lista de Bienes y/o Servicios</h6>
    <table class="table table-condensed table-hover table-bordered table-sm">
      <thead class="text-center small">
        <tr>
          <th>Item</th>
          <th>ID</th>
          @if(in_array($eventType, ['finance_event', 'supply_event', 'budget_event'])) <th>Item Pres.</th> @endif
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
                    @if(in_array($eventType, ['finance_event', 'supply_event', 'budget_event']))
                    <td>{{ $itemRequestForm->budgetItem->fullName() ?? '' }}</td>
                    @endif
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
          @if(in_array($eventType, ['finance_event', 'supply_event', 'budget_event']))
          <td colspan="10">Valor Total</td>
          @else
          <td colspan="9">Valor Total</td>
          @endif
          <td>${{ number_format($requestForm->estimated_expense,0,",",".") }}</td>
          <!-- <td colspan="3">Cantidad de Items</td>
          <td colspan="3">{{count($requestForm->itemRequestForms)}}</td> -->
        </tr>
      </tfoot>
    </table>
</div>
@else
<!-- Pasajeros -->
<div class="table-responsive">
    <h6><i class="fas fa-info-circle"></i> Lista de Pasajeros</h6>
    <table class="table table-condensed table-hover table-bordered table-sm">
      <thead class="text-center small">
        <tr>
          <th>#</th>
          <th>RUT</th>
          <th>Nombres</th>
          <th>Apellidos</th>
          @if(in_array($eventType, ['finance_event', 'supply_event', 'budget_event'])) <th>Item Pres.</th> @endif
          <th>Tipo viaje</th>
          <th>Origen</th>
          <th>Destino</th>
          <th>Fecha ida</th>
          <th>Fecha vuelta</th>
          <th>Equipaje</th>
          <th>Total pasaje</th>
        </tr>
      </thead>
      <tbody class="small">
        @foreach($requestForm->passengers as $key => $passenger)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ number_format($passenger->run, 0, ",", ".") }}-{{ $passenger->dv }}</td>
                    <td>{{ $passenger->name }}</td>
                    <td>{{ $passenger->fathers_family }} {{ $passenger->mothers_family }}</td>
                    @if(in_array($eventType, ['finance_event', 'supply_event', 'budget_event']))
                    <td>-</td>
                    @endif
                    <td>{{ isset($round_trips[$passenger->round_trip]) ? $round_trips[$passenger->round_trip] : '' }}</td>
                    <td>{{ $passenger->origin }}</td>
                    <td>{{ $passenger->destination }}</td>
                    <td>{{ $passenger->departure_date->format('d-m-Y H:i') }}</td>
                    <td>{{ $passenger->return_date->format('d-m-Y H:i') }}</td>
                    <td>{{ isset($baggages[$passenger->baggage]) ? $baggages[$passenger->baggage] : '' }}</td>
                    <td align="right">${{ number_format($passenger->unit_value, $requestForm->type_of_currency == 'peso' ? 0 : 2, ",", ".") }}</td>
                </tr>
        @endforeach
      </tbody>
      <tfoot class="text-right small">
        <tr>
          <td colspan="{{ in_array($eventType, ['finance_event', 'supply_event', 'budget_event']) ? 11 : 10 }}">Valor Total</td>
          <td>${{ number_format($requestForm->estimated_expense, $requestForm->type_of_currency == 'peso' ? 0 : 2,",",".") }}</td>
        </tr>
      </tfoot>
    </table>
</div>
@endif

<livewire:request-form.authorization :requestForm="$requestForm" :eventType="$eventType" >

@endif

@endsection
