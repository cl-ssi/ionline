<?php setlocale(LC_ALL, 'es'); ?>
<html lang="es">

<head>
    <meta charset="utf-8">

    <title>Viático</title>

    <meta name="description" content="">
    <meta name="author" content="Servicio de Salud Tarapacá">

    <style media="screen">
        body {
          font-family: Arial, Helvetica, sans-serif;
          font-size: 0.75rem;
        }

        .content {
          margin: 0 auto;
          /*border: 1px solid #F2F2F2;*/
          width: 724px;
          /*height: 1100px;*/
        }

        .monospace {
          font-family: "Lucida Console", Monaco, monospace;
        }

        .pie_pagina {
          margin: 0 auto;
          /*border: 1px solid #F2F2F2;*/
          width: 724px;
          height: 26px;
          position: fixed;
          bottom: 0;
        }

        .seis {
          font-size: 0.6rem;
        }

        .siete {
          font-size: 0.7rem;
        }

        .ocho {
          font-size: 0.8rem;
        }

        .nueve {
          font-size: 0.9rem;
        }

        .plomo {
          background-color: F3F1F0;
        }

        .titulo {
          text-align: center;
          font-size: 1.2rem;
          font-weight: bold;
          padding: 4px 0 6px;
        }

        .center {
          text-align: center;
        }

        .left {
          text-align: left;
        }

        .right {
          text-align: right;
        }

        .justify {
          text-align: justify;
        }

        .indent {
          text-indent: 30px;
        }

        .uppercase {
          text-transform: uppercase;
        }

        #firmas {
          margin-top: 80px;
        }

        #firmas>div {
          display: inline-block;
        }

        .li_letras {
          list-style-type: lower-alpha;
        }

        table {
          border: 1px solid grey;
          border-collapse: collapse;
          padding: 0 4px 0 4px;
          width: 100%;
        }

        th,
        td {
          border: 1px solid grey;
          border-collapse: collapse;
          padding: 0 4px 0 4px;
        }

        .column {
          float: left;
          width: 50%;
        }

        /* Clear floats after the columns */
        .row:after {
          content: "";
          display: table;
          clear: both;
        }

        .aprove {
            border: 1px solid #cccccc;
            padding: 0 4px 0 4px;
            font-size: 90%;
            width: 230;
        }

        @media all {
          .page-break {
            display: none;
          }
        }

        @media print {
          .page-break {
            display: block;
            page-break-before: always;
          }
        }
    </style>
</head>

