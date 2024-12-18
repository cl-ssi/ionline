@extends('layouts.document')

@section('title', 'Viático ' . $allowance->id)

@section('content')

    <style>
        .tabla th,
        .tabla td {
            padding: 3px;
            /* Ajusta este valor a tus necesidades */
        }

        .totales {
            margin-left: auto;
            margin-right: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .nowrap {
            white-space: nowrap;
        }
        
        .signature-container {
            height: 160px;
        }
        
    </style>

    <div style="float: right; width: 300px; padding-top: 66px;">

        <div class="left quince"
            style="padding-left: 2px; padding-bottom: 10px;">
            <strong style="text-transform: uppercase; padding-right: 30px;">
                @if($allowance->establishment_id == App\Models\Parameters\Parameter::get('establishment', 'HospitalAltoHospicio'))
                    RESOLUCION EXENTA N°: {{ ($allowance->correlative) ? $allowance->correlative.' - '.$allowance->created_at->format('Y')  : $allowance->id }}
                @else
                    RESOLUCION EXENTA N°: {{ ($allowance->correlative) ? $allowance->correlative : $allowance->id }}
                @endif
            </strong>
        </div>

        <div style="padding-top:5px; padding-left: 2px;">
            Iquique, {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
        </div>
    </div>

    <div style="clear: both; padding-bottom: 35px"></div>

    <div class="siete">VISTOS: Decreto Ley 2763/79 Salud, Art. 14 del Reglamento de los Servicios de Salud, 
        Decreto 262/77 de Hacienda, que aprobó el Reglamento de Viáticos, Resolución 1050/80 de 
        la Contraloría General de la República.
    </div>

    <div style="clear: both; padding-bottom: 25px"></div>

    <div class="left"><b>1-. Descripción de Viático</b></div>

    <div style="clear: both; padding-bottom: 5px"></div>

    <table class="tabla">
        <tr>
            <th style="width: 40%; background-color: #EEEEEE;">Nombre Completo</th>
            <th style="width: 20%; background-color: #EEEEEE;">RUN</th>
            <th style="width: 20%; background-color: #EEEEEE;">Calidad</th>
            <th style="width: 20%; background-color: #EEEEEE;">Calidad</th>
        </tr>
        <tr align="center">
            <td>{{ $allowance->userAllowance->fullName }}</td>
            <td>{{ $allowance->userAllowance->id }}-{{ $allowance->userAllowance->dv }}</td>
            <td>{{ $allowance->contractualCondition->name }}</td>
            <td>N° {{ number_format($allowance->law, 0, ",", ".") }}</td>
        </tr>

        <tr>
            <th colspan="2" style="background-color: #EEEEEE;">Cargo / Función</th>
            <th colspan="2" style="background-color: #EEEEEE;">Gr. Cat. horas</th>
        </tr>
        <tr align="center">
            <td colspan="2">{{ $allowance->position }}</td>
            <td>{{ $allowance->allowanceValue->name }}</td>
            <td>{{ $allowance->grade }}</td>
        </tr>

        <tr>
            <th colspan="2" style="background-color: #EEEEEE;">Establecimiento</th>
            <th colspan="2" style="background-color: #EEEEEE;">Unidad o Sección</th>
        </tr>
        <tr align="center">
            <td colspan="2">{{ $allowance->organizationalUnitAllowance->establishment->name }}</td>
            <td colspan="2">{{ $allowance->organizationalUnitAllowance->name }}</td>
        </tr>

        <tr>
            <th colspan="4" style="background-color: #EEEEEE;">Motivo</th>
        </tr>
        <tr align="center">
            <td colspan="4">{{ $allowance->reason }}</td>
        </tr>
    </table>

    <div style="clear: both; padding-bottom: 15px"></div>

    <div class="left"><b>2-. Origen / Destino(s)</b></div>

    <div style="clear: both; padding-bottom: 5px"></div>

    <table class="tabla">
        <tr>
            <th style="background-color: #EEEEEE;" colspan="3">Origen</th>
        </tr>
        <tr>
            <td align="center" colspan="3">{{ $allowance->originCommune->name }}</td>
        </tr>
        <tr class="table-active">
            <th width="33%" style="background-color: #EEEEEE;">Comuna</th>
            <th width="33%" style="background-color: #EEEEEE;">Localidad</th>
            <th width="33%" style="background-color: #EEEEEE;">Descripción</th>
        </tr>
        @foreach($allowance->destinations as $destination)
        <tr align="center">
            <td>{{ $destination->commune->name }}</td>
            <td>{{ ($destination->locality) ? $destination->locality->name : '' }}</td>
            <td>{{ $destination->description }}</td>
        </tr>
        @endforeach
    </table>

    <div style="clear: both; padding-bottom: 15px"></div>

    <div class="left"><b>3-. Información de Itinerario</b></div>

    <div style="clear: both; padding-bottom: 5px"></div>

    <table class="tabla">
        <tr>
            <th width="33%" style="background-color: #EEEEEE;">Medio de transporte</th>
            <th width="33%" style="background-color: #EEEEEE;">Itinerario</th>
            <th width="33%" style="background-color: #EEEEEE;">Derecho de pasaje</th>
        </tr>
        <tr align="center">
            <td>{{ $allowance->MeansOfTransportValue }}</td>
            <td>{{ $allowance->RoundTripValue }}</td>
            <td>{{ $allowance->PassageValue }}</td>
        </tr>
        <tr>
            <th style="background-color: #EEEEEE;">Pernocta fuera del lugar de residencia</th>
            <th style="background-color: #EEEEEE;">Alojamiento *</th>
            <th style="background-color: #EEEEEE;">Alimentación *</th>
        </tr>
        <tr align="center">
            <td>{{ $allowance->OvernightValue }}</td>
            <td>{{ $allowance->AccommodationValue }}</td>
            <td>{{ $allowance->FoodValue }}</td>
        </tr>
        <tr class="table-active">
            <th style="background-color: #EEEEEE;">Desde</th>
            <th style="background-color: #EEEEEE;">Hasta</th>
            <th style="background-color: #EEEEEE;">Sólo medios días</th>
        </tr>
        <tr align="center">
            <td>{{ $allowance->FromFormat }}</td>
            <td>{{ $allowance->ToFormat }}</td>
            <td>{{ $allowance->HalfDaysOnlyValue }}</td>
        </tr>
    </table>

    <div style="clear: both; padding-bottom: 15px"></div>

    <div class="left"><b>4-. Resumen</b></div>

    <div style="clear: both; padding-bottom: 5px"></div>

    <table class="tabla">
        <tr>
            <th width="20%" style="background-color: #EEEEEE;">Viático</th>
            <th width="20%" style="background-color: #EEEEEE;">%</th>
            <th width="20%" style="background-color: #EEEEEE;">Valor</th>
            <th width="20%" style="background-color: #EEEEEE;">N° Días</th>
            <th width="20%" style="background-color: #EEEEEE;">Valor Total</th>
        </tr>
        <tr>
            <td><b>1. DIARIO</b></td>
            <td align="center">100%</td>
            <td align="right">
                ${{ ($allowance->day_value) ? number_format($allowance->day_value, 0, ",", ".") : number_format($allowance->allowanceValue->value, 0, ",", ".") }}
            </td>
            <td align="center"> 
                {{ ($allowance->total_days) ? intval($allowance->total_days) : 0 }}
            </td>
            <td align="right">
                ${{ ($allowance->total_days >= 1) ? number_format(($allowance->day_value * intval($allowance->total_days)), 0, ",", ".") : '0' }}
            </td>
        </tr>
        <tr>
            <td><b>2. PARCIAL</b></td>
            <td align="center">40%</td>
            <td align="right">
                ${{ ($allowance->half_day_value) ? number_format($allowance->half_day_value, 0, ",", ".") : '0' }}
            </td>
            <td align="center">
                {{ ($allowance->total_half_days) ? intval($allowance->total_half_days) : 0 }}
                @if($allowance->total_half_days && $allowance->total_half_days > 1)
                    medios días
                @elseif($allowance->total_half_days && $allowance->total_half_days == 1)
                    medio día
                @else

                @endif
            </td>
            <td align="right">
                ${{ ($allowance->half_day_value) ? number_format($allowance->half_day_value * $allowance->total_half_days, 0, ",", ".") : '' }}
            </td>
        </tr>
        <tr>
            <td><b>3. PARCIAL</b></td>
            <td align="center">50%</td>
            <td align="right">${{ ($allowance->fifty_percent_day_value) ? number_format($allowance->fifty_percent_day_value, 0, ",", ".") : '0' }}</td>
            <td align="center">{{ ($allowance->fifty_percent_total_days) ? intval($allowance->fifty_percent_total_days) : 0 }}</td>
            <td align="right">${{ ($allowance->fifty_percent_day_value) ? number_format($allowance->fifty_percent_day_value * $allowance->fifty_percent_total_days, 0, ",", ".") : '' }}</td>
        </tr>
        <tr>
            <td><b>4. PARCIAL</b></td>
            <td align="center">60%</td>
            <td align="right">${{ ($allowance->sixty_percent_day_value) ? number_format($allowance->sixty_percent_day_value, 0, ",", ".") : '0' }}</td>
            <td align="center">{{ ($allowance->sixty_percent_total_days) ? intval($allowance->sixty_percent_total_days) : 0 }}</td>
            <td align="right">${{ ($allowance->sixty_percent_day_value) ? number_format($allowance->sixty_percent_day_value * $allowance->sixty_percent_total_days, 0, ",", ".") : '' }}</td>
        </tr>
        <tr>
            <td colspan="3"></td>                    
            <td align="center"><b>Total</b></td>
            <td align="right">
                ${{ number_format($allowance->total_value, 0, ",", ".") }}
            </td>
        </tr>
    </table>

    <div style="clear: both; padding-bottom: 10px">&nbsp;</div>

    <div class="siete">
        <b>NOTA</b>:	 EL CUMPLIMIENTO DE ESTE COMETIDO ES DE RESPONSABILIDAD DEL JEFE DIRECTO, 
        SOLIDARIAMENTE CON LA PERSONA QUE DISPONGA EL PAGO.
    </div>
        
    <div class="siete">
        AL TERMINO DE ESTE COMETIDO DEBERA ENTREGAR AL JEFE DE CONTABILIDAD EL BOLETO DE TRANSPORTE USADO.
    </div>

    <div class="siete">
        EL ANTICIPO DE VIATICO DEBERA REINTEGRARSE DENTRO DE LAS 48 HORAS DE REALIZADO EL COMETIDO. 
    </div>

    <!-- Sección de las aprobaciones -->
    <div class="signature-container">
        <div class="signature" style="padding-left: 32px;">
            {{--
            @include('sign.approvation', [
                'approval' => $allowance->approvalLegacy,
            ])
            --}}
        </div>
        
        <div class="signature" style="padding-left: 6px; padding-right: 6px;">
            @if($approvals = $allowance->approvals->where('position', 'center'))
                @foreach($approvals as $approval)
                    @include('sign.approvation', [
                        'approval' => $approval,
                    ])
                @endforeach
            @endif
        </div>
        <div class="signature">
            @if($approvals = $allowance->approvals->where('position', 'right'))
                @foreach($approvals as $approval)
                    @include('sign.approvation', [
                        'approval' => $approval,
                    ])
                @endforeach
            @endif
        </div>
    </div>
@endsection
