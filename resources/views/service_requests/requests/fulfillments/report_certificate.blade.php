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
    @if($fulfillment->serviceRequest->responsabilityCenter->establishment_id == 1)
      HOSPITAL DR. ERNESTO TORRES GALDÁMEZ<br>
    @else
      SERVICIO SALUD IQUIQUE<br>
    @endif
    SUBDIRECCIÓN DE GESTIÓN Y DESARROLLO DE LAS PERSONAS
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


@if($fulfillment->serviceRequest->working_day_type == "HORA MÉDICA" or $fulfillment->serviceRequest->working_day_type == "TURNO DE REEMPLAZO")
<?php setlocale(LC_ALL, 'es'); ?>
  <div class="nueve">
      <div class="justify" style="width: 100%;">
          Mediante el presente certifico que <b><span class="uppercase">{{$fulfillment->serviceRequest->employee->fullName}}</span></b> ha desempeñado las actividades
          estipuladas en su convenio de prestación de servicios con el
          @if($fulfillment->serviceRequest->responsabilityCenter->establishment_id == 38)
            @if($fulfillment->serviceRequest->employee->organizationalUnit->id == 24)
              Consultorio General Urbano Dr. Hector Reyno,
              <b> en el mes de {{$fulfillment->start_date->monthName}} del {{$fulfillment->start_date->year}}</b>
              @if($fulfillment->serviceRequest->type == 'Covid')
              durante el periodo de contingencia COVID
              @endif
            @else
              Servicio Salud Iquique,
              <b> en el mes de {{$fulfillment->start_date->monthName}} del {{$fulfillment->start_date->year}}</b>
              @if($fulfillment->serviceRequest->type == 'Covid')
              durante el periodo de contingencia COVID
              @endif
            @endif
          @else
            Hospital Dr. Ernesto Torres Galdames,
            por <b>horas extras realizadas en el mes de {{$fulfillment->start_date->monthName}} del {{$fulfillment->start_date->year}} </b>.
          @endif
            <br><br>


              <table class="siete">
                  <thead>
                  <tr>
                      <th>Inicio</th>
                      <th>Término</th>
                      <th>Observación</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($fulfillment->shiftControls->sortBy('start_date') as $key => $shiftControl)
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

          <br><br>Se extiende el presente certificado para ser presentado en la oficina de finanzas y contabilidad para gestión de pago.
      </div>
  </div>

