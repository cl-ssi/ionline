@extends('layouts.record')

@section('title', 'Solicitud de devolución de horas extras')

@section('linea1', $record->organizationalUnit->name)

@section('content')

    <style>
        .tabla th, .tabla td {
            border: 1px solid black;
            padding: 5px; /* Ajusta el espacio entre el texto y los bordes según tus preferencias */
        }
    </style>

    <div style="float: right; width: 300px; padding-top: 66px;">

        <div class="left quince" style="padding-left: 2px; padding-bottom: 10px;">
            <strong style="text-transform: uppercase; padding-right: 30px;">
                Número:
            </strong>
            <span class="catorce negrita">{{ $record->id }}</span>
        </div>

        <div style="padding-top:5px; padding-left: 2px;">
            Iquique, {{ $record->created_at->day }} de {{ $record->created_at->monthName }} del
            {{ $record->created_at->year }}
        </div>

    </div>

    <div style="clear: both; padding-bottom: 35px"></div>

    <div class="center diez">
        <strong style="text-transform: uppercase;">
            SOLICITUD MENSUAL DE HORAS EXTRAORDINARIAS
        </strong>
    </div>

    <br>

    <table>
        <tr>
            <th class="left">Solicitante:</th>
            <td>{{ $record->user->fullName }} ({{ $record->user->run }})</td>
            <td width="100"></td>
            <th class="left">Tipo de solicitud:</th>
            <td>{{ $record->type->getLabel() }} </td>
        </tr>
        <tr>
            <th class="left">Unidad Solicitante:</th>
            <td>{{ $record->user->organizationalUnit->name }} </td>
            <td width="100"></td>
            <th class="left">Grado:</th>
            <td>{{ $record->grado }} </td>
        </tr>
        <tr>
            <th class="left">Jefatura Directa:</th>
            <td>{{ $record->user->boss->shortName }} </td>
            <td width="100"></td>
            <th class="left">Planta:</th>
            <td>{{ $record->planta }} </td>
        </tr>

    </table>

    <br>

    @foreach ($record->getWeeks() as $week)
        @if($week['days'])
            <table class="tabla">
                <tr>
                    <th>Fecha</th>
                    <th>Horas Diurnas</th>
                    <th>Horas Nocturnas</th>
                    <th>Justificación</th>
                </tr>
                @foreach ($week['days'] as $days)
                    <tr>
                        <td width="60">{{ $days['date'] }}</td>
                        <td width="74" class="right">{{ $days['hours_day'] }} min</td>
                        <td width="74" class="right">{{ $days['hours_night'] }} min</td>
                        <td>{{ $days['justification'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>
                        Total horas
                    </th>
                    <th style="text-align: right;">
                        ({{ $week['totals']['total_hours_day_converted'] }}) {{ $week['totals']['total_hours_day'] }} min
                    </th>
                    <th style="text-align: right;">
                        ({{ $week['totals']['total_hours_night_converted'] }}) {{ $week['totals']['total_hours_night'] }} min
                    </th>
                    <th></th>
                </tr>
            </table>
        <br>
        @endif
    @endforeach

    <table>
        <tr>
            <th width="60">Total</th>
            <th width="78" style="text-align: right; padding: 5px;">({{ $record->totalMinutesDayInHours }}) {{ $record->total_minutes_day }} min</th>
            <th width="74" style="text-align: right; padding: 5px;">({{ $record->totalMinutesNightInHours }}) {{ $record->total_minutes_night }} min</th>
            <th width="68" style="text-align: right; padding: 5px;">{{ $record->type->getLabel() }}</th>
        </tr>
    </table>

@endsection

@section('approvals')
    <!-- Aprobación no persistente del propio usuario -->
    <div style="padding-left: 300px">
        @include('sign.approvation', [
            'approval' => $userApproval,
        ])
    </div>

    <!-- Sección de las aprobaciones -->
    <div class="signature-footer">
        @foreach($record->approvals as $approval)
            <div class="signature" style="padding-left: 6px;">
                @include('sign.approvation', [
                    'approval' => $approval,
                ])
            </div>
        @endforeach
    </div>
@endsection