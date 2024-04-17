@extends('warehouse.pdf.layouts')

@section('title', "Acta de Ingreso " . $dte['id'])

@section('content')

<div style="width: 49%; display: inline-block;">
    <div class="siete">
        {{ env('APP_SS') }}
    </div>
</div>


<div class="right" style="width: 50%; display: inline-block; padding-bottom: 10px;">
    Iquique, {{ now()->day . ' de ' . now()->monthName . ' del ' . now()->year }}<br>
</div>

<div class="titulo">
    ACTA DE RECEPCIÓN CONFORME
</div>

<p>
    El siguiente DTE (documento tributario electrónico) fué recepcionado en portal DIPRES Acepta, lo cual confirma la
    recepción conforme del siguiente DTE con los siguientes detalles:
</p>

<table class="ocho">
    <tbody>
        <tr class="">
            <td style="font-weight:bold; width: 1rem; vertical-align: top;">
                Tipo de Documento
            </td>
            <td style="width: 1rem; vertical-align: top;">
                {{ $dte['tipo_documento'] }}
            </td>
        </tr>
        <tr class="">
            <td style="font-weight:bold; width: 1rem; vertical-align: top;">
                Folio
            </td>
            <td style="width: 1rem; vertical-align: top;">
                {{ $dte['folio'] }}
            </td>
        </tr>
        <tr class="">
            <td style="font-weight:bold; width: 1rem; vertical-align: top;">
                RUT
            </td>
            <td style="width: 1rem; vertical-align: top;">
                {{ $dte['emisor'] }}
            </td>
        </tr>
        <tr class="">
            <td style="font-weight:bold; width: 1rem; vertical-align: top;">
                Razón Social Emisor
            </td>
            <td style="width: 1rem; vertical-align: top;">
                {{ $dte['razon_social_emisor'] }}
            </td>
        </tr>
        <tr class="">
            <td style="font-weight:bold; width: 1rem; vertical-align: top;">
                Publicación
            </td>
            <td style="width: 1rem; vertical-align: top;">
                {{ \Carbon\Carbon::parse($dte['publicacion']) }}
            </td>
        </tr>
        <tr class="">
            <td style="font-weight:bold; width: 1rem; vertical-align: top;">
                Emisión
            </td>
            <td style="width: 1rem; vertical-align: top;">
                {{ \Carbon\Carbon::parse($dte['emision']) }}
            </td>
        </tr>
        <tr class="">
            <td style="font-weight:bold; width: 1rem; vertical-align: top;">
                Monto Total
            </td>
            <td style="width: 1rem; vertical-align: top;">
                $ {{ money($dte['monto_total']) }}
            </td>
        </tr>
        <tr class="">
            <td style="font-weight:bold; width: 1rem; vertical-align: top;">
                Fecha Máxima para Reclamar
            </td>
            <td style="width: 1rem; vertical-align: top;">
                {{ \Carbon\Carbon::parse($dte['publicacion'])->add('+3 days')->format('Y-m-d') }}
            </td>
        </tr>
        <tr class="">
            <td style="font-weight:bold; width: 1rem; vertical-align: top;">
                Folio OC
            </td>
            <td style="width: 1rem; vertical-align: top;">
                {{ $dte['folio_oc'] }}
            </td>
        </tr>
    </tbody>
</table>

<br>

<table class="ocho">
    <thead>
        <tr>
            <th class="text-left">
                ACTAS DE RECEPCIÓN TÉCNICA
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($controls as $control)
        <tr class="">
            <td style="width: 1rem; vertical-align: top;">
                ACTA DE RECEPCIÓN DE ARTÍCULOS EN BODEGA
                #{{ $control['id'] }}
                -
                ORDEN DE COMPRA {{ $control['po_code'] }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<p>
    Se deja constancia que los bienes/servicios se recepcionan conforme de acuerdo a especificaciones técnicas, cumple
    con la calidad técnica, oportunidad y operatividad.
</p>

@endsection
