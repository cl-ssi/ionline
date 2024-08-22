@extends('layouts.document')

@section('title', 'Recepción ' . $record->id)

@section('linea1', $record->organizationalUnit->name)

@section('linea3', 'id: ' . $record->id . ' - ' . $record->user->initials)

@section('content')

    <style>
        .tabla th {
            text-align: left;
            padding-right: 3px;
        }
        .tabla td {
            padding: 5px;
            /* Ajusta este valor a tus necesidades */
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
            Iquique, {{ $record->created_at->day }} de {{ $record->created_at->monthName }} del {{ $record->created_at->year }}
        </div>


    </div>

    <div style="clear: both; padding-bottom: 50px"></div>

    <div class="center diez">
        <strong style="text-transform: uppercase;">
            SOLICITUD DE AUSENTISMO: {{ $record->tipo_de_ausentismo }}
        </strong>
    </div>

    <div style="height: 30px;"></div>

    <table class="tabla">
        <tr>
            <th>Solicitante</th>
            <td>{{ $record->nombre }}</td>
        </tr>
        <tr>
            <th>Unidad Organizacional</th>
            <td>{{ $record->nombre_unidad }}</td>
        </tr>
        <tr>
            <th>Tipo de ausentismo</th>
            <td>{{ $record->tipo_de_ausentismo }} {{ $record->jornada }}</td>
        </tr>
        <tr>
            <th>Fecha Inicio</th>
            <td>{{ $record->finicio->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <th>Fecha Término</th>
            <td>{{ $record->ftermino->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <th>Fundamento</th>
            <td>{{ $record->observacion }}</td>
        </tr>
    </table>

    <!-- Sección de las aprobaciones -->
    <div class="signature-container">
        <div class="signature" style="padding-left: 32px;">

        </div>
        <div class="signature" style="padding-left: 6px; padding-right: 6px;">

        </div>
        <div class="signature">       
            @include('sign.approvation', [
                'approval' => $approval,
            ])
        </div>
    </div>
@endsection
