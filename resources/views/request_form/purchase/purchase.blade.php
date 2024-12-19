@extends('layouts.bt4.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
<h4 class="mb-3">Compra</h4>

@include('request_form.partials.nav')

<div class="row">
    <div class="col-md-8">
        <div class="table-responsive">
            <h6><i class="fas fa-info-circle"></i> Detalle Formulario ID {{$requestForm->id}} @if($requestForm->purchasingProcess)
                <span class="badge badge-{{$requestForm->purchasingProcess->getColor()}}">{{$requestForm->purchasingProcess->status->getLabel()}}</span>
                @else
                <span class="badge badge-warning">En proceso</span>
                @endif
            </h6>
            <table class="table table-sm table-striped table-bordered">
                <tbody class="small">
                    <tr>
                        <th class="table-active" scope="row">Folio</th>
                        <td>{{ $requestForm->folio }}
                        @if($requestForm->father)
                            <br>(<a href="{{ route('request_forms.show', $requestForm->father->id) }}"
                                    target="_blank">{{ $requestForm->father->folio }}</a>)
                        @endif
                    </td>
                    </tr>
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
                        <td>{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
                    </tr>
                    {{--@if($requestForm->has_increased_expense)
                    <tr>
                        <th class="table-active" style="width: 33%">Nuevo Presupuesto</th>
                        <td>{{$requestForm->symbol_currency}}{{ number_format($requestForm->new_estimated_expense,$requestForm->precision_currency,",",".") }}</td>
                    </tr>
                    @endif--}}
                    <tr>
                        <th class="table-active" scope="row">Nombre del Solicitante</th>
                        <td>{{ $requestForm->user ? $requestForm->user->fullName : 'Usuario eliminado' }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Unidad Organizacional</th>
                        <td>{{ $requestForm->user ? $requestForm->userOrganizationalUnit->name : 'Usuario eliminado' }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Administrador de Contrato</th>
                        <td>{{ $requestForm->contractManager ? $requestForm->contractManager->fullName : 'Usuario eliminado' }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Mecanismo de Compra</th>
                        <td>{{ $requestForm->getPurchaseMechanism()}}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Tipo de Compra</th>
                        <td>{{ $requestForm->purchaseType->name }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Unidad de Compra</th>
                        <td>{{ $requestForm->purchaseUnit->name  }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Caracteristica de Compra</th>
                        <td>{{ $requestForm->SubtypeValue }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Programa Asociado</th>
                        <td>{{ $requestForm->associateProgram ? $requestForm->associateProgram->alias_finance.' '.$requestForm->associateProgram->period : $requestForm->program }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Folio SIGFE</th>
                        <td>{{ $requestForm->associateProgram->folio ?? $requestForm->sigfe }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Financiamiento</th>
                        <td>{{ $requestForm->associateProgram->financing ?? '' }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Justificación de Adquisición</th>
                        <td>{{ $requestForm->justification }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Comprador</th>
                        <td>{{ $requestForm->purchasers->first()->fullName ?? 'No asignado' }}</td>
                    </tr>

                </tbody>
            </table>
        </div>

        @if($requestForm->isPurchaseInProcess())
        <!-- <div class="float-right"> -->
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" @if($requestForm->purchasingProcess == null || ($requestForm->purchasingProcess && $requestForm->purchasingProcess->details->count() == 0 && $requestForm->purchasingProcess->detailsPassenger->count() == 0)) onclick="return alert('No hay registro de compras para dar término al proceso de compra') || event.stopImmediatePropagation()" @endif data-target="#processClosure" data-status="finished">
                Terminar <i class="fas fa-shopping-cart"></i>
            </button>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger btn-sm float-right mr-2" data-toggle="modal" onclick="return confirm('¿Está seguro/a de anular proceso de compra?') || event.stopImmediatePropagation()" data-target="#processClosure" data-status="canceled">
                Anular <i class="fas fa-shopping-cart"></i>
            </button>

            @include('request_form.purchase.modals.purchasing_process_closure')

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm float-right mr-2" data-toggle="modal" data-target="#exampleModal">
                Agregar nuevo proceso de compra
            </button>

            @include('request_form.purchase.modals.select_purchase_mechanism')

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm float-right mr-2" data-toggle="modal" data-target="#requestBudget" @if($isBudgetEventSignPending) disabled @endif >
                Cambiar presupuesto
            </button>

            @include('request_form.purchase.modals.request_new_budget')
        <!-- </div> -->
        @endif
    </div>
    <div class="col-md-4">
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

</div>

<!-- PROCESO DE FIRMAS -->
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <h6><i class="fas fa-signature"></i> Proceso de Firmas</h6>
                <table class="table table-sm table-striped table-bordered">
                    <tbody class="text-center small">
                        <tr>
                            @php 
                                $signsCount = $requestForm->eventRequestForms->count();
                                $width = 100 / $signsCount;
                            @endphp

                            @foreach($requestForm->eventRequestForms->whereNull('deleted_at') as $event)
                            <td width="{{ $width }}%"><strong>{{ $event->EventTypeValue }}</strong></td>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($requestForm->eventRequestForms->whereNull('deleted_at') as $event)
                            <td width="{{ $width }}%">
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
                                @endif
                                @if($event->StatusValue == 'Rechazado')
                                <span style="color: Tomato;">
                                    <i class="fas fa-times-circle"></i> {{ $event->StatusValue }} <br>
                                </span>
                                <i class="fas fa-user"></i> {{ $event->signerUser->fullName }}<br>
                                <p style="font-size: 11px">
                                    {{ $event->position_signer_user }} {{ $event->signerOrganizationalUnit->name }}<br>
                                </p>
                                <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($event->signature_date)->format('d-m-Y H:i:s') }}<br>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- OBSERVACIONES PREVIAS -->
@if($requestForm->eventRequestForms->whereNotNull('deleted_at')->count() > 0)
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <h6><i class="fas fa-eye"></i> Observaciones previas</h6>
                    <table class="table table-sm table-striped table-bordered">
                        <tbody class="small">
                            @foreach($requestForm->eventRequestForms->whereNotNull('deleted_at') as $event)
                            @if($event->comment != null)
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
                                <td><i class="fas fa-calendar"></i> {{ $event->signature_date->format('d-m-Y H:i:s') }} por: {{ $event->signerUser->fullName }} en calidad de {{ $event->EventTypeValue }}</td>
                                <td class="text-left font-italic"><i class="fas fa-comment"></i> "{{ $event->comment }}"</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif

<br>

@if($requestForm->isPurchaseInProcess())
    @if($requestForm->purchase_mechanism_id == 1)
        @if($requestForm->purchase_type_id == 1)
            <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_petty_cash', $requestForm) }}" enctype="multipart/form-data">
        @endif
        @if($requestForm->purchase_type_id == 2)
            <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_internal_oc', $requestForm) }}">
        @endif
        @if($requestForm->purchase_type_id == 3)
            <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_fund_to_be_settled', $requestForm) }}">
        @endif
    @endif

    @if($requestForm->purchase_mechanism_id == 2)
        @if($requestForm->father || $requestForm->purchase_type_id == 4)
        <!-- OC ejecución inmediata desde trato directo con ejecucion en el tiempo o CONVENIO MARCO MENOR A 1.000 UTM -->
            <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_oc', $requestForm) }}" enctype="multipart/form-data">
        @else
            <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_convenio_marco', $requestForm) }}" enctype="multipart/form-data">
        @endif
    @endif

    @if($requestForm->purchase_mechanism_id == 3)
        @if($requestForm->father)
        <!-- OC ejecución inmediata desde trato directo con ejecucion en el tiempo -->
        <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_oc', $requestForm) }}" enctype="multipart/form-data">
        @else
        <form method="POST" class="form-horizontal" action="{{ isset($result) ? route('request_forms.supply.update_direct_deal', [$requestForm, $result]) : route('request_forms.supply.create_direct_deal', $requestForm) }}" enctype="multipart/form-data">
        @endif
    @endif

    @if($requestForm->purchase_mechanism_id == 4)
        @if($requestForm->father)
        <!-- OC ejecución inmediata desde licitacion con ejecucion en el tiempo -->
        <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_oc', $requestForm) }}" enctype="multipart/form-data">
        @else
        <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_tender', $requestForm) }}" enctype="multipart/form-data">
        @endif
    @endif

    <!-- compra ágil -->
    @if($requestForm->purchase_mechanism_id == 5)
    <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_oc', $requestForm) }}" enctype="multipart/form-data">
    @endif

    @csrf
    @method(isset($result) ? 'PUT' : 'POST')
@endif
 
@if($requestForm->type_form == 'bienes y/o servicios')
<div class="container-fluid">
    <div class="row">
        <div class="col-md">
            <div class="table-responsive">
            <h6><i class="fas fa-shopping-cart"></i> Lista de Bienes y/o Servicios:</h6>
                <table class="table table-sm table-hover table-bordered small">
                    <thead class="text-center">
                        <tr>
                            <th>Item</th>
                            <!-- <th>Estado</th> -->
                            <th>Cod.Presup.</th>
                            <th>Artículo</th>
                            <th>UM</th>
                            <th>Especificaciones Técnicas</th>
                            <th><i class="fas fa-paperclip"></i></th>
                            <th>Proveedor<br>RUT - Nombre</th>
                            <th>Especificaciones del proveedor</th>
                            <th width="100">Cantidad</th>
                            <th width="150">Valor U.</th>
                            <th width="80">Impto.</th>
                            <th width="100">Cargos</th>
                            <th width="100">Dsctos</th>
                            <th width="150">Total Item</th>
                            <th colspan="2"></th>
                            <!-- <th></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requestForm->itemRequestForms as $key => $item)
                        @php($selectedItem = isset($result) ? $result_details->firstWhere('item_request_form_id', $item->id) : null)
                        <tr data-id="{{$item->product->code ?? ''}}">
                            <td>{{ $key+1 }}</td>
                            <!-- <td>{{ $item->status }}</td> -->
                            <td>{{ $item->budgetItem?->fullName() }}</td>
                            <td>@if($item->product_id)
                            {{ optional($item->product)->code}} {{ optional($item->product)->name }}
                            @else
                            {{ $item->article }}
                            @endif
                            </td>
                            <td>{{ $item->unit_of_measurement }}</td>
                            <td>{!! $item->specification !!}</td>
                            <td align="center">
                            @if($item->article_file)
                            <a href="{{ route('request_forms.show_item_file', $item) }}" target="_blank">
                            <i class="fas fa-file"></i></a>
                            @endif
                            </td>
                            <td>
                            <input type="text" class="form-control form-control-sm mb-2" name="supplier_run[]" id="for_supplier_run" value="{{ old('supplier_run.'.$key, $selectedItem->supplier_run ?? '') }}"> 
                            <textarea class="form-control form-control-sm" name="supplier_name[]" id="for_supplier_name">{{ old('supplier_name.'.$key, $selectedItem->supplier_name ?? '') }}</textarea>
                            </td>
                            <td>
                            <textarea class="form-control form-control-sm" name="supplier_specifications[]" id="for_supplier_specifications" rows="4">{{ old('supplier_specifications.'.$key, $selectedItem->supplier_specifications ?? '') }}</textarea>
                            </td>
                            <td align="right">
                            <input type="number" class="form-control form-control-sm text-right" step="0.01" min="0.1" id="for_quantity" name="quantity[]" value="{{ old('quantity.'.$key, $selectedItem->quantity ?? $item->quantity) }}">
                            </td>
                            <td align="right">
                            <input type="number" class="form-control form-control-sm text-right" step="0.01" min="1" id="for_unit_value" name="unit_value[]" value="{{ old('unit_value.'.$key, $selectedItem->unit_value ?? $item->unit_value) }}">
                            </td>
                            <td align="right">
                            <!-- <input type="text" class="form-control form-control-sm text-right" id="for_tax" name="tax[]" value="{{ $item->tax }}"> -->
                            <select name="tax[]" class="form-control form-control-sm" id="for_tax">
                            <option value="">Seleccione...</option>    
                            <option value="iva" {{$item->tax == 'iva' ? 'selected' : ''}} >I.V.A. 19%</option>
                            <option value="bh" {{$item->tax == 'bh' ? 'selected' : ''}} ></option>
                            <option value="srf" {{$item->tax == 'srf' ? 'selected' : ''}} >S.R.F Zona Franca 0%</option>
                            <option value="e" {{$item->tax == 'e' ? 'selected' : ''}}>Exento 0%</option>
                            <option value="nd" {{$item->tax == 'nd' ? 'selected' : ''}} >No Definido</option>
                            </select>
                            </td>
                            <td align="right">
                            <input type="number" class="form-control form-control-sm text-right" step="0.01" min="1" id="for_charges" name="charges[]" value="{{ old('charges.'.$key, $selectedItem->charges ?? '') }}">
                            </td>
                            <td align="right">
                            <input type="number" class="form-control form-control-sm text-right" step="0.01" min="1" id="for_discounts" name="discounts[]" value="{{ old('discounts.'.$key, $selectedItem->discounts ?? '') }}">
                            </td>
                            <td align="right">
                            <input type="number" class="form-control form-control-sm text-right" step="0.01" min="1" id="for_item_total" name="item_total[]" value="{{ old('item_total.'.$key, $selectedItem->expense ?? $item->expense) }}" readonly>
                            </td>
                            <td align="center">
                            <fieldset class="form-group">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="item_id[{{$key}}]" onclick="disabledSaveBtn()" id="for_item_id" value="{{ $item->id }}" {{ $item->id == old('item_id.'.$key, '') || ($selectedItem && $item->id == $selectedItem->item_request_form_id) ? 'checked' : '' }} @if($isBudgetEventSignPending || !$requestForm->isPurchaseInProcess()) disabled @endif>
                            </div>
                            </fieldset>
                            </td>
                            <!-- <td align="center">
                            <a href="">
                            <span style="color: Tomato;">
                            <i class="fas fa-times-circle"></i>
                            </span>
                            </a>
                            </td> -->
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12"></td>
                            <td class="text-right">Valor Total</td>
                            <td align="right">
                            <input type="number" step="0.01" min="1" class="form-control form-control-sm text-right" id="total_amount" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="12"></td>
                            <td class="text-right">Total seleccionado</td>
                            <td align="right">
                            <input type="number" step="0.01" min="1" class="form-control form-control-sm text-right" id="total_amount_selected" readonly>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@else
    <div class="container-fluid">
        <div class="row">
            <div class="col-md">
                <h6><i class="fas fa-shopping-cart"></i> Lista de Pasajeros</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered small">
                        <thead class="text-center">
                            <tr>
                                <th>Item</th>
                                <th width="70">RUT</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Fecha Nac.</th>
                                <th>Teléfono</th>
                                <th>E-mail</th>
                                <th>Item Pres.</th> 
                                <th>Tipo viaje</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Fecha ida</th>
                                <th>Fecha vuelta</th>
                                <th>Equipaje</th>
                                {{--
                                <th>Total pasaje</th>
    
                                <th>Cod.Presup.</th>
                                <th>Artículo</th>
                                <th>UM</th>
                                <th>Especificaciones Técnicas</th>
                                <th><i class="fas fa-paperclip"></i></th>
                                <th>Proveedor<br>RUT - Nombre</th>
                                <th>Especificaciones del proveedor</th>
                                <th width="100">Cantidad</th>
                                --}}

                                <th width="150">Valor U.</th>
                                {{--<th width="80">Impto.</th>--}}
                                <th width="100">Cargos</th>
                                <th width="100">Dsctos</th>
                                <th width="150">Total Item</th>
                                <th colspan="2"></th>
                                <!-- <th></th> -->
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requestForm->passengers as $key => $passenger)
                            @php($selectedItem = isset($result) ? $result_details->firstWhere('passenger_request_form_id', $passenger->id) : null)
                            {{--<tr data-id="{{$item->product->code ?? ''}}">--}}
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ number_format($passenger->run, 0, ",", ".") }}-{{ $passenger->dv }}</td>
                                <td>{{ $passenger->name }}</td>
                                <td>{{ $passenger->fathers_family }} {{ $passenger->mothers_family }}</td>
                                <td>{{ $passenger->birthday ? $passenger->birthday->format('d-m-Y') : '' }}</td>
                                <td>{{ $passenger->phone_number }}</td>
                                <td>{{ $passenger->email }}</td>
                                <td>{{ $passenger->budgetItem ? $passenger->budgetItem->fullName() : '' }}</td>
                                <td>{{ $passenger->roundTripName }}</td>
                                <td>{{ $passenger->origin }}</td>
                                <td>{{ $passenger->destination }}</td>
                                <td>{{ $passenger->departure_date->format('d-m-Y H:i') }}</td>
                                <td>{{ $passenger->return_date ? $passenger->return_date->format('d-m-Y H:i') : '' }}</td>
                                <td>{{ $passenger->baggageName }}</td>
                                {{--
                                <td align="right">{{ number_format($passenger->unit_value, $requestForm->precision_currency, ",", ".") }}</td>
                                <td>{{ $item->budgetItem?->fullName() }}</td>
                                <td>@if($item->product_id)
                                    {{ optional($item->product)->code}} {{ optional($item->product)->name }}
                                    @else
                                    {{ $item->article }}
                                    @endif
                                </td>
                                <td>{{ $item->unit_of_measurement }}</td>
                                <td>{{ $item->specification }}</td>
                                <td align="center">
                                    @if($item->article_file)
                                    <a href="{{ route('request_forms.show_item_file', $item) }}" target="_blank">
                                        <i class="fas fa-file"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm mb-2" name="supplier_run[]" id="for_supplier_run" value="{{ old('supplier_run.'.$key, $selectedItem->supplier_run ?? '') }}"> 
                                        <textarea class="form-control form-control-sm" name="supplier_name[]" id="for_supplier_name">{{ old('supplier_name.'.$key, $selectedItem->supplier_name ?? '') }}</textarea>
                                </td>
                                <td>
                                    <textarea class="form-control form-control-sm" name="supplier_specifications[]" id="for_supplier_specifications" rows="4">{{ old('supplier_specifications.'.$key, $selectedItem->supplier_specifications ?? '') }}</textarea>
                                </td>
                                <td align="right">
                                    <input type="number" class="form-control form-control-sm text-right" step="0.01" min="0.1" id="for_quantity" name="quantity[]" value="{{ old('quantity.'.$key, $selectedItem->quantity ?? $passenger->quantity) }}">
                                </td>
                                --}}
                                <input type="hidden" id="for_quantity" name="quantity[]" value="{{ old('quantity.'.$key, $selectedItem->quantity ?? 1) }}">
                                <td align="right">
                                    <input type="number" class="form-control form-control-sm text-right" step="0.01" min="1" id="for_unit_value" name="unit_value[]" value="{{ old('unit_value.'.$key, $selectedItem->unit_value ?? $passenger->unit_value) }}">
                                </td>
                                {{--<td align="right">
                                    <select name="tax[]" class="form-control form-control-sm" id="for_tax">
                                        <option value="">Seleccione...</option>    
                                        <option value="iva">I.V.A. 19%</option>
                                        <option value="bh"></option>
                                        <option value="srf">S.R.F Zona Franca 0%</option>
                                        <option value="e">Exento 0%</option>
                                        <option value="nd">No Definido</option>
                                    </select>
                                </td>--}}
                                <input type="hidden" name="tax[]" value="e" id="for_tax">
                                <td align="right">
                                    <input type="number" class="form-control form-control-sm text-right" step="0.01" min="1" id="for_charges" name="charges[]" value="{{ old('charges.'.$key, $selectedItem->charges ?? '') }}">
                                </td>
                                <td align="right">
                                    <input type="number" class="form-control form-control-sm text-right" step="0.01" min="1" id="for_discounts" name="discounts[]" value="{{ old('discounts.'.$key, $selectedItem->discounts ?? '') }}">
                                </td>
                                <td align="right">
                                    <input type="number" class="form-control form-control-sm text-right" step="0.01" min="1" id="for_item_total" name="item_total[]" value="{{ old('item_total.'.$key, $selectedItem->expense ?? $passenger->unit_value) }}" readonly>
                                 </td>
                                 <td align="center">
                                    <fieldset class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="passenger_id[{{$key}}]" onclick="disabledSaveBtn()" id="for_passenger_id" value="{{ $passenger->id }}" {{ $passenger->id == old('passenger_id.'.$key, '') || ($selectedItem && $passenger->id == $selectedItem->passenger_request_form_id) ? 'checked' : '' }} @if($isBudgetEventSignPending || !$requestForm->isPurchaseInProcess()) disabled @endif>    
                                        </div>
                                    </fieldset>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="16"></td>
                                <td class="text-right">Valor Total</td>
                                <td align="right">
                                    <input type="number" step="0.01" min="1" class="form-control form-control-sm text-right" id="total_amount" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="16"></td>
                                <td class="text-right">Total seleccionado</td>
                                <td align="right">
                                <input type="number" step="0.01" min="1" class="form-control form-control-sm text-right" id="total_amount_selected" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endif

<main class="container pt-3"><!-- open div container again -->

@if($requestForm->isPurchaseInProcess())
<br>

<!-- Menores a 3 UTM -->
@if($requestForm->purchase_mechanism_id == 1)
@if($requestForm->purchase_type_id == 1)
@include('request_form.purchase.partials.petty_cash_form')
@endif

@if($requestForm->purchase_type_id == 2)
@include('request_form.purchase.partials.internal_purchase_order_form')
@endif

@if($requestForm->purchase_type_id == 3)
@include('request_form.purchase.partials.fund_to_be_settled_form')
@endif
@endif


<!-- Convenio Marco menos CONVENIO MARCO MENOR A 1.000 UTM (cod 4) -->
@if($requestForm->purchase_mechanism_id == 2 && !$requestForm->father && $requestForm->purchase_type_id != 4)
@include('request_form.purchase.partials.convenio_marco_form')
@endif

<!-- Trato Directo -->
@if($requestForm->purchase_mechanism_id == 3 && !$requestForm->father)
@include('request_form.purchase.partials.direct_deal_form')
@endif

<!-- LICITACIÓN PUBLICA -->
@if($requestForm->purchase_mechanism_id == 4 && !$requestForm->father)
@include('request_form.purchase.partials.tender_form')
@endif

<!-- COMPRA INMEDIATA A PARTIR DE OTRO RF o COMPRA ÁGIL (cod 7) o CONVENIO MARCO MENOR A 1.000 UTM (cod 4) -->
@if( $requestForm->father || in_array($requestForm->purchase_type_id, [4, 7, 26]))
    @include('request_form.purchase.partials.immediate_purchase_form')
@endif

{{--@if(env('APP_ENV') == 'local')
@include('request_form.purchase.partials.immediate_purchase_form_mp')
@endif--}}

</form>
@endif

<br>

<!--Observaciones al proceso de compra -->
@if($requestForm->purchasingProcess)
<h6><i class="fas fa-eye"></i> Observaciones al proceso de compra</h6>
<div class="row">
    <div class="col-sm">
        <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.edit_observation', $requestForm) }}">
            @csrf
            <div class="form-group">
                <textarea name="observation" class="form-control form-control-sm" rows="3">{!! $requestForm->purchasingProcess->observation !!}</textarea>
            </div>
            <button type="submit" class="btn btn-primary float-right">
                <i class="fas fa-save"></i> Guardar
            </button>
        </form>
    </div>
</div>
<br>
@endif

@if($requestForm->purchasingProcess && ($requestForm->purchasingProcess->details->count() > 0 || $requestForm->purchasingProcess->detailsPassenger->count() > 0))
</main> <!-- close div container -->
<!-- nueva tabla -->
<div class="container-fluid">
    <div class="col-sm">
        <div class="table-responsive">
            <h6><i class="fas fa-shopping-cart"></i> Información de la Compra</h6>
            <table class="table table-sm table-hover table-bordered small">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Tipo compra</th>
                        <th>ID Licitación</th>
                        <th>Fechas</th>
                        <th>Orden de compra</th>
                        <th>Proveedor RUT - nombre</th>
                        <th>Cotización</th>
                        <th>N° res.</th>
                        <th>Especificaciones Técnicas (COMPRADOR/PROVEEDOR)</th>
                        <th>Cantidad</th>
                        <th>Unidad de medida</th>
                        <th>Moneda</th>
                        <th>Precio neto</th>
                        <th>Total cargos</th>
                        <th>Total descuentos</th>
                        <th>Total impuesto</th>
                        <th>MONTO TOTAL</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( ($requestForm->purchasingProcess->details->count() > 0 ? $requestForm->purchasingProcess->details : $requestForm->purchasingProcess->detailsPassenger) as $key => $detail)
                    <tr @if($detail->pivot->status != 'total') class="text-muted" @endif>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $detail->pivot->id}}<br>
                            @if($detail->pivot->status != 'total')
                            <a href="">
                                <span style="color: Tomato;">
                                    <i class="fas fa-times-circle" title="{!! $detail->pivot->release_observation !!}"></i>
                                </span>
                            </a>
                            @endif
                        </td>
                        <td>{{ $detail->pivot->getPurchasingTypeName() }}</td>
                        <td>{{ $detail->pivot->tender ? $detail->pivot->tender->tender_number : '-' }}</td>
                        <td align="center">@if($detail->pivot->tender)
                            <button type="button" class="badge badge-pill badge-dark popover-item" id="detail-{{$detail->id}}" rel="popover"><i class="fas fa-info"></i></button>
                            <div class="popover-list-content" style="display:none;">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Fecha creación <span class="badge badge-light">{{ $detail->pivot->tender->creation_date ? $detail->pivot->tender->creation_date->format('d-m-Y H:i') : '-' }}</span></li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Fecha cierre <span class="badge badge-light">{{$detail->pivot->tender->closing_date ? $detail->pivot->tender->closing_date->format('d-m-Y H:i') : '-'}}</span></li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Fecha inicio <span class="badge badge-light">{{$detail->pivot->tender->initial_date ? $detail->pivot->tender->initial_date->format('d-m-Y H:i') : '-'}}</span></li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Fecha final <span class="badge badge-light">{{$detail->pivot->tender->final_date ? $detail->pivot->tender->final_date->format('d-m-Y H:i') : '-'}}</span></li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Fecha publicación respuestas <span class="badge badge-light">{{$detail->pivot->tender->pub_answers_date ? $detail->pivot->tender->pub_answers_date->format('d-m-Y H:i') : '-'}}</span></li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Fecha acto apertura <span class="badge badge-light">{{$detail->pivot->tender->opening_act_date ? $detail->pivot->tender->opening_act_date->format('d-m-Y H:i') : '-'}}</span></li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Fecha publicación <span class="badge badge-light">{{$detail->pivot->tender->pub_date ? $detail->pivot->tender->pub_date->format('d-m-Y H:i') : '-'}}</span></li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Fecha adjudicación <span class="badge badge-light">{{$detail->pivot->tender->grant_date ? $detail->pivot->tender->grant_date->format('d-m-Y H:i') : '-'}}</span></li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Fecha estimada adjudicación <span class="badge badge-light">{{$detail->pivot->tender->estimated_grant_date ? $detail->pivot->tender->estimated_grant_date->format('d-m-Y H:i') : '-'}}</span></li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Fecha visita terreno <span class="badge badge-light">{{$detail->pivot->tender->field_visit_date ? $detail->pivot->tender->field_visit_date->format('d-m-Y H:i') : '-'}}</span></li>
                                </ul>
                            </div>
                            @endif</td>
                        <td>{{ $detail->pivot->tender && $detail->pivot->tender->oc ? $detail->pivot->tender->oc->po_id : ($detail->pivot->immediatePurchase ? $detail->pivot->immediatePurchase->po_id : '-') }}</td>
                        <td>{{ $detail->pivot->tender && $detail->pivot->tender->supplier ? $detail->pivot->tender->supplier->run. ' - '.$detail->pivot->tender->supplier->name : $detail->pivot->supplier_run.' - '.$detail->pivot->supplier_name }}</td>
                        <td>{{ $detail->pivot->immediatePurchase ? $detail->pivot->immediatePurchase->cot_id : '-'}}</td>
                        <td>{{ $detail->pivot->directDeal ? $detail->pivot->directDeal->resol_direct_deal : '-'}}</td>
                        <td>Comprador: {{ $detail->specification }} // proveedor: {{ $detail->pivot->supplier_specifications }}</td>
                        <td align="right">{{ $detail->pivot->quantity }}</td>
                        <td>{{ $detail->unit_of_measurement }}</td>
                        <td>{{ $detail->pivot->tender ? $detail->pivot->tender->currency : '' }}</td>
                        <td align="right">{{$requestForm->symbol_currency}}{{ number_format($detail->pivot->unit_value,$requestForm->precision_currency,",",".") }}</td>
                        <td align="right">{{$requestForm->symbol_currency}}{{ number_format($detail->pivot->charges,$requestForm->precision_currency,",",".") }}</td>
                        <td align="right">{{$requestForm->symbol_currency}}{{ number_format($detail->pivot->discounts,$requestForm->precision_currency,",",".") }}</td>
                        <td>{{ $detail->pivot->tax ?? $detail->tax }}</td>
                        <td align="right">{{$requestForm->symbol_currency}}{{ number_format($detail->pivot->expense,$requestForm->precision_currency,",",".") }}</td>
                        <td>
                            <button type="button" id="btn_items_{{$key}}" title="Ver" class="btn btn-link btn-sm" data-toggle="modal" data-target="#Receipt-{{$detail->pivot->id}}">
                                <i class="fas fa-receipt"></i>
                            </button>
                            @include('request_form.purchase.modals.detail_purchase')
                            @if(env('APP_ENV') == 'local')
                            <a href="{{ route('request_forms.supply.edit', [$requestForm->id, $detail->pivot->id]) }}" class="btn btn-link btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                            @endif
                            @if($detail->pivot->status == 'total')
                            <button type="button" id="btn_delete_{{$key}}" title="Ver" class="btn btn-link btn-sm" data-toggle="modal" data-target="#releaseitem-{{$detail->pivot->id}}">
                                <i class="fas fa-window-close" style="color: red"></i>
                            </button>
                            @include('request_form.purchase.modals.reason_item_release')
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="17" class="text-right">Valor Total</td>
                        <th class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->purchasingProcess->getExpense(),$requestForm->precision_currency,",",".") }}</td>
                    </tr>
                    <tr>
                        <th colspan="17" class="text-right">Saldo disponible Requerimiento</td>
                        <th class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense - $requestForm->purchasingProcess->getExpense(),$requestForm->precision_currency,",",".") }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<main class="container pt-3"><!-- open div container again -->
