@extends('layouts.report_pharmacies')

@section('title', "Acta de recepción " . $purchase->id )

@section('content')

<?php setlocale(LC_ALL, 'es_CL.UTF-8');?>

<!-- <div>
    <div style="width: 49%; display: inline-block;">
        <div class="siete" style="padding-top: 3px;">
            Droguería - {{ env('APP_SS') }}
        </div>
        <div class="siete" style="padding-top: 3px;">
            <i>fernando.molina@redsalud.gob.cl</i>
        </div>
    </div>
    <div class="right" style="width: 49%; display: inline-block;">
        Iquique {{ $purchase->date->formatLocalized('%d de %B del %Y') }}<br>
    </div>
</div> -->

@canany(['Pharmacy: SSI (id:1)', 'Pharmacy: REYNO (id:2)'])
    <div>
        <div style="width: 49%; display: inline-block;">
            <div class="siete" style="padding-top: 3px;">
                Droguería - {{ env('APP_SS') }}
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>fernando.molina@redsalud.gob.cl</i>
            </div>
        </div>
        <div class="right" style="width: 49%; display: inline-block;">
            Iquique {{ $purchase->date->formatLocalized('%d de %B del %Y') }}<br>
        </div>
    </div>
@endcan
@can('Pharmacy: APS (id:3)')
    <div>
        <div style="width: 49%; display: inline-block;">
            <div class="siete" style="padding-top: 3px;">
                Bodega APS - {{ env('APP_SS') }}
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>bodega.ssi@redsalud.gov.cl</i>
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>N* minsal 576975 teléfono 572406975</i>
            </div>
        </div>
        <div class="right" style="width: 49%; display: inline-block;">
            Iquique {{ $purchase->date->formatLocalized('%d de %B del %Y') }}<br>
        </div>
    </div>
@endcan
@can('Pharmacy: Servicios generales (id:4)')
    <div>
        <div style="width: 49%; display: inline-block;">
            <div class="siete" style="padding-top: 3px;">
                Bodega Servicios Generales - {{ env('APP_SS') }}
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>bodega.ssi@redsalud.gov.cl</i>
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>N* minsal 576975 teléfono 572406975</i>
            </div>
        </div>
        <div class="right" style="width: 49%; display: inline-block;">
            Iquique {{ $purchase->date->formatLocalized('%d de %B del %Y') }}<br>
        </div>
    </div>
@endcan

<div class="titulo">ACTA DE RECEPCIÓN N° {{ $purchase->id }}</div>

<div style="padding-bottom: 8px;">
    <strong>Recibido de:</strong> {{ $purchase->supplier->name }}<br>
    <strong>Nota:</strong> {{ $purchase->notes }}<br>
    <strong>Factura:</strong> {{ $purchase->invoice }}
    <strong style="padding-left: 32px;">Guía:</strong> {{ $purchase->despatch_guide }}
    <strong style="padding-left: 32px;">OC:</strong> {{ $purchase->purchase_order }}
</div>

<table class="ocho">
    <thead>
        <tr>
            <th>Cantidad</th>
            <th>Descripción del material</th>
            <th>Fecha de Venc.</th>
            <th>Lote</th>
            <th>Precio</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchase->purchaseItems as $item)
            <tr>
                <td class="right">{{ $item->amount }} {{ $item->unity }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ Carbon\Carbon::parse($item->due_date)->format('d/m/Y')}}</td>
                <td>{{ $item->batch }}</td>
                <td class="right">@numero( $item->unit_cost )</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="right">
    <strong>Monto neto:</strong> @numero( $purchase->purchase_order_amount )<br>
    <strong>IVA:</strong> @numero( $purchase->purchase_order_amount * 0.19 )<br>
    <strong>Monto total:</strong> @numero( $purchase->purchase_order_amount * 1.19 )<br>
</div>


<div id="firmas">
    <div class="left" style="width: 49%;">
        <strong>Destino:</strong> {{ $purchase->destination }}<br>
        <strong>Con fondos:</strong> {{ $purchase->from }}<br>
    </div>
    <!-- <div class="center" style="width: 49%">
        <span class="uppercase">Funcionario que recibe</span>
    </div> -->
</div>

<br>

<div style="width: 100%;border:1px solid black;">
Observaciones: <br><br><br><br><br><br>
</div>

<br><br><br><br><br>
<div style="float: right;">FUNCIONARIO QUE RECIBE</div><br>

<br><br><br><br><br>
<div style="float: right;">REFERENTE TÉCNICO Y/O ADMINISTRADOR DE CONTRATO</div><br>

@endsection
