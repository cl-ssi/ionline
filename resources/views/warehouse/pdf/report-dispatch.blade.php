@extends('warehouse.pdf.layouts')

@section('title', "Acta de Egreso " . $control->id )

@section('content')

<div style="width: 49%; display: inline-block;">
    <div class="siete" style="padding-top: 3px;">
        {{ env('APP_SS') }}
    </div>
    <div class="siete" style="padding-top: 3px;">
        <i>correo@redsalud.gob.cl</i>
    </div>
</div>
<div class="right" style="width: 49%; display: inline-block;">
    Iquique {{ $control->date->formatLocalized('%d de %B del %Y') }}<br>
</div>

<div class="titulo">ACTA DE EGRESO N° {{ $control->id }}</div>

<div style="padding-bottom: 8px;">
    <strong>Bodega:</strong> {{ optional($control->store)->name }}<br>
    <strong>Programa:</strong> {{ optional($control->program)->name }}<br>
    <strong>Destino:</strong> {{ optional($control->destination)->name }}<br>
    <strong>Nota:</strong> {{ $control->note }}<br>
</div>

<table class="ocho">
    <thead>
        <tr>
            <th>Cantidad</th>
            <th>Código de Barra</th>
            <th>Descripción</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($control->items as $item)
            <tr>
                <td class="center" style="vertical-align: top;">
                    {{ $item->quantity }}
                </td>
                <td class="center" style="vertical-align: top;">
                    {{ optional($item->product)->barcode }}
                </td>
                <td style="vertical-align: top;">
                    {{ optional($item->product->product)->name }}
                    - {{ optional($item->product)->name }}
                </td>
                <td class="center" style="vertical-align: top;">
                    {{ $control->date->format('d/m/Y')}}
                </td>
            </tr>
        @endforeach
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