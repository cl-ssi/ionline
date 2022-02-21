@extends('layouts.report')

@section('title', "Muestra a ISP - $reception->id")

@section('content')

<div class="siete" style="padding-top: 3px;">
    Unidad de Drogas
</div>

<div class="seis" style="padding-top: 4px; color: #999">
    Código interno: {{ $reception->sampleToIsp->id }} -
    {{ strtolower($reception->sampleToIsp->user->Initials) }}
</div>

<div class="right" style="float: right; width: 280px;">
    <div class="left" style="padding-bottom: 6px;">
        <strong>OFICIO RESERVADO N°:</strong> {{ $reception->sampleToIsp->number }}
    </div>
    <div class="left" style="padding-bottom: 6px;">
        <strong>ANT:</strong>
        Acta de Recepción N° {{ $reception->id }} -
        {{ $reception->created_at->format('d-m-Y') }}<br>
        Unidad de Drogas - Ley 20.000
    </div>
    <div class="left" style="padding-bottom: 8px;">
        <strong>MAT:</strong> Envío {{ $samples }} muestra(s) para análisis.
    </div>
    <div class="left" style="padding-bottom: 2px;">
        Iquique, {{ ($reception->sampleToIsp->document_date) ? $reception->sampleToIsp->document_date->format('d-m-Y'):'' }}
    </div>
</div>

<div style="clear: both; padding-bottom: 10px"></div>

<div style="width: 60px; float:left;">
    <strong>DE:</strong>
</div>
<div style="weight: bold;float:left; text-transform: uppercase;">
    <strong>{{ $reception->sampleToIsp->lawyer->position }}<br>{{ env('APP_SS') }}</strong>
</div>

<div style="clear: both; padding-bottom: 10px"></div>

<div style="width: 60px; float:left;">
    <strong>PARA:</strong>
</div>
<div style="weight: bold; float:left; text-transform: uppercase;">
    <strong>SR. DIRECTOR<br>
        INSTITUTO DE SALUD PÚBLICA DE CHILE</strong>
</div>
<div style="clear: both"></div>

<div style="border-top: 1px solid #CCC; margin: 15px 0px 15px;"></div>

<p class="justify">
    <ol>
        <li style="padding-bottom: 10px;">
            Adjunto sírvase encontrar sobre sellado, con un peso de
            <strong>{{ $reception->sampleToIsp->envelope_weight }}</strong> gramos que contiene:
            <ul>
                @foreach($items as $item)
                <li>
                    {{ $item->sample_number }} muestra(s) de
                    <strong>{{ $item->sample }}</strong> {{ $item->substance->unit }}
                    de presunta <strong>{{ $item->substance->name }}</strong>
                    para el análisis correspondiente.
                    @if(count($reception->items) > 1)
                        Muestra <strong>{{$item->position}})</strong>.
                    @endif
                </li>
                @endforeach
            </ul>
        </li>
        <li style="padding-bottom: 10px;">
            Se anexa acta de recepción <strong>{{ $reception->id }}</strong>
            del <strong>{{ $reception->created_at->format('d-m-Y') }}</strong>.
        </li>
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
            {{ $reception->sampleToIsp->lawyer->FullName }}<br>
            {{ $reception->sampleToIsp->lawyer->position }}<br>
            {{ env('APP_SS') }}
        </p>
    </div>
</div> -->


<div class="row">
    <div class="column">
        <p>
            <strong>Distribución:</strong>
            <ul>
                <li>Director ISP</li>
                <li>CC: {{ $reception->court->name }}</li>
                <li>CC: Unidad de Drogas - SSI</li>
                <li>CC: Oficina de Partes - SSI</li>
            </ul>
        </p>
    </div>

    <!-- <div class="column right">
            <p style="padding-right: 117px">
                <strong>Responsables:</strong> -->
            </p>
            <!--li>Departamento de Asesoría Jurídica  {{ $reception->sampleToIsp->lawyer->Initials }}  _______</li-->
            <!-- Unidad de Drogas &nbsp;&nbsp; {{ $reception->sampleToIsp->manager->Initials }} &nbsp;&nbsp; _______
    </div> -->
</div>

@endsection
