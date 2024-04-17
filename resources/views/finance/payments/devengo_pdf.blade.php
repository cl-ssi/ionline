@extends('layouts.sigfe_document')

@section('title', 'Devengo Sigfe')

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
        Contabilidad
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
        <td style="width:100px">{{ $dte->comparativeRequirement?->devengo_fecha }}</td>
    </tr>
    <tr>
        <th>Tipo de Transacción</td>
        <td style="width:160px">Creación</td>
        <th style="width:94px">Proceso Fuente</th>
        <td style="width:100px">Devengo</td>
    </tr>
    <tr>
        <th>Tipo de Movimiento</td>
        <td style="width:160px">Financiero</td>
        <th style="width:94px">Identificación de Transferencia de Datos</th>
        <td style="width:100px"></td>
    </tr>
    <tr>
        <th>Origen del Ajuste</td>
        <td style="width:160px"></td>
        <th style="width:94px">Folio Anterior</th>
        <td style="width:100px"></td>
    </tr>
    <tr>
        <th>Usuario Aprobador</td>
        <td style="width:160px">interDTE</td>
        <th style="width:94px">Origen Transacción</th>
        <td style="width:100px">Sistema Vertical DTE</td>
    </tr>

</table>
<br>
<div style="margin-top: 60px; padding-left: 9px; font-size: 1.3rem">
    <strong style="">
        Contabilidad
    </strong>
</div>

    <table class="tabla-items" style="font-size: 1.05em;">
        <thead>
            <tr>
                <th width="100px">Cuenta Contable</th>
                <th width="100px">Monto Debe<br>(CLP)</th>
                <th width="100px">Monto Haber<br>(CLP)</th>
            </tr>
        </thead>
        <tbody style="font-size: 1.1em;">
            @foreach($dte->tgrAccountingPortfolios as $accountingPortfolio)
                <tr>
                    
                    <td>{{ $accountingPortfolio->cuenta_contable }}</td>
                    <td>{{ $accountingPortfolio->debe ?? 0 }} </td>
                    <td>{{ $accountingPortfolio->haber ?? 0 }} </td>
                </tr>
            @endforeach
            <tr class="negrita ocho">
                <td>
                    Total (CLP)
                </td>
                <td>{{ $dte->totalDebe() }}</td>
                <td>{{ $dte->totalHaber() }}</td>  
            </tr>
        </tbody>
    </table>

    <br>
    <div style="margin-top: 60px; padding-left: 9px; font-size: 1.3rem">
        <strong style="">
            Cartera Financiera
        </strong>
    </div>


    <table class="tabla-items" style="font-size: 1.05em;">
        <thead>
            <tr>
                <th width="100px">Cuenta Contable</th>
                <th width="100px">Monto Debe<br>(CLP)</th>
                <th width="100px">Monto Haber<br>(CLP)</th>
            </tr>
        </thead>
        <tbody style="font-size: 1.1em;">
            @foreach($dte->tgrAccountingPortfolios as $accountingPortfolio)
                <tr>
                    
                    <td>{{ $accountingPortfolio->cuenta_contable }}</td>
                    <td>{{ $accountingPortfolio->debe ?? 0 }} </td>
                    <td>{{ $accountingPortfolio->haber ?? 0 }} </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="padding-top: 5px; padding-bottom: 5px;">
                        <center>Cartera Financiera</center>
                        <strong>Principal:</strong>{{ $dte->tgrPayedDte?->principal }}<br>
                        <strong>Monto Debe Dcto :</strong>0<br>
                        <strong>Monto Haber Dcto :</strong>{{ $dte->totalHaber() }}
                </td>

            </tr>
        </tbody>
    </table>

    <table class="tabla-items" style="font-size: 1.05em;">
        <thead>
            <tr>
                <th>Beneficiario</th>
                <th>Nº<br>Documento</th>
                <th>Fecha <br>Documento</th>
                <th>Tipo<br>Documento</th>
                <th>Descripcion</th>
                <th>Monto<br>Debe<br>Dcto</th>
                <th>Monto<br>Haber<br>Dcto</th>
                <th>Moneda Origen</th>
                <th>Fecha<br>Tipo<br>Cambio</th>
                <th>Tipo<br>Cambio</th>
                <th>Monto<br>MO</th>
            </tr>
        </thead>
        <tbody style="font-size: 1.1em;">
            <tr>
                <td>xxx1</td>
                <td>xxx2</td>
                <td>xxx3</td>
                <td>xxx4</td>
                <td>xxx5</td>
                <td>xxx6</td>
                <td>xxx7</td>
                <td>xxx8</td>
                <td>xxx9</td>
                <td>xxx10</td>
                <td>xxx11</td>
            </tr>
        </tbody>
        <tr>
            <td colspan="11">Fechas Cumplimiento</td>
        </tr>
        <thead>
            <tr>
                <th>Combinaciòn de Catàlogos</th>
                <th>Fecha Cumplimiento </th>
                <th>Monto Debe</th>
                <th>Monto Haber</th>
                <th>Monto Debe M/O</th>
                <th>Monto Haber M/O</th>
            </tr>
        </thead>
        <tbody style="font-size: 1.1em;">
            <tr>
                <td>xxx1</td>
                <td>xxx2</td>
                <td>xxx3</td>
                <td>xxx4</td>
                <td>xxx5</td>
                <td>xxx6</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td>xxx2</td>
                <td>xxx3</td>
                <td>xxx4</td>
                <td>xxx5</td>
                <td>xxx6</td>

            </tr>
        </tbody>
    </table>

Monto Total Cartera Debe:xxx<br>
Monto Total Cartera Haber:xxx<br>



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