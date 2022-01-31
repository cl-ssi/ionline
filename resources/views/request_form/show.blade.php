@extends('layouts.app')

@section('title', 'Formulario de requerimiento')

@section('content')
@php($round_trips = ['round trip' => 'Ida y Vuelta', 'one-way only' => 'Solo Ida'])
@php($baggages    = ['handbag' => 'Bolso de Mano', 'hand luggage' => 'Equipaje de Cabina', 'baggage' => 'Equipaje de Bodega', 'oversized baggage' => 'Equipaje Sobredimensionado'])
@include('request_form.partials.nav')

<div class="row">
    <div class="col-sm-8">
        <div class="table-responsive">
            <h6><i class="fas fa-info-circle"></i> Detalle Formulario</h6>
            <table class="table table-sm table-bordered">
              <tbody class="small">
                  <tr>
                      <th class="table-active" colspan="2" scope="row">Fecha de Creación</th>
                      <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                  </tr>
                  <tr>
                      <th class="table-active" colspan="2" style="width: 33%">Nombre</th>
                      <td>{{ $requestForm->name }}</td>
                  </tr>
                  <tr>
                      <th class="table-active" colspan="2" style="width: 33%">Gasto Estimado</th>
                      <td>${{ number_format($requestForm->estimated_expense,0,",",".") }}</td>
                  </tr>
                  <tr>
                      <th class="table-active" colspan="2" scope="row">Tipo de moneda</th>
                      <td>{{ $requestForm->TypeOfCurrencyValue }}</td>
                  </tr>
                  <tr>
                      <th class="table-active" rowspan="2" scope="row">Gestor</th>
                      <th class="table-active" scope="row">Usuario</th>
                      <td>{{ $requestForm->user->getFullNameAttribute()}}</td>
                  </tr>
                  <tr>
                      <th class="table-active" scope="row">Unidad Organizacional</th>
                      <td>{{ $requestForm->userOrganizationalUnit->name}}</td>
                  </tr>
                  <tr>
                      <th class="table-active" rowspan="2" scope="row">Administrador de Contrato</th>
                      <th class="table-active" scope="row">Usuario</th>
                      <td>{{ $requestForm->contractManager->name }}</td>
                  </tr>
                  <tr>
                      <th class="table-active" scope="row">Unidad Organizacional</th>
                      <td>{{ $requestForm->contractOrganizationalUnit->name}}</td>
                  </tr>
                  <tr>
                      <th class="table-active" colspan="2" scope="row">Mecanismo de Compra</th>
                      <td>{{ $requestForm->purchaseMechanism->PurchaseMechanismValue }}</td>
                  </tr>
                  <tr>
                      <th class="table-active" colspan="2" scope="row">Tipo de Formulario</th>
                      <td>{{ $requestForm->SubtypeValue }}</td>
                  </tr>
                  <tr>
                      <th class="table-active" colspan="2" scope="row">Programa Asociado</th>
                      <td>{{ $requestForm->program }}</td>
                  </tr>
                  @if(in_array($eventType, ['finance_event', 'supply_event']))
                  <tr>
                      <th class="table-active" colspan="2" scope="row">Folio SIGFE</th>
                      <td>{{ $requestForm->sigfe }}</td>
                  </tr>
                  @endif
                  <tr>
                      <th class="table-active" colspan="2" scope="row">Justificación de Adquisición</th>
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

            @if($requestForm->father)
                @foreach($requestForm->father->requestFormFiles as $requestFormFile)
                  <a href="{{ route('request_forms.show_file', $requestFormFile) }}" class="list-group-item list-group-item-action py-2 small" target="_blank">
                    <i class="fas fa-file"></i> {{ $requestFormFile->name }} -
                    <i class="fas fa-calendar-day"></i> {{ $requestFormFile->created_at->format('d-m-Y H:i') }}</a>
                @endforeach
            @endif
        </div>
    </div>
</div>

<div class="table-responsive">
    <h6><i class="fas fa-signature"></i> Proceso de Firmas</h6>
    <table class="table table-sm table-striped table-bordered">
        <tbody class="text-center small">
            <tr>
              @foreach($requestForm->eventRequestForms as $event)
                <td><strong>{{ $event->EventTypeValue }}</strong><br>
                    {{ $event->signerOrganizationalUnit->name }}
                </td>
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

@if($requestForm->type_form == 'bienes y/o servicios')
<div class="table-responsive">
    <h6><i class="fas fa-info-circle"></i> Lista de Bienes y/o Servicios</h6>
    <table class="table table-condensed table-hover table-bordered table-sm">
      <thead class="text-center small">
        <tr>
          <th>Item</th>
          <th>ID</th>
          <th>Item Pres.</th>
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
                    <td>{{ $itemRequestForm->budgetItem ? $itemRequestForm->budgetItem->fullName() : '' }}</td>
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
                    <td align="center">{{ $itemRequestForm->tax }}</td>
                    <td align="right">${{ number_format($itemRequestForm->expense,0,",",".") }}</td>
                </tr>
        @endforeach
      </tbody>
      <tfoot class="text-right small">
        <tr>
          <td colspan="10">Valor Total</td>
          <td>${{ number_format($requestForm->estimated_expense,0,",",".") }}</td>
        </tr>
        <tr>
          <td colspan="10">Cantidad de Items</td>
          <td>{{count($requestForm->itemRequestForms)}}</td>
        </tr>
      </tfoot>
    </table>
</div>
@else
<!-- Pasajeros -->
<div class="table-responsive">
    <h6><i class="fas fa-info-circle"></i> Lista de Pasajeros</h6>
    <table class="table table-sm table-striped table-bordered small">
      <thead class="text-center small">
        <tr>
          <th>#</th>
          <th>RUT</th>
          <th>Nombres</th>
          <th>Apellidos</th>
          <th>Cod. Pres.</th>
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
                    <td>-</td>
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

@endsection
@section('custom_js')
@endsection
@section('custom_js_head')
@endsection