@else
@if($fulfillment->type == "Mensual" || $fulfillment->type == "Parcial")

  @if($fulfillment->FulfillmentItems->count() == 0)
    <div class="nueve">
        <div class="justify" style="width: 100%;">
            Mediante el presente certifico que <b><span class="uppercase">{{$fulfillment->serviceRequest->employee->fullName}}</span></b> ha desempeñado las actividades estipuladas
            en su convenio de prestación de servicios con el
            @if($fulfillment->serviceRequest->responsabilityCenter->establishment_id == 38)
              @if($fulfillment->serviceRequest->employee->organizationalUnit->id == 24)
                Consultorio General Urbano Dr. Hector Reyno
              @else
                Servicio Salud Iquique
              @endif
            @else
              Hospital Dr.Ernesto Torres Galdames
            @endif
            durante el periodo
            @if($fulfillment->serviceRequest->type == 'Covid')
            de contingencia COVID
            @endif
            del <b>{{$fulfillment->start_date->format('d/m/Y')}}</b> al <b>{{$fulfillment->end_date->format('d/m/Y')}}</b>.

            <br><br>Se extiende el presente certificado para ser presentado en la oficina de finanzas y contabilidad para gestión de pago.
        </div>
    </div>
  @else
    <div class="nueve">
        <div class="justify" style="width: 100%;">
          @if($fulfillment->FulfillmentItems->where('type','Renuncia voluntaria')->count() > 0)
            @if($fulfillment->FulfillmentItems->where('type','!=','Renuncia voluntaria')->count() > 0)
              Junto con saludar, se adjunta renuncia voluntaria a honorarios del funcionario <b><span class="uppercase">{{$fulfillment->serviceRequest->employee->fullName}}</span></b>,
              a contar del <b>{{$fulfillment->FulfillmentItems->where('type','Renuncia voluntaria')->first()->end_date->format('d/m/Y')}}</b>. Además se registraron las siguientes ausencias:
            @else
              Mediante el presente certifico que <b><span class="uppercase">{{$fulfillment->serviceRequest->employee->fullName}}</span></b> ha desempeñado las actividades estipuladas en su convenio de prestación de servicios con el
              <b><span class="uppercase">{{$fulfillment->serviceRequest->establishment->name}}</span></b>,
              @if($fulfillment->serviceRequest->type == 'Covid')
              durante el periodo de
              contingencia COVID
              @endif
              desde
              <b>{{$fulfillment->start_date->format('d/m/Y')}}</b> al <b>{{$fulfillment->FulfillmentItems->where('type','Renuncia voluntaria')->first()->end_date->sub(1, 'day')->format('d/m/Y')}}</b>.
              <br><br>
              Se deja constancia que presentó su renuncia voluntaria a contar del <b>{{$fulfillment->FulfillmentItems->where('type','Renuncia voluntaria')->first()->end_date->format('d/m/Y')}}</b>
            @endif
          @elseif($fulfillment->FulfillmentItems->where('type','Abandono de funciones')->count() > 0)
            @if($fulfillment->FulfillmentItems->where('type','!=','Abandono de funciones')->count() > 0)
            Mediante el presente certifico que <b><span class="uppercase">{{$fulfillment->serviceRequest->employee->fullName}}</span></b> ha desempeñado las actividades estipuladas en su convenio de prestación de servicios con el <b>{{$fulfillment->serviceRequest->establishment->name ?? ''}}</b> del periodo del
              {{$fulfillment->start_date->format('d/m/Y')}}
            al {{$fulfillment->FulfillmentItems->where('type','Abandono de funciones')->first()->end_date->sub(1, 'day')->format('d/m/Y')}} </b>
            <br>
            <br>
            Se deja constancia que el prestador de servicio Abandonó sus funciones a contar del día <b>{{$fulfillment->FulfillmentItems->where('type','Abandono de funciones')->first()->end_date->format('d/m/Y')}}</b>
              Además se registraron las siguientes ausencias:
            @else
            Mediante el presente certifico que <b><span class="uppercase">{{$fulfillment->serviceRequest->employee->fullName}}</span></b> ha desempeñado las     actividades estipuladas en su convenio de prestación de servicios con el <b>{{$fulfillment->serviceRequest->establishment->name ?? ''}}</b> del periodo del
            <b>
            {{$fulfillment->start_date->format('d/m/Y')}}
            al {{$fulfillment->FulfillmentItems->where('type','Abandono de funciones')->first()->end_date->sub(1, 'day')->format('d/m/Y')}} </b>
            <br>
            <br>

            Se deja constancia que el prestador de servicio Abandonó sus funciones a contar del día <b>{{$fulfillment->FulfillmentItems->where('type','Abandono de funciones')->first()->end_date->format('d/m/Y')}}</b>.

              <!-- El prestador de servicios Honorario Suma Alzada , manifestó  de forma verbal o por escrito sin mediar renuncia voluntaria , su intención de no perseverar el contrato de honorarios suscrito con el Hospital , lo que materializo a contar de la fecha de su ausencia al lugar de trabajo desde el día {{$fulfillment->FulfillmentItems->where('type','Abandono de funciones')->first()->end_date->format('d/m/Y')}}. -->
            @endif
            @elseif($fulfillment->FulfillmentItems->where('type','Término de contrato anticipado')->count() > 0)
            @if($fulfillment->FulfillmentItems->where('type','!=','Término de contrato anticipado')->count() > 0)
            Mediante el presente certifico que <b><span class="uppercase">{{$fulfillment->serviceRequest->employee->fullName}}</span></b> ha desempeñado las     actividades estipuladas en su convenio de prestación de servicios con el <b>{{$fulfillment->serviceRequest->establishment->name ?? ''}}</b> del periodo del
            <b>
            {{$fulfillment->start_date->format('d/m/Y')}}
            al {{$fulfillment->FulfillmentItems->where('type','Término de contrato anticipado')->first()->end_date->sub(1, 'day')->format('d/m/Y')}}
            </b>
            <br>
            <br>
            Se deja constancia que el prestador de servicio se le realizó por parte de su jefatura directa un Término de contrato anticipado a contar del día
            <b>{{$fulfillment->FulfillmentItems->where('type','Término de contrato anticipado')->first()->end_date->format('d/m/Y')}}</b>
            @else
            Mediante el presente certifico que <b><span class="uppercase">{{$fulfillment->serviceRequest->employee->fullName}}</span></b> ha desempeñado las     actividades estipuladas en su convenio de prestación de servicios con el <b>{{$fulfillment->serviceRequest->establishment->name ?? ''}}</b> del periodo del
            <b>
            {{$fulfillment->start_date->format('d/m/Y')}}
            al {{$fulfillment->FulfillmentItems->where('type','Término de contrato anticipado')->first()->end_date->sub(1, 'day')->format('d/m/Y')}}
            </b>
            <br>
            <br>
            Se deja constancia que el prestador de servicio se le realizó por parte de su jefatura directa un Término de contrato anticipado a contar del día
            <b>{{$fulfillment->FulfillmentItems->where('type','Término de contrato anticipado')->first()->end_date->format('d/m/Y')}}</b>
            @endif


          @else
            Mediante el presente certifico que <b><span class="uppercase">{{$fulfillment->serviceRequest->employee->fullName}}</span></b> ha desempeñado las actividades estipuladas
            en su convenio de prestación de servicios con el
            @if($fulfillment->serviceRequest->responsabilityCenter->establishment_id == 38)
              @if($fulfillment->serviceRequest->employee->organizationalUnit->id == 24)
                Consultorio General Urbano Dr. Hector Reyno
              @else
                Servicio Salud Iquique
              @endif
            @else
              Hospital Dr.Ernesto Torres Galdames
            @endif

            @if($fulfillment->serviceRequest->type == 'Covid')
              durante el periodo de contingencia COVID
            @endif

            <!-- contingencia COVID del  -->
            <b>{{$fulfillment->start_date->format('d/m/Y')}}</b> al <b>{{$fulfillment->end_date->format('d/m/Y')}}</b>,
            registrando las siguientes ausencias:
          @endif
        </div>
    </div>

    <br><br>


        @if($fulfillment->FulfillmentItems->whereIn('type',['Renuncia voluntaria','Abandono de funciones'])->count() > 0)
          @if($fulfillment->FulfillmentItems->whereNotIn('type',['Renuncia voluntaria','Abandono de funciones'])->count() > 0)
            @foreach($fulfillment->FulfillmentItems->whereNotIn('type',['Renuncia voluntaria','Abandono de funciones']) as $key =>$FulfillmentItem)
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
                <tr>
                    <td style="text-align:center">{{$FulfillmentItem->type ?? ''}}</td>
                    <td style="text-align:center">{{$FulfillmentItem->start_date ? $FulfillmentItem->start_date->format('d-m-Y H:i'):''}}</td>
                    <td style="text-align:center">{{$FulfillmentItem->end_date ? $FulfillmentItem->end_date->format('d-m-Y H:i'):''}}</td>
                    <td style="text-align:center">{{$FulfillmentItem->observation ??''}}</td>
                </tr>
              </tbody>
            </table>
            <br>
            @endforeach
          @endif
        @else
          @foreach($fulfillment->FulfillmentItems as $key =>$FulfillmentItem)
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
              <tr>
                  <td style="text-align:center">{{$FulfillmentItem->type ?? ''}}</td>
                  <td style="text-align:center">{{$FulfillmentItem->start_date ? $FulfillmentItem->start_date->format('d-m-Y H:i'): ''}}</td>
                  <td style="text-align:center">{{$FulfillmentItem->end_date ? $FulfillmentItem->end_date->format('d-m-Y H:i'):''}}</td>
                  <td style="text-align:center">{{$FulfillmentItem->observation??''}}</td>
              </tr>
            </tbody>
          </table>
          <br>
          @endforeach
        @endif

    <div class="nueve">
        <div class="justify" style="width: 100%;">
          Se extiende el presente certificado para ser presentado en la oficina de finanzas y contabilidad para gestión de pago.
        </div>
    </div>
  @endif
