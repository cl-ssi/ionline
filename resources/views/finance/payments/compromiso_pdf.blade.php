@extends('layouts.sigfe_document')

@section('title', 'Compromiso Sigfe')

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
        Compromiso
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
    </tr>
    <tr>
        <th>Folio</td>
        <td style="width:160px">{{ $dte->comparativeRequirement?->devengo_folio }}</td>
        <th style="width:94px">Fecha y Hora de Aprobación</th>
        <td style="width:100px"></td>
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

@endsection