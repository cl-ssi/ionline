@extends('layouts.app')

@section('title', 'Selección')

@section('content')

@include('replacement_staff.nav')

@if($requestReplacementStaff->requestFather)
<div class="row">
    <div class="col">
      <div class="alert alert-primary" role="alert">
          Este formulario corresponde a una extensión del formulario Nº
          <a target="_blank" href="{{ route('replacement_staff.request.technical_evaluation.edit', $requestReplacementStaff->requestFather) }}">
              {{ $requestReplacementStaff->requestFather->id }} - {{ $requestReplacementStaff->requestFather->name }}
          </a>
      </div>
    </div>
</div>
@endif

<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead class="small">
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
        <tbody class="small">
            <tr>
                <th class="table-active">Solicitante</th>
                <td style="width: 33%">{{ $requestReplacementStaff->user->FullName }}</td>
                <td style="width: 33%">{{ $requestReplacementStaff->organizationalUnit->name }}</td>
            </tr>
            <tr>
                <th class="table-active">Nombre de Formulario / Nº de Cargos</th>
                <td style="width: 33%">{{ $requestReplacementStaff->name }}</td>
                <td style="width: 33%">{{ $requestReplacementStaff->charges_number }}</td>
            </tr>
            <tr>
                <th class="table-active">Estamento / Grado</th>
                <td style="width: 33%">{{ $requestReplacementStaff->profile_manage->name }}</td>
                <td style="width: 33%">{{ $requestReplacementStaff->degree }}</td>
            </tr>
            <tr>
                <th class="table-active">Periodo</th>
                <td style="width: 33%">{{ $requestReplacementStaff->start_date->format('d-m-Y') }}</td>
                <td style="width: 33%">{{ $requestReplacementStaff->end_date->format('d-m-Y') }}</td>
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
                <th class="table-active">
                  Fundamento de la Contratación / Detalle de Fundamento
                </th>
                <td style="width: 33%">
                  {{ $requestReplacementStaff->fundamentManage->NameValue }}
                </td>
                <td style="width: 33%">
                  {{ $requestReplacementStaff->fundamentDetailManage->NameValue }}
                </td>
            </tr>
            <tr>
                <th class="table-active">Otro Fundamento (especifique)</th>
                <td colspan="2">{{ $requestReplacementStaff->other_fundament }}</td>
            </tr>
            <tr>
                <th class="table-active">Funcionario a Reemplazar
                </th>
                <td style="width: 33%">
                  @if($requestReplacementStaff->run)
                      {{$requestReplacementStaff->run}}-{{$requestReplacementStaff->dv}}
                  @endif
                </td>
                <td style="width: 33%">{{ $requestReplacementStaff->name_to_replace }}</td>
            </tr>
            <tr>
                <th class="table-active">La Persona cumplirá labores en / Jornada</th>
                <td style="width: 33%">{{ $requestReplacementStaff->WorkDayValue }}</td>
                <td style="width: 33%">{{ $requestReplacementStaff->other_work_day }}</td>
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
                <th class="table-active">Staff Sugerido</th>
                <td colspan="2">
                  @if($requestReplacementStaff->replacementStaff)
                      {{ $requestReplacementStaff->replacementStaff->FullName }}
                  @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>

@if($requestReplacementStaff->request_status != "pending")
    <a href="{{ route('replacement_staff.request.technical_evaluation.create_document', $requestReplacementStaff) }}"
        class="btn btn-info btn-sm float-right" 
        title="Selección" 
        target="_blank">
        Exportar Resumen <i class="fas fa-file"></i>
    </a>
<br /> <br /> 
@endif