@else

  <?php setlocale(LC_ALL, 'es'); ?>
  <div class="nueve">
      <div class="justify" style="width: 100%;">
          Mediante el presente certifico que <b><span class="uppercase">{{$fulfillment->serviceRequest->employee->fullName}}</span></b> ha desempeñado las actividades
          estipuladas en su convenio de prestación de servicios con el
          @if($fulfillment->serviceRequest->responsabilityCenter->establishment_id == 38)
            @if($fulfillment->serviceRequest->employee->organizationalUnit->id == 24)
              Consultorio General Urbano Dr. Hector Reyno,
              <b> en el mes de {{$fulfillment->start_date->monthName}} del {{$fulfillment->start_date->year}}</b>
              @if($fulfillment->serviceRequest->type == 'Covid')
              durante el periodo de contingencia COVID
              @endif
            @else
              Servicio Salud Iquique,
              <b> en el mes de {{$fulfillment->start_date->monthName}} del {{$fulfillment->start_date->year}}</b>
              @if($fulfillment->serviceRequest->type == 'Covid')
              durante el periodo de contingencia COVID
              @endif
            @endif
          @else
            Hospital Dr. Ernesto Torres Galdames,
            por <b>horas extras realizadas en el mes de {{$fulfillment->start_date->monthName}} del {{$fulfillment->start_date->year}} </b>.
          @endif
            <br><br>


              <table class="siete">
                  <thead>
                  <tr>
                      <th>Inicio</th>
                      <th>Término</th>
                      <th>Observación</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($fulfillment->shiftControls->sortBy('start_date') as $key => $shiftControl)
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

          <br><br>Se extiende el presente certificado para ser presentado en la oficina de finanzas y contabilidad para gestión de pago.
      </div>
  </div>
@endif

@endif


<br style="padding-bottom: 10px;">

<br><br><br><br>

<div id="firmas">
    <div class="center" style="width: 100%;">
        <strong>
        <span class="uppercase">{{ $signer->fullName }}</span><br>
        <span class="uppercase">{{ $signer->position }}</span><br>
        <span class="uppercase">{{ $signer->organizationalUnit->name }}</span><br>

        @if($fulfillment->serviceRequest->responsabilityCenter->establishment_id == 38)
          @if($fulfillment->serviceRequest->employee->organizationalUnit->id == 24)
            CONSULTORIO GENERAL URBANO DR. HECTOR REYNO<br>
          @else
            SERVICIO SALUD IQUIQUE<br>
          @endif
        @else
          HOSPITAL DR ERNESTO TORRES GALDÁMEZ<br>
        @endif
        </strong>
    </div>
</div>

</body>
</html>
