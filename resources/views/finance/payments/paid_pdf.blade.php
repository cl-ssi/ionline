@extends('layouts.sigfe_document')

@section('title', 'Comprobante de Liquidación de Fondo')

@section('content')
    <style>
        .tabla-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 6px;
        }

        .tabla-custom tr {}

        .tabla-custom th {
            text-align: left;
            padding-left: 10px;
        }

        .tabla-custom td {
            padding-left: 10px;
            border: 1px solid black;
        }

        .tabla-items {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-items thead {
            background-color: black;
            color: white;
            font-weight: bold;
            text-align: center;
            vertical-align: top;

        }

        .tabla-items tr {}

        .tabla-items th {
            border: 1px solid black;
            padding: 0px;
            padding: 8px 0 3px 0;
            line-height: 0.5;
        }

        .tabla-items td {
            padding-left: 10px;
            padding-top: 3px;
            padding-bottom: 3x;
            border: 1px solid black;
        }

        hr {
            margin-bottom: 0px;
        }
    </style>

@section('linea1', 'Ministerio de Salud')

<div style="margin-top: 120px; padding-left: 9px; font-size: 1.3rem">
    <strong style="">
        Comprobante de Liquidación de Fondos
    </strong>
</div>

<hr>

<table class="tabla-custom nueve">
    <tr>
        <th width="130px">Institución / Área Transaccional</th>
        <td colspan="7">Servicio de Salud Iquique / Hospital de Alto Hospicio</td>
    </tr>
    <tr>
        <th>Título</th>
        <td colspan="7">
            {{ $dte->comparativeRequirement?->devengo_titulo  }}
        </td>
    </tr>
    <tr>
        <th>Descripción</th>
        <td colspan="7">
            {{ $dte->comparativeRequirement?->devengo_titulo }} @if($dte->paid_automatic) @endif
        </td>
    </tr>
    <tr>
        <th>Periodo de Operación</td>
        <td style="width:160px">{{ ucfirst($dte->tgrPayedDte?->fecha_generacion->monthName) }}</td>
        <th style="width:94px">Ejercicio Fiscal</th>
        <td style="width:100px">¿?</td>
        <th style="width:90px">ID</th>
        <td style="width:140px"></td>
        <th style="width:120px">Folio</th>
        <td>{{ $dte->comparativeRequirement?->efectivo_folio }}</td>
    </tr>
    <tr>
        <th>Fecha y Hora de Aprobación</th>
        <td>{{ $dte->tgrPayedDte?->fecha_generacion }}</td>
        <th>Tipo de Transacción</th>
        <td>Creación</td>
        <th>Tipo de Operación</th>
        <td>{{ $dte->tgrPayedDte?->tipo_operacion }}</td>
        <th>Identificación de Transferencia de Datos</th>
        <td></td>
    </tr>
    <tr>
        <th>Origen del Ajuste</th>
        <td></td>
        <th>Folio Anterior</th>
        <td></td>
    </tr>
</table>

<br><br><br>

<div style="border: 2px solid black; padding: 6px">

    <table class="tabla-custom nueve">
        <tr>
            <th width="108px;">Principal</th>
            <td class="negrita">{{ $dte->tgrPayedDte?->principal }}</td>
        </tr>
    </table>

    <table class="tabla-items" style="font-size: 1.05em;">
        <thead>
            <tr>
                <th width="100px">Tipo<br>Documento</th>
                <th>Nº<br>Documento</th>
                <th>Moneda<br>Documento</th>
                <th width="220px">Cuenta Contable</th>
                <th>Cuenta Bancaria</th>
                <th width="100px">Medio de Pago</th>
                <th>Nº Documento<br>de Pago</th>
                <th>Moneda<br>de Pago</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody style="font-size: 1.1em;">
            <tr>
                <td>{{ $dte->tgrPayedDte?->tipo_documento }}</td>
                <td>{{ $dte->tgrPayedDte?->folio_documento }} </td>
                <td>{{ $dte->tgrPayedDte?->moneda }} </td>
                <td>{{ $dte->tgrAccountingPortfolio?->cuenta_contable }} </td>
                <td>{{ $dte->tgrPayedDte?->banco_cta_corriente }}</td>
                <td>{{ $dte->tgrPayedDte?->medio_pago }} </td>
                <td>{{ $dte->tgrPayedDte?->nro_documento_pago }}</td>
                <td>{{ $dte->tgrPayedDte?->moneda }}</td>
                <td style="text-align: right;">{{ money($dte->tgrPayedDte?->monto) }} </td>
            </tr>
            <tr class="negrita ocho">
                <td colspan="7" style="padding-top: 5px; padding-bottom: 5px;">
                    Total (CLP)
                </td>
                <td></td>
                <td style="text-align: right;">
                    {{ money($dte->tgrPayedDte?->monto) }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

<table class="nueve" width="100%" style="text-align: center; margin-top: 30px;">
    <tr>
        <td width="120px"></td>
        <td style="border-bottom: 1px solid black;">00000000-0-InterPPC</td>
        <td width="120px"></td>
        <td style="border-bottom: 1px solid black;">00000000-0-InterPPC</td>
        <td width="120px"></td>
    </tr>
    <tr>
        <td></td>
        <td>Usuario Generador</td>
        <td></td>
        <td>Usuario Aprobador</td>
        <td></td>
    </tr>
</table>


@endsection
