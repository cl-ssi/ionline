@extends('layouts.app')

@section('title', 'Formulario de requerimiento')

@section('content')
@php($round_trips = ['round trip' => 'Ida y Vuelta', 'one-way only' => 'Solo Ida'])
@php($baggages = ['handbag' => 'Bolso de Mano', 'hand luggage' => 'Equipaje de Cabina', 'baggage' => 'Equipaje de Bodega', 'oversized baggage' => 'Equipaje Sobredimensionado'])
@include('request_form.partials.nav')

<div class="row">
  <div class="col-sm-8">
    <div class="table-responsive">
      <h6><i class="fas fa-info-circle"></i> Detalle Formulario ID {{$requestForm->id}}
      @if ($requestForm->getStatus() == 'Aprobado')
        @if($requestForm->purchasingProcess)
        <span class="badge badge-{{$requestForm->purchasingProcess->getColor()}}">{{$requestForm->purchasingProcess->getStatus()}}</span>
        @else
        <span class="badge badge-warning">En proceso</span>
        @endif
      @endif

      @if($requestForm->eventRequestForms->count() > 0)
        @if($requestForm->eventRequestForms->first()->status == 'pending'
          && Auth()->user()->organizational_unit_id != 40 &&
          $requestForm->request_user_id == auth()->user()->id ||
          Auth()->user()->hasPermissionTo('Request Forms: all'))
        <a class="btn btn-link btn-sm float-right font-weight-bold align-top" href="{{route('request_forms.edit', $requestForm)}}">
          <i class="fas fa-edit"></i> Editar formulario
        </a>
        @endif
      @endif

      @if($requestForm->status == 'saved' &&
          Auth()->user()->organizational_unit_id != 40 &&
          $requestForm->request_user_id == auth()->user()->id ||
          ($requestForm->status == 'saved' &&
          Auth()->user()->hasPermissionTo('Request Forms: all')))
        <a class="btn btn-link btn-sm float-right font-weight-bold align-top" href="{{route('request_forms.edit', $requestForm)}}">
          <i class="fas fa-edit"></i> Editar formulario
        </a>
      @endif
      </h6>
      <table class="table table-sm table-bordered">
        <tbody class="small">
          <tr>
            <th class="table-active" colspan="2" scope="row">Folio</th>
            <td>{{ $requestForm->folio }}</td>
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
          <tr>
            <th class="table-active" colspan="2" scope="row">Tipo de moneda</th>
            <td>{{ $requestForm->TypeOfCurrencyValue }}</td>
          </tr>
          <tr>
            <th class="table-active" rowspan="2" scope="row">Gestor</th>
            <th class="table-active" scope="row">Usuario</th>
            <td>{{ $requestForm->user->FullName }}</td>
          </tr>
          <tr>
            <th class="table-active" scope="row">Unidad Organizacional</th>
            <td>{{ $requestForm->userOrganizationalUnit->name}}</td>
          </tr>
          <tr>
            <th class="table-active" rowspan="2" scope="row">Administrador de Contrato</th>
            <th class="table-active" scope="row">Usuario</th>
            <td>{{ $requestForm->contractManager->FullName }}</td>
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
        <td><strong>{{ $event->EventTypeValue }}</strong>
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
          <i class="fas fa-user"></i> {{ $event->signerUser->FullName }}<br>
          <p style="font-size: 11px">
            {{ $event->position_signer_user }} {{ $event->signerOrganizationalUnit->name }}<br>
          </p>
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
        <td align="right">{{ number_format($itemRequestForm->unit_value,$requestForm->precision_currency,",",".") }}</td>
        <td align="center">{{ $itemRequestForm->tax }}</td>
        <td align="right">{{ number_format($itemRequestForm->expense,$requestForm->precision_currency,",",".") }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot class="text-right small">
      <tr>
        <td colspan="10">Valor Total</td>
        <td>{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
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
        <td align="right">{{ number_format($passenger->unit_value, $requestForm->precision_currency, ",", ".") }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot class="text-right small">
      <tr>
        <td colspan="{{ in_array($eventType, ['finance_event', 'supply_event', 'budget_event']) ? 11 : 10 }}">Valor Total</td>
        <td>{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense, $requestForm->precision_currency,",",".") }}</td>
      </tr>
    </tfoot>
  </table>
</div>

@endif

<!--Observaciones al proceso de compra -->
@if($requestForm->purchasingProcess)
<h6><i class="fas fa-eye"></i> Observaciones al proceso de compra</h6>
<div class="card">
  <div class="card-body">
    {{$requestForm->purchasingProcess->observation}}
  </div>
</div>
<br>
@endif

@if($requestForm->purchasingProcess && $requestForm->purchasingProcess->details->count() > 0)
<div class="row">
  <div class="col-sm">
    <div class="table-responsive">
      <h6><i class="fas fa-shopping-cart"></i> Información de la Compra</h6>


      <table class="table table-sm table-striped table-bordered small">
        <thead class="text-center">
          <tr>
            <th>Item</th>
            <th>Fecha</th>
            <th>Tipo de compra</th>
            <th>Cod.Presup.</th>
            <th>Artículo</th>
            <th>UM</th>
            <th>Especificaciones Técnicas</th>
            <th>Archivo</th>
            <th>Cantidad</th>
            <th>Valor U.</th>
            <th>Impuestos</th>
            <th>Total Item</th>
            <th></th>
            <!-- <th></th>  -->
          </tr>
        </thead>
        <tbody>
          @foreach($requestForm->purchasingProcess->details as $key => $detail)
          <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $requestForm->purchasingProcess->start_date }}</td>
            <!-- <td>{{ $requestForm->purchasingProcess->purchaseMechanism->name }}</td> -->
            <td>{{ $detail->pivot->getPurchasingTypeName() }}</td>
            <td>{{ $detail->budgetItem->fullName() ?? '' }}</td>
            <td>{{ $detail->article }}</td>
            <td>{{ $detail->unit_of_measurement }}</td>
            <td>{{ $detail->specification }}</td>
            <td align="center">
              @if($detail->article_file)
              <a href="{{ route('request_forms.show_item_file', $detail) }}" target="_blank">
                <i class="fas fa-file"></i></a>
              @endif
            </td>
            <td align="right">{{ $detail->pivot->quantity }}</td>
            <td align="right">{{$requestForm->symbol_currency}}{{ number_format($detail->pivot->unit_value,$requestForm->precision_currency,",",".") }}</td>
            <td>{{ $detail->tax }}</td>
            <td align="right">{{$requestForm->symbol_currency}}{{ number_format($detail->pivot->expense,$requestForm->precision_currency,",",".") }}</td>
            <td>
              <button type="button" id="btn_items_{{$key}}" class="btn btn-link btn-sm" data-toggle="modal" data-target="#Receipt-{{$detail->pivot->id}}">
                <i class="fas fa-receipt"></i>
              </button>
              @include('request_form.purchase.modals.detail_purchase')

            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="11" class="text-right">Valor Total</td>
            <th class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->purchasingProcess->getExpense(),$requestForm->precision_currency,",",".") }}</td>
          </tr>
          <tr>
            <th colspan="11" class="text-right">Saldo disponible Requerimiento</td>
            <th class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense - $requestForm->purchasingProcess->getExpense(),$requestForm->precision_currency,",",".") }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
