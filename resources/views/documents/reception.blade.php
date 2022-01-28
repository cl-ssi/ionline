<html lang="es">
    <!-- FIXME: hacer un layout en vez de tener el codigo acá, quizá utilizar
        el de reportes de ilícios.
    -->
    <head>
        <meta charset="utf-8">
        <title>Intranet {{ $document->number }} - {{ $document->subject }}</title>
        <meta name="description" content="Documento">
        <meta name="author" content="Alvaro Torres F. <alvaro.torres@redsalud.gob.cl>">

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
        </style>
    </head>

    <body>

        <div class="content">
            <img src="{{ asset('images/logo_pluma.jpg') }}" width="120" alt=""><br>
            <!--div class="siete" style="padding-bottom: 4px;">{{ $document->user->organizationalUnit->name }}</div-->
            <div class="left seis" style="padding-bottom: 6px; color: #999">Código interno: {{ $document->id }}</div>

            <div class="right" style="float: right; width: 300px;">
                <div class="left" style="padding-bottom: 6px;"><strong>N°:</strong> {{ $document->number }}</div>
                <div class="left" style="padding-bottom: 2px;">Iquique, 
                {{ $document->date ? $document->date->day . " de " . $document->date->monthName ." del ". $document->date->year: '' }}</div>

            </div>

            <div style="clear: both; padding-bottom: 10px"></div>

            <div>
                {!! $document->content !!}
            </div>

            <table style="height: 36px; width: 100%; border-collapse: collapse; margin-top: 60px" border="0">
                <tbody>
                    <tr>
                        <td style="width: 50%; height: 18px; text-align: center;">__________________________</td>
                        <td style="width: 50%; height: 18px; text-align: center;">__________________________</td>

                    </tr>
                    <tr>
                        <td style="width: 50%; height: 18px; text-align: center;">{!! $document->fromHtmlSign !!}</td>
                        <td style="width: 50%; height: 18px; text-align: center;">{!! $document->forHtml !!}</td>

                    </tr>
                    <tr>
                        <td style="width: 50%; height: 18px; text-align: center;"><strong>Quien entrega</strong></td>
                        <td style="width: 50%; height: 18px; text-align: center;"><strong>Quien recibe</strong></td>

                    </tr>
                    <tr>
                        <td></td>
                        <td style="width: 50%; height: 38px; text-align: center;"><br>_____/_____/_____________</td>
                    </tr>
                </tbody>
            </table>

            <p>Obs:&nbsp;</p>

            <div class="pie_pagina seis center">
                <!--{{ config('app.ss') }}<br-->
                {{ env('APP_SS_ADDRESS') }} - Fono: {{ env('APP_SS_TELEPHONE') }} - {{ env('APP_SS_WEBSITE') }}
            </div>
        </div>

    </body>
</html>