@endif

@if(Str::contains($requestForm->subtype, 'tiempo'))
<div class="row">
    <div class="col-sm">
        <div class="table-responsive">
            <h6><i class="fas fa-shopping-cart"></i> Historial de bienes y/o servicios ejecución inmediata</h6>
            <table class="table table-sm table-hover table-bordered small">
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
                    <tr @if($child->status->value != 'approved') class="text-muted" @endif>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $child->id }}<br>
                            @switch($child->status->getLabel())
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
                        </td>
                        <td>@if($child->status->value == 'approved')<a href="{{ route('request_forms.supply.purchase', $child) }}">{{ $child->folio }}</a> @else {{ $child->folio }} @endif<br>
                        <td>{{ $child->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}<br>
                            {{ $requestForm->SubtypeValue }}
                        </td>
                        <td>{{ $child->name }}</td>
                        <td>{{ $child->user ? $child->user->fullName : 'Usuario eliminado' }}<br>
                            {{ $child->userOrganizationalUnit ? $child->userOrganizationalUnit->name : 'Usuario eliminado' }}
                        </td>
                        <td>{{ $child->purchasers->first()->fullName ?? 'No asignado' }}</td>
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
                        <th colspan="9" class="text-right">Totales</th>
                        <th class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->getTotalEstimatedExpense(),$requestForm->precision_currency,",",".") }}</th>
                        <th class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->getTotalExpense(),$requestForm->precision_currency,",",".") }}</th>
                    </tr>
                    <tr>
                        <th colspan="10" class="text-right">Saldo disponible Compras</th>
                        <th class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->purchasingProcess->getExpense() - $requestForm->getTotalExpense(),$requestForm->precision_currency,",",".") }}</th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
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
'from' => 'purchase',
'eventType' => 'no'
])