<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <tbody class="small">
            <tr>
                <td colspan="{{ $requestReplacementStaff->RequestSign->count() }}">El proceso debe contener las firmas y timbres de las personas que dan autorización para que la Unidad Selección inicie el proceso de Llamado de presentación de antecedentes.</td>
            </tr>
            <tr>
                @foreach($requestReplacementStaff->RequestSign as $sign)
                  <td class="table-active text-center">
                      <strong>{{ $sign->organizationalUnit->name }}</strong>
                  </td>
                @endforeach
            </tr>
            <tr>
                @foreach($requestReplacementStaff->RequestSign as $requestSign)
                  <td align="center">
                      @if($requestSign->request_status == 'pending' && $requestSign->organizational_unit_id == Auth::user()->organizationalUnit->id)
                          Estado: {{ $requestSign->StatusValue }} <br><br>
                          <div class="row">
                              <div class="col-sm">
                                  <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.sign.update', [$requestSign, 'status' => 'accepted']) }}">
                                      @csrf
                                      @method('PUT')
                                      <button type="submit" class="btn btn-success btn-sm"
                                          onclick="return confirm('¿Está seguro que desea Aceptar la solicitud?')"
                                          title="Aceptar">
                                          <i class="fas fa-check-circle"></i>
                                      </button>
                                  </form>
                              </div>
                              <div class="col-sm">
                                  <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.sign.update', [$requestSign, 'status' => 'rejected']) }}">
                                      @csrf
                                      @method('PUT')
                                      <button type="submit" class="btn btn-danger btn-sm"
                                          onclick="return confirm('¿Está seguro que desea Reachazar la solicitud?')"
                                          title="Rechazar">
                                          <i class="fas fa-times-circle"></i>
                                      </button>
                                  </form>
                              </div>
                          </div>
                      @elseif($requestSign->request_status == 'accepted' || $requestSign->request_status == 'rejected')
                        <span style="color: green;">
                          <i class="fas fa-check-circle"></i> {{ $requestSign->StatusValue }} <br>
                        </span>
                        <i class="fas fa-user"></i> {{ $requestSign->user->FullName }}<br>
                        <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($requestSign->date_sign)->format('d-m-Y H:i:s') }}<br>
                      @else
                          @if($requestSign->request_status == NULL)
                              <i class="fas fa-ban"></i> No disponible para Aprobación.<br>
                          @else
                              <i class="fas fa-clock"></i> {{ $requestSign->StatusValue }}<br>
                          @endif
                      @endif
                  </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>

<br>

@if($requestReplacementStaff->technical_evaluation_status == 'complete' ||
    $requestReplacementStaff->technical_evaluation_status == 'rejected')
    <div class="table-responsive">
        <table class="table table-sm table-bordered small">
            <tr>
                <th class="table-active" style="width: 33%">Estado de Solicitud</th>
                <td colspan="2">{{ $requestReplacementStaff->StatusValue }}</td>
            </tr>
            <tr>
                <th class="table-active">Fecha de Cierre</th>
                <td colspan="2">{{ $date_end->format('d-m-Y H:i:s') }}</td>
            </tr>
        </table>
    </div>
@endif

<br>

<div class="card" id="commission">
    <div class="card-header">
        <h6>Funcionario(s) asignados a esta solicitud</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="small">
                    <tr class="table-active">
                        <th><i class="fas fa-calendar-alt"></i> Fecha</th>
                        <th><i class="fas fa-user"></i> De</th>
                        <th><i class="fas fa-user"></i> Para</th>
                        <th><i class="fas fa-info"></i> Observaciones</th>
                    </tr>
                </thead>
                <tbody class="small">
                  @foreach($requestReplacementStaff->assignEvaluations as $assignEvaluation)
                    <tr>
                        <td>{{ $assignEvaluation->created_at->format('d-m-Y H:i:s') }}</th>
                        <td>{{ $assignEvaluation->user->FullName }}</td>
                        <td>{{ $assignEvaluation->userAssigned->FullName }}</td>
                        <td>{{ $assignEvaluation->observation }}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>

        @if($requestReplacementStaff->technicalevaluation->technical_evaluation_status == 'pending')

        <!-- Button trigger modal -->
        @can('Replacement Staff: assign request')
        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
          data-target="#exampleModal-assign-{{ $requestReplacementStaff->id }}">
            <i class="fas fa-user-tag"></i> Asignar nuevamente
        </button>

        @include('replacement_staff.modals.modal_to_re_assign')
        @endcan

        @endif
    </div>
</div>

<br>

<div class="row">
    <div class="col">
        @if($requestReplacementStaff->technicalEvaluation->reason == NULL)
            @if(($requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id ||
              Auth::user()->hasRole('Replacement Staff: admin')) && $requestReplacementStaff->technicalEvaluation->technical_evaluation_status == 'pending')
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger btn-sm float-right" data-toggle="modal"
                  data-target="#exampleModal-reject-{{ $requestReplacementStaff->technicalEvaluation->id }}">
                    <i class="fas fa-window-close"></i> Finalizar Proceso Selección
                </button>

                @include('replacement_staff.modals.modal_to_reject_technical_evaluation')
            @endif
        @else
            <div class="alert alert-danger" role="alert">
                <h6><i class="fas fa-exclamation-circle"></i> Proceso Selección Finalizado</h6>
                <ul>
                    <li><strong>Motivo:</strong> {{ $requestReplacementStaff->technicalEvaluation->ReasonValue }}</li>
                    <li><strong>Observación:</strong> {{ $requestReplacementStaff->technicalEvaluation->observation }}</li>
                    <li><strong>Fecha:</strong> {{ $requestReplacementStaff->technicalEvaluation->date_end->format('d-m-Y H:i:s') }}</li>
                </ul>
            </div>
        @endif
    </div>
