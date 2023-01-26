@extends('warehouse.pdf.layouts')

@section('title', "Acta de Ingreso " . $control->id)

@section('content')

<div style="width: 49%; display: inline-block;">
    <div class="siete">
        {{ env('APP_SS') }}
    </div>
    <div class="siete" style="padding-top: 3px;">
        <i>correo@redsalud.gob.cl</i>
    </div>
</div>

<div class="right" style="width: 50%; display: inline-block;">
    Iquique, {{ $control->format_date }}<br>
</div>

<div class="titulo">
    ACTA DE INGRESO N° {{ $control->id }}
</div>

<div class="center">
    @if($act_type == 'technical')
        <strong class="seis">Acta Recepción Técnica</strong>
    @else
        <strong class="seis">Acta Ingreso a Bodega</strong>
    @endif
</div>

<div style="padding-bottom: 8px;">
    <strong>Bodega:</strong> {{ optional($control->store)->name }}<br>
    <strong>Programa:</strong> {{ $control->program_name }}<br>
    <strong>Tipo de Ingreso:</strong> {{ optional($control->typeReception)->name }}<br>
    @switch($control->type_reception_id)
        @case(\App\Models\Warehouse\TypeReception::receiving())
            <strong>Origen:</strong> {{ optional($control->origin)->name }}<br>
            @break
        @case(\App\Models\Warehouse\TypeReception::receiveFromStore())
            <strong>Bodega Origen:</strong> {{ optional($control->originStore)->name }}<br>
            @break
        @case(\App\Models\Warehouse\TypeReception::return())
            <strong>Bodega Origen:</strong> {{ optional($control->originStore)->name }}<br>
            @break
        @case(\App\Models\Warehouse\TypeReception::purchaseOrder())
            <strong>Código OC:</strong> {{ $control->po_code }}<br>
            @break
    @endswitch
    <strong>Nota:</strong> {{ $control->note }}<br>
</div>

<table class="ocho">
    <thead>
        <tr>
            <th>Código</th>
            <th>Cant.</th>
            <th>Producto</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @forelse($control->items as $item)
            <tr>
                <td class="center" style="width: 1rem; vertical-align: top;">
                    <span class="monospace siete">
                        {{ optional($item->product->product)->code }}
                    </span>
                </td>
                <td class="center" style="width: 1rem; vertical-align: top;">
                    {{ $item->quantity }}
                </td>
                <td style="vertical-align: top;">
                    {{ optional($item->product->product)->name }}
                    <br>
                    <small>
                        @if($item->product->barcode)
                            {{ $item->product->barcode }}
                            -
                        @endif
                        {{ optional($item->product)->name }}
                    </small>
                </td>
                <td class="center" style="vertical-align: top;">
                    {{ $control->date->format('d/m/Y')}}
                </td>
            </tr>
        @empty
            <tr>
                <td class="center" colspan="4">
                    <strong>No hay productos</strong>
                </td>
            </tr>
        @endforelse

        @if($control->isPurchaseOrder())
            <tr>
                <td colspan="2"></td>
                <td class="right">
                    <strong>NETO</strong>
                </td>
                <td class="right">
                    <strong>{{ money($control->net_total) }}</strong>
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="right">
                    @if($control->purchaseOrder)
                        <strong>
                            IVA {{ optional($control->purchaseOrder)->tax_percentage }}%
                        </strong>
                    @endif
                </td>
                <td class="right">
                    <strong>{{ money($control->total_tax) }}</strong>
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="right">
                    <strong>TOTAL</strong>
                </td>
                <td class="right">
                    <strong>{{ money($control->total) }}</strong>
                </td>
            </tr>
        @endif
    </tbody>
</table>

@if($control->receptionVisator)
<div class="content-signature">
    <div class="aprove">
        <em>
            Recepcionado digitalmente el {{ $control->created_at }} por:
        </em>
        <br>
        <span style="font-size: 110%;">
            <b>{{ $control->receptionVisator->full_name }} </b> <br>
        </span>
        <span style="font-size: 100%;">
            {{ optional($control->receptionVisator)->organizationalUnit->name }} <br>
        </span>
        {{ optional($control->receptionVisator)->organizationalUnit->establishment->name }}<br>
    </div>
</div>
@endif

@endsection
