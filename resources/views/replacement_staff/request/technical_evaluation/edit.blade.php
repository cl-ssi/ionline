@extends('layouts.app')

@section('title', 'Selección')

@section('content')

@include('replacement_staff.nav')


<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
            <tr class="table-active">
                <th colspan="3">Formulario Solicitud Contratación de Personal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="table-active">Por medio del presente, la Subdirección</th>
                <td colspan="2">
                    @foreach($technicalEvaluation->requestReplacementStaff->RequestSign as $sing)
                        @if($sing->ou_alias == 'sub')
                            {{ $sing->organizationalUnit->name }}
                        @endif
                    @endforeach
                </td>
            </tr>
            <tr>
                <th class="table-active">En el grado</th>
                <td colspan="2">{{ $technicalEvaluation->requestReplacementStaff->degree }}</td>
            </tr>
            <tr>
                <th class="table-active">Calidad Jurídica</th>
                <td colspan="2">{{ $technicalEvaluation->requestReplacementStaff->LegalQualityValue }}</td>
            </tr>
            <tr>
                <th class="table-active">La Persona cumplirá labores en Jornada</th>
                <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->WorkDayValue }}</td>
                <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->other_work_day }}</td>
            </tr>
            <tr>
                <th class="table-active">Justificación o fundamento de la Contratación</th>
                <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->FundamentValue }}</td>
                <td style="width: 33%">De funcionario: {{ $technicalEvaluation->requestReplacementStaff->name_to_replace }}</td>
            </tr>
            <tr>
                <th class="table-active">Otros (especifique)</th>
                <td colspan="2">{{ $technicalEvaluation->requestReplacementStaff->other_fundament }}</td>
            </tr>
            <tr>
                <td colspan="3">El documento debe contener las firmas y timbres de las personas que dan autorización para que la Unidad Selección inicie el proceso de Llamado de presentación de antecedentes.</td>
            </tr>
            <tr>
                @foreach($technicalEvaluation->requestReplacementStaff->RequestSign as $sign)
                  <td class="table-active">
                      {{ $sign->organizationalUnit->name }}<br>
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
                          <i class="fas fa-check-circle"></i> {{ $requestSign->StatusValue }} <br>
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

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
            <tr class="table-active">
                <th colspan="6">Evaluación Técnica</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th rowspan="2" class="table-active text-center"><i class="fas fa-user"></i></th>
                <td>{{ $technicalEvaluation->user->FullName }}</td>
                <th rowspan="2" class="table-active text-center"><i class="fas fa-calendar-alt"></i></th>
                <td>{{ $technicalEvaluation->created_at->format('d-m-Y H:i:s') }}</td>
                <th rowspan="2" class="table-active text-center">Estado</th>
                <td rowspan="2">{{ $technicalEvaluation->StatusValue }}</td>
            </tr>
            <tr>
                <td>{{ $technicalEvaluation->user->organizationalUnit->name }}</td>
                <td>{{ (isset($technicalEvaluation->date_end)) ? $technicalEvaluation->date_end->format('d-m-Y H:i:s'):''}}</td>
            </tr>
        </tbody>
    </table>
</div>

<br>

<div class="card" id="commission">
    <div class="card-header">
        <h6>Integrantes Comisión</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Unidad Organizacional</th>
                      <th>Cargo</th>
                      <th></th>
                    </tr>
                </thead>
                <tbody>
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
        @livewire('replacement-staff.commission', ['users' => $users,
                  'technicalEvaluation' => $technicalEvaluation])
    </div>
    <br>
</div>

<br>

