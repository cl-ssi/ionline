@extends('layouts.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<h4 class="mb-3">Compra</h4>

@include('request_form.partials.nav')

<div class="row">
    <div class="col-sm-8">
        <div class="table-responsive">
            <h6><i class="fas fa-info-circle"></i> Detalle Formulario ID {{$requestForm->id}}</h6>
            <table class="table table-sm table-striped table-bordered">
                <!-- <thead>
                    <tr class="table-active">
                        <th colspan="2">Formulario Contratación de Personal </th>
                    </tr>
                </thead> -->
                <tbody class="small">
                    <tr>
                        <th class="table-active" scope="row">Folio</th>
                        <td>{{ $requestForm->folio }}</td>
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
                    <tr>
                        <th class="table-active" scope="row">Nombre del Solicitante</th>
                        <td>{{ $requestForm->user ? $requestForm->user->FullName : 'Usuario eliminado' }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Unidad Organizacional</th>
                        <td>{{ $requestForm->user ? $requestForm->userOrganizationalUnit->name : 'Usuario eliminado' }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Adminitrador de Contrato</th>
                        <td>{{ $requestForm->contractManager ? $requestForm->contractManager->FullName : 'Usuario eliminado' }}</td>
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
                        <td>{{ $requestForm->program }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Folio SIGFE</th>
                        <td>{{ $requestForm->sigfe }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Justificación de Adquisición</th>
                        <td>{{ $requestForm->justification }}</td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="float-right">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                Editar Mecanismo de Compra
            </button>

            @include('request_form.purchase.modals.select_purchase_mechanism')

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#requestBudget" @if($isBudgetEventSignPending || $requestForm->father || $requestForm->has_increased_expense) disabled @endif >
                Solicitar presupuesto
            </button>

            @include('request_form.purchase.modals.request_new_budget')
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
              @foreach($requestForm->eventRequestForms as $event)
                <td><strong>{{ $event->EventTypeValue }}</strong></td>
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
                  @endif
                </td>
              @endforeach
            </tr>
        </tbody>
    </table>
</div>

<br>

<div class="row">
    <div class="col-sm">
        <div class="table-responsive">
            <h6><i class="fas fa-shopping-cart"></i> Lista de Bienes y/o Servicios:</h6>
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
                @if($requestForm->father || $requestForm->purchase_type_id == 4) <!-- OC ejecución inmediata desde trato directo con ejecucion en el tiempo o CONVENIO MARCO MENOR A 1.000 UTM -->
                <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_oc', $requestForm) }}" enctype="multipart/form-data">
                @else
                <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_convenio_marco', $requestForm) }}" enctype="multipart/form-data">
                @endif
            @endif

            @if($requestForm->purchase_mechanism_id == 3)
                @if($requestForm->father) <!-- OC ejecución inmediata desde trato directo con ejecucion en el tiempo -->
                <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_oc', $requestForm) }}" enctype="multipart/form-data">
                @else
                <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_direct_deal', $requestForm) }}" enctype="multipart/form-data">
                @endif
            @endif

            @if($requestForm->purchase_mechanism_id == 4)
                @if($requestForm->father) <!-- OC ejecución inmediata desde licitacion con ejecucion en el tiempo -->
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
            @method('POST')

            <table class="table table-sm table-striped table-bordered small">
                <thead class="text-center">
                    <tr>
                        <th>Item</th>
                        <th>Estado</th>
                        <th>Cod.Presup.</th>
                        <th>Artículo</th>
                        <th>UM</th>
                        <th>Especificaciones Técnicas</th>
                        <th>Archivo</th>
                        <th width="100">Cantidad</th>
                        <th width="150">Valor U.</th>
                        <th width="50">Impto.</th>
                        <th width="150">Total Item</th>
                        <th colspan="2"></th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($requestForm->itemRequestForms as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->budgetItem()->first()->fullName() }}</td>
                        <td>{{ $item->article }}</td>
                        <td>{{ $item->unit_of_measurement }}</td>
                        <td>{{ $item->specification }}</td>
                        <td align="center">
                            @if($item->article_file)
                            <a href="{{ route('request_forms.show_item_file', $item) }}" target="_blank">
                              <i class="fas fa-file"></i></a>
                            @endif
                        </td>
                        <td align="right">
                          <input type="number" class="form-control form-control-sm text-right" step="0.01" min="0.1" id="for_quantity" name="quantity[]"
                              value="{{ old('quantity.'.$key, $item->quantity) }}">
                        </td>
                        <td align="right">
                          <input type="number" class="form-control form-control-sm text-right" step="0.01" min="1" id="for_unit_value" name="unit_value[]"
                              value="{{ old('unit_value.'.$key, $item->unit_value) }}">
                        </td>
                        <td align="right">
                          <input type="text" class="form-control form-control-sm text-right" id="for_tax" name="tax[]"
                              value="{{ $item->tax }}" readonly>
                        </td>
                        <td align="right">
                          <input type="number" class="form-control form-control-sm text-right" step="0.01" min="1" id="for_item_total" name="item_total[]"
                              value="{{ old('item_total.'.$key, $item->expense) }}" readonly>
                        </td>
                        <td align="center">
                            <fieldset class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="item_id[{{$key}}]" onclick="disabledSaveBtn()"
                                        id="for_item_id" value="{{ $item->id }}" {{ $item->id == old('item_id.'.$key, '') ? 'checked' : '' }} @if($isBudgetEventSignPending) disabled @endif>
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
                      <td colspan="9"></td>
                      <td class="text-right">Valor Total</td>
                      <td align="right">
                          <input type="number" step="0.01" min="1" class="form-control form-control-sm text-right" id="total_amount" readonly>
                        </td>
                    </tr>
                    <tr>
                      <td colspan="9"></td>
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
@if( $requestForm->father || in_array($requestForm->purchase_type_id, [4, 7]))
    @include('request_form.purchase.partials.immediate_purchase_form')
@endif

<br>

<!--Observaciones al proceso de compra -->
@if($requestForm->purchasingProcess)
<h6><i class="fas fa-eye"></i> Observaciones al proceso de compra</h6>
<div class="row">
    <div class="col-sm">
        <form action="">
        <div class="form-group">
            <textarea name="observation" class="form-control form-control-sm" rows="3">{{ old('observation', $requestForm->purchasingProcess->observation ?? '') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary float-right" id="save_btn" disabled>
            <i class="fas fa-save"></i> Guardar
        </button>
        </form>
    </div>
</div>
<br>
@endif

@if($requestForm->purchasingProcess && $requestForm->purchasingProcess->details->count() > 0)
<div class="row">
    <div class="col-sm">
        <div class="table-responsive">
            <h6><i class="fas fa-shopping-cart"></i> Historial de compras</h6>


            <table class="table table-sm table-striped table-bordered small">
                <thead class="text-center">
                    <tr>
                        <th>Item</th>
                        <th>Fecha</th>
                        <!-- <th>Mecanismo de Compra</th> -->
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
                        <!-- <td align="center">
                            <fieldset class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="item_id[]" onclick="disabledSaveBtn()"
                                      id="for_item_id" value="{{ $item->id }}">
                                </div>
                            </fieldset>
                        </td> -->
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
            <h6><i class="fas fa-shopping-cart"></i> Historial de bienes y/o servicios ejecución inmediata</h6>
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
                        <td>@if($child->status == 'approved')<a href="{{ route('request_forms.supply.purchase', $child) }}">{{ $child->folio }}</a> @else {{ $child->folio }} @endif<br>
                        <td>{{ $child->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}<br>
                            {{ $requestForm->SubtypeValue }}
                        </td>
                        <td>{{ $child->name }}</td>
                        <td>{{ $child->user ? $child->user->FullName : 'Usuario eliminado' }}<br>
                        {{ $child->userOrganizationalUnit ? $child->userOrganizationalUnit->name : 'Usuario eliminado' }}</td>
                        <td>{{ $child->purchasers->first()->FullName ?? 'No asignado' }}</td>
                        <td align="center">{{ $child->quantityOfItems() }}</td>
                        <td align="right">{{$requestForm->symbol_currency}}{{ number_format($child->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
                        <td align="right">{{ $child->purchasingProcess ? $requestForm->symbol_currency.number_format($child->purchasingProcess->getExpense(),$requestForm->precision_currency,",",".") : '-' }}</td>
                        {{--<td align="right">{{ $child->purchasingProcess ? $requestForm->symbol_currency.number_format($child->estimated_expense - $child->purchasingProcess->getExpense(),$requestForm->precision_currency,",",".") : '-' }}</td>--}}
                    </tr>
                  @empty
                    <tr><td colspan="100%" class="text-center">No existen bienes y/o servicios de ejecución inmediata asociados a este formulario de requerimiento.</td></tr>
                  @endforelse
                </tbody>
                @if($requestForm->children->count() > 0)
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


@endsection

@section('custom_js')

<script type="text/javascript">

var withholding_tax = {2021: 0.115, 2022: 0.1225, 2023: 0.13, 2024: 0.1375, 2025: 0.145, 2026: 0.1525, 2027: 0.16, 2028: 0.17}
var year = new Date().getFullYear();

calculateAmount();

function totalValueWithTaxes(value, tax){
    if(tax == 'iva') return value * 1.19;
    if(tax == 'bh') return withholding_tax[year] ? Math.round(value / (1 - withholding_tax[year])) : Math.round(value / (1 - withholding_tax[Object.keys(withholding_tax).pop()]));
    return value;
}

$('#for_quantity,#for_unit_value').on('change keyup',function(){
    var tr    = $(this).closest('tr')
    var qty   = tr.find('input[name="quantity[]"]')
    var price = tr.find('input[name="unit_value[]"]')
    var tax   = tr.find('input[name="tax[]"]')
    var total = tr.find('input[name="item_total[]"]')
    var grand_total = $('#total_amount')

    total.val((qty.val() * totalValueWithTaxes(price.val(), tax.val())).toFixed(2))

    var grandTotal=0;
    $('table').find('input[name="item_total[]"]').each(function(){
        if(!isNaN($(this).val()))
            grandTotal += parseFloat($(this).val())
    });

    

    if(isNaN(grandTotal))
        grandTotal = 0;
    grand_total.val(grandTotal.toFixed(2))

    calculateAmount(true)
});

document.getElementById("save_btn").disabled = {{ old('_token') === null ? 'true' : 'false' }}

function disabledSaveBtn() {
    // Get the checkbox
    var checkBox = document.getElementById("for_applicant_id");
    // If the checkbox is checked, display the output text
    if (document.querySelectorAll('input[type="checkbox"]:checked').length > 0){
        document.getElementById("save_btn").disabled = false;
        calculateAmount(true);
    } else {
        document.getElementById("save_btn").disabled = true;
        calculateAmount(true);
    }
}

function calculateAmount(checked = false) {
    var total = 0;
    $('input[type="checkbox"]' + (checked ? ':checked' : '')).each(function(){
        var val = Math.round($(this).parents("tr").find('input[name="item_total[]"]').val() * 100) / 100;
        if(!isNaN(val))
            total += val;
    });

    $(checked ? '#for_amount,#total_amount_selected' : '#total_amount').val(total.toFixed(2));
}

// Calcular fecha de entrega a partir de la suma de dias habiles o corridos con la fecha de la OC aceptada
$('#for_po_accepted_date,#for_days_delivery,#for_days_type_delivery').on('change keyup',function(){
    var fechaAceptada = $('#for_po_accepted_date').val();
    var dias = $('#for_days_delivery').val();
    var tipo = $('#for_days_type_delivery option:selected').val();

    if(fechaAceptada && dias && tipo){
        var fechaEstimada = new Date(fechaAceptada + "T00:00:00");
        if(tipo == 'corridos'){
            fechaEstimada.setDate(fechaEstimada.getDate() + parseInt(dias));
        }else{ // dias hábiles
            while(parseInt(dias)){
                fechaEstimada.setDate(fechaEstimada.getDate() + 1);
                switch(fechaEstimada.getDay()){
                    case 0: case 6: break; // domingo y sábado no se contabilizan
                    default: dias--;
                }
            }
        }
        $('#for_estimated_delivery_date').val(formatDateInput(fechaEstimada));
    }else{
        $('#for_estimated_delivery_date').val("");
    }
});

function formatDateInput(date) {
    return date.getFullYear() + "-" + ("0"+(date.getMonth()+1)).slice(-2) +"-"+("0" + date.getDate()).slice(-2);
}

$('form').submit(function() {
    $('#save_btn').attr("disabled", true);
    return true;
});

$('input[type="file"]').bind('change', function(e) {
    //Validación de tamaño
    for (let i = 0; i < this.files.length; i++) {
      if((this.files[i].size / 1024 / 1024) > 3){
          alert('No puede cargar archivos de más de 3 MB.');
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
    $('input[name=taking_of_reason_file]').prop('required',this.checked);
    $('input[name=taking_of_reason_file]').prop('disabled',!this.checked);
});

</script>

@endsection

@section('custom_js_head')

@endsection
