<?php setlocale(LC_ALL, 'es_CL.UTF-8');?>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Certificado de cumplimiento</title>
        <meta name="description" content="">
        <meta name="author" content="Servicio de Salud Iquique">
        <style media="screen">
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.8rem;
        }
        .content {
            margin: 0 auto;
            /*border: 1px solid #F2F2F2;*/
            width: 724px;
            /*height: 1100px;*/
        }
        .monospace {
            font-family: "Lucida Console", Monaco, monospace;
        }
        .pie_pagina {
            margin: 0 auto;
            /*border: 1px solid #F2F2F2;*/
            width: 724px;
            height: 26px;
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
        .plomo {
            background-color: F3F1F0;
        }
        .titulo {
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 4px 0 6px;
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

        .indent {
            text-indent: 30px;
        }

        .uppercase {
            text-transform: uppercase;
        }

        #firmas {
            margin-top: 100px;
        }

        #firmas > div {
            display: inline-block;
        }

        .li_letras {
            list-style-type: lower-alpha;
        }

        table {
            border: 1px solid grey;
            border-collapse: collapse;
            padding: 0 4px 0 4px;
            width: 100%;
        }
        th, td {
            border: 1px solid grey;
            border-collapse: collapse;
            padding: 0 4px 0 4px;
        }

        .column {
          float: left;
          width: 50%;
        }

        /* Clear floats after the columns */
        .row:after {
          content: "";
          display: table;
          clear: both;
        }

        @media all {
            .page-break { display: none; }
        }

        @media print {
            .page-break { display: block; page-break-before: always; }
        }

        </style>
    </head>
    <body>
        <div class="content">

                <div class="content">
                    <img style="padding-bottom: 4px;" src="images/logo_pluma.jpg"
                        width="120" alt="Logo Servicio de Salud"><br>


<div class="siete" style="padding-top: 3px;">
    HOSPITAL DR. ERNESTO TORRES GALDÁMEZ<br>
    SUBDIRECCIÓN DE GESTIÓN Y DESARROLLO DE LAS PERSONAS
</div>

<br><br><br><br><br><br><br><br>
<div class="titulo">
    <div class="center" style="width: 100%;">
        <strong>
        <span class="uppercase">CERTIFICADO</span><br>
        </strong>
    </div>
</div>

<br><br><br><br>


@if($fulfillment->FulfillmentAbsences->count() == 0)
  <div class="nueve">
      <div class="justify" style="width: 100%;">
          Mediante el presente certifico que don(a) o Sr(a) <b><span class="uppercase">{{$fulfillment->serviceRequest->name}}</span></b> ha desempeñado las actividades estipuladas
          en su convenio de prestación de servicios con el Hospital Dr.Ernesto Torres Galdames durante el preríodo de contingencia COVID
          del <b>{{$fulfillment->start_date->format('d/m/Y')}}</b> al <b>{{$fulfillment->end_date->format('d/m/Y')}}</b>.
      </div>
  </div>
@else
  <div class="nueve">
      <div class="justify" style="width: 100%;">
          Mediante el presente certifico que don(a) o Sr(a) <b><span class="uppercase">{{$fulfillment->serviceRequest->name}}</span></b> ha desempeñado las actividades estipuladas
          en su convenio de prestación de servicios con el Hospital Dr.Ernesto Torres Galdames durante el preríodo de contingencia COVID
          del <b>{{$fulfillment->start_date->format('d/m/Y')}}</b> al <b>{{$fulfillment->end_date->format('d/m/Y')}}</b>, registrando las siguientes ausencias:
      </div>
  </div>

  <br><br>

  <table class="siete">
    <thead>
      <tr>
        <th>Tipo</th>
        <th>Inicio</th>
        <th>Término</th>
        <th>Observación</th>
      </tr>
    </thead>
    <tbody>
      @foreach($fulfillment->FulfillmentAbsences as $key =>$FulfillmentAbsence)
      <tr>
          <td style="text-align:center">{{$FulfillmentAbsence->type}}</td>
          <td style="text-align:center">{{$FulfillmentAbsence->start_date->format('d-m-Y H:i')}}</td>
          <td style="text-align:center">{{$FulfillmentAbsence->end_date->format('d-m-Y H:i')}}</td>
          <td style="text-align:center">{{$FulfillmentAbsence->observation}}</td>
      </tr>
      @endforeach
  </table>
@endif

<br style="padding-bottom: 10px;">

<div id="firmas">
    <div class="center" style="width: 100%;">
        <strong>
        <span class="uppercase">{{$fulfillment->serviceRequest->user->getFullNameAttribute()}}</span><br>
        <span class="uppercase">{{$fulfillment->serviceRequest->user->position}}</span><br>
        <span class="uppercase">{{$fulfillment->serviceRequest->user->organizationalUnit->name}}</span><br>
        HOSPITAL DR ERNESTO TORRES GALDÁMEZ<br>
        </strong>
    </div>
</div>

</body>
</html>
