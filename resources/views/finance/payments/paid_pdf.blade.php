@extends('layouts.sigfe_document')

@section('title', 'Comprobante de Liquidación de Fondo')

@section('content')
    <style>
        .tabla-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 6px; 
            /* padding: 0 10 0 10px; */
        }
        .tabla-custom tr {

        }
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
            /* padding: 0 10 0 10px; */
        }

        .tabla-items thead {
            background-color: black; color: white;
            font-weight: bold;
            text-align: center;
            vertical-align: top;

        }
        .tabla-items tr {

        }
        .tabla-items th {
            border: 1px solid black;
            padding: 0px;
            padding: 8px 0 3px 0;
            line-height: 0.5;
        }

        .tabla-items td {
            padding-left: 10px;
            padding-top: 2px;
            padding-bottom: 2x;
            /* padding: 8px 0 8px 10px 10px; */
            border: 1px solid black;
        }
    </style>

    @section('linea1','Ministerio de Salud')

    <div style="margin-top: 124px; padding-left: 9px; font-size: 1.3rem">
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
            <td colspan="7">{{ $dte->comparativeRequirement?->devengo_titulo ?? 'Pago Automático:FA / 7347095 / 99017000 / 1272565-375-SE23 / SEGUROS GENERALES' }}</td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td colspan="7">{{ $dte->comparativeRequirement?->devengo_titulo ?? 'Pago Automático:FA / 7347095 / 99017000 / 1272565-375-SE23 / SEGUROS GENERALES'  }}</td>
        </tr>
        <tr>
            <th>Periodo de Operación</td>
            <td style="width:160px">Septiembre</td>
            <th style="width:94px">Ejercicio Fiscal</th>
            <td style="width:100px">2023</td>
            <th style="width:90px">ID</th>
            <td style="width:140px">42803425</td>
            <th style="width:120px">Folio</th>
            <td>{{ $dte->comparativeRequirement?->efectivo_folio }}</td>
        </tr>
        <tr>
            <th>Fecha y Hora de Aprobación</th>
            <td>{{ $dte->tgrPayedDte?->fecha_generacion }}</td>
            <th>Tipo de Transacción</th>
            <td>Creación ¿?</td>
            <th>Tipo de Operación</th>
            <td>{{ $dte->tgrPayedDte?->tipo_operacion }} Pagos a Terceros</td>
            <th>Identificación de Transferencia de Datos</th>
            <td>¿?</td>
        </tr>
        <tr>
            <th>Origen del Ajuste</th>
            <td>¿?</td>
            <th>Folio Anterior</th>
            <td>¿?</td>
        </tr>
    </table>

    <br><br><br>

    <div style="border: 2px solid black; padding: 6px">

        <table class="tabla-custom nueve">
            <tr>
                <th width="108px;">Principal</th>
                <td class="negrita">{{ $dte->tgrPayedDte?->principal }} 9901700-2 SEGUROS GENERALES SUDAMERICA S.A.</td>
            </tr>
        </table>

        <table class="tabla-items siete">
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
            <tbody>
                <tr>
                    <td>{{ $dte->tgrPayedDte?->tipo_documento }} Factura Afecta Electrónica</td>
                    <td>{{ $dte->tgrPayedDte?->folio_documento }} 734095</td>
                    <td>{{ $dte->tgrPayedDte?->moneda }} CLP</td>
                    <td>{{ $dte->tgrAccountingPortfolio?->cuenta_contable }} 21522 Cuentas por Pagar - Bienes y Servicios de Consumo</td>
                    <td>{{ $dte->tgrPayedDte?->banco_cta_corriente }}</td>
                    <td>{{ $dte->tgrPayedDte?->medio_pago }} Transferencia Electrónica de Fondos</td>
                    <td>{{ $dte->tgrPayedDte?->nro_documento_pago }}</td>
                    <td>{{ $dte->tgrPayedDte?->moneda }}</td>
                    <td style="text-align: right;">{{ $dte->tgrPayedDte?->monto }}</td>
                </tr>
                <tr class="negrita ocho">
                    <td colspan="7">Total (CLP)</td>
                    <td></td>
                    <td style="text-align: right;">4.629.971</td>
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
