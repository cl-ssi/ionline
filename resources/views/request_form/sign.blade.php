@extends('layouts.bt4.app')

@section('title', $title)

@section('content')
@php($round_trips = ['round trip' => 'Ida y Vuelta', 'one-way only' => 'Solo Ida'])
@php($baggages = ['handbag' => 'Bolso de Mano', 'hand luggage' => 'Equipaje de Cabina', 'baggage' => 'Equipaje de Bodega', 'oversized baggage' => 'Equipaje Sobredimensionado'])
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css" />

<h4 class="mb-3">{{$title}}</h4>

@include('request_form.partials.nav')

<div class="row">
  <div class="col-sm-8">
    <div class="table-responsive">
      <h6><i class="fas fa-info-circle"></i> Detalle Formulario ID {{$requestForm->id}}</h6>
      <table class="table table-sm table-bordered">
        <tbody class="small">
          <tr>
            <th class="table-active" colspan="2" scope="row">Folio</th>
            <td>{{ $requestForm->folio }}
                @if($requestForm->father)
                    <br>(<a href="{{ route('request_forms.show', $requestForm->father->id) }}"
                            target="_blank">{{ $requestForm->father->folio }}</a>)
                @endif
            </td>
          </tr>
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
            <td>{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
          </tr>
          @if($requestForm->has_increased_expense)
          <tr>
            <th class="table-active" colspan="2" style="width: 33%">Nuevo presupuesto</th>
            <td>{{$requestForm->symbol_currency}}{{ number_format($requestForm->new_estimated_expense,$requestForm->precision_currency,",",".") }}</td>
          </tr>
          @endif
          <tr>
            <th class="table-active" colspan="2" scope="row">Tipo de moneda</th>
            <td>{{ $requestForm->TypeOfCurrencyValue }}</td>
          </tr>
          <tr>
            <th class="table-active" rowspan="2" scope="row">Solicitante</th>
            <th class="table-active" scope="row">Usuario Gestor</th>
            <td>{{ $requestForm->user->fullName }}</td>
          </tr>
          <tr>
            <th class="table-active" scope="row">Unidad Organizacional</th>
            <td>{{ $requestForm->userOrganizationalUnit->name}}</td>
          </tr>
          <tr>
            <th class="table-active" rowspan="2" scope="row">Administrador de Contrato</th>
            <th class="table-active" scope="row">Usuario</th>
            <td>{{ $requestForm->contractManager->fullName }}</td>
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
            <th class="table-active" colspan="2" scope="row">Programa Asociado</th>
            <td>{{ $requestForm->associateProgram ? $requestForm->associateProgram->alias_finance.' '.$requestForm->associateProgram->period : $requestForm->program }}</td>
          </tr>
          @if(in_array($eventType, ['finance_event', 'supply_event', 'pre_budget_event', 'budget_event']))
          <tr>
            <th class="table-active" colspan="2" scope="row">Folio SIGFE</th>
            <td>{{ $requestForm->associateProgram->folio ?? $requestForm->sigfe }}</td>
          </tr>
          <tr>
            <th class="table-active" colspan="2" scope="row">Financiamiento</th>
            <td>{{ $requestForm->associateProgram->financing ?? '' }}</td>
          </tr>
          @endif
          <tr>
            <th class="table-active" colspan="2" scope="row">Justificación de Adquisición</th>
            <td>{{ $requestForm->justification }}</td>
          </tr>
          <tr>
            <th class="table-active" colspan="2" scope="row">Comprador</th>
            <td>{{ $requestForm->purchasers->first()->fullName ?? 'No asignado' }}</td>
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

<br>

<div class="table-responsive">
  <h6><i class="fas fa-signature"></i> Proceso de Firmas</h6>
  <table class="table table-sm table-striped table-bordered">
    <tbody class="text-center small">
      <tr>
        @foreach($requestForm->eventRequestForms->whereNull('deleted_at') as $event)
        <td><strong>{{ $event->EventTypeValue }}</strong>
        </td>
        @endforeach
      </tr>
      <tr>
        @foreach($requestForm->eventRequestForms->whereNull('deleted_at') as $event)
        <td>
          @if($event->StatusValue == 'Pendiente')
          <span>
            <i class="fas fa-clock"></i> {{ $event->StatusValue }} <br>
          </span>
          @endif
          @if($event->StatusValue == 'No aplica')
          <span>
            <i class="fas fa-ban"></i> N/A <br>
          </span>
          @endif
          @if($event->StatusValue == 'Aprobado')
          <span style="color: green;">
            <i class="fas fa-check-circle"></i> {{ $event->StatusValue }} <br>
          </span>
          <i class="fas fa-user"></i> {{ $event->signerUser->fullName }}<br>
          <p style="font-size: 11px">
            {{ $event->position_signer_user }} {{ $event->signerOrganizationalUnit->name }}<br>
          </p>
          <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($event->signature_date)->format('d-m-Y H:i:s') }}<br>
          @if($event->comment)
          <br>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#exampleModal-{{ $event->id }}">
            <i class="fas fa-comment"></i>
          </button>
          @endif
          @include('request_form.partials.modals.signature_comment')
          @endif
          @if($event->StatusValue == 'Rechazado')
          <span style="color: Tomato;">
            <i class="fas fa-times-circle"></i> {{ $event->StatusValue }} <br>
          </span>
          <i class="fas fa-user"></i> {{ $event->signerUser->fullName }}<br>
          <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($event->signature_date)->format('d-m-Y H:i:s') }}<br>

          @if($event->comment)
          <br>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal-{{ $event->id }}">
            <i class="fas fa-comment"></i>
          </button>
          @endif
          @include('request_form.partials.modals.signature_comment')
          @endif
        </td>
        @endforeach
      </tr>
    </tbody>
  </table>
