@extends('layouts.document')

@section('title', "Protocolo de Análisis - $protocol->id")

@section('linea1', "Unidad de Análisis")

@section('linea2', $protocol->user->organizationalUnit->name)

@section('linea3', $protocol->user->Initials)

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
        PROTOCOLO DE ANÁLISIS
    </strong>
</div>


<p>
    Antecedentes:
    Muestra número <strong>{{ $protocol->sample }}</strong> correspondiente a
    acta de recepción <strong>{{ $protocol->receptionItem->reception->id }}.</strong>
    <!-- Mostrar la letra del ítem sólo si es el acta tiene más de un item -->
    @if($protocol->receptionItem->reception->items->count() > 1)
        Item <strong>{{ $protocol->receptionItem->letter }}).</strong>
    @endif
</p>


<strong>a) Descripción de la muestra.</strong>

<ul>
    <li>
        Peso de la muestra: {{ $protocol->receptionItem->sample }}
            <span style="text-transform: lowercase;">{{ $protocol->receptionItem->substance->unit }}</span>.
    </li>
    <li>
        Descripción de la muestra: {{ $protocol->receptionItem->description }}
    </li>
</ul>

<strong>b) Descripción del test a que fue sometida la muestra.</strong>

<ul>
    <li>
        <strong>Reacción con Fast Blue B</strong> <br>
        Prueba de color que permite determinar la presencia de
        tetrahidrocanabinoles extrayendo el principio activo con un
        solvente orgánico. El cual se hace reaccionar con la sal de azul
        sólido B en un medio acuoso, obteniendo un color rojo púrpura.
    </li>

</ul>

<strong>c) Exposición del resultado del procedimiento aplicado.</strong>

<ul>
    <li>
        Identificación de tetrahidocababinoles: <strong> {{ $protocol->result }}.</strong>
    </li>
</ul>

<br>
<h4>Conclusión:
    <strong>
        {{ ( $protocol->result == 'Positivo' ) ? 'MARIHUANA' : 'MARIHUANA NEGATIVO' }}
    </strong>
</h4>

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

        <div class="signature">
        </div>
    </div>
@endsection