@extends('layouts.report')

@section('title', 'Acta de recepción - {{ $reception->id }}')

@section('content')

<div class="siete" style="padding-top: 3px;">Unidad de Drogas</div>
<div class="siete" style="padding-top: 4px;">
    {{ $reception->lawyer->Initials }}/
    {{ $reception->manager->Initials }}/
    {{ $reception->user->Initials }}</div>

<div class="right" style="float: right; width: 280px;">
    <div class="left" style="padding-bottom: 6px;"><strong>OFICIO RESERVADO N°:</strong> </div>
    <div class="left" style="padding-bottom: 6px;"><strong>ANT:</strong> </div>
    <div class="left" style="padding-bottom: 8px;"><strong>MAT:</strong> Informa sobre decomiso.</div>
    <div class="left" style="padding-bottom: 2px;">Iquique, </div>
    <div class="left seis" style="padding-bottom: 6px; color: #ccc">Código interno: </div>
</div>
<div style="clear: both; padding-bottom: 10px"></div>
<div style="width: 60px; float:left;"><strong>DE:</strong></div>
<div style="weight: bold;float:left; text-transform: uppercase;"><strong>JEFE DEPARTAMENTO ASESORIA JURIDICA<br>{{ env('APP_SS') }}</strong></div>
<div style="clear: both; padding-bottom: 10px"></div>
<div style="width: 60px; float:left;"><strong>PARA:</strong></div>
<div style="weight: bold; float:left; text-transform: uppercase;"><strong>SR. FISCAL<br>{{ $reception->court->name }}</strong></div>
<div style="clear: both"></div>
<div style="border-top: 1px solid #CCC; margin: 15px 0px 15px;"></div>

<p class="justify">
    <ol>
        <li style="padding-bottom: 10px;">
            Remito a usted Protocolo de Análisis N° de fecha <strong>30-07-2018</strong>
            del laboratorio de la Secretaría Regional Ministerial de Salud de Tarapacá,
            correspondiente al análisis del decomiso del parte del antecedente,
            acta N° <strong>{{ $reception->id }}</strong> y formulario
            ininterrumpido de cadena de custodia.
        </li>
        <li style="padding-bottom: 10px;">
            Adjunto informe sobre tráfico y acción de la <strong>Marihuana</strong>,
            en el organismo.
        </li>
        <li style="padding-bottom: 10px;">
            La presente delegación de firma se aprobó por resolución exenta
            <strong>{{ $mandato }}</strong> de la Dirección
            del {{ env('APP_SS') }}.
        </li>
    </ol>
</p>


<p>
    Saluda atentamente a usted, <strong>por orden de la dirección del {{ env('APP_SS') }}</strong>.
</p>

<p>

</p>



    <!--
    Remito a usted Acta de Recepción N° <strong>{{ $reception->id }}</strong>
    de la Unidad de Drogas del <strong>{{ env('APP_SS') }}</strong>.
    Formulario cadena de custodia ininterrumpido, correspondiente;
    Informe sobre tráfico y acción de la <strong>
        @foreach($substances as $substance) {{ $substance->substance->name }}, @endforeach
    </strong> en el organismo.


<ul>
    @foreach($substances as $substance)
        <li>Muestra de la sustancia presunta fue enviada al
            <strong>{{ $substance->substance->laboratory }}</strong> para el análisis correspondiente.
        </li>
    @endforeach
</ul>
-->

<div id="firmas">
    <div class="center" style="width: 100%;">
        <p class="uppercase">
            {{ $reception->lawyer->FullName }}<br>
            {{ $reception->lawyer->position }}<br>
            {{ env('APP_SS') }}
        </p>
    </div>
</div>
@endsection