<div class="card" id="applicant">
    <div class="card-header">
        <h6>Postulantes </h6>
    </div>
    <div class="card-body">
        @if($technicalEvaluation->applicants->count() > 0)
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Calificación</th>
                      <th>Observaciones</th>
                      <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($technicalEvaluation->applicants->sortByDesc('score') as $applicant)
                    <tr class="{{ ($applicant->selected == 1)?'table-success':''}}">
                        <td>{{ $applicant->replacement_staff->FullName }}</td>
                        <td>{{ $applicant->score }}</td>
                        <td>{{ $applicant->observations }}</td>
                        <td style="width: 4%">
                            @if($technicalEvaluation->date_end == NULL)
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
                            <!-- Button trigger modal -->
                          @if($technicalEvaluation->technical_evaluation_status == 'pending')
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                              data-target="#exampleModal-applicant-{{ $applicant->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                          @else
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                              data-target="#exampleModal-applicant-{{ $applicant->id }}" disabled>
                                <i class="fas fa-edit"></i>
                            </button>
                          @endif
                          @include('replacement_staff.modals.modal_to_select_applicant')
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endif
        <br>

        @if($technicalEvaluation->technical_evaluation_status == 'pending')
        <div class="card card-body">
            <form method="GET" class="form-horizontal"
                action="{{ route('replacement_staff.request.technical_evaluation.edit', $technicalEvaluation) }}">
                <div class="form-row">
                    <fieldset class="form-group col-4">
                        <label for="for_name">Nombres</label>
                        <input class="form-control" type="text" name="search" autocomplete="off" style="text-transform: uppercase;" placeholder="RUN (sin dígito verificador) / NOMBRE" value="{{$request->search}}">
                    </fieldset>

                    <fieldset class="form-group col-4">
                        <label for="for_profile_search">Estamento</label>
                        <select name="profile_search" class="form-control">
                            <option value="0">Seleccione...</option>
                            @foreach($profileManage as $profile)
                                <option value="{{ $profile->id }}" {{ ($request->profile_search == $profile->id)?'selected':'' }}>{{ $profile->Name }}</option>
                            @endforeach
                        </select>
                    </fieldset>

                    <fieldset class="form-group col-4">
                        <label for="for_profession_search">Profesión</label>
                        <select name="profession_search" class="form-control">
                            <option value="0">Seleccione...</option>
                            @foreach($professionManage as $profession)
                                <option value="{{ $profession->id }}" {{ ($request->profession_search == $profession->id)?'selected':'' }}>{{ $profession->Name }}</option>
                            @endforeach
                        </select>
                    </fieldset>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>

        <br>

        <div class="table-responsive">
            <table class="table small table-striped">
                <thead>
                    <tr>
                        <th>Nombre Completo</th>
                        <th>Run</th>
                        <th>Estamento</th>
                        <th>Título</th>
                        <th>Fecha Titulación</th>
                        <th>Años Exp.</th>
                        <th>Estado</th>
                        <th style="width: 10%"></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.applicant.store', $technicalEvaluation) }}">
                    @csrf
                    @method('POST')

                    @foreach($replacementStaff as $staff)
                    <tr>
                        <td>{{ $staff->FullName }}</td>
                        <td>{{ $staff->Identifier }}</td>
                        <td>
                            @foreach($staff->profiles as $title)
                                <h6><span class="badge rounded-pill bg-light">{{ $title->profile_manage->name }}</span></h6>
                            @endforeach
                        </td>
                        <td>
                            @foreach($staff->profiles as $title)
                                <h6><span class="badge rounded-pill bg-light">{{ $title->profession_manage->name }}</span></h6>
                            @endforeach
                        </td>
                        <td>
                            @foreach($staff->profiles as $title)
                                <h6><span class="badge rounded-pill bg-light">{{ Carbon\Carbon::parse($title->degree_date)->format('d-m-Y') }}</span></h6>
                            @endforeach
                        </td>
                        <td>
                            @foreach($staff->profiles as $title)
                                <h6><span class="badge rounded-pill bg-light">{{ $title->YearsOfDegree }}</span></h6>
                            @endforeach
                        </td>
                        <td>{{ $staff->StatusValue }}</td>
                        <td>
                            <a href="{{ route('replacement_staff.show_replacement_staff', $staff) }}"
                              class="btn btn-outline-secondary btn-sm"
                              title="Ir"
                              target="_blank"> <i class="far fa-eye"></i></a>
                            <a href="{{ route('replacement_staff.show_file', $staff) }}"
                              class="btn btn-outline-secondary btn-sm"
                              title="Ir"
                              target="_blank"> <i class="far fa-file-pdf"></i></a>
                        </td>
                        <td>
                            <fieldset class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="replacement_staff_id[]"
                                        value="{{ $staff->id }}">
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Seleccionar</button>
                    </form>

            {{ $replacementStaff->links() }}
            @endif
        </div>
    </div>
<br>

<div class="card applicant" id="file">
    <div class="card-header">
        <h6>Adjuntos </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                      <th>Nombre Archivo</th>
                      <th>Cargado por</th>
                      <th>Fecha</th>
                      <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($technicalEvaluation->technical_evaluation_files->sortByDesc('created_at') as $technicalEvaluationFiles)
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
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
        @livewire('replacement-staff.files', ['users' => $users,
                  'technicalEvaluation' => $technicalEvaluation])
    </div>
    <br>
</div>

@endsection

@section('custom_js')

@endsection
