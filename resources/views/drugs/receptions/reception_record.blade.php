@extends('layouts.report')

@section('title', "Acta de recepción - $reception->id")

@section('content')

<div class="siete" style="padding-top: 3px;">Unidad de Decomisos</div>
<div class="siete" style="padding-top: 4px;">
    {{ $reception->lawyer->Initials }}/
    {{ $reception->manager->Initials }}/
    {{ $reception->user->Initials }}
</div>

<div class="titulo">ACTA DE RECEPCIÓN N° {{ $reception->id }}</div>

<p class="justify indent">
    En Iquique, a <strong>{{ $reception->created_at->day }} de {{ $reception->created_at->monthName }} del {{ $reception->created_at->year }}</strong>
    siendo las <strong>{{ $reception->created_at->format('H:i') }}</strong> horas
    en la Unidad de Drogas de Servicio de Salud de Iquique,
    en conformidad a la ley 20.000/2005, se ha recibido el
    Ordinario N° <strong>{{ $reception->document_number }}</strong>
    de <strong>{{ $reception->documentPoliceUnit->name }}</strong>
    con fecha <strong>{{ $reception->document_date->format('d-m-Y') }}</strong>,
    @if($reception->parte)
    {{ $reception->parte_label }} N° <strong>{{ $reception->parte }}</strong> de
    <strong>{{ $reception->partePoliceUnit->name }}</strong>,
    @endif
    a <strong>{{ $reception->court->name }}</strong>
    para muestreo en el Servicio de Salud de Iquique,
    las siguientes sustancias:
</p>

<!-- Usar vieñas con letras sólo si hay más de un item -->
{!! $reception->items->count()== 1 ? "<ul>" : "<ol class='li_letras'>" !!}

    @foreach($reception->items as $item)
        <li style="margin-bottom: 16px;"> {{ $item->description }}
        <table class="ocho">
            <thead>
                <tr>
                    <th style="width: 50px;">N.U.E.</th>
                    <th>Presunción</th>
                    <th>Peso Oficio</th>
                    <th>Peso Bruto</th>
                    <th>Peso Neto</th>
                    <th>Muestra</th>
                    <th nowrap>Contra M.</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="center">{{ $item->nue }}</td>
                    <td>{{ $item->substance->name }}</td>
                    <td class="center" nowrap>
                        {{ $item->document_weight ? $item->document_weight .' '.$item->substance->unit : 'No informado'}}
                    </td>
                    <td class="center" nowrap>
                        {{ $item->gross_weight }} {{ $item->substance->unit }}
                    </td>
                    <td class="center" nowrap>
                        @if($item->net_weight OR ($item->net_weight == 0))
                            {{ $item->net_weight }} {{ $item->substance->unit }}
                        @endif
                        @if($item->estimated_net_weight)
                            (* {{ $item->estimated_net_weight }} {{ $item->substance->unit }})
                        @endif
                    </td>
                    <td class="center" nowrap>
                        @if($item->sample == 0)
                            -
                        @else
                            ({{ $item->sample_number }})
                            {{ $item->sample }}
                            {{ $item->substance->unit }}
                        @endif
                    </td>
                    <td class="center" nowrap>
                        @if($item->countersample == 0)
                            -
                        @else
                            ({{ $item->sample_number }})
                            {{ $item->countersample }}
                            {{ $item->substance->unit }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        @if($item->estimated_net_weight)
            * Peso neto estimado, pues no es posible obtener el peso neto hasta
            después de la incineración.
        @endif
        </li>
    @endforeach

{!! $reception->items->count()== 1 ? "</ul>" : "</ol>" !!}

@if($reception->observation)
<p>Observación:
    <strong>{{ $reception->observation }}</strong>
</p>
@endif

@if($reception->imputed)
<p style="text-transform: capitalize;">Imputado:
    <strong>{{ $reception->imputed }} - {{ $reception->imputed_run }}</strong>
</p>
@endif

<div id="firmas">
    <div class="center" style="width: 49%;">
        <span class="uppercase">{{ $reception->delivery }}</span> ({{ $reception->delivery_run }})<br>
        {{ $reception->delivery_position }}<br style="padding-bottom: 6px;">
        Funcionario que entrega
    </div>
    <div class="center" style="width: 49%">
        <span class="uppercase">{{ $reception->user->FullName }}</span><br>
        {{ $reception->user->position }} <br>
        Funcionario que Recibe<br style="padding-bottom: 6px;">

    </div>
</div>
@endsection
