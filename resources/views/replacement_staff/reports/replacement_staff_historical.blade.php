@extends('layouts.bt4.app')

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
                    <td>{{ $replacementStaff->fullName }}</td>
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

</div>

<div class="col-sm">
    <div class="table-responsive">
        <h6><i class="fas fa-info-circle"></i> Listado de Evaluaciones Técnicas</h6>
        <table class="table table-sm table-bordered table-striped">
            <thead class="small text-center">
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Nombre Solicitud</th>
                    <th rowspan="2" width="10%">Calificación Evaluación Psicolaboral</th>
                    <th rowspan="2" width="12%">Calificación Evaluación Técnica y/o de Apreciación Global</th>
                    <th colspan="2">Seleccionado</th>
                    <th colspan="2">Desiste</th>
                    <th colspan="2">Fecha Efectiva</th>
                </tr>
                <tr>
                    <th>Estado</th>
                    <th>Observacion</th>
                    <th>Estado</th>
                    <th>Observacion</th>
                    <th>Ingreso</th>
                    <th>Fin</th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach($applicants as $key => $applicant)
                    <tr>
                        <td class="text-center"><a href="{{ route('replacement_staff.request.technical_evaluation.edit', $applicant->technicalEvaluation->requestReplacementStaff) }}" target="_blank">{{ $applicant->technicalEvaluation->requestReplacementStaff->id }}</a></td>
                        <td><a href="{{ route('replacement_staff.request.technical_evaluation.edit', $applicant->technicalEvaluation->requestReplacementStaff) }}" target="_blank">{{ $applicant->technicalEvaluation->requestReplacementStaff->name }}</a></td>
                        <td class="text-center">{{ $applicant->psycholabor_evaluation_score }}</td>
                        <td class="text-center">{{ $applicant->technical_evaluation_score }}</td>
                        <td class="text-center">
                            @if($applicant->selected == 1)
                            Si
                            @endif
                        </td>
                        <td class=>{{ $applicant->observations }}</td>
                        <td class="text-center">
                            @if($applicant->desist == 1)
                            Si
                            @endif
                        </td>
                        <td class=>{{ $applicant->desist_observation }}</td>
                        <td class="text-center" width="8%">{{ $applicant->start_date->format('d-m-Y') }}</td>
                        <td class="text-center" width="8%">{{ $applicant->end_date->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