<br /><br />

@if(auth()->user()->hasPermissionTo('Request Forms: audit'))

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
                @include('partials.audit', ['audits' => $requestForm->audits()])
            </div>
        </div>
    </div>
    @if($requestForm->itemRequestForms->count() > 0)
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
                                    <strong>{{ $attribute }}</strong> : {{ isset($modified['old']) ? $modified['old'] : '' }} => {{ $modified['new'] }};
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
    @else
    <div class="card">
        <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Pasajes aéreos
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
                        @foreach($requestForm->passengers as $passenger)
                            @if($passenger->audits->count() > 0)
                                @foreach($passenger->audits->sortByDesc('updated_at') as $audit)
                                    <tr>
                                        <td nowrap>{{ $audit->created_at }}</td>
                                        <td nowrap>{{ optional($audit->user)->fullName }}</td>
                                        <td>
                                            @foreach($audit->getModified() as $attribute => $modified)
                                                @if(isset($modified['old']) OR isset($modified['new']))
                                                    <strong>{{ $attribute }}</strong>
                                                    :  {{ isset($modified['old']) ? $modified['old'] : '' }}
                                                    => {{ $modified['new'] ?? '' }};
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
    <div class="card">
        <div class="card-header" id="headingThree">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                        data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Firmas
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
                        @foreach($requestForm->eventRequestForms as $eventRequestForm)
                            @if($eventRequestForm->audits->count() > 0)
                                @foreach($eventRequestForm->audits->sortByDesc('updated_at') as $audit)
                                    <tr>
                                        <td nowrap>{{ $audit->created_at }}</td>
                                        <td nowrap>{{ optional($audit->user)->fullName }}</td>
                                        <td>
                                            @foreach($audit->getModified() as $attribute => $modified)
                                                @if(isset($modified['old']) OR isset($modified['new']))
                                                    <strong>{{ $attribute }}</strong>
                                                    :  {{ isset($modified['old']) ? $modified['old'] : '' }}
                                                    => {{ $modified['new'] }};
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
        <div class="card-header" id="headingFour">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    Información de la Compra
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
                            @foreach(($requestForm->purchasingProcess->details->count() > 0 ? $requestForm->purchasingProcess->details : $requestForm->purchasingProcess->detailsPassenger) as $detail)
                            @if($detail->pivot->audits->count() > 0)
                            @foreach($detail->pivot->audits->sortByDesc('updated_at') as $audit)
                            <tr>
                                <td nowrap>{{ $audit->created_at }}</td>
                                <td nowrap>{{ optional($audit->user)->fullName }}</td>
                                <td>
                                    @foreach($audit->getModified() as $attribute => $modified)
                                    @if(isset($modified['old']) OR isset($modified['new']))
                                    <strong>{{ $attribute }}</strong> : {{ isset($modified['old']) ? $modified['old'] : '' }} => {{ $modified['new'] }};
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
        <div class="card-header" id="headingFive">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    Historial de Procesos de Compra
                </button>
            </h2>
        </div>
        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
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
                            @foreach(($requestForm->purchasingProcess->details->count() > 0 ? $requestForm->purchasingProcess->details : $requestForm->purchasingProcess->detailsPassenger) as $detail)
                            @if($detail->pivot->audits->count() > 0)
                            @foreach($detail->pivot->getPurchasingType()->audits->sortByDesc('updated_at') as $audit)
                            <tr>
                                <td nowrap>{{ $audit->created_at }}</td>
                                <td nowrap>{{ optional($audit->user)->fullName }}</td>
                                <td>
                                    @foreach($audit->getModified() as $attribute => $modified)
                                    @if(isset($modified['old']) OR isset($modified['new']))
                                    <strong>{{ $attribute }}</strong> : {{ isset($modified['old']) ? $modified['old'] : '' }} => {{ $modified['new'] }};
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $('.popover-item').popover({
            html: true,
            trigger: 'hover',
            content: function() {
                return $(this).next('.popover-list-content').html();
            }
        });
    });

    // https://webreflection.medium.com/using-the-input-datetime-local-9503e7efdce
    Date.prototype.toDatetimeLocal =
    function toDatetimeLocal() {
        var
        date = this,
        ten = function (i) {
            return (i < 10 ? '0' : '') + i;
        },
        YYYY = date.getFullYear(),
        MM = ten(date.getMonth() + 1),
        DD = ten(date.getDate()),
        HH = ten(date.getHours()),
        II = ten(date.getMinutes())
        // SS = ten(date.getSeconds())
        ;
        return YYYY + '-' + MM + '-' + DD + 'T' +
                HH + ':' + II; // + ':' + SS;
    };

    var withholding_tax = {
        2021: 0.115,
        2022: 0.1225,
        2023: 0.13,
        2024: 0.1375,
        2025: 0.145,
        2026: 0.1525,
        2027: 0.16,
        2028: 0.17
    }
    var year = new Date().getFullYear();

    // se imprime valor % boleta de honorarios que corresponda segun el año vigente
    $('#for_tax option[value=bh],#for_new_tax option[value=bh]').text("Boleta de Honorarios " + (withholding_tax[year] ? withholding_tax[year] * 100 : withholding_tax[Object.keys(withholding_tax).pop()] * 100) + "%");

    calculateAmount();
    calculateNewAmount();
    @if(isset($result_details))
    calculateAmount(true);
    @endif

    function totalValueWithTaxes(value, tax) {
        if (tax == 'iva') return value * 1.19;
        if (tax == 'bh') return withholding_tax[year] ? Math.round(value / (1 - withholding_tax[year])) : Math.round(value / (1 - withholding_tax[Object.keys(withholding_tax).pop()]));
        return value;
    }

    $('#for_quantity,#for_unit_value,#for_tax,#for_charges,#for_discounts').on('change keyup', function() {
        var tr = $(this).closest('tr')
        var qty = tr.find('input[name="quantity[]"]')
        var price = tr.find('input[name="unit_value[]"]')
        var tax = tr.find('select[name="tax[]"] option:selected')
        var charges = tr.find('input[name="charges[]"]')
        var discounts = tr.find('input[name="discounts[]"]')
        var total = tr.find('input[name="item_total[]"]')
        var grand_total = $('#total_amount')

        // total.val((qty.val() * totalValueWithTaxes(price.val(), tax.val())).toFixed(2) - -charges.val() - discounts.val());
        total.val((totalValueWithTaxes(qty.val() * price.val() - -charges.val() - discounts.val(), tax.val())).toFixed(2));

        var grandTotal = 0;
        $('table').find('input[name="item_total[]"]').each(function() {
            if (!isNaN($(this).val()))
                grandTotal += parseFloat($(this).val())
        });

        if (isNaN(grandTotal))
            grandTotal = 0;
        grand_total.val(grandTotal.toFixed(2))

        calculateAmount(true)
    });

    document.getElementById("save_btn").disabled = {{old('_token') === null ? 'true' : 'false'}} // favor de no modificar esta línea

    @if(isset($result))
    document.getElementById("save_btn").disabled = false;
    @endif

    function disabledSaveBtn() {
        // Get the checkbox
        var checkBox = document.getElementById("for_applicant_id");
        // If the checkbox is checked, display the output text
        if (document.querySelectorAll('input[type="checkbox"]:checked').length > 0) {
            document.getElementById("save_btn").disabled = false;
            calculateAmount(true);
        } else {
            document.getElementById("save_btn").disabled = true;
            calculateAmount(true);
        }
    }

    function calculateAmount(checked = false) {
        var total = 0;
        $('input[type="checkbox"]' + (checked ? ':checked' : '')).each(function() {
            var val = Math.round($(this).parents("tr").find('input[name="item_total[]"]').val() * 100) / 100;
            if (!isNaN(val))
                total += val;
        });

        $(checked ? '#total_amount_selected' : '#total_amount').val(total.toFixed(2));
        var for_po_discounts = $('#for_po_discounts').val() ?? 0;
        var for_po_charges   = $('#for_po_charges').val() ?? 0;
        if(checked && for_po_discounts == 0 && for_po_charges == 0) $('#for_amount').val(total.toFixed(2));
    }

    function calculateNewAmount() {
        var total = 0;
        $('input[name="new_item_total[]').each(function() {
            var val = Math.round(this.value * 100) / 100;
            if (!isNaN(val))
                total += val;
        });

        $('#total_new_amount').val(total.toFixed(2));
    }

    // Calcular fecha de entrega a partir de la suma de dias habiles o corridos con la fecha de la OC aceptada
    $('#for_po_accepted_date,#for_days_delivery,#for_days_type_delivery').on('change keyup', function() {
        var fechaAceptada = $('#for_po_accepted_date').val();
        var dias = $('#for_days_delivery').val();
        var tipo = $('#for_days_type_delivery option:selected').val();

        if (fechaAceptada && dias && tipo) {
            var fechaEstimada = new Date(fechaAceptada);
            if (tipo == 'corridos') {
                fechaEstimada.setDate(fechaEstimada.getDate() + parseInt(dias));
            } else { // dias hábiles
                while (parseInt(dias)) {
                    fechaEstimada.setDate(fechaEstimada.getDate() + 1);
                    switch (fechaEstimada.getDay()) {
                        case 0:
                        case 6:
                            break; // domingo y sábado no se contabilizan
                        default:
                            dias--;
                    }
                }
            }
            $('#for_estimated_delivery_date').val(fechaEstimada.toDatetimeLocal());
        } else {
            $('#for_estimated_delivery_date').val("");
        }
    });

    // function formatDateInput(date) {
    //     return date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2);
    // }

    $('form').submit(function() {
        $('#save_btn,#send_budget').attr("disabled", true);
        return true;
    });

    $('input[type="file"]').bind('change', function(e) {
        //Validación de tamaño
        for (let i = 0; i < this.files.length; i++) {
            if ((this.files[i].size / 1024 / 1024) > 5) {
                alert('No puede cargar archivos de más de 5 MB.');
                $(this).val('');
                break;
            }
        }
        //Validación de pdf
        // const allowedExtension = ".pdf";
        // let hasInvalidFiles = false;

        // for (let i = 0; i < this.files.length; i++) {
        //     let file = this.files[i];

        //     if (!file.name.endsWith(allowedExtension)) {
        //         hasInvalidFiles = true;
        //     }
        // }

        // if(hasInvalidFiles) {
        //     $('#for_document').val('');
        //     alert("Debe seleccionar un archivo pdf.");
        // }
    });

    $('#for_has_taking_of_reason').change(function() {
        $('input[name=taking_of_reason_file]').prop('required', this.checked);
        $('input[name=taking_of_reason_file]').prop('disabled', !this.checked);
    });

    $('#for_is_lower_amount').change(function() {
        $('input[name=resol_contract],input[name=guarantee_ticket],input[name=guarantee_ticket_exp_date],input[name=resol_contract_file],input[name=guarantee_ticket_file],input[name=has_taking_of_reason],input[name=taking_of_reason_date],input[name=memo_number],input[name=memo_file]').prop('required', !this.checked);
        $('input[name=resol_contract],input[name=guarantee_ticket],input[name=guarantee_ticket_exp_date],input[name=resol_contract_file],input[name=guarantee_ticket_file],input[name=has_taking_of_reason],input[name=taking_of_reason_date],input[name=memo_number],input[name=memo_file]').prop('disabled', this.checked);
    });

    $('#for_status').change(function() {
        if ($(this).val() == 'adjudicada') {
            $('#adjudicada').show().prop('required', true);
            $('#for_supplier_id,#for_resol_administrative_bases,#for_resol_adjudication,#for_resol_contract,#for_guarantee_ticket,#for_guarantee_ticket_exp_date').prop('required', true);
            $('input[name=resol_administrative_bases_file], input[name=resol_adjudication_deserted_file], input[name=resol_contract_file], input[name=guarantee_ticket_file], input[name=oc_file]').val('').prop('required', true);
            $('#for_resol_deserted,#for_justification').val('').prop('required', false);
            $('#desierta').hide().prop('required', false);
        } else if ($(this).val() == 'desierta') {
            $('#desierta').show();
            $('#for_resol_deserted,#for_justification').prop('required', true);
            $('#for_supplier_id,#for_resol_administrative_bases,#for_resol_adjudication,#for_resol_contract,#for_guarantee_ticket,#for_guarantee_ticket_exp_date').val('').prop('required', false).selectpicker('refresh');
            $('#for_start_date,#for_duration,#for_po_id,#for_po_description,#for_po_accepted_date,#for_days_type_delivery,#for_days_delivery,#for_estimated_delivery_date,#for_po_with_confirmed_receipt_date,#for_po_sent_date,#for_amount,#for_destination_warehouse,#for_supplier_specifications,#for_taking_of_reason_date,#for_memo_number').val('');
            $('#for_has_taking_of_reason').prop("checked", false);
            $('input[name=resol_administrative_bases_file], input[name=resol_adjudication_deserted_file], input[name=resol_contract_file], input[name=guarantee_ticket_file], input[name=taking_of_reason_file], input[name=memo_file], input[name=oc_file]').val('').prop('required', false);
            $('#adjudicada').hide().prop('required', false);
        } else {
            $('#adjudicada, #desierta').hide();
        }
    });

    //FILE IN MESSAGE MODAL
    $('#for_file').bind('change', function() {
        //Validación de tamaño
        if ((this.files[0].size / 1024 / 1024) > 3) {
            alert('No puede cargar un pdf de mas de 3 MB.');
            $('#for_file').val('');
        }

        //Validación de pdf
        const allowedExtension = ".pdf";
        let hasInvalidFiles = false;

        for (let i = 0; i < this.files.length; i++) {
            let file = this.files[i];

            if (!file.name.endsWith(allowedExtension)) {
                hasInvalidFiles = true;
            }
        }

        if (hasInvalidFiles) {
            $('#for_file').val('');
            alert("Debe seleccionar un archivo pdf.");
        }

    });

    $('#processClosure').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('status') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('.modal-body select').val(recipient)
    })

    $('#processClosure').on('shown.bs.modal', function() {
        $(this).find('select option:not(:selected)').attr('disabled', true);
        $(this).find('textarea[name="observation"]').focus();
    });

    $('#btn_licitacion').click(function() {
        if(document.getElementById("for_tender_number").value != '')
        {
            $('#btn_licitacion').prop('disabled', true).html("Cargando...");
            axios.get('https://api.mercadopublico.cl/servicios/v1/publico/licitaciones.json?codigo='+document.getElementById("for_tender_number").value+'&ticket=E08630E0-4621-4986-8B75-68A172A386EE')
            // axios.get('/request_forms/supply/mercado-publico-api/licitaciones/' + document.getElementById("for_tender_number").value)
            .then(function(response) {
                // handle success
                console.log(response.data);
                $('#btn_licitacion').prop('disabled', false).html("Consultar");
                // console.log(response.data.Listado[0].Nombre);
                // document.getElementById("for_description").value = response.data.Listado[0].Nombre;
                $('#for_description').val(response.data.Listado[0].Nombre);
                $('#for_full_description').val(response.data.Listado[0].Descripcion);
                $('#for_status').val(response.data.Listado[0].Estado.toLowerCase()).change();
                if(response.data.Listado[0].Estado.toLowerCase() == 'adjudicada'){
                    $('#for_currency').val(response.data.Listado[0].Moneda);
                    $('#for_n_suppliers').val(response.data.Listado[0].Adjudicacion.NumeroOferentes);
                    var FechaCreacion = new Date(response.data.Listado[0].Fechas.FechaCreacion);
                    $('#for_creation_date').val(FechaCreacion.toDatetimeLocal());
                    var FechaCierre = new Date(response.data.Listado[0].Fechas.FechaCierre);
                    $('#for_closing_date').val(FechaCierre.toDatetimeLocal());
                    var FechaInicio = new Date(response.data.Listado[0].Fechas.FechaInicio);
                    $('#for_initial_date').val(FechaInicio.toDatetimeLocal());
                    var FechaFinal = new Date(response.data.Listado[0].Fechas.FechaFinal);
                    $('#for_final_date').val(FechaFinal.toDatetimeLocal());
                    var FechaPubRespuestas = new Date(response.data.Listado[0].Fechas.FechaPubRespuestas);
                    $('#for_pub_answers_date').val(FechaPubRespuestas.toDatetimeLocal());
                    var FechaActoAperturaTecnica = new Date(response.data.Listado[0].Fechas.FechaActoAperturaTecnica);
                    $('#for_opening_act_date').val(FechaActoAperturaTecnica.toDatetimeLocal());
                    var FechaPublicacion = new Date(response.data.Listado[0].Fechas.FechaPublicacion);
                    $('#for_pub_date').val(FechaPublicacion.toDatetimeLocal());
                    var FechaAdjudicacion = new Date(response.data.Listado[0].Fechas.FechaAdjudicacion);
                    $('#for_grant_date').val(FechaAdjudicacion.toDatetimeLocal());
                    var FechaEstimadaAdjudicacion = new Date(response.data.Listado[0].Fechas.FechaEstimadaAdjudicacion);
                    $('#for_estimated_grant_date').val(FechaEstimadaAdjudicacion.toDatetimeLocal());
                    var FechaVisitaTerreno = new Date(response.data.Listado[0].Fechas.FechaVisitaTerreno);
                    $('#for_field_visit_date').val(FechaVisitaTerreno.toDatetimeLocal());
                    $('#for_has_taking_of_reason').prop("checked", parseInt(response.data.Listado[0].TomaRazon));
                }
                @if(Str::contains($requestForm->subtype, 'tiempo'))
                if(response.data.Listado[0].Items){
                    var productos = [];
                    for(var i = 0; i < response.data.Listado[0].Items.Cantidad; i++)
                        productos.push({codigo: response.data.Listado[0].Items.Listado[i].CodigoProducto, 
                                        cantidad: response.data.Listado[0].Items.Listado[i].Adjudicacion.Cantidad, 
                                        monto: response.data.Listado[0].Items.Listado[i].Adjudicacion.MontoUnitario,
                                        rutProveedor: response.data.Listado[0].Items.Listado[i].Adjudicacion.RutProveedor,
                                        nombreProveedor: response.data.Listado[0].Items.Listado[i].Adjudicacion.NombreProveedor
                                    })
                    const duplicates = productos.map(p => p.codigo).filter((e, index, arr) => arr.indexOf(e) !== index)
                    // console.log(duplicates)
                    for(var i in productos){
                        if(!duplicates.includes(productos[i].codigo)){
                            var tr = $("tr[data-id="+ productos[i].codigo + "]");
                            tr.find('#for_item_id').prop('checked', true);
                            tr.find('#for_quantity').val(productos[i].cantidad).change();
                            tr.find('#for_unit_value').val(productos[i].monto).change();
                            tr.find('#for_supplier_run').val(productos[i].rutProveedor);
                            tr.find('#for_supplier_name').val(productos[i].nombreProveedor);
                            disabledSaveBtn();
                        }
                        // console.log(productos[i])
                    }
                }
                @endif
            })
            .catch(function(error) {
                // handle error
                //alert(response.data.Cantidad);
                $('#btn_licitacion').prop('disabled', false).html("Consultar");
                alert('valor digitado no se encuentra en Mercado Público o error en la Comunicación');
                console.log(error);
            })
            .then(function() {
                // always executed
            });
        }
        else
        {
            alert('Debe llenar un valor en el campo antes de consultar en la API');
        }



    });

    $('#btn_oc').click(function() {
        if(document.getElementById("for_po_id").value != '')
        {
            $('#btn_oc').prop('disabled', true).html("Cargando...");
            axios.get('https://api.mercadopublico.cl/servicios/v1/publico/ordenesdecompra.json?codigo='+document.getElementById("for_po_id").value+'&ticket=E08630E0-4621-4986-8B75-68A172A386EE')
            // axios.get('/api/request_forms/supply/mercado-publico-api/ordenesdecompra/' + document.getElementById("for_po_id").value)
            .then(function(response) {
                // handle success
                console.log(response.data);
                $('#btn_oc').prop('disabled', false).html("Consultar");
                $('#for_po_description').val(response.data.Listado[0].Nombre);
                $('#for_po_status').val(response.data.Listado[0].Estado);
                var FechaCreacion = new Date(response.data.Listado[0].Fechas.FechaCreacion);
                $('#for_po_date').val(FechaCreacion.toDatetimeLocal());
                var FechaAceptacion = new Date(response.data.Listado[0].Fechas.FechaAceptacion);
                $('#for_po_accepted_date').val(FechaAceptacion.toDatetimeLocal());
                var FechaEnvio = new Date(response.data.Listado[0].Fechas.FechaEnvio);
                $('#for_po_sent_date').val(FechaEnvio.toDatetimeLocal());
                $('#for_po_discounts').val(response.data.Listado[0].Descuentos);
                $('#for_po_charges').val(response.data.Listado[0].Cargos);
                $('#for_po_net_amount').val(response.data.Listado[0].TotalNeto);
                $('#for_po_tax_percent').val(response.data.Listado[0].PorcentajeIva);
                $('#for_po_tax_amount').val(response.data.Listado[0].Impuestos);
                $('#for_amount').val(response.data.Listado[0].Total);
                $('#for_po_supplier_name').val(response.data.Listado[0].Proveedor.Nombre);
                $('#for_po_supplier_activity').val(response.data.Listado[0].Proveedor.Actividad);
                $('#for_po_supplier_office_run').val(response.data.Listado[0].Proveedor.RutSucursal);
                $('#for_po_supplier_office_name').val(response.data.Listado[0].Proveedor.NombreSucursal);
                $('#for_po_supplier_address').val(response.data.Listado[0].Proveedor.Direccion);
                $('#for_po_supplier_commune').val(response.data.Listado[0].Proveedor.Comuna);
                $('#for_po_supplier_region').val(response.data.Listado[0].Proveedor.Region);
                $('#for_po_supplier_contact_name').val(response.data.Listado[0].Proveedor.NombreContacto);
                $('#for_po_supplier_contact_position').val(response.data.Listado[0].Proveedor.CargoContacto);
                $('#for_po_supplier_contact_phone').val(response.data.Listado[0].Proveedor.FonoContacto);
                $('#for_po_supplier_contact_email').val(response.data.Listado[0].Proveedor.MailContacto);

                if(response.data.Listado[0].Items){
                    var productos = [];
                    for(var i = 0; i < response.data.Listado[0].Items.Cantidad; i++)
                        productos.push({codigo: response.data.Listado[0].Items.Listado[i].CodigoProducto, 
                                        cantidad: response.data.Listado[0].Items.Listado[i].Cantidad, 
                                        monto: response.data.Listado[0].Items.Listado[i].PrecioNeto,
                                        cargos: response.data.Listado[0].Items.Listado[i].TotalCargos,
                                        descto: response.data.Listado[0].Items.Listado[i].TotalDescuentos,
                                        rutProveedor: response.data.Listado[0].Proveedor.RutSucursal,
                                        nombreProveedor: response.data.Listado[0].Proveedor.NombreSucursal,
                                        specsProveedor: response.data.Listado[0].Items.Listado[i].EspecificacionProveedor
                                    })
                    const duplicates = productos.map(p => p.codigo).filter((e, index, arr) => arr.indexOf(e) !== index)
                    // console.log(duplicates)
                    for(var i in productos){
                        if(!duplicates.includes(productos[i].codigo)){
                            var tr = $("tr[data-id="+ productos[i].codigo + "]");
                            tr.find('#for_item_id').prop('checked', true);
                            tr.find('#for_quantity').val(productos[i].cantidad).change();
                            tr.find('#for_unit_value').val(productos[i].monto).change();
                            tr.find('#for_supplier_run').val(productos[i].rutProveedor);
                            tr.find('#for_supplier_name').val(productos[i].nombreProveedor);
                            tr.find('#for_supplier_specifications').val(productos[i].specsProveedor);
                            disabledSaveBtn();
                        }
                        // console.log(productos[i])
                    }
                }

                if($('#for_po_discounts').val() > 0 || $('#for_po_charges').val() > 0)
                    $('#for_amount').val(response.data.Listado[0].Total);
            })
            .catch(function(error) {
                // handle error
                //alert(response.data.Cantidad);
                $('#btn_oc').prop('disabled', false).html("Consultar");
                alert('valor digitado no se encuentra en Mercado Público o error en la Comunicación');
                console.log(error);
            })
            .then(function() {
                // always executed
            });
        }
        else
        {
            alert('Debe llenar un valor en el campo antes de consultar en la API');
        }



    });

    //NEW BUDGET EVENTS FOR ITEMS
    // $('#for_new_quantity,#for_new_unit_value,#for_new_tax').on('change keyup', function() {
    $(document).on('change keyup', '.new-item', function() {
        var tr = $(this).closest('tr')
        var qty = tr.find('input[name="new_quantity[]"]')
        var price = tr.find('input[name="new_unit_value[]"]')
        var tax = tr.find('select[name="new_tax[]"] option:selected')
        var total = tr.find('input[name="new_item_total[]"]')

        total.val((totalValueWithTaxes(qty.val() * price.val(), tax.val())).toFixed(2));
        calculateNewAmount()
    });

    /*NEW BUDGET EVENTS FOR PASSENGERS
    $('#for_new_item_total').on('change keyup', function() {
        calculateNewAmount()
    });
    */

    // NEW BUDGET EVENTS FOR PASSENGERS
    $(document).on('change keyup', '.new-item-total', function() {
        calculateNewAmount();
    });

    // Function to calculate the total new amount
    function calculateNewAmount() {
        let totalAmount = 0;

        // Iterate over all inputs with the class 'new-item-total'
        $('.new-item-total').each(function() {
            totalAmount += parseFloat($(this).val()) || 0;
        });

        // Update the total amount field
        $('#total_new_amount').val(totalAmount.toFixed(2));
    }

</script>

@endsection

@section('custom_js_head')


@endsection
