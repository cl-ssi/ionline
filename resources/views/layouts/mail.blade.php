<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="utf-8">
        <title>@yield('firmante')</title>
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
            }
            .linea_azul {
                background-color: #0168B3;
                width: 58px;
            }
            .linea_roja {
                background-color: #EE3A43;
                width: 82px;
            }
            .letra_servicio {
                font-size:10.5pt;
                font-family: Arial, Helvetica, sans-serif;
                color: #505050;
                font-weight: 800;
                width: 140px;
            }
            .letra_ministerio {
                font-size:9.0pt;
                font-family: Arial, Helvetica, sans-serif;
                padding-top: 6px;
                font-weight: 600;
                color: #808080;
            }
            .letra_gobierno {
                font-size:8.4pt;
                font-family: Arial, Helvetica, sans-serif;
                font-weight: 800;
                padding-top: 3px;
                color: #808080;
            }
            .alto_membrete {
                height: 18px;
            }
            .alto_firma {
                height: 2px;
            }
            .cuerpo {
                border: 0px;
            }
            .texto {
                font-size: 10pt;
                font-family: Arial, Helvetica, sans-serif;
                text-align: justify;
                /*color: #404040;*/
            }
            .texto_footer {
                font-size:8.5pt;
                font-family: Arial, Helvetica, sans-serif;
                color: #7F7F7F;
            }
            @media print {
                body {-webkit-print-color-adjust: exact;}
            }
            .tabla {
                border-spacing: 0;
                border-collapse: collapse;
            }
        </style>
    </head>

    <body>
        <table style="border-spacing: 0; border-collapse: collapse;" class="tabla" width="144">
            <tr class="alto_membrete">
                <td style="background-color: #0168B3; width: 58px;" class="linea_azul alto_membrete">&nbsp;</td>
                <td style="background-color: #EE3A43; width: 82px;" class="linea_roja alto_membrete">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="letra_servicio"
                        style="font-size:10.5pt;
                                font-family: Arial, Helvetica, sans-serif;
                                color: #505050;
                                font-weight: 800;
                                width: 140px;">{{ env('APP_SS') }}</div>
                    <div class="letra_ministerio"
                        style="font-size:9.0pt;
                                font-family: Arial, Helvetica, sans-serif;
                                padding-top: 6px;
                                font-weight: 600;
                                color: #808080;">Ministerio de Salud</div>
                    <div class="letra_gobierno"
                        style="font-size:8.4pt;
                                font-family: Arial, Helvetica, sans-serif;
                                font-weight: 800;
                                padding-top: 3px;
                                color: #808080;">Gobierno de Chile</div>
                </td>
            </tr>
        </table>

        <table class="cuerpo">
            <tr>
                <td width="160" id="margen_izquierdo"></td>
                <td class="texto">
                    @yield('content')
                    <br>
                </td>
            </tr>
        </table>

        <table style="border-spacing: 0; border-collapse: collapse; margin-top: 10px;" class="tabla">
            <tr>
                <td style="background-color: #0168B3; width: 58px;" class="linea_azul alto_firma"></td>
                <td style="background-color: #EE3A43; width: 82px;" class="linea_roja alto_firma"></td>
                <td class="alto_firma" style="width: 100px;"></td>
            </tr>
            <tr>
                <td colspan="3">
                    <p style="font-size:8.5pt;" class="texto_footer">
                        <b>@yield('firmante')</b></br>
                        @yield('linea1')</br>
                        @yield('linea2')</br>
                        @yield('linea3')
                    </p>
                </td>
            </tr>
        </table>

    </body>

</html>
