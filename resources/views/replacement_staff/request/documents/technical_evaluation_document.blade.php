<?php setlocale(LC_ALL, 'es'); ?>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Resumen de la Solicitud de Contratación Nº {{ $technicalEvaluation->requestReplacementStaff->id }}</title>
  <meta name="description" content="">
  <meta name="author" content="Servicio de Salud Iquique">
  <style media="screen">
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 0.75rem;
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
      margin-top: 80px;
    }

    #firmas>div {
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

    th,
    td {
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
      .page-break {
        display: none;
      }
    }

    @media print {
      .page-break {
        display: block;
        page-break-before: always;
      }
    }
  </style>
</head>

<body>
  <div class="content">

    <div class="content">
      <img style="padding-bottom: 4px;" src="images/logo_pluma.jpg" width="120" alt="Logo Servicio de Salud"><br>


      <div class="siete" style="padding-top: 3px;">
        <strong>{{ env('APP_SS') }}</strong>
      </div>
      <div class="seis" style="padding-top: 4px;">
        <strong>Unidad de Reclutamiento y Selección de Personal</strong>
      </div>
      <!-- <div class="seis" style="padding-top: 4px;">
        <strong>{{ env('APP_SS_RUN') }}</strong>
      </div> -->

      <!-- <div class="right" style="float: right;">
        <div class="left" style="padding-bottom: 6px;">
          <strong>FECHA DE ORDEN: </strong>
        </div>
      </div> -->

      <div style="clear: both; padding-bottom: 5px">&nbsp;</div>

      <div class="center">
        <div class="titulo" style="padding-bottom: 6px;">
          <strong>Resumen de la Solicitud de Contratación </strong>
        </div>
      </div>

      <div style="clear: both; padding-bottom: 5px">&nbsp;</div>

      <table class="table table-sm table-bordered">
          <thead>
              <tr class="table-active">
                  <td colspan="3"><strong>Formulario Contratación de Personal - Solicitud Nº {{ $technicalEvaluation->requestReplacementStaff->id }}</strong></td>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td><strong>Estado</strong></td>
                  <td colspan="2">
                      {{ $technicalEvaluation->requestReplacementStaff->StatusValue }}
                  </td>
              </tr>
              <tr>
                  <td><strong>Por medio del presente</strong></td>
                  <td colspan="2">
                      {{ $technicalEvaluation->requestReplacementStaff->organizationalUnit->name }}
                  </td>
              </tr>
              <tr>
                  <td><strong>Nombre / Nº de Cargos</strong></td>
                  <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->name }}</td>
                  <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->charges_number }}</td>
              </tr>
              <tr>
                  <td><strong>Estamento / Grado</strong></td>
                  <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->profile_manage->name }}</td>
                  <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->degree }}</td>
              </tr>
              <tr>
                  <td><strong>Calidad Jurídica / $ Honorarios</strong></td>
                  <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->legalQualityManage->NameValue }}</td>
                  <td style="width: 33%">
                    @if($technicalEvaluation->requestReplacementStaff->LegalQualityValue == 'Honorarios')
                        ${{ number_format($technicalEvaluation->requestReplacementStaff->salary,0,",",".") }}
                    @endif
                  </td>
              </tr>
              <tr>
                  <td><strong>La Persona cumplirá labores en / Jornada</strong></td>
                  <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->WorkDayValue }}</td>
                  <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->other_work_day }}</td>
              </tr>
              <tr>
                  <td>
                    <strong>
                    Fundamento de la Contratación<br>
                    Detalle de Fundamento
                    <strong>
                  </td>
                  <td style="width: 33%">
                    {{ $technicalEvaluation->requestReplacementStaff->fundamentManage->NameValue }}<br>
                    {{ $technicalEvaluation->requestReplacementStaff->fundamentDetailManage->NameValue }}
                  </td>
                  <td style="width: 33%">De funcionario: {{ $technicalEvaluation->requestReplacementStaff->name_to_replace }}</td>
              </tr>
              <tr>
                  <td><strong>Otro Fundamento (especifique)</strong></td>
                  <td colspan="2">{{ $technicalEvaluation->requestReplacementStaff->other_fundament }}</td>
              </tr>
              <tr>
                  <td><strong>Periodo</strong></td>
                  <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->start_date->format('d-m-Y') }}</td>
                  <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->end_date->format('d-m-Y') }}</td>
              </tr>
              <tr>
                  <td><strong>Lugar de Desempeño</strong></td>
                  <td colspan="2">{{ $technicalEvaluation->requestReplacementStaff->ouPerformance->name }}</td>
              </tr>
          </tbody>
      </table>

      <div style="clear: both; padding-bottom: 5px">&nbsp;</div>

      <div class="row">
          <div class="col-sm-12">
              <h3>&nbsp; Proceso de firmas</h3>
          </div>
      </div>

      <table class="table table-sm table-bordered">
          <tbody>
              <tr>
                  @foreach($technicalEvaluation->requestReplacementStaff->RequestSign as $sign)
                    <td align="center">
                      <strong>
                        {{ $sign->organizationalUnit->name }}<br>
                      </strong>
                    </td>
                  @endforeach
              </tr>
              <tr>
                  @foreach($technicalEvaluation->requestReplacementStaff->RequestSign as $requestSign)
                    <td align="center">
                        @if($requestSign->request_status == 'accepted')
                            {{ $requestSign->StatusValue }}<br>
                            {{ $requestSign->user->FullName }}<br>
                            {{ ($requestSign->date_sign) ? $requestSign->date_sign->format('d-m-Y H:i:s') : '' }}<br>
                        @endif
                        @if($requestSign->request_status == 'rejected')
                            {{ $requestSign->StatusValue }}<br>
                            {{ $requestSign->user->FullName }}<br>
                            {{ $requestSign->date_sign->format('d-m-Y H:i:s') }}<br>
                            <hr>
                            {{ $requestSign->observation }}<br>
                        @endif
                        @if($requestSign->request_status == 'pending' || $requestSign->request_status == NULL)
                            <i class="fas fa-clock"></i> Pendiente.<br>
                        @endif
                    </td>
                  @endforeach
              </tr>
          </tbody>
      </table>

      <div style="clear: both; padding-bottom: 5px">&nbsp;</div>

      <table class="table table-sm table-bordered">
          <tbody>
              <tr>
              @if($technicalEvaluation)
                @if($technicalEvaluation->technical_evaluation_status == 'complete' ||
                  $technicalEvaluation->technical_evaluation_status == 'rejected')
                  <tr>
                      <td style="width: 33%"><strong>Estado de Solicitud</strong></td>
                      <td colspan="2">{{ $technicalEvaluation->requestReplacementStaff->StatusValue }}</td>
                  </tr>
                  <tr>
                      <td><strong>Fecha de Cierre</strong></td>
                      <td colspan="2">{{ $technicalEvaluation->requestReplacementStaff->technicalEvaluation->date_end->format('d-m-Y H:i:s') }}</td>
                  </tr>
                @endif
              @endif
          </tbody>
      </table>

      <div style="clear: both; padding-bottom: 5px">&nbsp;</div>

      @if($technicalEvaluation &&
              $technicalEvaluation->commissions->count() > 0)
          <h3>&nbsp; Integrantes Comisión</h3>
          <table class="table table-sm table-bordered">
              <thead class="text-center">
                  <tr>
                      <th>Nombre</th>
                      <th>Unidad Organizacional</th>
                      <th>Cargo</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($technicalEvaluation->commissions as $commission)
                  <tr>
                      <td>{{ $commission->user->FullName }}</td>
                      <td>{{ $commission->user->organizationalUnit->name }}</td>
                      <td>{{ $commission->job_title }}</td>
                  </tr>
                @endforeach
              </tbody>
          </table>

          <div style="clear: both; padding-bottom: 5px">&nbsp;</div>

      @endif

      @if($technicalEvaluation &&
        $technicalEvaluation->reason != NULL)

          <h3>&nbsp; Proceso Selección Finalizado</h3>
          <table class="table table-sm table-bordered">
              <thead class="text-center">
                  <tr>
                      <th>Motivo</th>
                      <th>Observación</th>
                      <th>Fecha</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>{{ $technicalEvaluation->ReasonValue }}</td>
                      <td>{{ $technicalEvaluation->observation }}</td>
                      <td>{{ $technicalEvaluation->date_end->format('d-m-Y H:i:s') }}</td>
                  </tr>
              </tbody>
          </table>

          <div style="clear: both; padding-bottom: 5px">&nbsp;</div>

      @endif

      @if($technicalEvaluation->requestReplacementStaff->technicalEvaluation &&
              $technicalEvaluation->requestReplacementStaff->technicalEvaluation->applicants->count() > 0)

          <h3>&nbsp; Postulantes a cargo(s)</h3>
          <table class="table table-sm table-striped table-bordered">
              <thead class="text-center">
                  <tr>
                      <th style="width: 8%">Estado</th>
                      <th>Nombre</th>
                      <th>Calificación Evaluación Psicolaboral</th>
                      <th>Calificación Evaluación Técnica y/o de Apreciación Global</th>
                      <th>Observaciones</th>
                      <th style="width: 10%">Ingreso Efectivo</th>
                      <th style="width: 10%">Fin</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($technicalEvaluation->applicants->sortByDesc('score') as $applicant)
                  <tr class="{{ ($applicant->selected == 1 && $applicant->desist == NULL)?'table-success':''}}">
                      <td>
                          @if($applicant->selected == 1 && $applicant->desist == NULL)
                              Seleccionado
                          @endif
                          @if($applicant->desist == 1)
                              @if($applicant->reason == 'renuncia a reemplazo')
                                  Renuncia a reemplazo (Posterior ingreso)
                              @endif
                              @if($applicant->reason == 'rechazo oferta laboral')
                                  Rechazo oferta laboral (Previo ingreso)
                              @endif
                          @endif
                      </td>
                      <td>{{ $applicant->replacementStaff->FullName }}</td>
                      <td align="center">{{ $applicant->psycholabor_evaluation_score }} <br> {{ $applicant->PsyEvaScore }}</td>
                      <td align="center">{{ $applicant->technical_evaluation_score }} <br> {{ $applicant->TechEvaScore }}</td>
                      <td>{{ $applicant->observations }}</td>
                      <td>{{ ($applicant->start_date) ? $applicant->start_date->format('d-m-Y') : '' }}</td>
                      <td>{{ ($applicant->end_date) ? $applicant->end_date->format('d-m-Y') : '' }}</td>
                  </tr>
                @endforeach
              </tbody>
          </table>

          <div style="clear: both; padding-bottom: 5px">&nbsp;</div>
      @endif

      <div class="pie_pagina center seis">
          <!--{{ env('APP_SS') }}<br-->
          Esto es informe extraído de {{ env('APP_NAME') }} -  {{ env('APP_SS') }}
      </div>
    </div>
</body>

</html>
