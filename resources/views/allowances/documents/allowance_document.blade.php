@extends('allowances.documents.layouts')

@section('title', "Viático")

@section('content')

<div style="width: 49%; display: inline-block;">
    <div class="siete">
        
    </div>
</div>

<div class="right" style="width: 50%; display: inline-block;">
    <b>RESOLUCION EXENTA N°</b>: {{ $allowance->folio_sirh }} <br>
    Iquique, {{ $allowance->created_at->format('d-m-Y H:i') }}
</div>

<div style="clear: both; padding-bottom: 10px">&nbsp;</div>

<div class="siete">
    VISTOS: Decreto Ley 2763/79 Salud, Art. 14 del Reglamento de los Servicios de Salud, 
    Decreto 262/77 de Hacienda, que aprobó el Reglamento de Viáticos, Resolución 1050/80 de 
    la Contraloría General de la República.
</div>

<div style="clear: both; padding-bottom: 15px">&nbsp;</div>

<div class="left"><b>1-. Descripción de Viático</b></div>
<br>

<table class="siete">
    <tbody>
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
            <td colspan="2"></td>
            <td colspan="2">{{ $allowance->allowanceValue->name }}</td>
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
            <td>{{-- $allowance->destinationCommune->name --}}</td>
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
            <td colspan="2">{{-- $allowance->from->format('d-m-Y') --}}</td>
            <td colspan="2">{{-- $allowance->to->format('d-m-Y') --}}</td>
        </tr>
    </tbody>
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
    <b>NOTA</b>: EL CUMPLIMIENTO DE ESTE COMETIDO ES DE RESPONSABILIDAD DEL JEFE DIRECTO, 
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

@endsection