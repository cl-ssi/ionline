<?php setlocale(LC_ALL, 'es_CL.UTF-8'); ?>
<html lang="es">
<!-- FIXME: hacer un layout en vez de tener el codigo acá, quizá utilizar
        el de reportes de ilícios.
    -->

<head>
    <meta charset="utf-8">
    <title>{{ $document->subject }}</title>
    <meta name="description" content="Documento">
    <meta name="author" content="Sistemas SSI <sistemas.ssi@redsalud.gob.cl>">

    <style>
        body,
        table {
            font-family: Arial, Helvetica, sans-serif;
            /*font-family: "Lucida Console", Monaco, monospace;*/
            font-size: 0.8rem;
        }

        .content {
            margin: 0 auto;
            padding-left: 20px;
            /*border: 1px solid #F2F2F2;*/
            width: 704px;
            /* 714 achicado para dar margen izq para perforar */
        }

        .content-block,
        p {
            page-break-inside: avoid;
        }

        .pie_pagina {
            margin: 0 auto;
            /*border: 1px solid #F2F2F2;*/
            width: 704px;
            height: 13px;
            padding-left: 180px;
            position: fixed;
            bottom: 0;
        }

        .seis {
            font-size: 0.6rem;
        }

        .siete {
            font-size: 0.7rem;
        }

        .ocho {
            font-size: 0.8rem;
        }

        .nueve {
            font-size: 0.9rem;
        }

        .catorce {
            font-size: 1.4rem;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .justify {
            text-align: justify;
        }

        .negrita {
            font-weight: bold;
        }

        br {
            display: block;
            /* makes it have a width */
            content: "";
            /* clears default height */
            margin-top: 4;
            /* change this to whatever height you want it */
        }
    </style>
</head>

<body>

    <div class="content">
        <div class="left" style="float: left;">
            @if(isset($image))
            <img src="data:image/png;base64,{{ $image }}" width="120" alt="Logo servicio de salud"><br>
            @else
            <img src="{{ asset('images/logo_rgb.png') }}" width="120" alt="Logo servicio de salud"><br>
            @endif
            <div class="siete" style="padding-bottom: 4px;">
                {{ $document->user->organizationalUnit->establishment->name }}<br>
                {{ $document->user->organizationalUnit->name }}
            </div>
            <div class="left seis" style="padding-bottom: 6px; color: #999">ID: {{ $document->id }}
                @if ($document->internal_number)
                - Nº Interno: {{ $document->internal_number }}
                @endif
            </div>
        </div>

        <div class="right" style="float: right; width: 340px; padding-top: 90px;">
            <div class="left" style="padding-bottom: 26px; font-size: 15px; padding-left: 60px;">
                <strong style="text-transform: uppercase; padding-right: 30px;">{{ optional($document->type)->name }} N°:</strong>
                <span class="catorce negrita">{{ $document->number }}</span><br>
                <div style="padding-top:6px">Iquique, {{ $document->date->day }} de {{ $document->date->monthName }} del {{ $document->date->year }}</div>
            </div>
        </div>

        <div style="clear: both; padding-bottom: 10px"></div>
        <div>
            {!! $document->contentHtml !!}
        </div>


    @if($document->distributionHtml != null)
    <div class="firma seis" style="padding-top: 6px; padding-bottom: 8px; display: inline-block; vertical-align:top; width: 49%;">
        <div style="padding-bottom: 4px;"><strong>DISTRIBUCIÓN:</strong></div>
        <div style="padding-bottom: 4px;">{!! $document->distributionHtml !!}</div>
    </div>
    @endif

    <div style="padding-bottom: 6px; display: inline-block; vertical-align:top; width: 49%; text-align: right">

        @if($document->responsible != null)
        <table class="siete" style="margin-right: 0; margin-left: auto;">
            <tr class="seis">
                <td colspan="3"><strong>RESPONSABLES:</strong></td>
            </tr>
            @foreach($document->responsiblesArray as $responsable)
            <tr>
                <td class="seis">{{ $responsable }}</td>
            </tr>
            @endforeach
        </table>
        @endif
    </div>


    <div class="pie_pagina center seis">
        {{ $document->user->organizationalUnit->establishment->address }} - 
        Fono: {{ $document->user->organizationalUnit->establishment->telephone }} - 
        {{ env('APP_SS_WEBSITE') }}
    </div>
    </div>

</body>

</html>