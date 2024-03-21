@extends('layouts.document')

@section('title', "Protocolo de Análisis - $protocol->id")

@section('linea1', $protocol->user->organizationalUnit->name)

@section('linea3', $protocol->user->initials)

@section('content')

<div style="float: right; width: 300px; padding-top: 66px;">

    <div class="left quince"
        style="padding-left: 2px; padding-bottom: 10px;">
        <strong style="text-transform: uppercase; padding-right: 30px;">
            Número: 
        </strong>
        <span class="catorce negrita">{{ $protocol->id }}</span>
    </div>

    <div style="padding-top:5px; padding-left: 2px;">
        Iquique, {{ $protocol->created_at->day }} de {{ $protocol->created_at->monthName }} de {{ $protocol->created_at->year }}
    </div>

</div>

<div style="clear: both; padding-bottom: 35px"></div>

<div class="center diez">
    <strong style="text-transform: uppercase;">
        ACTA DE DESTRUCCIÓN DE MUESTRA <br> PROTOCOLO DE ANALISIS
    </strong>
</div>


<p class="justify indent">
    En conformidad a la ley 20.000/2005, se procede al análisis y posterior
    destrucción química de la siguiente muestra de sustancia:
</p>

<ul>
    <li>Muestra número <strong>{{ $protocol->sample }}</strong> correspondiente a
    acta de recepción <strong>{{ $protocol->receptionItem->reception->id }}</strong>.
    <!-- Mostrar la letra del ítem sólo si es el acta tiene más de un item -->
    @if($protocol->receptionItem->reception->items->count() > 1)
        Item <strong>{{ $protocol->receptionItem->letter }}).</strong>
    @endif
    Peso de la muestra: <strong>{{ $protocol->receptionItem->sample }}</strong>
        <span style="text-transform: lowercase;">{{ $protocol->receptionItem->substance->unit }}</span>.
    </li>
</ul>

<p>
    Antecedentes:
    Ord. N° <strong>{{ $protocol->receptionItem->reception->document_number }}</strong>,
    {{ $protocol->receptionItem->reception->parte_label }} N°
    <strong>{{ $protocol->receptionItem->reception->parte }}</strong>
    de <strong>{{ $protocol->receptionItem->reception->partePoliceUnit->name }}</strong>.
    <strong>{{ $protocol->receptionItem->reception->court->name }}</strong>.
</p>

@if($protocol->receptionItem->reception->imputed)
<p style="text-transform: capitalize; display:inline">Imputado:
    <strong>{{ $protocol->receptionItem->reception->imputed }} - {{ $protocol->receptionItem->reception->imputed_run }}</strong>
</p>
@endif

<p>
    Posterior a esta destrucción química, el día <strong>08 de Marzo de 2024</strong> se efectúa <strong>incineración</strong> de restos de muestras ya analizadas 
    y se comprobó que la sustancia fue destruida en su integridad.
</p>

<p>Para constancia firma:</p>

@endsection

@section('approvals')
    <!-- Sección de las aprobaciones -->
    <div class="signature-footer">

        <div class="signature">
        </div>

        <div class="signature">
            @if($protocol->approval)
                @include('sign.approvation', [
                    'approval' => $protocol->approval,
                ])
            @endif
            <!-- {{ $protocol->user->position }} <br> -->
        </div>
        
    </div>
@endsection