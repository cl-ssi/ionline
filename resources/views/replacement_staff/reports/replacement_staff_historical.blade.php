@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col-sm-8">
        <h5 class="mb-3"><i class="far fa-file-alt"></i> Reporte: Histórico por Persona </h5>
    </div>
</div>

<div class="row">
    <div class="col-sm">
        <form class="form-inline" method="GET" action="{{ route('replacement_staff.reports.replacement_staff_historical') }}">
            <div class="input-group">
                <input type="text" name="run" class="form-control" placeholder="Ingrese RUN sin DV" value="{{ $request->run }}" autofocus>
                <div class="input-group-append">
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="fas fa-search" aria-hidden="true"></i> Buscar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<br>

@if($replacementStaff)
<div class="row">
    <div class="col-sm-6">
        <div class="table-responsive">
          <h6><i class="fas fa-info-circle"></i> Antecedentes Personales</h6>
          <table class="table table-sm table-bordered">
            <tbody class="small">
                <tr>
                    <th class="table-active" width="25%">Nombre</th>
                    <td>{{ $replacementStaff->FullName }}</td>
                </tr>
                <tr>
                    <th class="table-active">Run</th>
                    <td>{{ $replacementStaff->Identifier }}</td>
                </tr>
                <tr>
                    <th class="table-active">Sexo</th>
                    <td>{{ $replacementStaff->GenderValue }}</td>
                </tr>
                <tr>
                    <th class="table-active">Fecha Nacimiento</th>
                    <td>{{ $replacementStaff->birthday->format('d-m-Y') }} ({{ Carbon\Carbon::parse($replacementStaff->birthday)->age }} años)</td>
                </tr>
                <tr>
                    <th class="table-active">Correo Electrónico</th>
                    <td>{{ $replacementStaff->email }}</td>
                </tr>
                <tr>
                    <th class="table-active">Teléfono</th>
                    <td>{{ $replacementStaff->telephone }} {{ $replacementStaff->telephone2 }}</td>
                </tr>
                <tr>
                    <th class="table-active">Dirección</th>
                    <td>{{ $replacementStaff->address }}</td>
                </tr>
                <tr>
                    <th class="table-active">Región</th>
                    <td>{{ $replacementStaff->region->name }}</td>
                </tr>
                <tr>
                    <th class="table-active">Comuna</th>
                    <td>{{ $replacementStaff->clCommune->name }}</td>
                </tr>
                <tr>
                    <th class="table-active">Estado</th>
                    <td>{{ $replacementStaff->StatusValue }}</td>
                </tr>
            </tbody>
          </table>
        </div>
    </div>
    <div class="col-sm-6">
        <h6><i class="fas fa-id-card-alt"></i> Perfil Profesional:</h6>
        <div class="table-responsive">
          <table class="table table-sm table-bordered">
            <tbody class="small">
              @foreach($replacementStaff->profiles as $profile)
                <tr>
                    <th class="table-active" width="25%">Estamento</th>
                    <td>{{ $profile->profile_manage->name }}</td>
                </tr>
                <tr>
                    <th class="table-active">Título</th>
                    <td>{{ $profile->profession_manage->name }}</td>
                </tr>
                <tr>
                    <th class="table-active">Experiencia</th>
                    <td>{{ $profile->ExperienceValue }}</td>
                </tr>
                <tr>
                    <th class="table-active">Fecha Titulación</th>
                    <td>{{ $profile->degree_date->format('d-m-Y') }} ({{ Carbon\Carbon::parse($profile->degree_date)->age }} años)</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col-sm">
        <div class="table-responsive">
          <h6><i class="fas fa-info-circle"></i> Listado de Evaluaciones Técnicas</h6>
          <table class="table table-sm table-bordered table-striped">
              <thead class="small text-center">
                  <tr>
                      <th rowspan="2">#</th>
                      <th rowspan="2">Solicitud</th>
                      <th rowspan="2">Calificación Evaluación Psicolaboral</th>
                      <th rowspan="2">Calificación Evaluación Técnica y/o de Apreciación Global</th>
                      <th rowspan="2">Observacion</th>
                      <th rowspan="2">Estado</th>
                      <th rowspan="2">Rachazo</th>
                      <th colspan="2">Fecha Efectiva</th>
                  </tr>
                  <tr>
                      <th>Ingreso</th>
                      <th>Fin</th>
                  </tr>
              </thead>
              <tbody class="small">
                @foreach($applicants as $key => $applicant)
                  <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $applicant->technicalEvaluation->requestReplacementStaff->name }}</td>
                      <td>{{ $applicant->psycholabor_evaluation_score }}</td>
                      <td>{{ $applicant->technical_evaluation_score }}</td>
                      <td>{{ $applicant->observations }}</td>
                      <td>
                        @if($applicant->selected == 1)
                          Seleccionado
                        @endif
                      </td>
                      <td>
                        @if($applicant->desist == 1)
                          Rechazo
                        @endif
                      </td>
                      <td>{{ $applicant->start_date->format('d-m-Y') }}</td>
                      <td>{{ $applicant->end_date->format('d-m-Y') }}</td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
    </div>
</div>

@else
<div class="row">
    <div class="col">
        <div class="card mb-3 bg-light">
            <div class="card-body">
                Estimado Usuario: No existen registros de RUN solicitado.
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('custom_js')

@endsection