<body>
    <div class="content">
        <img style="padding-bottom: 4px;" src="images/logo_pluma.jpg" width="120" alt="Logo Servicio de Salud"><br>

        <div class="right" style="float: right; width: 340px;">
            <div class="left" style="padding-bottom: 6px;">
                <strong>RESOLUCION EXENTA N°:</strong> {{ $allowance->folio_sirh }}
            </div>
            <div class="left" style="padding-bottom: 2px;">
                <strong>Iquique, {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</strong>
            </div>
        </div>

        <div style="clear: both; padding-bottom: 10px">&nbsp;</div>

        <div class="siete">VISTOS: Decreto Ley 2763/79 Salud, Art. 14 del Reglamento de los Servicios de Salud, 
          Decreto 262/77 de Hacienda, que aprobó el Reglamento de Viáticos, Resolución 1050/80 de 
          la Contraloría General de la República.
        </div>

        <div style="clear: both; padding-bottom: 15px">&nbsp;</div>

        <div class="left"><b>1-. Descripción de Viático</b></div>
        <br>
        <table class="siete">
            <tr>
                <th rowspan="2" style="width: 20%">Sección I</th>
                <th style="width: 40%" colspan="2">Nombre Completo</th>
                <th style="width: 20%">RUN</th>
                <th style="width: 20%">Calidad</th>
            </tr>
            <tr align="center">
                <td colspan="2">{{ $allowance->userAllowance->fullName }}</td>
                <td>{{ $allowance->userAllowance->id }}-{{ $allowance->userAllowance->dv }}</td>
                <td>{{ $allowance->ContractualConditionValue }}</td>
            </tr>

            <tr>
                <th rowspan="2">Sección II</th>
                <th colspan="2">Cargo / Función</th>
                <th colspan="2">Gr. Cat. horas</th>
            </tr>
            <tr align="center">
                <td colspan="2">{{ $allowance->position }}</td>
                <td>{{ $allowance->allowanceValue->name }}</td>
                <td>{{ $allowance->grade }}</td>
            </tr>

            <tr>
                <th rowspan="2" style="width: 25%">Sección III</th>
                <th colspan="2">Establecimiento</th>
                <th colspan="2">Unidad o Sección</th>
            </tr>
            <tr align="center">
                <td colspan="2">{{ $allowance->organizationalUnitAllowance->establishment->name }}</td>
                <td colspan="2">{{ $allowance->organizationalUnitAllowance->name }}</td>
            </tr>

            <tr>
                <th rowspan="2" style="width: 20%">Sección IV</th>
                <th width="20%">Origen</th>
                <th width="20%">Destino</th>
                <th width="20%">Lugar</th>
                <th width="20%">Motivo</th>
            </tr>
            <tr align="center">
                <td>{{ $allowance->originCommune->name }}</td>
                <td>{{ $allowance->destinationCommune->name }}</td>
                <td>{{ $allowance->place }}</td>
                <td>{{ $allowance->reason }}</td>
            </tr>

            <tr>
                <th rowspan="2" style="width: 20%">Sección V</th>
                <th>Medio de transporte</th>
                <th>Itinerario</th>
                <th>Derecho de pasaje</th>
                <th>Pernocta fuera del lugar de residencia</th>
            </tr>
            <tr align="center">
                <td>{{ $allowance->MeansOfTransportValue }}</td>
                <td>{{ $allowance->RoundTripValue }}</td>
                <td>{{ $allowance->PassageValue }}</td>
                <td>{{ $allowance->OvernightValue }}</td>
            </tr>

            <tr>
                <th rowspan="2" style="width: 20%">Sección VI</th>
                <th colspan="2">Desde</th>
                <th colspan="2">Hasta</th>
            </tr>
            <tr align="center">
                <td colspan="2">{{ $allowance->from->format('d-m-Y') }}</td>
                <td colspan="2">{{ $allowance->to->format('d-m-Y') }}</td>
            </tr>
        </table>

        <div style="clear: both; padding-bottom: 10px">&nbsp;</div>

        <div class="left"><b>2-. Resumen</b></div>
        <br>
        <table class="siete">
            <tbody>
                <tr>
                    <th width="25%">Viático</th>
                    <th width="25%">Valor</th>
                    <th width="25%">N° Días</th>
                    <th width="25%">Valor Total</th>
                </tr>
                <tr>
                    <th align="left">1. DIARIO</th>
                    <td align="right">
                        ${{ $allowance->day_value ? number_format($allowance->day_value, 0, ",", ".") : number_format($allowance->allowanceValue->value, 0, ",", ".") }}
                    </td>
                    <td align="center">{{ intval($allowance->total_days) }}</td>
                    <td align="right">
                        ${{ ($allowance->total_days >= 1) ? number_format(($allowance->day_value * intval($allowance->total_days)), 0, ",", ".") : '0' }}
                    </td>
                </tr>
                <tr>
                    <th align="left">2. PARCIAL</th>
                    <td align="right">
                        ${{ number_format($allowance->half_day_value, 0, ",", ".") }}
                    </td>
                    <td align="center">0,5</td>
                    <td align="right">${{ number_format($allowance->half_day_value, 0, ",", ".") }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td align="center"><b>Total</b></td>
                    <td align="right">${{ number_format($allowance->total_value, 0, ",", ".") }}</td>
                </tr>
            </tbody>
        </table>
        
        <div style="clear: both; padding-bottom: 20px">&nbsp;</div>

        <div class="siete">
            <b>NOTA</b>:	 EL CUMPLIMIENTO DE ESTE COMETIDO ES DE RESPONSABILIDAD DEL JEFE DIRECTO, 
            SOLIDARIAMENTE CON LA PERSONA QUE DISPONGA EL PAGO.
        </div>

        <div style="clear: both; padding-bottom: 3px">&nbsp;</div>
        
        <div class="siete">
            AL TERMINO DE ESTE COMETIDO DEBERA ENTREGAR AL JEFE DE CONTABILIDAD EL BOLETO DE TRANSPORTE USADO.
        </div>

        <div style="clear: both; padding-bottom: 3px">&nbsp;</div>

        <div class="siete">
            EL ANTICIPO DE VIATICO DEBERA REINTEGRARSE DENTRO DE LAS 48 HORAS DE REALIZADO EL COMETIDO. 
        </div>
    </div>

    <br>

    <!-- <div class="aprove">
        <em>Aprobado digitalmentes el {{ now() }} por:</em><br>
        <span style="font-size: 110%;">
            <b>{{ auth()->user()->fullName }}</b> <br>
        </span>
        <span style="font-size: 100%;">
            {{ optional(auth()->user()->organizationalUnit)->name }} <br>
        </span>
        {{ optional(auth()->user()->organizationalUnit)->establishment->name }}<br>
    </div> -->


</body>

</html>
