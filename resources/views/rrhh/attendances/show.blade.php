@extends('layouts.document')

@section('title', 'Asistencia')

@section('content')

    <div style="float: right; width: 200px; padding-top: 66px;">

        <div style="padding-top:5px; padding-left: 2px;">
            Fecha del informe: {{ $attendance->report_date->toDateString() }} 
        </div>

    </div>

    <div style="clear: both; padding-bottom: 65px"></div>

    <div class="center diez" style="margin-bottom: 34px;">
        <strong style="text-transform: uppercase;">
            INFORME DE ASISTENCIA
        </strong>
    </div>

    <div class="ocho" style="padding-left: 38px; padding-bottom: 10px;">
        <strong  style="text-transform: uppercase;">
            {{ $attendance->user->full_name }}
            <br>
            {{ $attendance->date->monthName }} {{ $attendance->date->year }} 
        </strong>
    </div>

    @if ($attendance)
        <pre style="white-space: pre-wrap; word-wrap: break-word; padding-left: 38px;">{{ $attendance->records }}</pre>
    @else
        <p>No se encontraron registros de asistencia.</p>
    @endif
@endsection
