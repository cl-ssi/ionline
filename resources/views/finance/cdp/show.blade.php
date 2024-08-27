@extends('layouts.document')

@section('title', 'CDP')

@section('linea1', '')

@section('linea3', 'Cdp: ' . $cdp->id . ' - Rf:' . $cdp->request_form_id)

@section('content')

<div style="float: right; width: 300px; padding-top: 66px;">

    <div class="left quince"
        style="padding-left: 2px; padding-bottom: 10px;">
        <strong style="text-transform: uppercase; padding-right: 30px;">
            Número:
        </strong>
        <span class="catorce negrita"></span>

    </div>

    <div style="padding-top:5px; padding-left: 2px;">
        Iquique, {{ $cdp->date->day }} de {{ $cdp->date->monthName }} del {{ $cdp->date->year }}
    </div>


</div>

<div style="clear: both; padding-bottom: 35px"></div>

<div class="center diez">
    <strong style="text-transform: uppercase;">
        CERTIFICADO DE DISPONIBILIDAD PRESUPUESTARIA
    </strong>
</div>

<br><br><br>

<p class="justify" style="line-height: 1.8;">
    De conformidad al presupuesto aprobado para esta institución por la Ley N° 20.407 de Presupuestos del Sector Público {{ $cdp->date->year }},
    certifico que, a la fecha del presente documento,  la institución cuenta con el presupuesto para el financiamiento de los bienes y/o servicios 
    indicados en formulario de requerimiento folio <b>{{ $cdp->requestForm->folio }}</b>.
</p>

<br><br><br>

<table class="tabla seis">
    <thead>
        <tr>
            <th colspan="2">{{ $cdp->requestForm->name }}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th align="left" style="width: 50%">PROGRAMA ASOCIADO</th>
            <td>{{ $cdp->requestForm->associateProgram->alias_finance ?? $cdp->requestForm->program }}</td>
        </tr>
        <tr>
            <th align="left" style="width: 50%">Folio Requerimiento - SIGFE</th>
            <td>{{ $cdp->requestForm->associateProgram->folio ?? $cdp->requestForm->sigfe }}</td>
        </tr>
        <tr>
            <th align="left" style="width: 50%">Financiamiento</th>
            <td>{{ $cdp->requestForm->associateProgram->financing ?? '' }}</td>
        </tr>
        <tr>
            <th align="left" style="width: 50%">Monto $</th>
            <td>{{$cdp->requestForm->symbol_currency}} 
                {{--                 
                    {{ 
                        number_format(
                            $cdp->requestForm->has_increased_expense 
                            ? $cdp->requestForm->new_estimated_expense 
                            : $cdp->requestForm->estimated_expense,$cdp->requestForm->precision_currency
                        ,",",".") 
                    }} 
                --}}

                {{ number_format($cdp->requestForm->estimated_expense,$cdp->requestForm->precision_currency,",",".") }}
            </td>
        </tr>
    </tbody>
</table>

<div style="height: 80px;"></div>

<!-- Sección de las aprobaciones -->
<div class="signature-container">
    <div class="signature" style="padding-left: 32px;">

    </div>
    <div class="signature" style="padding-left: 6px; padding-right: 6px;">

    </div>
    <div class="signature">
        @if($cdp->approval)
            @include('sign.approvation', [
                'approval' => $cdp->approval,
            ])
        @endif
    </div>
</div>
@endsection