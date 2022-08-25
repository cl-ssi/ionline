@extends('warehouse.pdf.layouts')

@section('title', "Acta de Egreso " . $control->id)

@section('content')

<div style="width: 49%; display: inline-block;">
    <div class="siete" style="padding-top: 3px;">
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
    ACTA DE EGRESO N° {{ $control->id }}
</div>

<div style="padding-bottom: 8px;">
    <strong>Bodega:</strong> {{ optional($control->store)->name }}<br>
    <strong>Programa:</strong> {{ $control->program_name }}<br>
    <strong>Tipo de Egreso:</strong> {{ optional($control->typeDispatch)->name }}<br>
    @switch($control->type_dispatch_id)
        @case(\App\Models\Warehouse\TypeDispatch::internal())
            <strong>Establecimiento:</strong>
            {{ optional($control->organizationalUnit)->establishment->name }}
            -
            {{ optional($control->organizationalUnit)->name }}
            <br>
            @break
        @case(\App\Models\Warehouse\TypeDispatch::external())
            <strong>Destino:</strong>
            {{ optional($control->destination)->name }}
            <br>
            @break
        @case(\App\Models\Warehouse\TypeDispatch::sendToStore())
            <strong>Bodega Destino:</strong>
            {{ optional($control->destinationStore)->name }}
            <br>
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
                <td class="center" style="vertical-align: top;">
                    <span class="monospace siete">
                        {{ optional($item->product->product)->code }}
                    </span>
                </td>
                <td class="center" style="vertical-align: top;">
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
    </tbody>
</table>


<div id="firmas">
    <div class="center" style="width: 49%">
        <span class="uppercase">Encargado de bodega</span>
    </div>
    <div class="center" style="width: 49%">
        <span class="uppercase">Funcionario que recibe</span>
    </div>
</div>

@endsection
