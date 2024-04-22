@extends('layouts.sigfe_document')

@section('title', 'Devengo Sigfe')

@section('content')

<style>
        .tabla-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
            padding-left: 14px;
        }

        .tabla-custom tr {
        }

        .tabla-custom th {
            text-align: left;
            /* padding-left: 10px; */
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
            line-height: 100%; 
            padding-top: 2px; 
            padding-bottom: 2px;
        }

        .tabla-items td {
            padding-left: 10px;
            padding-top: 3px;
            padding-bottom: 3x;
            border: 1px solid black;
        }

        .tabla-cumplimiento {
            width: 99%;
            border-collapse: collapse;
            padding-bottom: 18px;
        }

        .tabla-cumplimiento thead {
            background-color: black;
            color: white;
            font-weight: bold;
            text-align: center;
            vertical-align: top;
        }
        
        .tabla-cumplimiento td {
            text-align: center;
        }

        hr {
            margin-bottom: 0px;
        }

        .margen-wn {
            padding-left: 10px;
        }
</style>

@section('linea1', 'Ministerio de Salud')

<div style="margin-top: 120px; padding-left: 9px; font-size: 1.3rem">
    <strong style="">
        Contabilidad
    </strong>
</div>

<hr>

<table class="tabla-custom" style="font-size: 1.2em;">
    <tr>
        <th>Institución / Área Transaccional</th>
        <td colspan="3">Servicio de Salud Iquique / Hospital de Alto Hospicio</td>
    </tr>
    <tr>
        <th class="margen-wn" class="margen-wn">Título</th>
        <td colspan="3">
            {{ $dte->comparativeRequirement?->devengo_titulo  }}
        </td>
    </tr>
    <tr>
        <th class="margen-wn">Descripción</th>
        <td colspan="3">
            {{ $dte->comparativeRequirement?->devengo_titulo }} @if($dte->paid_automatic) @endif 
        </td>
    </tr>
    <tr>
        <th width="150px" class="margen-wn">Periodo de Operación</td>
        <td width="190px">{{ ucfirst($dte->tgrPayedDte?->fecha_generacion->monthName) }}</td>
        <th width="165px" class="margen-wn">Ejercicio Fiscal</th>
        <td></td>
    </tr>
    <tr>
        <th class="margen-wn">Folio</td>
        <td>{{ $dte->comparativeRequirement?->devengo_folio }}</td>
        <th class="margen-wn">Fecha y Hora de Aprobación</th>
        <td>{{ $dte->comparativeRequirement?->devengo_fecha }}</td>
    </tr>
    <tr>
        <th class="margen-wn">Tipo de Transacción</td>
        <td>Creación</td>
        <th class="margen-wn">Proceso Fuente</th>
        <td>Devengo</td>
    </tr>
    <tr>
        <th class="margen-wn">Tipo de Movimiento</td>
        <td>Financiero</td>
        <th class="margen-wn">Identificación de Transferencia de Datos</th>
        <td></td>
    </tr>
    <tr>
        <th class="margen-wn">Origen del Ajuste</td>
        <td></td>
        <th class="margen-wn">Folio Anterior</th>
        <td></td>
    </tr>
    <tr>
        <th class="margen-wn">Usuario Aprobador</td>
        <td>interDTE</td>
        <th class="margen-wn">Origen Transacción</th>
        <td>Sistema Vertical DTE</td>
    </tr>
</table>

<br>

<div style="margin-top: 20px; padding-left: 0px; font-size: 1.2rem; margin-bottom: 16px;">
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
    <div style="margin-top: 30px; padding-left: 9px; font-size: 1.2rem; margin-bottom: 16px;">
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
                <td colspan="3" style="padding-top: 15px; padding-bottom: 2px; font-size: 14px;">
                        <center><strong>Cartera Financiera</strong></center>
                        <strong>Principal : </strong>{{ $dte->tgrPayedDte?->principal }} 
                        <strong>Monto Debe Dcto : </strong>0<br>
                        <strong>Monto Haber Dcto : </strong>{{ $dte->totalHaber() }} 
                </td>

            </tr>
        </tbody>
    </table>

    <table class="tabla-items" style="font-size: 1.05em;">
        <thead>
            <tr>
                <th>Beneficiario</th>
                <th>Nº Documento</th>
                <th>Fecha Documento</th>
                <th>Tipo Documento</th>
                <th>Descripcion</th>
                <th>Monto Debe Dcto</th>
                <th style="">Monto Haber Dcto</th>
                <th>Moneda Origen</th>
                <th>Fecha Tipo Cambio</th>
                <th>Tipo Cambio</th>
                <th>Monto MO</th>
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

            <tr>
                <td colspan="11" style="text-align: center; padding-top: 15px;">
                    <strong>Fechas Cumplimiento</strong>
                    <table class="tabla-cumplimiento">
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
                                <td width="110"  style="text-align: center;">Propio Contabilidad - 00 -
                                    No Aplica</td>
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

                </td>
            </tr>
        </tbody>
    </table>

    <div class="margen-wn ocho" style="margin-top: 20px;">
        <div><strong>Monto Total Cartera Debe : </strong> 0<div>
        <div><strong>Monto Total Cartera Haber :</strong> 22.610</div>
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

<div style="margin-top: 30px;">
    Usuario Responsable : 16350071 - Nibaldo Andrés Quinzacara Carpier
</div>

@endsection