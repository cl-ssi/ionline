<!-- Modal -->
<div class="modal fade" id="exampleModalCenter-req-{{ $requestReplacementStaff->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Gestión de Solicitudes para aprobación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table table-sm table-bordered">
            <thead>
                <tr class="table-active">
                    <th colspan="3">Formulario Contratación de Personal - Solicitud Nº {{ $requestReplacementStaff->id }}
                        @switch($requestReplacementStaff->request_status)
                            @case('pending')
                                <span class="badge bg-warning">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break

                            @case('complete')
                                <span class="badge bg-success">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break

                            @case('rejected')
                                <span class="badge bg-danger">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break

                            @default
                                Default case...
                        @endswitch
                    </th>
                </tr>
            </thead>
              <tbody>
                  <tr>
                      <th class="table-active">Por medio del presente</th>
                      <td colspan="2">
                          {{ $requestReplacementStaff->organizationalUnit->name }}
                      </td>
                  </tr>
                  <tr>
                      <th class="table-active">Nombre / Nº de Cargos</th>
                      <td style="width: 33%">{{ $requestReplacementStaff->name }}</td>
                      <td style="width: 33%">{{ $requestReplacementStaff->charges_number }}</td>
                  </tr>
                  <tr>
                      <th class="table-active">Estamento / Grado</th>
                      <td style="width: 33%">{{ $requestReplacementStaff->profile_manage->name }}</td>
                      <td style="width: 33%">{{ $requestReplacementStaff->degree }}</td>
                  </tr>
                  <tr>
                      <th class="table-active">Calidad Jurídica / $ Honorarios</th>
                      <td style="width: 33%">{{ $requestReplacementStaff->legalQualityManage->NameValue }}</td>
                      <td style="width: 33%">
                        @if($requestReplacementStaff->LegalQualityValue == 'Honorarios')
                            ${{ number_format($requestReplacementStaff->salary,0,",",".") }}
                        @endif
                      </td>
                  </tr>
                  <tr>
                      <th class="table-active">La Persona cumplirá labores en Jornada</th>
                      <td style="width: 33%">{{ $requestReplacementStaff->WorkDayValue }}</td>
                      <td style="width: 33%">{{ $requestReplacementStaff->other_work_day }}</td>
                  </tr>
                  <tr>
                      <th class="table-active">
                        Fundamento de la Contratación<br>
                        Detalle de Fundamento
                      </th>
                      <td style="width: 33%">
                        {{ $requestReplacementStaff->fundamentManage->NameValue }}<br>
                        {{ $requestReplacementStaff->fundamentDetailManage->NameValue }}
                      </td>
                      <td style="width: 33%">De funcionario: {{ $requestReplacementStaff->name_to_replace }}</td>
                  </tr>
                  <tr>
                      <th class="table-active">Otro Fundamento (especifique)</th>
                      <td colspan="2">{{ $requestReplacementStaff->other_fundament }}</td>
                  </tr>
                  <tr>
                      <th class="table-active">Periodo</th>
                      <td style="width: 33%">{{ $requestReplacementStaff->start_date->format('d-m-Y') }}</td>
                      <td style="width: 33%">{{ $requestReplacementStaff->end_date->format('d-m-Y') }}</td>
                  </tr>
                  <tr>
                      <th class="table-active">Archivos</th>
                      <td style="width: 33%">Perfil de Cargo
                        @if($requestReplacementStaff->job_profile_file)
                            <a href="{{ route('replacement_staff.request.show_file', $requestReplacementStaff) }}" target="_blank"> <i class="fas fa-paperclip"></i></a>
                        @endif
                      </td>
                      <td style="width: 33%">Correo (Verificación Solicitud) <a href="{{ route('replacement_staff.request.show_verification_file', $requestReplacementStaff) }}" target="_blank"> <i class="fas fa-paperclip"></i></a></td>
                  </tr>
                  <tr>
                      <th class="table-active">Lugar de Desempeño</th>
                      <td colspan="2">{{ $requestReplacementStaff->ouPerformance->name }}</td>
                  </tr>
                  <tr>
                      <td colspan="3">El proceso debe contener las firmas y timbres de las personas que dan autorización para que la Unidad Selección inicie el proceso de Llamado de presentación de antecedentes.</td>
                  </tr>
                  <tr>
                      @foreach($requestReplacementStaff->RequestSign as $sign)
                        <td class="table-active text-center">
                            {{ $sign->organizationalUnit->name }}<br>
                        </td>
                      @endforeach
                  </tr>
                  <tr>
                      @foreach($requestReplacementStaff->RequestSign as $requestSign)
                        <td align="center">
                            @if($requestSign->request_status == 'accepted')
                                <span style="color: green;">
                                  <i class="fas fa-check-circle"></i> {{ $requestSign->StatusValue }} </span><br>
                                <i class="fas fa-user"></i> {{ $requestSign->user->FullName }}<br>
                                <i class="fas fa-calendar-alt"></i> {{ ($requestSign->date_sign) ? $requestSign->date_sign->format('d-m-Y H:i:s') : '' }}<br>
                            @endif
                            @if($requestSign->request_status == 'rejected')
                                <span style="color: Tomato;">
                                  <i class="fas fa-times-circle"></i> {{ $requestSign->StatusValue }} </span><br>
                                <i class="fas fa-user"></i> {{ $requestSign->user->FullName }}<br>
                                <i class="fas fa-calendar-alt"></i> {{ $requestSign->date_sign->format('d-m-Y H:i:s') }}<br>
                                <hr>
                                {{ $requestSign->observation }}<br>
                            @endif
                            @if($requestSign->request_status == 'pending' || $requestSign->request_status == NULL)
                                <i class="fas fa-clock"></i> Pendiente.<br>
                            @endif
                        </td>
                      @endforeach
                  </tr>
                  @if($requestReplacementStaff->technicalEvaluation)
                    @if($requestReplacementStaff->technicalEvaluation->technical_evaluation_status == 'complete' ||
                      $requestReplacementStaff->technicalEvaluation->technical_evaluation_status == 'rejected')
                      <tr>
                          <th class="table-active">Estado de Solicitud</th>
                          <td colspan="2">{{ $requestReplacementStaff->StatusValue }}</td>
                      </tr>
                      <tr>
                          <th class="table-active">Fecha de Cierre</th>
                          <td colspan="2">{{ $requestReplacementStaff->technicalEvaluation->date_end->format('d-m-Y H:i:s') }}</td>
                      </tr>
                    @endif
                  @endif
              </tbody>
          </table>

          <div class="row">
              <div class="col">
                  @if($requestReplacementStaff->technicalEvaluation &&
                    $requestReplacementStaff->end_date < now()->toDateString() &&
                      $requestReplacementStaff->technicalEvaluation->date_end != null &&
                        $requestReplacementStaff->user_id == Auth::user()->id)
                      <a class="btn btn-success float-right" href="{{ route('replacement_staff.request.create_extension', $requestReplacementStaff) }}">
                          <i class="fas fa-plus"></i> Extender en Nueva Solicitud</a>
                  @endif
              </div>
          </div>

          <br>

          @if($requestReplacementStaff->technicalEvaluation &&
                  $requestReplacementStaff->technicalEvaluation->commissions->count() > 0)
          <div class="card" id="commission">
              <div class="card-header">
                  <h6>Integrantes Comisión</h6>
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table table-sm table-bordered">
                          <thead class="text-center">
                              <tr>
                                <th>Nombre</th>
                                <th>Unidad Organizacional</th>
                                <th>Cargo</th>
                              </tr>
                          </thead>
                          <tbody >
                              @foreach($requestReplacementStaff->technicalEvaluation->commissions as $commission)
                              <tr>
                                  <td>{{ $commission->user->FullName }}</td>
                                  <td>{{ $commission->user->organizationalUnit->name }}</td>
                                  <td>{{ $commission->job_title }}</td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
              <br>
          </div>

          <br>

          @endif

          @if($requestReplacementStaff->technicalEvaluation &&
            $requestReplacementStaff->technicalEvaluation->reason != NULL)

          <div class="row">
              <div class="col">
                  <div class="alert alert-danger" role="alert">
                      <h6><i class="fas fa-exclamation-circle"></i> Proceso Selección Finalizado</h6>
                      <ul>
                          <li><strong>Motivo:</strong> {{ $requestReplacementStaff->technicalEvaluation->ReasonValue }}</li>
                          <li><strong>Observación:</strong> {{ $requestReplacementStaff->technicalEvaluation->observation }}</li>
                          <li><strong>Fecha:</strong> {{ $requestReplacementStaff->technicalEvaluation->date_end->format('d-m-Y H:i:s') }}</li>
                      </ul>
                  </div>
              </div>
          </div>

          <br>

          @endif

          @if($requestReplacementStaff->technicalEvaluation &&
                  $requestReplacementStaff->technicalEvaluation->applicants->count() > 0)

          <div class="card" id="applicant">
              <div class="card-header">
                  <h6>Selección de RR.HH.</h6>
              </div>
              <div class="card-body">
                <h6>Postulantes a cargo(s)</h6>
                  <div class="table-responsive">
                      <table class="table table-sm table-striped table-bordered">
                          <thead class="text-center">
                              <tr>
                                <th style="width: 15%">Nombre</th>
                                <th style="width: 18%">Calificación Evaluación Psicolaboral</th>
                                <th style="width: 18%">Calificación Evaluación Técnica y/o de Apreciación Global</th>
                                <th style="width: 22%">Observaciones</th>
                                <th>Ingreso Efectivo</th>
                                <th>Fin</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($requestReplacementStaff->technicalEvaluation->applicants->sortByDesc('score') as $applicant)
                              <tr class="{{ ($applicant->selected == 1)?'table-success':''}}">
                                  <td>
                                    <a href="{{ route('replacement_staff.show_replacement_staff', $applicant->replacementStaff) }}"
                                      target="_blank">{{ $applicant->replacementStaff->FullName }}
                                    </a>
                                    <br>
                                    @if($applicant->selected == 1 && $applicant->desist == NULL)
                                      <span class="badge bg-success">Seleccionado</span>
                                    @endif
                                    @if($applicant->desist == 1)
                                      <span class="badge bg-danger">Desiste Selección</span>
                                    @endif
                                  </td>
                                  <td class="text-center">{{ $applicant->psycholabor_evaluation_score }} <br> {{ $applicant->PsyEvaScore }}</td>
                                  <td class="text-center">{{ $applicant->technical_evaluation_score }} <br> {{ $applicant->TechEvaScore }}</td>
                                  <td>{{ $applicant->observations }}</td>
                                  <td class="text-center">{{ ($applicant->start_date) ? $applicant->start_date->format('d-m-Y') : '' }}</td>
                                  <td class="text-center">{{ ($applicant->end_date) ? $applicant->end_date->format('d-m-Y') : '' }}</td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>

          <br>
          @endif

          @if($requestReplacementStaff->technicalEvaluation &&
                  $requestReplacementStaff->technicalEvaluation->technicalEvaluationFiles->count() > 0)
          <div class="card" id="file">
              <div class="card-header">
                  <h6>Adjuntos </h6>
              </div>
              <div class="card-body">
                  <div class="table-responsive">

                      <table class="table table-sm table-striped table-bordered">
                          <thead class="text-center">
                              <tr>
                                <th>Nombre Archivo</th>
                                <th>Cargado por</th>
                                <th>Fecha</th>
                                <th></th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach($requestReplacementStaff->technicalEvaluation->technicalEvaluationFiles->sortByDesc('created_at') as $technicalEvaluationFiles)
                              <tr>
                                <td>{{ $technicalEvaluationFiles->name }}</td>
                                <td>{{ $technicalEvaluationFiles->user->FullName }}</td>
                                <td>{{ $technicalEvaluationFiles->created_at->format('d-m-Y H:i:s') }}</td>
                                <td style="width: 4%">
                                    <a href="{{ route('replacement_staff.request.technical_evaluation.file.show_file', $technicalEvaluationFiles) }}"
                                      class="btn btn-outline-secondary btn-sm"
                                      title="Ir"
                                      target="_blank"> <i class="far fa-eye"></i></a>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
              <br>
          </div>
          @endif
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
