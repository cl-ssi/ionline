<?php setlocale(LC_ALL, 'es'); ?>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Resumen de la Solicitud de Contratación Nº {{ $requestReplacementStaff->id }}</title>
  <meta name="description" content="">
  <meta name="author" content="Servicio de Salud Tarapacá">
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
      <img style="padding-bottom: 4px;" src="images/Logo Servicio de Salud Tarapacá - Pluma.png" width="120" alt="Logo Servicio de Salud"><br>


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
                  <td colspan="3"><strong>Formulario Contratación de Personal - Solicitud Nº {{ $requestReplacementStaff->id }}</strong></td>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td><strong>Estado</strong></td>
                  <td colspan="2">
                      {{ $requestReplacementStaff->StatusValue }}
                  </td>
              </tr>
              <tr>
                  <td><strong>Solicitante</strong></th>
                  <td style="width: 33%">{{ $requestReplacementStaff->user->fullName }}</td>
                  <td style="width: 33%">{{ $requestReplacementStaff->organizationalUnit->name }}</td>
              </tr>
              <tr>
                  <td><strong>Nombre de Formulario / Nº de Cargos</strong></td>
                  <td style="width: 33%">{{ $requestReplacementStaff->name }}</td>
                  <td style="width: 33%">{{ $requestReplacementStaff->charges_number }}</td>
              </tr>
              <tr>
                  <td><strong>Estamento / Ley / Grado</strong></td>
                  <td style="width: 33%">{{ $requestReplacementStaff->profile_manage->name }}</td>
                  <td style="width: 33%">{{ ($requestReplacementStaff->law) ? 'Ley N° '.number_format($requestReplacementStaff->law, 0, ",", ".").' -' : '' }} {{ ($requestReplacementStaff->degree) ? $requestReplacementStaff->degree : 'Sin especificar grado' }}</td>
              </tr>
              <tr>
                  <td><strong>Periodo</strong></td>
                  <td style="width: 33%">{{ $requestReplacementStaff->start_date->format('d-m-Y') }}</td>
                  <td style="width: 33%">{{ $requestReplacementStaff->end_date->format('d-m-Y') }}</td>
              </tr>
              <tr>
                  <td><strong>Calidad Jurídica / $ Honorarios</strong></td>
                  <td style="width: 33%">{{ $requestReplacementStaff->legalQualityManage->NameValue }}</td>
                  <td style="width: 33%">
                    @if($requestReplacementStaff->LegalQualityValue == 'Honorarios')
                        ${{ number_format($requestReplacementStaff->salary,0,",",".") }}
                    @endif
                  </td>
              </tr>
              <tr>
                  <td><strong>Fundamento de la Contratación / Detalle de Fundamento</strong></td>
                  <td style="width: 33%">
                    {{ $requestReplacementStaff->fundamentManage->NameValue }}
                  </td>
                  <td style="width: 33%">
                    {{ ($requestReplacementStaff->fundamentDetailManage) ? $requestReplacementStaff->fundamentDetailManage->NameValue : '' }}
                  </td>
              </tr>
              <tr>
                  <td><strong>Otro Fundamento (especifique)</strong></td>
                  <td colspan="2">{{ $requestReplacementStaff->other_fundament }}</td>
              </tr>
              <tr>
                  <td><strong>Funcionario a Reemplazar</strong></td>
                  <td style="width: 33%">
                    @if($requestReplacementStaff->run)
                        {{$requestReplacementStaff->run}}-{{$requestReplacementStaff->dv}}
                    @endif
                  </td>
                  <td style="width: 33%">{{ $requestReplacementStaff->name_to_replace }}</td>
              </tr>
              <tr>
                  <td><strong>La Persona cumplirá labores en / Jornada</strong></td>
                  <td style="width: 33%">{{ $requestReplacementStaff->WorkDayValue }}</td>
                  <td style="width: 33%">{{ $requestReplacementStaff->other_work_day }}</td>
              </tr>
              <tr>
                  <td><strong>Lugar de Desempeño</strong></td>
                  <td colspan="2">{{ $requestReplacementStaff->ouPerformance->name }}</td>
              </tr>
              <tr>
                  <td><strong>Staff Sugerido</strong></td>
                  <td colspan="2">
                    @if($requestReplacementStaff->replacementStaff)
                        {{ $requestReplacementStaff->replacementStaff->fullName }}
                    @endif
                  </td>
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
                  @if(count($requestReplacementStaff->approvals) > 0)
                      <!-- APPROVALS DE JEFATURA DIRECTA -->
                      @foreach($requestReplacementStaff->approvals as $approval)
                        @if($approval->subject == "Solicitud de Aprobación Jefatura Depto. o Unidad")
                              <th class="table-active text-center">
                                  {{ $approval->sentToOu->name }}
                              </th >     
                          @endif
                      @endforeach
                      <!-- APROBACION DE PERSONAL -->
                      @foreach($requestReplacementStaff->requestSign as $sign)
                          <th class="table-active text-center">
                              {{ $sign->organizationalUnit->name }}
                          </th>
                      @endforeach
                      <!-- APPROVALS DE PLANIFICACION, SDGP, FINANZAS -->
                      @foreach($requestReplacementStaff->approvals as $approval)
                        @if($approval->subject != "Solicitud de Aprobación Jefatura Depto. o Unidad")
                              <th class="table-active text-center">
                                  {{ $approval->sentToOu->name }}
                              </th >     
                          @endif
                      @endforeach
                  @else
                      @foreach($requestReplacementStaff->requestSign as $sign)
                          <th class="table-active text-center">
                              {{ $sign->organizationalUnit->name }}
                          </th>
                      @endforeach
                  @endif
              </tr>
              <tr>
                  @if(count($requestReplacementStaff->approvals) > 0)
                      <!-- APPROVALS DE JEFATURA DIRECTA -->
                      @foreach($requestReplacementStaff->approvals as $approval)
                          @if($approval->subject == "Solicitud de Aprobación Jefatura Depto. o Unidad")
                              <td align="center"> 
                                  @if($approval->StatusInWords == "Aprobado")
                                      {{ $approval->StatusInWords }}<br>
                                      {{ $approval->approver->fullName }}<br>
                                      {{ $approval->approver_at->format('d-m-Y H:i:s') }}<br>
                                  @endif
                                  @if($approval->StatusInWords == "Rechazado")
                                      {{ $approval->StatusInWords }}<br>
                                      {{ $approval->approver->fullName }}<br>
                                      {{ $approval->approver_at->format('d-m-Y H:i:s') }}<br>
                                      <hr>
                                      {{ $approval->approver_observation }}
                                  @endif
                              </td>  
                          @endif
                      @endforeach
                      <!-- APROBACION DE PERSONAL -->
                      @foreach($requestReplacementStaff->requestSign as $sign)
                          <td align="center"> 
                              @if($sign->request_status == 'accepted')
                                  {{ $sign->StatusValue }}<br>
                                  {{ $sign->user->fullName }}<br>
                                  {{ $sign->date_sign->format('d-m-Y H:i:s') }}<br>
                              @endif
                              @if($sign->request_status == 'rejected')
                                  {{ $sign->StatusValue }}<br>
                                  {{ $sign->user->fullName }}<br>
                                  {{ $sign->date_sign->format('d-m-Y H:i:s') }}<br>
                                  <hr>
                                  {{ $sign->observation }}<br>
                              @endif
                          </td>
                      @endforeach
                      <!-- APPROVALS DE JEFATURA DIRECTA -->
                      @foreach($requestReplacementStaff->approvals as $approval)
                          @if($approval->subject != "Solicitud de Aprobación Jefatura Depto. o Unidad")
                              <td align="center"> 
                                  @if($approval->StatusInWords == "Aprobado")
                                      {{ $approval->StatusInWords }}<br>
                                      {{ $approval->approver->fullName }}<br>
                                      {{ $approval->approver_at->format('d-m-Y H:i:s') }}<br>
                                  @endif
                                  @if($approval->StatusInWords == "Rechazado")
                                      {{ $approval->StatusInWords }}<br>
                                      {{ $approval->approver->fullName }}<br>
                                      {{ $approval->approver_at->format('d-m-Y H:i:s') }}<br>
                                      <hr>
                                      {{ $approval->approver_observation }}
                                  @endif
                              </td>  
                          @endif
                      @endforeach
                  @else
                      @foreach($requestReplacementStaff->requestSign as $sign)
                          <td align="center"> 
                              @if($sign->request_status == 'accepted')
                                  {{ $sign->StatusValue }}<br>
                                  {{ $sign->user->fullName }}<br>
                                  {{ $sign->date_sign->format('d-m-Y H:i:s') }}<br>
                              @endif
                              @if($sign->request_status == 'rejected')
                                  {{ $sign->StatusValue }}<br>
                                  {{ $sign->user->fullName }}<br>
                                  {{ $sign->date_sign->format('d-m-Y H:i:s') }}<br>
                                  <hr>
                                  {{ $sign->observation }}<br>
                              @endif
                              @if($sign->request_status == 'not valid')
                                  @if($requestReplacementStaff->signaturesFile)
                                      @foreach($requestReplacementStaff->signaturesFile->signaturesFlows as $flow)
                                          @if($flow->status == 1)
                                              Aceptada<br>
                                              {{ $flow->userSigner->fullName }}<br>
                                              {{ $flow->signature_date->format('d-m-Y H:i:s') }}
                                          @endif
                                          @if($flow->status === 0)
                                              {{ $flow->signerName }}<br>
                                              {{ $flow->signature->rejected_at->format('d-m-Y H:i:s') }}<br>
                                              <hr>
                                              {{ $flow->observation }}<br>
                                          @endif
                                      @endforeach
                                  @else
                                      <i class="fas fa-clock"></i> Pendiente<br>
                                  @endif
                              @endif
                          </td>
                      @endforeach
                  @endif
              </tr>
          </tbody>
      </table>

      <div style="clear: both; padding-bottom: 5px">&nbsp;</div>

      @if($requestReplacementStaff->technicalEvaluation)
        @if($requestReplacementStaff->technicalEvaluation->technical_evaluation_status == 'complete' ||
          $requestReplacementStaff->technicalEvaluation->technical_evaluation_status == 'rejected')

            <table class="table table-sm table-bordered">
                <tbody>
                    <tr>
                        <td style="width: 33%"><strong>Estado de Solicitud</strong></td>
                        <td colspan="2">{{ $requestReplacementStaff->StatusValue }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fecha de Cierre</strong></td>
                        <td colspan="2">{{ $requestReplacementStaff->technicalEvaluation->date_end->format('d-m-Y H:i:s') }}</td>
                    </tr>
                </tbody>
            </table>

        @endif
      @endif

      <div style="clear: both; padding-bottom: 5px">&nbsp;</div>
      {{--
      @if($requestReplacementStaff->technicalEvaluation &&
              $requestReplacementStaff->technicalEvaluation->commissions->count() > 0)
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
                @foreach($requestReplacementStaff->technicalEvaluation->commissions as $commission)
                  <tr>
                      <td>{{ $commission->user->fullName }}</td>
                      <td>{{ $commission->user->organizationalUnit->name }}</td>
                      <td>{{ $commission->job_title }}</td>
                  </tr>
                @endforeach
              </tbody>
          </table>

          <div style="clear: both; padding-bottom: 5px">&nbsp;</div>

      @endif
      --}}

      @if($requestReplacementStaff->technicalEvaluation &&
        $requestReplacementStaff->technicalEvaluation->reason != NULL)

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
                      <td>{{ $requestReplacementStaff->technicalEvaluation->ReasonValue }}</td>
                      <td>{{ $requestReplacementStaff->technicalEvaluation->observation }}</td>
                      <td>{{ $requestReplacementStaff->technicalEvaluation->date_end->format('d-m-Y H:i:s') }}</td>
                  </tr>
              </tbody>
          </table>

          <div style="clear: both; padding-bottom: 5px">&nbsp;</div>

      @endif
      
      {{--
      @if($requestReplacementStaff->technicalEvaluation &&
              $requestReplacementStaff->technicalEvaluation->applicants->count() > 0)

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
                @foreach($requestReplacementStaff->technicalEvaluation->applicants->sortByDesc('score') as $applicant)
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
                      <td>{{ $applicant->replacementStaff->fullName }}</td>
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

      --}}

      <div class="pie_pagina center seis">
          <!--{{ env('APP_SS') }}<br-->
          Esto es informe extraído de {{ env('APP_NAME') }} -  {{ env('APP_SS') }}
      </div>
    </div>
</body>

</html>