@endif

<br>

@if(Str::contains($requestForm->subtype, 'tiempo'))
<div class="row">
  <div class="col-sm">
    <div class="table-responsive">
      <h6><i class="fas fa-shopping-cart"></i> Historial de compras ejecución inmediata</h6>
      <table class="table table-sm table-striped table-bordered small">
        <thead class="text-center">
          <tr>
            <th>Item</th>
            <th>ID</th>
            <th>Folio</th>
            <th style="width: 7%">Fecha Creación</th>
            <th>Tipo / Mecanismo de Compra</th>
            <th>Descripción</th>
            <th>Usuario Gestor</th>
            <th>Comprador</th>
            <th>Items</th>
            <th>Monto total</th>
            <th>Monto utilizado</th>
            <!-- <th>Saldo disponible</th> -->
            <!-- <th>Estado</th> -->
            <!-- <th></th>  -->
          </tr>
        </thead>
        <tbody>
          @forelse($requestForm->children as $key => $child)
          <tr @if($child->status != 'approved') class="text-muted" @endif>
            <td>{{ $key+1 }}</td>
            <td>{{ $child->id }}<br>
              @switch($child->getStatus())
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
            </td>
            <td>@if($child->status == 'approved')<a href="{{ route('request_forms.show', $child) }}">{{ $child->folio }}</a> @else {{ $child->folio }} @endif<br>
            <td>{{ $child->created_at->format('d-m-Y H:i') }}</td>
            <td>{{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}<br>
              {{ $requestForm->SubtypeValue }}
            </td>
            <td>{{ $child->name }}</td>
            <td>{{ $child->user ? $child->user->FullName : 'Usuario eliminado' }}<br>
              {{ $child->userOrganizationalUnit ? $child->userOrganizationalUnit->name : 'Usuario eliminado' }}
            </td>
            <td>{{ $child->purchasers->first()->FullName ?? 'No asignado' }}</td>
            <td align="center">{{ $child->quantityOfItems() }}</td>
            <td align="right">{{$requestForm->symbol_currency}}{{ number_format($child->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
            <td align="right">{{ $child->purchasingProcess ? $requestForm->symbol_currency.number_format($child->purchasingProcess->getExpense(),$requestForm->precision_currency,",",".") : '-' }}</td>
            {{--<td align="right">{{ $child->purchasingProcess ? $requestForm->symbol_currency.number_format($child->estimated_expense - $child->purchasingProcess->getExpense(),$requestForm->precision_currency,",",".") : '-' }}</td>--}}
          </tr>
          @empty
          <tr>
            <td colspan="100%" class="text-center">No existen bienes y/o servicios de ejecución inmediata asociados a este formulario de requerimiento.</td>
          </tr>
          @endforelse
        </tbody>
        @if($requestForm->children->count() > 0 && $requestForm->purchasingProcess)
        <tfoot>
          <tr>
            <th colspan="9" class="text-right">Totales</td>
            <th class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->getTotalEstimatedExpense(),$requestForm->precision_currency,",",".") }}</td>
            <th class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->getTotalExpense(),$requestForm->precision_currency,",",".") }}</td>
          </tr>
          <tr>
            <th colspan="10" class="text-right">Saldo disponible Compras</td>
            <th class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->purchasingProcess->getExpense() - $requestForm->getTotalExpense(),$requestForm->precision_currency,",",".") }}</td>
          </tr>
        </tfoot>
        @endif
      </table>
    </div>
  </div>
