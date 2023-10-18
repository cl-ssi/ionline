<?php setlocale(LC_ALL, 'es_CL.UTF-8');?>
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
            body, table {
                font-family: Arial, Helvetica, sans-serif;
                /*font-family: "Lucida Console", Monaco, monospace;*/
                font-size: 0.8rem;
            }
            .content {
                margin: 0 auto;
                padding-left: 20px;
                /*border: 1px solid #F2F2F2;*/
                width: 704px; /* 714 achicado para dar margen izq para perforar */
            }
            .content-block, p {
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
            br {
                display: block; /* makes it have a width */
                content: ""; /* clears default height */
                margin-top: 4; /* change this to whatever height you want it */
            }
            .firma {
                border: 1px solid #CCC;
                width: 220px;
                /* height: 70px; */
                float: left;
                padding: 8px 3px 3px 3px;
                font-size: 0.9em;
                background-image: url('/images/firma_gobierno_70.png');
                background-repeat: no-repeat;
                background-position: center right;
            }
            .firma-ou {
                font-size: 0.9em;
            }
            .firma-header {
                font-size: 0.8em;
                font-family: monospace;
            }
            .firma-digital {
                font-size: 0.8em;
            }
            .firma-servicio {
                font-size: 0.9em;
            }
            .firma-fecha {
                font-size: 0.9em;
            }
            .margen-central {
                margin-right: 10px;
            }
            .numero-partes {
                font-size: 1.8em;
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
                <!--div class="siete" style="padding-bottom: 4px;">{{ $document->user->organizationalUnit->name }}</div-->
                <div class="left seis" style="padding-bottom: 6px; color: #999">Código interno: {{ $document->id }}</div>
            </div>

            <div class="right" style="float: right; width: 310px;">
                <div style="border: 1px solid #CCC;">
                    <p class="firma-header">
                        Firmado electrónicamente de acuerdo a la ley Nº 19.799<br>
                        https://i.saludtarapaca.gob.cl/validador ID:2342-Xdf4 <br>
                    </p>
                    <div class="numero-partes" style="padding-top: 40px;">23.423</div>
                </div>
                <div class="left" style="padding-bottom: 6px; font-size: 15px; padding-left: 60px;"><strong>{{ optional($document->type)->name }} N°:</strong> {{ $document->number }}</div>
                <div style="padding-top:26px"></div>
                <div class="left" style="padding-bottom: 6px; text-align: justify;">
                    <strong>ANT:</strong> {{ $document->antecedent }}
                </div>
                <div class="left" style="padding-bottom: 8px; text-align: justify;">
                    <strong>MAT:</strong> {{ $document->subject }}
                </div>
                <div><br><p></div>
            </div>

            <div style="clear: both; padding-bottom: 10px"></div>

            @switch($document->greater_hierarchy)
                @case('from')
                    <div style="width: 60px; float:left;"><strong>DE:</strong></div>
                    <div style="weight: bold;float:left; text-transform: uppercase;"><strong>{!! $document->fromHtml !!}</strong></div>
                    <div style="clear: both; padding-bottom: 10px"></div>

                    <div style="width: 60px; float:left;"><strong>PARA:</strong></div>
                    <div style="weight: bold; float:left; text-transform: uppercase;"><strong>{!! $document->forHtml !!}</strong></div>
                    <div style="clear: both"></div>
                    @break

                @case('for')
                    <div style="width: 60px; float:left;"><strong>PARA:</strong></div>
                    <div style="weight: bold; float:left; text-transform: uppercase;"><strong>{!! $document->forHtml !!}</strong></div>
                    <div style="clear: both; padding-bottom: 10px"></div>

                    <div style="width: 60px; float:left;"><strong>DE:</strong></div>
                    <div style="weight: bold;float:left; text-transform: uppercase;"><strong>{!! $document->fromHtml !!}</strong></div>
                    <div style="clear: both"></div>
                    @break

            @endswitch


            <div style="border-top: 1px solid #CCC; margin: 14px 0px 14px;"></div>
            <div>
                {!! $document->contentHtml !!}
            </div>

            <div style="padding-top: 20px">
            {{--
            <div class="firma center" style="padding-top: 68px; text-transform: uppercase; padding-bottom: 8px;">
                <div style="padding-bottom: 4px;">___________________________________</div>
                <div style="padding-bottom: 4px;">{!! $document->fromHtmlSign !!}</div>
                <div>{{ env('APP_SS') }}</div>
            </div>
            --}}
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
                        <tr><td class="seis">{{ $responsable }}</td>
                        {{--
                        <td class="center"> _ _ _ </td><td>_______</td>
                        --}}
                        </tr>
                    @endforeach
                </table>
                @endif
            </div>

            <div style="padding-top: 140px">
                <div class="firma margen-central">
                    <span class="firma-digital">Firmado digitalmente de acuerdo a la ley 19.779</span><br>
                    <b>José Ignacio Donoso Carrera </b><br>
                    <span class="firma-servicio">Servicio de Salud Tarapacá</span><br>
                    <span class="firma-fecha">21-02-2023 16:45</span><br>
                </div>
                <div class="firma margen-central">
                    <b>María Paz Iturriaga Lisbona </b><br>
                    <span class="firma-ou">Director</span><br>
                    <span class="firma-servicio">Servicio de Salud Tarapacá</span><br>
                    <span class="firma-fecha">21-02-2023 16:45</span><br>
                </div>
                <div class="firma">
                    <b>José Ignacio Donoso Carrera </b><br>
                    <span class="firma-ou">Subdirector de Gestión Asistencial</span><br>
                    <span class="firma-servicio">Servicio de Salud Tarapacá</span><br>
                    <span class="firma-fecha">21-02-2023 16:45</span><br>
                </div>
            </div>

            <div class="pie_pagina center seis">
                <!--{{ env('APP_SS') }}<br-->
                {{ env('APP_SS_ADDRESS') }} - Fono: {{ env('APP_SS_TELEPHONE') }} - {{ env('APP_SS_WEBSITE') }}
            </div>
        </div>

    </body>
</html>
