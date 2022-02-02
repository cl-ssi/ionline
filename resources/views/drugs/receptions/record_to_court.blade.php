@extends('layouts.report')

@section('title', 'Acta a Fiscalía')

@section('content')

<div class="siete" style="padding-top: 3px;">
    Unidad de Drogas
</div>

<div class="seis" style="padding-top: 4px; color: #999">
    Código interno: {{ $reception->recordToCourt->id }} -
    {{ strtolower($recordToCourt->user->Initials) }}
</div>

<div class="right" style="float: right; width: 280px;">
    <div class="left" style="padding-bottom: 6px;">
        <strong>OFICIO RESERVADO N°:</strong> {{ $recordToCourt->number }}
    </div>
    <div class="left" style="padding-bottom: 6px;">
        <strong>ANT:</strong>
        ORD: {{ $reception->document_number }}
        del {{ $reception->document_date->format('d-m-Y')}}
        de la {{ $reception->documentPoliceUnit->name }},
        {{ $reception->parte_label }} N°: {{ $reception->parte}} de la
        {{ $reception->partePoliceUnit->name }}.
        <br>

    </div>
    <div class="left" style="padding-bottom: 8px;">
        <strong>MAT:</strong> Informa sobre decomiso.
    </div>
    <div class="left" style="padding-bottom: 2px;">
        Iquique, {{ ($reception->recordToCourt->document_date) ? $reception->recordToCourt->document_date->format('d-m-Y'):'' }}
    </div>
</div>

<div style="clear: both; padding-bottom: 10px"></div>

<div style="width: 60px; float:left;">
    <strong>DE:</strong>
</div>
<div style="weight: bold;float:left; text-transform: uppercase;">
    <strong>{{ $recordToCourt->lawyer->position }}<br>{{ env('APP_SS') }}</strong>
</div>

<div style="clear: both; padding-bottom: 10px"></div>

<div style="width: 60px; float:left;">
    <strong>PARA:</strong>
</div>
<div style="weight: bold; float:left; text-transform: uppercase;">
    <strong>SR. FISCAL<br>
        {{ $reception->court->name }}</strong>
</div>
<div style="clear: both"></div>

<div style="border-top: 1px solid #CCC; margin: 15px 0px 15px;"></div>

<p class="justify">
    Junto con saludar cordialmente, remito a usted:
    <ol>
        <li style="padding-bottom: 10px;">
            <strong>Acta de recepción N°: {{ $reception->id }}</strong>
            del <strong>{{ $reception->created_at->format('d-m-Y') }}</strong>
            de la Unidad de Drogas del {{ env('APP_SS') }}.
        </li>

        <li style="padding-bottom: 10px;">
            Formulario de Cadena de Custodia Ininterrumpido.
        </li>

        <li style="padding-bottom: 10px;">
            Informe sobre el tráfico y acción en el organismo de la
            <i>Sustancia Presunta</i> señalada en el ácta de recepción.
        </li>

        @if(count($itemsSEREMI) >= 1)
        <li style="padding-bottom: 10px;">
            Protocolos de análisis de la Unidad de Análisis del
            {{ env('APP_SS') }}, correspondiente
            al decomiso del parte señalado en los antecedentes.
            <ol>
                @foreach($itemsSEREMI as $itemSEREMI)
                    @foreach($itemSEREMI->protocols as $protocol)
                        <li>
                            <strong>Protocolo N°: {{ $protocol->id }}</strong>
                            con fecha <strong>
                            {{ $protocol->created_at->format('d-m-Y') }},
                        </strong> ítem <strong>{{$itemSEREMI->position}})</strong>
                        del acta de recepción.
                        </li>
                    @endforeach
                @endforeach
            </ol>
        </li>
        @endif

    </ol>

    Además, informo a usted lo siguiente:

    <ol>
        @if(count($itemsISP) >= 1)
        <li style="padding-bottom: 10px;">
            La muestra del ítem
            @foreach($itemsISP as $itemISP)
                <strong>{{ $itemISP->position }}), </strong>
            @endforeach
            de la <i>Sustancia Presunta</i> fue enviada al Instituto de
            Salud Pública de Chile para el análisis correspondiente.
        </li>
        @endif

        <li style="padding-bottom: 10px;">
            La presente delegación de firma se aprobó por resolución exenta
            <strong>{{ $mandato }}</strong> de la Dirección
            del {{ env('APP_SS') }}.
        </li>

    </ol>
</p>

<!-- FIXME: El genero del director debería estar en parametro -->
<p>
    Saluda atentamente a usted, "Por orden del Director del {{ env('APP_SS') }}".
</p>


<!-- <div id="firmas">
    <div class="center" style="width: 100%;">
        <p class="uppercase">
            {{ $recordToCourt->lawyer->FullName }}<br>
            {{ $recordToCourt->lawyer->position }}<br>
            {{ env('APP_SS') }}
        </p>
    </div>
</div> -->


<div class="row">
    <div class="column">
        <p>
            <strong>Distribución:</strong>
            <ul>
                <li>{{ $reception->court->name }}</li>
                <li>CC: Unidad de Drogas - SSI</li>
                <li>CC: Oficina de Partes - SSI</li>
            </ul>
        </p>
    </div>

    <!-- <div class="column right">
            <p style="padding-right: 117px">
                <strong>Responsables:</strong>
            </p> -->
            <!--li>Departamento de Asesoría Jurídica  {{ $reception->recordToCourt->lawyer->Initials }}  _______</li-->
            <!-- Unidad de Drogas &nbsp;&nbsp; {{ $reception->recordToCourt->manager->Initials }} &nbsp;&nbsp; _______
    </div> -->
</div>

@endsection
