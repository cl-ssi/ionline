@extends('layouts.document')

@section('title', "Manual - $record->title")

@section('linea1', 'Departamento de Tecnologías de la Información y Comunicaciones')

@section('content')

    <div style="float: right; width: 300px; padding-top: 66px;">

        <div style="padding-top:5px; padding-left: 200px;">
            Versión: <span class="negrita">{{ number_format($record->version, 1, '.', '') }}</span><br>
        </div>

    </div>

    <div style="clear: both; padding-bottom: 210px"></div>

    <div class="center diez">
        <strong style="text-transform: uppercase;">
            {{ $record->title }}
            <br>
            Manual de uso
        </strong>
    </div>

    <div style="clear: both; padding-bottom: 160px"></div>

    <p class="ocho">
        Historial de cambios
    </p>
    <table class="tabla">
        <thead>
            <tr>
                <th>Autor</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($record->modifications as $key => $modificacion)
                <tr>
                    <td class="celda" style="width: 200px;">{{ $key }}</td>
                    <td class="celda">{{ $modificacion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>


    {!! $record->content !!}

@endsection


@section('before-content')
    <!-- Sección de las aprobaciones -->
    <div class="signature-footer">

        <div class="signature">

        </div>

        <div class="signature">
            @if ($record->approval)
                @include('sign.approvation', [
                    'approval' => $record->approval,
                ])
            @endif
        </div>

        <div class="signature">

        </div>

    </div>
@endsection