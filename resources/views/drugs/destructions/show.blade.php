@extends('layouts.report')

@section('title', "Acta de destrucción - $destruction->id")

@section('content')

<div class="siete" style="padding-top: 3px;">Unidad de Drogas</div>

<div class="siete" style="padding-top: 4px;">
    {{ $destruction->lawyer->Initials }}/
    {{ $destruction->manager->Initials }}/
    {{ $destruction->user->Initials }}</div>

<div class="titulo">ACTA DE DESTRUCCIÓN N° {{ $destruction->reception->id }}</div>

<p class="justify indent">
    En Iquique, a <strong>{{ $destruction->destructed_at->day }} de {{ $destruction->destructed_at->monthName }} del {{ $destruction->destructed_at->year }}</strong>
    en conformidad a la ley 20.000/2005, en presencia de los funcionarios
    que más abajo se indica y de <strong>{{ $destruction->police }}</strong>,
    institución que acompaña, se procede a la desctrucción de
    las siguientes sustancias:
</p>

<!-- Usar vieñas con letras sólo si hay más de un item -->
{!! $destruction->reception->items->count()== 1 ? "<ul>" : '<ol class="li_letras">' !!}

    @foreach($destruction->reception->items as $item)
        <li style="margin-bottom: 14px; padding-bottom: 6px">
            {{ $item->description }}

        <table class="ocho">
            <thead>
                <tr>
                    <th style="width: 50px;">N.U.E.</th>
                    <th>Presunción</th>
                    <th>Peso Oficio</th>
                    <th>Peso Bruto</th>
                    <th>
                        @if($item->net_weight)
                            Peso Neto
                        @else
                            Peso Neto *.
                        @endif
                    </th>
                    <th>Muestra</th>
                    <th>Contra M.</th>
                    <th nowrap>A Destruir</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="center">{{ $item->nue }}</td>
                    <td>{{ $item->substance->name }}</td>
                    <td class="center">
                        {{ $item->document_weight ? $item->document_weight .' '.$item->substance->unit : 'No informado'}}
                    </td>
                    <td class="center">
                        {{ $item->gross_weight }} {{ $item->substance->unit }}
                    </td>
                    <td nowrap class="center">
                        @if($item->net_weight OR ($item->net_weight == 0))
                            {{ $item->net_weight }} {{ $item->substance->unit }}
                        @endif
                        @if($item->estimated_net_weight)
                            (* {{ $item->estimated_net_weight }} {{ $item->substance->unit }})
                        @endif
                    </td>
                    <td class="center">
                        @if($item->sample == 0)
                            -
                        @else
                            ({{ $item->sample_number }})
                            {{ $item->sample }}
                            {{ $item->substance->unit }}
                        @endif
                    </td>
                    <td class="center">
                        @if($item->countersample == 0)
                            -
                        @else
                            ({{ $item->sample_number }})
                            {{ $item->countersample }}
                            {{ $item->substance->unit }}
                        @endif
                    </td>
                    <td class="center">{{ $item->destruct }} {{ $item->substance->unit }}</td>
                </tr>

            </tbody>
        </table>
        @if($item->estimated_net_weight)
            * Peso neto estimado, debido a que no se puede calcular el peso del contenedor antes de la destrucción.
        @endif
        </li>

    @endforeach
{!! $destruction->reception->items->count()== 1 ? "</ul>" : "</ol>" !!}

@if($destruction->reception->observation)
<p>Observación:
    <strong>{{ $destruction->reception->observation }}</strong>
</p>
@endif

<p>
    Antecedentes:
    Ord. N° <strong>{{ $destruction->reception->document_number }}</strong>,
    {{ $destruction->reception->parte_label }} N°
    <strong>{{ $destruction->reception->parte }}</strong>
    de <strong>{{ $destruction->reception->partePoliceUnit->name }}</strong>.
    <strong>{{ $destruction->reception->court->name }}</strong>.
</p>

@if($destruction->reception->imputed)
<p style="text-transform: capitalize; display:inline">Imputado:
    <strong>{{ $destruction->reception->imputed }} - {{ $destruction->reception->imputed_run }}</strong>
</p>
@endif

<p>
    Para destruir la sustancia se usó el método de <strong>incineración</strong>
    y se comprobó que la sustancia fue destruida en su integridad.
</p>

<p>Para constancia firman:</p>

<div id="firmas" style="">

    <div class="center" style="width: 33%">
        {{ $destruction->manager->FullName }}<br>
        {{ $destruction->manager->position }} {{ $destruction->manager->organizationalUnit->name }}<br>
        {{ config('app.ss') }}<br>
    </div>

    <div class="center" style="width: 33%">
        {{ $destruction->observer->FullName }}<br>
        Ministro de Fe<br>
        {{ config('app.ss') }}
    </div>

    <div class="center" style="width: 32%;">
        {{ $destruction->lawyer_observer->FullName }}<br>
        Departamento de Asesoría Jurídica<br>
        {{ config('app.ss') }}<br>
    </div>

</div>
@endsection
