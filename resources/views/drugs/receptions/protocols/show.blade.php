@extends('layouts.report')

@section('title', "Protocolo de Análisis - $protocol->id")

@section('content')

<div class="siete" style="padding-top: 3px;">Unidad de Análisis</div>
<div class="siete" style="padding-top: 4px;">
    {{ $protocol->user->Initials }}
</div>

<div class="titulo">PROTOCOLO DE ANÁLISIS N°: {{ $protocol->id }}</div>

Iquique, <strong>{{ $protocol->created_at->day }} de {{ $protocol->created_at->monthName }} del {{ $protocol->created_at->year }}</strong>.

<p>
    Antecedentes:
    Muestra número <strong>{{ $protocol->sample }}</strong> correspondiente a
    acta de recepción <strong>{{ $protocol->receptionItem->reception->id }}.</strong>
    <!-- Mostrar la letra del ítem sólo si es el acta tiene más de un item -->
    @if($protocol->receptionItem->reception->items->count() > 1)
        Item <strong>{{ $letra }}).</strong>
    @endif
</p>


<p> <strong>a) Descripción de la muestra.</strong></p>
<p>
    <ul>
        <li>
            <p>Peso de la muestra: {{ $protocol->receptionItem->sample }}
                <span style="text-transform: lowercase;">{{ $protocol->receptionItem->substance->unit }}</span>.</p>
        </li>
        <li>
            <p>Descripción de la muestra: {{ $protocol->receptionItem->description }}</p>
        </li>
    </ul>
</p>
<p> <strong>b) Descripción del test a que fue sometida la muestra.</strong></p>
<p>
    <ul>
        <li>

            <strong>Reacción con Fast Blue B</strong> <br>
            Prueba de color que permite determinar la presencia de
            tetrahidrocanabinoles extrayendo el principio activo con un
            solvente orgánico. El cual se hace reaccionar con la sal de azul
            sólido B en un medio acuoso, obteniendo un color rojo púrpura.
        </li>

    </ul>
</p>

<p> <strong>c) Exposición del resultado del procedimiento aplicado.</strong></p>
<p>
    <ul>
        <li>
            Identificación de tetrahidocababinoles: <strong> {{ $protocol->result }}.</strong>
        </li>
    </ul>
</p>

<br>
<h4>Conclusión:
    <strong>
        {{ ( $protocol->result == 'Positivo' ) ? 'MARIHUANA' : 'MARIHUANA NEGATIVO' }}
    </strong>
</h4>


<div id="firmas" class="center">
    <div  style="width: 100%">
        <span class="uppercase">{{ $protocol->user->FullName }}</span><br>
        {{ $protocol->user->position }} <br>
        {{ config('app.ss') }}<br style="padding-bottom: 6px;">
    </div>
</div>


<div class="page-break"></div>


<img style="padding-bottom: 4px;" src="{{ asset('images/logo_pluma.jpg') }}"
    width="120" alt="Logo {{ config('app.ss') }}"><br>
<div class="siete" style="padding-top: 3px;">Unidad de Drogas</div>
<div class="siete" style="padding-top: 4px;">
    {{ $protocol->user->Initials }}
</div>

<div class="titulo">ACTA DE DESTRUCCIÓN DE MUESTRA <br> PROTOCOLO DE ANALISIS: {{ $protocol->id }}</div>

<p class="justify indent">
    En Iquique, a <strong>{{ $protocol->created_at->day }} de {{ $protocol->created_at->monthName }} del {{ $protocol->created_at->year }}</strong>
    en conformidad a la ley 20.000/2005, se procede al análisis y posterior
    destrucción química de la siguiente muestra de sustancia:
</p>

<ul>
    <li>Muestra número <strong>{{ $protocol->sample }}</strong> correspondiente a
    acta de recepción <strong>{{ $protocol->receptionItem->reception->id }}</strong>.
    <!-- Mostrar la letra del ítem sólo si es el acta tiene más de un item -->
    @if($protocol->receptionItem->reception->items->count() > 1)
        Item <strong>{{ $letra }}).</strong>
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
    Posterior a esta destrucción química y con fecha ____________________
    se efectúa <strong>incineración</strong> de restos de muestras ya analizadas
    y se comprobó que la sustancia fue destruida en su integridad.
</p>

<p>Para constancia firman:</p>

<div id="firmas" class="center">
    <div  style="width: 100%">
        <span class="uppercase">{{ $protocol->user->FullName }}</span><br>
        {{ $protocol->user->position }} <br>
        {{ config('app.ss') }}<br style="padding-bottom: 6px;">
    </div>
</div>

@endsection
