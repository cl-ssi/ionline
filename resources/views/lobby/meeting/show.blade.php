@extends('layouts.document')

@section('title', 'Acta de reunión')

@section('linea3', 'Código interno: ' . $meeting->id)

@section('content')

    <div style="float: right; width: 300px; padding-top: 66px;">

        <div class="left quince"
            style="padding-left: 2px; padding-bottom: 10px;">
            <strong style="text-transform: uppercase; padding-right: 30px;">
                Número:
            </strong>
            <span class="catorce negrita">{{ $meeting->id }}</span>
        </div>

        <div style="padding-top:5px; padding-left: 2px;">
            Iquique, {{ $meeting->date->day }} de {{ $meeting->date->monthName }} del {{ $meeting->date->year }}
        </div>


    </div>

    <div style="clear: both; padding-bottom: 35px"></div>

    <div class="center diez">
        <strong style="text-transform: uppercase;">
            Acta de reunión: {{ $meeting->subject }}
        </strong>
    </div>



    <br>

    <table class="tabla ocho">
        <tr>
            <td width="150px"><strong>Solicitante</strong></td>
            <td>{{ $meeting->petitioner }}</td>
        </tr>
        <tr>
            <td><strong>Fecha</strong></td>
            <td>{{ $meeting->date?->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <td><strong>Mecanismo</strong></td>
            <td>{{ $meeting->mecanism }}</td>
        </tr>
        <tr>
            <td><strong>Hora Inicio/Término</strong></td>
            <td>{{ $meeting->start_at?->format('H:i') }} - {{ $meeting->end_at?->format('H:i') }}</td>
        </tr>
    </table>
    <br>

    <table class="tabla ocho">
        <tr>
            <td>
                <strong>Tema</strong>
            </td>
        </tr>
        <tr>
            <td>{{ $meeting->subject }}</td>
        </tr>
    </table>
    <br>

    <table class="tabla ocho">
        <tr>
            <td>
                <strong>Expositores</strong>
            </td>
        </tr>
        <tr>
            <td>{{ $meeting->exponents }}</td>
        </tr>
    </table>
    <br>


    <table class="tabla ocho">
        <tr>
            <td>
                <strong>Participantes</strong>
            </td>
        </tr>
        <tr>
            <td>
                <ul>

                    @foreach ($meeting->participants as $participant)
                        <li>{{ $participant->shortName }} - {{ $participant->position }} -
                            {{ $participant->organizationalUnit->name }} -
                            {{ $participant->organizationalUnit->establishment->alias }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
    </table>
    <br>

    <table class="tabla ocho">
        <tr>
            <td>
                <strong>Detalle</strong>
            </td>
        </tr>
        <tr>
            <td>{{ $meeting->details }}</td>
        </tr>
    </table>
    <br>

    <table class="tabla ocho">
        <tr>
            <td>
                <strong>Acuerdos/Compromisos</strong>
            </td>
        </tr>
        <tr>
            <td>
                <ul>

                    @foreach ($meeting->compromises as $compromise)
                        <li>{{ $compromise->date?->format('Y-m-d') }} - {{ $compromise->name }} -
                            {{ $compromise->status }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
    </table>


@endsection
