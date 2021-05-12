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
  
</div>

<br><br>
<div class="titulo">
    <div class="center" style="width: 100%;">
        <strong>
        <span class="uppercase">Certificado de Cumplimiento</span><br>
        </strong>
    </div>
</div>

<br><br>


    <br><br>Se extiende el presente certificado para ser presentado en la oficina de finanzas y contabilidad para gestión de pago.


  <?php setlocale(LC_ALL, 'es'); ?>
  <div class="nueve">
      <div class="justify" style="width: 100%;">
          Mediante el presente certifico que <b><span class="uppercase">{{$fulfillment->serviceRequest->employee->fullName}}</span></b> ha desempeñado las actividades
          estipuladas en su convenio de prestación de servicios con el
          @if($fulfillment->serviceRequest->responsabilityCenter->establishment_id == 38)
            @if($fulfillment->serviceRequest->employee->organizationalUnit->id == 24)
              Consultorio General Urbano Dr. Hector Reyno,
            @else
              Servicio Salud Iquique,
            @endif
          @else
            Hospital Dr. Ernesto Torres Galdames,
          @endif
            por <b>horas extras realizadas en el mes de {{$fulfillment->start_date->monthName}} del {{$fulfillment->start_date->year}} por contingencia COVID</b>.<br><br>


              <table class="siete">
                  <thead>
                  <tr>
                      <th>Inicio</th>
                      <th>Término</th>
                      <th>Observación</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($fulfillment->shiftControls as $key => $shiftControl)
                      <tr>
                          <td>{{$shiftControl->start_date->format('d-m-Y H:i')}}</td>
                          <td>{{$shiftControl->end_date->format('d-m-Y H:i')}}</td>
                          <td>{{ ($fulfillment->serviceRequest->working_day_type == 'DIURNO PASADO A TURNO') ? 'DIURNO PASADO A TURNO' : $shiftControl->observation}}</td>
                      </tr>
                  @endforeach
              </table>
          <br>
          @livewire('service-request.show-total-hours', ['fulfillment' => $fulfillment,
                                                         'forCertificate' => true])

          <br><br>Se extiende el presente certificado para ser presentado en recursos humanos, para que éste acredite la asistencia del funcionario. 
          Para posteriormente finanzas y contabilidad realice la gestión de pago.
      </div>
  </div>




<br style="padding-bottom: 10px;">

<br><br><br><br>

<div id="firmas">
    <div class="center" style="width: 100%;">
        <strong>
        <span class="uppercase"></span><br>
        <span class="uppercase"></span><br>
        <span class="uppercase"></span><br>

        
          HOSPITAL DR ERNESTO TORRES GALDÁMEZ<br>
        
        </strong>
    </div>
</div>

</body>
</html>
