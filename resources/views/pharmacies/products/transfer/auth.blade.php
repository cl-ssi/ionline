<?php setlocale(LC_ALL, 'es_CL.UTF-8');?>
<html lang="es">
    <!-- FIXME: hacer un layout en vez de tener el codigo acá, quizá utilizar
        el de reportes de ilícios.
    -->
    <head>
        <meta charset="utf-8">
        <title>Intranet - DOCUMENTO DE AUTORIZACIÓN DE ENTREGA DE AYUDAS TÉCNICAS
PROGRAMA DE REHABILITACIÓN INTEGRAL </title>
        <meta name="description" content="Documento">
        <meta name="author" content="Alvaro Torres F. <alvaro.torres@redsalud.gob.cl>">

        <style>
            body, table {
                font-family: Arial, Helvetica, sans-serif;
                /*font-family: "Lucida Console", Monaco, monospace;*/
                font-size: 0.8rem;
            }
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 5px;
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
    <?php setlocale(LC_ALL, 'es'); ?>
    <body>

        <div class="content">
            <img src="{{ asset('images/logo_pluma.jpg') }}" width="120" alt="Logo servicio de salud"><br>
            <div class="left seis" style="padding-bottom: 6px; color: #999">N° interno AATT: _________</div>

            <p class="right">Iquique, {{\Carbon\Carbon::now()->formatLocalized('%d de %B de %Y')}}.</p>
            <p>Mediante el presente documento y en marco a los problemas de <b>salud 36, piloto GES y decreto 22</b>, y a la evaluación de información de solicitud y entrega de ayudas técnicas ingresada por su establecimiento en plataforma i.saludiquique.cl, mediante el presente se informa a usted que las siguientes ayudas técnicas de encuentran disponible para ser retiradas en bodega del servicio de salud iquique:</p>
            <p>Entrega para establecimiento <b>{{$establishment->name}}</b></p>
			<table>
				<thead>
					<th width="200">Ayuda técnica</th>
					<th>Según stock disponible en establecimiento</th>
					<th>Para stock crítico en establecimiento</th>
					<th>Para pendientes de entrega</th>
					<th>Total a entregar</th>
				</thead>
				<tbody>
                    @forelse($establishment->products as $product)
                        @php( $pendientes = isset($pendings_by_product[$product->id]) ? $pendings_by_product[$product->id] : 0 )
                        @if($product->pivot->critic_stock + $pendientes > $product->pivot->stock)
                        <tr>
                            <td class="left"><b>{{$product->name}}</b></td>
                            <td class="center">{{$product->pivot->stock}}</td>
                            <td class="center">{{$product->pivot->critic_stock - $product->pivot->stock}}</td>
                            <td class="center">{{$pendientes}}</td>
                            <td class="center"><b>{{$product->pivot->critic_stock + $pendientes - $product->pivot->stock}}</b></td>
                        </tr>
                        @endif
					@empty
						<tr><td colspan="5" class="text-center">Sin productos</td></tr>
					@endforelse
				</tbody>
			</table>
            <ul>
                <li>Lugar de Retiro:  Obispo Labbe #962</li>
                <li>Horarios:  08:30 - 13:00 hrs. y 14:30 – 16:00 hrs. </li>
            </ul>
            <div class="firma center" style="padding-top: 68px; text-transform: uppercase; padding-bottom: 8px;">
                <div style="padding-bottom: 4px;">___________________________________</div>
                <div style="padding-bottom: 4px;">{{Auth::user()->fullName}}</div>
                <div style="padding-bottom: 4px;">REFERENTE TÉCNICO PROGRAMA DE REHABILITACIÓN INTEGRAL</div>
                <div>{{ env('APP_SS') }}</div>
            </div>


            <div class="firma seis" style="padding-top: 6px; padding-bottom: 8px; display: inline-block; vertical-align:top; width: 49%;">
                <div style="padding-bottom: 4px;"><strong>DISTRIBUCIÓN:</strong></div>
                <div style="padding-bottom: 4px;">
                <!-- <ul>
                    <li>Saludcamina@gmail.com</li>
                    <li>cinthia.ga.chavez@gmail.com</li>
                    <li>Francis.henriquez@redsalud.gov.cl</li>
                    <li>bodega.ssi@redsalud.gob.cl</li>
                    <li>Aps.ssi@redsalud.gov.cl</li>
                    <li>Oficina de partes SSI</li>
                </ul> -->
            
                </div>
            </div>

            <div class="pie_pagina seis center">
                <!--{{ env('APP_SS') }}<br-->
                {{ env('APP_SS_ADDRESS') }} - Fono: {{ env('APP_SS_TELEPHONE') }} - {{ env('APP_SS_WEBSITE') }}
            </div>
        </div>

    </body>
</html>
