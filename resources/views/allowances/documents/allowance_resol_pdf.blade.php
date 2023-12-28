@extends('layouts.document')

@section('title', 'Viático ' . $allowance->id)

{{--
@section('linea1', $reception->responsableOu->name)

@section('linea3', 'id: ' . $reception->id . ' - ' . $reception->creator->initials)

--}}

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
    </style>



    <div style="float: right; width: 300px; padding-top: 66px;">

        <div class="left quince"
            style="padding-left: 2px; padding-bottom: 10px;">
            <strong style="text-transform: uppercase; padding-right: 30px;">
                Número:
            </strong>
            <span class="catorce negrita">{{-- $reception->number --}}</span>
            {{--
            @if($reception->internal_number)
                <br>
                <small class="secondary">
                    <b style="padding-right: 20px;">Nº Interno:</b> 
                    {{ $reception->internal_number }}
                </small>
            @endif
            --}}
        </div>

        <div style="padding-top:5px; padding-left: 2px;">
            Iquique,
        </div>


    </div>

    <div style="clear: both; padding-bottom: 35px"></div>

    <div class="center diez">
        <strong style="text-transform: uppercase;">
            Título
        </strong>
    </div>


    <p style="white-space: pre-wrap;">{{-- $reception->header_notes --}}</p>

    <table class="tabla">
        <tr>
            <th>
                Orden de Compra
            </th>
            <td class="nowrap">
                Title
            </td>
        </tr>
    </table>

    <br>

    
    <!-- Sección de las aprobaciones -->
    {{--
    <div class="signature-container">
        <div class="signature" style="padding-left: 32px;">
            @if($approval = $reception->approvals->where('position', 'left')->first())
                @include('sign.approvation', [
                    'approval' => $approval,
                ])
            @endif
        </div>
        <div class="signature" style="padding-left: 6px; padding-right: 6px;">
            @if($approval = $reception->approvals->where('position', 'center')->first())
                @include('sign.approvation', [
                    'approval' => $approval,
                ])
            @endif
        </div>
        <div class="signature">
            @if($approval = $reception->approvals->where('position', 'right')->first())
                @include('sign.approvation', [
                    'approval' => $approval,
                ])
            @endif
        </div>
    </div>
    --}}
@endsection