</div>

@if($requestForm->getTrashedEventsWithComments()->count() > 0)
<div class="table-responsive">
    <h6><i class="fas fa-eye"></i> Observaciones previas</h6>
    <table class="table table-sm table-striped table-bordered">
        <tbody class="small">
            @foreach($requestForm->getTrashedEventsWithComments() as $event)
            <tr>
                <td>@if($event->StatusValue == 'Aprobado')
                    <span style="color: green;">
                        <i class="fas fa-check-circle text-left"></i> {{ $event->StatusValue }} <br>
                    </span>
                    @else
                    <span style="color: Tomato;">
                        <i class="fas fa-times-circle"></i> {{ $event->StatusValue }} <br>
                    </span> 
                    @endif
                </td>
                <td><i class="fas fa-calendar"></i> {{ $event->signature_date?->format('d-m-Y H:i:s') }} por: {{ $event->signerUser?->fullName }} en calidad de {{ $event->EventTypeValue }}</td>
                <td class="text-left font-italic"><i class="fas fa-comment"></i> "{{ $event->comment }}"</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if($eventType == 'pre_finance_event')

<livewire:request-form.prefinance-authorization :requestForm="$requestForm" :eventType="$eventType" :round_trips="$round_trips" :baggages="$baggages">

  <br>

  @else

  <br>

  @if($requestForm->type_form == 'bienes y/o servicios')



  <div class="table-responsive">
    <h6><i class="fas fa-list-ol"></i> Lista de Bienes y/o Servicios</h6>
    <table class="table table-condensed table-hover table-bordered table-sm">
      <thead class="text-center small">
        <tr>
          <th>Item</th>
          <th>ID</th>
          @if(in_array($eventType, ['finance_event', 'supply_event', 'pre_budget_event', 'budget_event'])) <th>Item Pres.</th> @endif
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
          @if(in_array($eventType, ['finance_event', 'supply_event', 'pre_budget_event', 'budget_event']))
          <td>{{ $itemRequestForm->budgetItem->fullName() ?? '' }}</td>
          @endif
          <td>
            @if($itemRequestForm->product_id)
              {{ optional($itemRequestForm->product)->code}} {{ optional($itemRequestForm->product)->name }}
            @else
              {{ $itemRequestForm->article }}
            @endif
          </td>
          <td>{{ $itemRequestForm->unit_of_measurement }}</td>
          <td>{!! $itemRequestForm->latestPendingItemChangedRequestForms->specification ?? $itemRequestForm->specification !!}</td>
          <td align="center">
            @if($itemRequestForm->article_file)
            <a href="{{ route('request_forms.show_item_file', $itemRequestForm) }}" target="_blank">
              <i class="fas fa-file"></i>
              @endif
          </td>
          <td align="right">{{ $itemRequestForm->latestPendingItemChangedRequestForms->quantity ?? $itemRequestForm->quantity }}</td>
          <td align="right">{{ str_replace(',00', '', number_format($itemRequestForm->latestPendingItemChangedRequestForms->unit_value ?? $itemRequestForm->unit_value, 2,",",".")) }}</td>
          <td>{{ $itemRequestForm->latestPendingItemChangedRequestForms->tax ?? $itemRequestForm->tax }}</td>
          <td align="right">{{ number_format($itemRequestForm->latestPendingItemChangedRequestForms->expense ?? $itemRequestForm->expense,$requestForm->precision_currency,",",".") }}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot class="text-right small">
        <tr>
          @if(in_array($eventType, ['finance_event', 'supply_event', 'pre_budget_event', 'budget_event']))
          <td colspan="10">Valor Total</td>
          @else
          <td colspan="9">Valor Total</td>
          @endif
          <td>{{$requestForm->symbol_currency}}{{ number_format($requestForm->new_estimated_expense ?? $requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
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
    <table class="table table-condensed table-hover table-bordered table-sm small">
      <thead class="text-center small">
        <tr>
          <th>#</th>
          <th width="70">RUT</th>
          <th>Nombres</th>
          <th>Apellidos</th>
          <th>Fecha Nac.</th>
          <th>Teléfono</th>
          <th>E-mail</th>
          @if(in_array($eventType, ['finance_event', 'supply_event', 'pre_budget_event', 'budget_event'])) <th>Item Pres.</th> @endif
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
          <td>{{ $passenger->birthday ? $passenger->birthday->format('d-m-Y') : '' }}</td>
          <td>{{ $passenger->phone_number }}</td>
          <td>{{ $passenger->email }}</td>
          @if(in_array($eventType, ['finance_event', 'supply_event', 'pre_budget_event', 'budget_event']))
          <td>{{ $passenger->budgetItem ? $passenger->budgetItem->fullName() : '' }}</td>
          @endif
          <td>{{ isset($round_trips[$passenger->round_trip]) ? $round_trips[$passenger->round_trip] : '' }}</td>
          <td>{{ $passenger->origin }}</td>
          <td>{{ $passenger->destination }}</td>
          <td>{{ $passenger->departure_date->format('d-m-Y H:i') }}</td>
          <td>{{ $passenger->return_date ? $passenger->return_date->format('d-m-Y H:i') : '' }}</td>
          <td>{{ isset($baggages[$passenger->baggage]) ? $baggages[$passenger->baggage] : '' }}</td>
          <td align="right">{{ number_format($passenger->latestPendingPassengerChanged->unit_value ?? $passenger->unit_value, $requestForm->precision_currency, ",", ".") }}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot class="text-right small">
        <tr>
          <td colspan="{{ in_array($eventType, ['finance_event', 'supply_event', 'pre_budget_event', 'budget_event']) ? 14 : 13 }}">Valor Total</td>
          <td>{{$requestForm->symbol_currency}}{{ number_format($requestForm->new_estimated_expense ?? $requestForm->estimated_expense, $requestForm->precision_currency,",",".") }}</td>
        </tr>
      </tfoot>
    </table>
  </div>
  @endif

  <livewire:request-form.authorization :requestForm="$requestForm" :eventType="$eventType">

    @endif

    <hr>

    @if($requestForm->messages->count() > 0)
    <!-- <div class="row bg-light"> -->
    <div class="col bg-light">
      <br>
      <h6><i class="fas fa-comment"></i> Foro de comunicación</h6>
      @foreach($requestForm->messages->sortByDesc('created_at') as $requestFormMessage)
      <div class="card" id="message">
        <div class="card-header col-sm">
          <i class="fas fa-user"></i> {{ $requestFormMessage->user->fullName }}

        </div>
        <div class="card-body">
          <i class="fas fa-calendar"></i> {{ $requestFormMessage->created_at->format('d-m-Y H:i:s') }}
          <p class="font-italic"><i class="fas fa-comment"></i> "{{ $requestFormMessage->message }}"</p>
        </div>
        @if($requestFormMessage->file)
        <div class="card-footer">
          <a href="{{ route('request_forms.message.show_file', $requestFormMessage) }}" target="_blank">
            <i class="fas fa-paperclip"></i> {{ $requestFormMessage->file_name }}
          </a>
        </div>
        @endif
      </div>
      <br>
      @endforeach
    </div>
    <!-- </div> -->
    @endif
    <br>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal-{{ $requestForm->id }}">
      <i class="fas fa-comment"></i> Agregar Mensaje
    </button>

    @include('request_form.partials.modals.create_message', [
    'from' => 'signature'
    ])

    <br><br>

    @endsection
