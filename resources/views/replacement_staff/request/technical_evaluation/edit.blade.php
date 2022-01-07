@extends('layouts.app')

@section('title', 'Selección')

@section('content')

@include('replacement_staff.nav')

<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead class="small">
            <tr class="table-active">
                <th colspan="3">Formulario Contratación de Personal - Solicitud Nº {{ $technicalEvaluation->requestReplacementStaff->id }}
                  @switch($technicalEvaluation->requestReplacementStaff->request_status)
                      @case('pending')
                          <span class="badge bg-warning">{{ $technicalEvaluation->requestReplacementStaff->StatusValue }}</span>
                          @break

                      @case('complete')
                          <span class="badge bg-success">{{ $technicalEvaluation->requestReplacementStaff->StatusValue }}</span>
                          @break

                      @case('rejected')
                          <span class="badge bg-danger">{{ $technicalEvaluation->requestReplacementStaff->StatusValue }}</span>
                          @break

                      @default
                          Default case...
                  @endswitch
                </th>
            </tr>
        </thead>
        <tbody class="small">
            <tr>
                <th class="table-active">Por medio del presente</th>
                <td colspan="2">
                  {{ $technicalEvaluation->requestReplacementStaff->organizationalUnit->name }}
                </td>
            </tr>
            <tr>
                <th class="table-active">Nombre / Nº de Cargos</th>
                <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->name }}</td>
                <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->charges_number }}</td>
            </tr>
            <tr>
                <th class="table-active">Estamento / Grado</th>
                <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->profile_manage->name }}</td>
                <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->degree }}</td>
            </tr>
            <tr>
                <th class="table-active">Calidad Jurídica / $ Honorarios</th>
                <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->legalQualityManage->NameValue }}</td>
                <td style="width: 33%">
                  @if($technicalEvaluation->requestReplacementStaff->LegalQualityValue == 'Honorarios')
                      ${{ number_format($technicalEvaluation->requestReplacementStaff->salary,0,",",".") }}
                  @endif
                </td>
            </tr>
            <tr>
                <th class="table-active">La Persona cumplirá labores en Jornada</th>
                <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->WorkDayValue }}</td>
                <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->other_work_day }}</td>
            </tr>
            <tr>
                <th class="table-active">
                  Fundamento de la Contratación<br>
                  Detalle de Fundamento
                </th>
                <td style="width: 33%">
                  {{ $technicalEvaluation->requestReplacementStaff->fundamentManage->NameValue }}<br>
                  {{ $technicalEvaluation->requestReplacementStaff->fundamentDetailManage->NameValue }}
                </td>
                <td style="width: 33%">De funcionario: {{ $technicalEvaluation->requestReplacementStaff->name_to_replace }}</td>
            </tr>
            <tr>
                <th class="table-active">Otro Fundamento (especifique)</th>
                <td colspan="2">{{ $technicalEvaluation->requestReplacementStaff->other_fundament }}</td>
            </tr>
            <tr>
                <th class="table-active">Periodo</th>
                <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->start_date->format('d-m-Y') }}</td>
                <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->end_date->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th class="table-active">Archivos</th>
                <td style="width: 33%">Perfil de Cargo
                  @if($technicalEvaluation->requestReplacementStaff->job_profile_file)
                      <a href="{{ route('replacement_staff.request.show_file', $technicalEvaluation->requestReplacementStaff) }}" target="_blank"> <i class="fas fa-paperclip"></i></a>
                  @endif
                </td>
                <td style="width: 33%">Correo (Verificación Solicitud) <a href="{{ route('replacement_staff.request.show_verification_file', $technicalEvaluation->requestReplacementStaff) }}" target="_blank"> <i class="fas fa-paperclip"></i></a></td>
            </tr>
            <tr>
                <th class="table-active">Lugar de Desempeño</th>
                <td colspan="2">{{ $technicalEvaluation->requestReplacementStaff->ouPerformance->name }}</td>
            </tr>
            <tr>
                <td colspan="3">El proceso debe contener las firmas y timbres de las personas que dan autorización para que la Unidad Selección inicie el proceso de Llamado de presentación de antecedentes.</td>
            </tr>
            <tr>
                @foreach($technicalEvaluation->requestReplacementStaff->RequestSign as $sign)
                  <td class="table-active text-center">
                      <strong>{{ $sign->organizationalUnit->name }}
                  </td>
                @endforeach
            </tr>
            <tr>
                @foreach($technicalEvaluation->requestReplacementStaff->RequestSign as $requestSign)
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
                  @foreach($technicalEvaluation->requestReplacementStaff->assignEvaluations as $assignEvaluation)
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

        @if($technicalEvaluation->technical_evaluation_status == 'pending')
        <!-- Button trigger modal -->
        @can('Replacement Staff: assign request')
        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
          data-target="#exampleModal-assign-{{ $technicalEvaluation->requestReplacementStaff->id }}">
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
        @if($technicalEvaluation->reason == NULL)
            @if(($technicalEvaluation->requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id ||
              Auth::user()->hasRole('Replacement Staff: admin')) && $technicalEvaluation->applicants->count() == 0)
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger btn-sm float-right" data-toggle="modal"
                  data-target="#exampleModal-reject-{{ $technicalEvaluation->id }}">
                    <i class="fas fa-window-close"></i> Finalizar Proceso Selección
                </button>

                @include('replacement_staff.modals.modal_to_reject_technical_evaluation')
            @endif
        @else
            <div class="alert alert-danger" role="alert">
                <h6><i class="fas fa-exclamation-circle"></i> Proceso Selección Finalizado</h6>
                <ul>
                    <li><strong>Motivo:</strong> {{ $technicalEvaluation->ReasonValue }}</li>
                    <li><strong>Observación:</strong> {{ $technicalEvaluation->observation }}</li>
                    <li><strong>Fecha:</strong> {{ $technicalEvaluation->date_end->format('d-m-Y H:i:s') }}</li>
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
                    @foreach($technicalEvaluation->commissions as $commission)
                    <tr>
                        <td>{{ $commission->user->FullName }}</td>
                        <td>{{ $commission->user->organizationalUnit->name }}</td>
                        <td>{{ $commission->job_title }}</td>
                        <td>
                          @if($technicalEvaluation->technical_evaluation_status == 'pending')
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

        @if($technicalEvaluation->requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id ||
          Auth::user()->hasRole('Replacement Staff: admin'))
            @livewire('replacement-staff.commission', ['users' => $users,
                      'technicalEvaluation' => $technicalEvaluation])
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

      @if($technicalEvaluation->applicants->count() > 0)
      <h6>Postulantes a cargo(s)</h6>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
                <thead class="text-center small">
                    <tr>
                      <th style="width: 22%">Nombre</th>
                      <th style="width: 22%">Calificación Evaluación Psicolaboral</th>
                      <th style="width: 22%">Calificación Evaluación Técnica y/o de Apreciación Global</th>
                      <th style="width: 22%">Observaciones</th>
                      @if($technicalEvaluation->requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id ||
                          Auth::user()->hasRole('Replacement Staff: admin'))
                      <th colspan="2"></th>
                      @endif
                    </tr>
                </thead>
                <tbody class="small">
                    @foreach($technicalEvaluation->applicants->sortByDesc('score') as $applicant)
                    <tr class="{{ ($applicant->selected == 1)?'table-success':''}}">
                        <td><a href="{{ route('replacement_staff.show_replacement_staff', $applicant->replacementStaff) }}" target="_blank">{{ $applicant->replacementStaff->FullName }}<a></td>
                        <td class="text-center">{{ $applicant->psycholabor_evaluation_score }} <br> {{ $applicant->PsyEvaScore }}</td>
                        <td class="text-center">{{ $applicant->technical_evaluation_score }} <br> {{ $applicant->TechEvaScore }}</td>
                        <td>{{ $applicant->observations }}</td>
                        @if($technicalEvaluation->requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id ||
                            Auth::user()->hasRole('Replacement Staff: admin'))
                        <td style="width: 4%">
                            @if($technicalEvaluation->date_end == NULL &&
                              ($applicant->psycholabor_evaluation_score == null || $applicant->technical_evaluation_score == null || $applicant->observations == null))
                            <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.applicant.destroy', $applicant) }}">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('¿Está seguro que desea eliminar el Postulante?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                            </form>
                            @else
                            <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.applicant.destroy', $applicant) }}">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('¿Está seguro que desea eliminar el Postulante?')" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                            </form>
                            @endif
                        </td>
                        <td style="width: 4%">
                            @if($technicalEvaluation->date_end == NULL)
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

      @if($technicalEvaluation->technical_evaluation_status == 'complete')
        <div class="alert alert-success small" role="alert">
            <h6><i class="fas fa-exclamation-circle"></i> Periodo Efectivo </h6>
            <ul>
                <li><strong>Ingreso:</strong> {{ $technicalEvaluation->applicants->first()->start_date->format('d-m-Y') }}</li>
                <li><strong>Término:</strong> {{ $technicalEvaluation->applicants->first()->end_date->format('d-m-Y') }}</li>
            </ul>
        </div>
      @endif

      @if($technicalEvaluation->applicants->count() > 0 && $technicalEvaluation->date_end == NULL)

          @if($technicalEvaluation->requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id ||
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

      @if($technicalEvaluation->technical_evaluation_status == 'pending')

      <hr>

      <h6>Busqueda de Postulantes</h6>

      @livewire('replacement-staff.search-select-applicants',
          ['technicalEvaluation' => $technicalEvaluation])

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
                  @foreach($technicalEvaluation->technicalEvaluationFiles->sortByDesc('created_at') as $technicalEvaluationFiles)
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
                      <td style="width: 4%">
                          @if($technicalEvaluation->technical_evaluation_status == 'pending')
                          <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.file.destroy', $technicalEvaluationFiles) }}">
                              @csrf
                              @method('DELETE')
                                  <button type="submit" class="btn btn-outline-danger btn-sm"
                                      onclick="return confirm('¿Está seguro que desea eliminar el Archivo Adjunto?')">
                                      <i class="fas fa-trash"></i>
                                  </button>
                          </form>
                          @else
                          <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.file.destroy', $technicalEvaluationFiles) }}">
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
        @if($technicalEvaluation->requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id ||
          Auth::user()->hasRole('Replacement Staff: admin'))
            @livewire('replacement-staff.files', ['users' => $users,
                      'technicalEvaluation' => $technicalEvaluation])
        @endif
    </div>
    <br>
</div>

@endsection

@section('custom_js')

@endsection
