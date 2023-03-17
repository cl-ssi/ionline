@extends('drugs.pdf.layouts')

@section('title', "Acta de Precursores N° " . $actPrecursor->id)

@section('content')

<div style="width: 49%; display: inline-block;">
    <div class="siete">
        {{ env('APP_SS') }}
    </div>
</div>


<div class="right" style="width: 50%; display: inline-block; padding-bottom: 10px;">
    Iquique, {{ $actPrecursor->format_date }}<br>
</div>

<div class="titulo">
    ACTA DE PRECURSORES N° {{ $actPrecursor->id }}
</div>

<div style="padding-bottom: 8px;">
    <strong>Fecha Acta:</strong> {{ $actPrecursor->date->format('Y-m-d') }}<br>
    <strong>Notas:</strong> {{ $actPrecursor->note }}<br>
</div>

<table class="ocho">
    <thead>
        <tr>
            <th>Acta</th>
            <th>Item</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th class="text-center">Peso neto</th>
        </tr>
    </thead>
    <tbody>
        @forelse($actPrecursor->precursors as $precursor)
            <tr>
                <td class="center" style="width: 1rem; vertical-align: top;">
                    {{ $precursor->reception_item->reception->id }}
                </td>
                <td>
                    {{ $precursor->reception_item->letter }}.
                </td>
                <td style="vertical-align: top;">
                    {{ $precursor->reception_item->substance->name }}
                </td>
                <td class="left" style="vertical-align: top;">
                    {{ $precursor->reception_item->description }}
                </td>
                <td class="right" style="vertical-align: top;">
                    {{ money($precursor->reception_item->net_weight)}} {{ $precursor->reception_item->substance->unit }}
                </td>
            </tr>
        @empty
            <tr>
                <td class="center" colspan="5">
                    <strong>No hay registros</strong>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>

<div id="firmas">
    <div class="center" style="width: 49%">
        <span class="uppercase">Persona Entrega</span>
        <br>
        <small>{{ $actPrecursor->delivery->short_name }}</small>
    </div>
    <div class="center" style="width: 49%">
        <span class="uppercase">Persona Recibe</span>
        <br>
        <small>{{ $actPrecursor->full_name_receiving }}</small>
    </div>
</div>

@endsection