</div>
@endif

@if($requestForm->messages->count() > 0)
<!-- <div class="row bg-light"> -->
<div class="col bg-light">
  <br>
  <h6><i class="fas fa-comment"></i> Foro de comunicación</h6>
  @foreach($requestForm->messages->sortByDesc('created_at') as $requestFormMessage)
  <div class="card" id="message">
    <div class="card-header col-sm">
      <i class="fas fa-user"></i> {{ $requestFormMessage->user->FullName }}

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
'from' => 'show'
])

<br><br>

@if(Auth::user()->hasPermissionTo('Request Forms: audit'))

<hr />

<h6><i class="fas fa-info-circle"></i> Auditoría Interna</h6>

<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Formulario
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        @include('partials.audit', ['audits' => $requestForm->audits])
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Bienes y/o servicios (Items)
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
          <h6 class="mt-3 mt-4">Historial de cambios</h6>
          <div class="table-responsive-md">
          <table class="table table-sm small text-muted mt-3">
              <thead>
                  <tr>
                      <th>Fecha</th>
                      <th>Usuario</th>
                      <th>Modificaciones</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($requestForm->itemRequestForms as $itemRequestForm)
                  @if($itemRequestForm->audits->count() > 0)
                  @foreach($itemRequestForm->audits->sortByDesc('updated_at') as $audit)
                  <tr>
                      <td nowrap>{{ $audit->created_at }}</td>
                      <td nowrap>{{ optional($audit->user)->fullName }}</td>
                      <td>
                      @foreach($audit->getModified() as $attribute => $modified)
                          @if(isset($modified['old']) OR isset($modified['new']))
                          <strong>{{ $attribute }}</strong> :  {{ isset($modified['old']) ? $modified['old'] : '' }}  => {{ $modified['new'] }};
                          @endif
                      @endforeach
                      </td>
                  </tr>
                  @endforeach
                  @endif
                @endforeach
              </tbody>
          </table>
          </div>
      </div>
    </div>
  </div>
  @if($requestForm->purchasingProcess)
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            Información de la Compra
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        <h6 class="mt-3 mt-4">Historial de cambios</h6>
        <div class="table-responsive-md">
        <table class="table table-sm small text-muted mt-3">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Modificaciones</th>
                </tr>
            </thead>
            <tbody>
              @foreach($requestForm->purchasingProcess->details as $detail)
                @if($detail->pivot->audits->count() > 0)
                @foreach($detail->pivot->audits->sortByDesc('updated_at') as $audit)
                <tr>
                    <td nowrap>{{ $audit->created_at }}</td>
                    <td nowrap>{{ optional($audit->user)->fullName }}</td>
                    <td>
                    @foreach($audit->getModified() as $attribute => $modified)
                        @if(isset($modified['old']) OR isset($modified['new']))
                        <strong>{{ $attribute }}</strong> :  {{ isset($modified['old']) ? $modified['old'] : '' }}  => {{ $modified['new'] }};
                        @endif
                    @endforeach
                    </td>
                </tr>
                @endforeach
                @endif
              @endforeach
            </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingFour">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
            Historial de Procesos de Compra
        </button>
      </h2>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
      <div class="card-body">
        <h6 class="mt-3 mt-4">Historial de cambios</h6>
        <div class="table-responsive-md">
        <table class="table table-sm small text-muted mt-3">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Modificaciones</th>
                </tr>
            </thead>
            <tbody>
              @foreach($requestForm->purchasingProcess->details as $detail)
                @if($detail->pivot->audits->count() > 0)
                @foreach($detail->pivot->getPurchasingType()->audits->sortByDesc('updated_at') as $audit)
                <tr>
                    <td nowrap>{{ $audit->created_at }}</td>
                    <td nowrap>{{ optional($audit->user)->fullName }}</td>
                    <td>
                    @foreach($audit->getModified() as $attribute => $modified)
                        @if(isset($modified['old']) OR isset($modified['new']))
                        <strong>{{ $attribute }}</strong> :  {{ isset($modified['old']) ? $modified['old'] : '' }}  => {{ $modified['new'] }};
                        @endif
                    @endforeach
                    </td>
                </tr>
                @endforeach
                @endif
              @endforeach
            </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>
@endif

@endsection
@section('custom_js')
@endsection
@section('custom_js_head')
@endsection