</div>

<br>

<div class="card" id="commission">
    <div class="card-header">
        <h6>Integrantes Comisión</h6>
    </div>
    <div class="card-body">
        @if (session('message-success-commission'))
          <div class="alert alert-success alert-dismissible fade show">
              {{ session('message-success-commission') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif
        @if (session('message-danger-commission'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('message-danger-commission') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif

        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
                <thead class="text-center small">
                    <tr>
                      <th>Nombre</th>
                      <th>Unidad Organizacional</th>
                      <th>Cargo</th>
                      <th></th>
                    </tr>
                </thead>
                <tbody class="small">
                    @foreach($requestReplacementStaff->technicalEvaluation->commissions as $commission)
                    <tr>
                        <td>{{ $commission->user->FullName }}</td>
                        <td>{{ $commission->user->organizationalUnit->name }}</td>
                        <td>{{ $commission->job_title }}</td>
                        <td>
                          @if($requestReplacementStaff->technicalEvaluation->technical_evaluation_status == 'pending')
                            <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.commission.destroy', $commission) }}">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('¿Está seguro que desea eliminar el Integrante de Comisión?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                            </form>
                          @else
                            <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.commission.destroy', $commission) }}">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('¿Está seguro que desea eliminar el Integrante de Comisión?')" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                            </form>
                          @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id ||
          Auth::user()->hasRole('Replacement Staff: admin'))
            @livewire('replacement-staff.commission', ['users' => $users,
                      'technicalEvaluation' => $requestReplacementStaff->technicalEvaluation])
        @endif
    </div>
    <br>
</div>

<br>

<div class="card" id="applicant">
    <div class="card-header">
        <h6>Selección de RR.HH.</h6>
    </div>
    <div class="card-body">
      @if (session('message-danger-without-applicants'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('message-danger-without-applicants') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      @endif

      @if (session('message-danger-delete-applicants'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('message-danger-delete-applicants') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      @endif

      @if (session('message-success-applicants'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message-success-applicants') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      @endif

      @if (session('message-success-evaluate-applicants'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message-success-evaluate-applicants') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      @endif

      @if (session('message-danger-aplicant-no-evaluated'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('message-danger-aplicant-no-evaluated') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      @endif

      @if (session('message-success-aplicant-finish'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message-success-aplicant-finish') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      @endif

      @if (session('message-success-aplicant-desist'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message-success-aplicant-finish') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      @endif

      @if($requestReplacementStaff->technicalEvaluation->applicants->count() > 0)
      <h6>Postulantes a cargo(s)</h6>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
                <thead class="text-center small">
                    <tr>
                      <th style="width: 15%">Nombre</th>
                      <th style="width: 18%">Calificación Evaluación Psicolaboral</th>
                      <th style="width: 18%">Calificación Evaluación Técnica y/o de Apreciación Global</th>
                      <th style="width: 22%">Observaciones</th>
                      @if($requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id ||
                          Auth::user()->hasRole('Replacement Staff: admin'))
                      <th style="width: 8%">Ingreso Efectivo</th>
                      <th style="width: 8%">Fin</th>
                      <th style="width: 8%">Fecha Ingreso Contrato</th>
                      <th colspan="2"></th>
                      @endif
                    </tr>
                </thead>
                <tbody class="small">
                    @foreach($requestReplacementStaff->technicalEvaluation->applicants->sortByDesc('score') as $applicant)
                    <tr class="{{ ($applicant->selected == 1 && $applicant->desist == NULL)?'table-success':''}}">
                        <td>
                          <a href="{{ route('replacement_staff.show_replacement_staff', $applicant->replacementStaff) }}"
                            target="_blank">{{ $applicant->replacementStaff->FullName }}
                          <a>
                          <br>
                          @if($applicant->selected == 1 && $applicant->desist == NULL)
                            <span class="badge bg-success">Seleccionado</span>
                          @endif
                          @if($applicant->desist == 1)
                            <span class="badge bg-danger">
                              @if($applicant->reason == 'renuncia a reemplazo')
                                Renuncia a reemplazo (Posterior ingreso)
                              @endif
                              @if($applicant->reason == 'rechazo oferta laboral')
                                Rechazo oferta laboral (Previo ingreso)
                              @endif
                              @if($applicant->reason == 'error digitacion')
                                Error de Digitación
                              @endif
                            </span>
                          @endif
                        </td>
                        <td class="text-center">{{ $applicant->psycholabor_evaluation_score }} <br> {{ $applicant->PsyEvaScore }}</td>
                        <td class="text-center">{{ $applicant->technical_evaluation_score }} <br> {{ $applicant->TechEvaScore }}</td>
                        <td>{{ $applicant->observations }}</td>
                        <td class="text-center">{{ ($applicant->start_date) ? $applicant->start_date->format('d-m-Y') : '' }}</td>
                        <td class="text-center">{{ ($applicant->end_date) ? $applicant->end_date->format('d-m-Y') : '' }}</td>
                        @if($requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id ||
                            Auth::user()->hasRole('Replacement Staff: admin'))
                        <td class="text-center">
                          @if($applicant->sirh_contract)
                              {{ $applicant->sirh_contract->format('d-m-Y') }}
                          @else
                              -
                          @endif
                        </td>
                        <td style="width: 4%">
                            @if($requestReplacementStaff->technicalEvaluation->date_end == NULL &&
                              ($applicant->psycholabor_evaluation_score == null || $applicant->technical_evaluation_score == null || $applicant->observations == null))
                            <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.applicant.destroy', $applicant) }}">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('¿Está seguro que desea eliminar el Postulante?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                            </form>
                            @elseif($applicant->selected == 1 && $applicant->desist == NULL)
                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal"
                              data-target="#exampleModal-to-change-selected-applicant-{{ $applicant->id }}">
                                <i class="fas fa-window-close"></i>
                            </button>
                            @include('replacement_staff.modals.modal_to_change_selected_applicant')
                            @endif
                        </td>
                        <td style="width: 4%">
                            @if($requestReplacementStaff->technicalEvaluation->date_end == NULL && $applicant->desist == NULL)
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                              data-target="#exampleModal-to-evaluate-applicant-{{ $applicant->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            @include('replacement_staff.modals.modal_to_evaluate_applicant')
                            @else
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                              data-target="#exampleModal-to-evaluate-applicant-{{ $applicant->id }}" disabled>
                                <i class="fas fa-edit"></i>
                            </button>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      @endif

      @if($requestReplacementStaff->technicalEvaluation->applicants->count() > 0 && 
        $requestReplacementStaff->technicalEvaluation->date_end == NULL)

          @if($requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id ||
            Auth::user()->hasRole('Replacement Staff: admin'))
              <div class="row">
                  <div class="col">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal"
                      data-target="#exampleModal-to-select-applicants">
                        <i class="fas fa-user-check"></i> Finalizar Selección
                    </button>
                    @include('replacement_staff.modals.modal_to_select_applicants')
                  </div>
              </div>
          @endif
      @endif

      @if($requestReplacementStaff->technicalEvaluation->technical_evaluation_status == 'pending')

      <hr>

      <h6>Busqueda de Postulantes</h6>

      @livewire('replacement-staff.search-select-applicants',
          ['technicalEvaluation' => $requestReplacementStaff->technicalEvaluation])

      @endif

    </div>
</div>

<br>

<div class="card" id="file">
    <div class="card-header">
        <h6>Adjuntos </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if (session('message-success-file'))
              <div class="alert alert-success alert-dismissible fade show">
                  {{ session('message-success-file') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
            @endif

            @if (session('message-danger-file'))
              <div class="alert alert-danger alert-dismissible fade show">
                  {{ session('message-danger-file') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
            @endif
            <table class="table table-sm table-striped table-bordered">
                <thead class="text-center small">
                    <tr>
                      <th>Nombre Archivo</th>
                      <th>Cargado por</th>
                      <th>Fecha</th>
                      <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody class="small">
                  @foreach($requestReplacementStaff->technicalEvaluation->technicalEvaluationFiles->sortByDesc('created_at') as $technicalEvaluationFile)
                    <tr>
                      <td>{{ $technicalEvaluationFile->name }}</td>
                      <td>{{ $technicalEvaluationFile->user->FullName }}</td>
                      <td>{{ $technicalEvaluationFile->created_at->format('d-m-Y H:i:s') }}</td>
                      <td style="width: 4%">
                          <a href="{{ route('replacement_staff.request.technical_evaluation.file.show_file', $technicalEvaluationFile) }}"
                            class="btn btn-outline-secondary btn-sm"
                            title="Ir"
                            target="_blank"> <i class="far fa-eye"></i></a>
                      </td>
                      <td style="width: 4%">
                          @if($requestReplacementStaff->technicalEvaluation->technical_evaluation_status == 'pending')
                          <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.file.destroy', $technicalEvaluationFile) }}">
                              @csrf
                              @method('DELETE')
                                  <button type="submit" class="btn btn-outline-danger btn-sm"
                                      onclick="return confirm('¿Está seguro que desea eliminar el Archivo Adjunto?')">
                                      <i class="fas fa-trash"></i>
                                  </button>
                          </form>
                          @else
                          <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.file.destroy', $technicalEvaluationFile) }}">
                              @csrf
                              @method('DELETE')
                                  <button type="submit" class="btn btn-outline-danger btn-sm"
                                      onclick="return confirm('¿Está seguro que desea eliminar el Archivo Adjunto?')" disabled>
                                      <i class="fas fa-trash"></i>
                                  </button>
                          </form>
                          @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
        @if($requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id ||
          Auth::user()->hasRole('Replacement Staff: admin'))
            @livewire('replacement-staff.files', ['users' => $users,
                      'technicalEvaluation' => $requestReplacementStaff->technicalEvaluation])
        @endif
    </div>
    <br>
</div>

<br>

@if($requestReplacementStaff->requestChilds->count() > 0)
<div class="row">
    <div class="col-sm">
        <h5><i class="fas fa-inbox"></i> Formularios de Continuidad</h5>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead class="text-center small">
            <tr>
                <th>#</th>
                <th style="width: 8%">Fecha</th>
                <th>Solicitud</th>
                <th>Grado</th>
                <th>Calidad Jurídica</th>
                <th colspan="2">Periodo</th>
                <th>Fundamento</th>
                <th>Jornada</th>
                <th>Solicitante</th>
                <th style="width: 2%"></th>
            </tr>
        </thead>
        <tbody class="small">
            @foreach($requestReplacementStaff->requestChilds as $requestChild)
            <tr>
                <td>
                    {{ $requestChild->id }} <br>
                    @switch($requestChild->request_status)
                        @case('pending')
                            <i class="fas fa-clock"></i>
                            @break

                        @case('complete')
                            <span style="color: green;">
                              <i class="fas fa-check-circle"></i>
                            </span>
                            @break

                        @case('rejected')
                            <span style="color: Tomato;">
                              <i class="fas fa-times-circle"></i>
                            </span>
                            @break

                        @default
                            Default case...
                    @endswitch
                </td>
                <td>{{ $requestChild->created_at->format('d-m-Y H:i:s') }}</td>
                <td>{{ $requestChild->name }}</td>
                <td class="text-center">{{ $requestChild->degree }}</td>
                <td>{{ $requestChild->legalQualityManage->NameValue }}</td>
                <td style="width: 8%">{{ $requestChild->start_date->format('d-m-Y') }} <br>
                    {{ $requestChild->end_date->format('d-m-Y') }}
                </td>
                <td class="text-center">{{ $requestChild->getNumberOfDays() }}
                    @if($requestChild->getNumberOfDays() > 1)
                        días
                    @else
                        dia
                    @endif
                </td>
                <td>
                    {{ $requestChild->fundamentManage->NameValue }}<br>
                    {{ $requestChild->fundamentDetailManage->NameValue }}
                </td>
                <td>
                    {{ $requestChild->WorkDayValue }}
                </td>
                <td>{{ $requestChild->user->FullName }}<br>
                    {{ $requestChild->organizationalUnit->name }}
                </td>
                <td>
                  @if($requestChild->technicalEvaluation)
                    <a href="{{ route('replacement_staff.request.technical_evaluation.edit', $requestChild) }}"
                                class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
                  @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if(Auth::user()->hasRole('Replacement Staff: admin'))
<br/>

<hr/>
<div style="height: 300px; overflow-y: scroll;">
    @include('partials.audit', ['audits' => $requestReplacementStaff->technicalEvaluation->audits] )
</div>

@endif

@endsection

@section('custom_js')

<script type="text/javascript">

    function changeSelectReason() {
        //get the selected value from the dropdown list
        var mylist = document.getElementById("for_reason");
        var result = mylist.options[mylist.selectedIndex].text;

        if (result == 'Rechazo oferta laboral (Previo ingreso)' || result == 'Error de digitación') {
          //disable all the radio button
          document.getElementById("for_start_date").readOnly = true;
          document.getElementById("for_end_date").readOnly = true;
        }
        else {
          //enable all the radio button
          document.getElementById("for_start_date").readOnly = false;
          document.getElementById("for_end_date").readOnly = false;
        }
    }
</script>

@endsection
