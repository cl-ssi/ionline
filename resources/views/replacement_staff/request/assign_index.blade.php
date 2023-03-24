@extends('layouts.app')

@section('title', 'Listado de Solicitudes')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col-sm-9">
        <h4 class="mb-3"><i class="fas fa-inbox"></i> Todas mis Solicitudes Asignadas: </h4>
    </div>
</div>

</div>

<div class="col-sm">
    @livewire('replacement-staff.search-requests', [
        'typeIndex' => 'assigned_to'
    ])
</div>

{{-- 
<div class="row">
    <div class="col-sm-5">
        <h4 class="mb-3">: </h4>
    </div>
    <div class="col-sm-3">
        <p>
            <a class="btn btn-primary disabled" data-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fas fa-filter"></i> Filtros
            </a>
        </p>
    </div>
</div>

<div class="collapse" id="collapseSearch">
  <br>
  <div class="card card-body">
      <form method="GET" class="form-horizontal" action="{{ route('replacement_staff.index') }}">
          <div class="form-row">
              En Desarrollo
          </div>
      </form>
  </div>
</div>

</div>

<br>

<div class="col">
    <h5><i class="fas fa-inbox"></i> Solicitudes Pendientes</h5>
</div>

<div class="col">
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
                <th>Estado</th>
                <th style="width: 2%"></th>
            </tr>
        </thead>
        <tbody class="small">
          @if($pending_requests != NULL)
            @foreach($pending_requests as $requestReplacementStaff)
            <tr>
                <td>
                    {{ $requestReplacementStaff->id }} <br>
                    @switch($requestReplacementStaff->request_status)
                        @case('pending')
                            <span class="badge badge-warning">Pendiente</span>
                            @break

                        @case('complete')
                            <span class="badge badge-success">Finalizada</span>
                            @break

                        @case('rejected')
                            <span class="badge badge-danger">Rechazada</span>
                            @break

                        @default
                            Default case...
                    @endswitch
                </td>
                <td>{{ $requestReplacementStaff->created_at->format('d-m-Y H:i:s') }}</td>
                <td>{{ $requestReplacementStaff->name }}</td>
                <td class="text-center">{{ $requestReplacementStaff->degree }}</td>
                <td>{{ $requestReplacementStaff->legalQualityManage->NameValue }}</td>
                <td style="width: 8%">{{ $requestReplacementStaff->start_date->format('d-m-Y') }} <br>
                    {{ $requestReplacementStaff->end_date->format('d-m-Y') }}
                </td>
                <td class="text-center">{{ $requestReplacementStaff->getNumberOfDays() }}
                    @if($requestReplacementStaff->getNumberOfDays() > 1)
                        días
                    @else
                        dia
                    @endif
                </td>
                <td>
                    {{ $requestReplacementStaff->fundamentManage->NameValue }}<br>
                    {{ $requestReplacementStaff->fundamentDetailManage->NameValue }}
                </td>
                <td>
                    {{ $requestReplacementStaff->WorkDayValue }}
                </td>
                <td>{{ $requestReplacementStaff->user->FullName }}<br>
                    {{ $requestReplacementStaff->organizationalUnit->name }}
                </td>
                <td class="text-center">
                    @foreach($requestReplacementStaff->RequestSign as $sign)
                        @if($sign->request_status == 'pending' || $sign->request_status == NULL)
                            <i class="fas fa-clock fa-2x" title="{{ $sign->organizationalUnit->name }}"></i>
                        @endif
                        @if($sign->request_status == 'accepted')
                          <span style="color: green;">
                            <i class="fas fa-check-circle fa-2x" title="{{ $sign->organizationalUnit->name }}"></i>
                          </span>
                        @endif
                        @if($sign->request_status == 'rejected')
                          <span style="color: Tomato;">
                            <i class="fas fa-times-circle fa-2x" title="{{ $sign->organizationalUnit->name }}"></i>
                          </span>
                        @endif
                    @endforeach
                    </br>
                    @if($requestReplacementStaff->request_id != NULL)
                        <span class="badge badge-info">Continuidad</span>
                    @endif
                </td>
                <td>
                  @if($requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id)
                      <!-- <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Asignado a: {{ $requestReplacementStaff->assignEvaluations->last()->userAssigned->FullName }}">
                      <a href="{{ route('replacement_staff.request.technical_evaluation.edit', $requestReplacementStaff->technicalEvaluation) }}"
                            class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i></a>
                      </span> -->

                      <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Asignado a: {{ $requestReplacementStaff->assignEvaluations->last()->userAssigned->FullName }}">
                      <a href="{{ route('replacement_staff.request.technical_evaluation.edit', $requestReplacementStaff) }}"
                            class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i></a>
                      </span>

                      
                  @endif
                </td>
            </tr>
            @endforeach
          @else
            <tr>
                <td>Hola
                  <div class="alert alert-secondary" role="alert">
                    A simple secondary alert—check it out!
                  </div>
                </td>
            </tr>
          @endif
        </tbody>
    </table>
</div>

<div class="col">
    <hr>
</div>

<div class="col">
    <h5><i class="fas fa-inbox"></i> Solicitudes Finalizadas</h5>
</div>

<div class="col">
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
                <th>Estado</th>
                <th style="width: 2%" colspan="2"></th>
            </tr>
        </thead>
        <tbody class="small">
            @foreach($requests as $requestReplacementStaff)
            <tr class="{{ ($requestReplacementStaff->sirh_contract == 1) ? 'table-success':'' }}">
                <td>
                    {{ $requestReplacementStaff->id }} <br>
                    @switch($requestReplacementStaff->request_status)
                        @case('pending')
                            <span class="badge badge-warning">Pendiente</span>
                            @break

                        @case('complete')
                            <span class="badge badge-success">Finalizada</span>
                            @break

                        @case('rejected')
                            <span class="badge badge-danger">Rechazada</span>
                            @break

                        @default
                            Default case...
                    @endswitch
                    <br>
                    @if($requestReplacementStaff->sirh_contract)
                        <i class="fas fa-file-signature"></i>
                    @endif
                </td>
                <td>{{ $requestReplacementStaff->created_at->format('d-m-Y H:i:s') }}</td>
                <td>{{ $requestReplacementStaff->name }}</td>
                <td class="text-center">{{ $requestReplacementStaff->degree }}</td>
                <td>{{ $requestReplacementStaff->legalQualityManage->NameValue }}</td>
                <td style="width: 8%">{{ $requestReplacementStaff->start_date->format('d-m-Y') }} <br>
                    {{ $requestReplacementStaff->end_date->format('d-m-Y') }}
                </td>
                <td class="text-center">{{ $requestReplacementStaff->getNumberOfDays() }}
                    @if($requestReplacementStaff->getNumberOfDays() > 1)
                        días
                    @else
                        dia
                    @endif
                </td>
                <td>{{ $requestReplacementStaff->fundamentManage->NameValue }}<br>
                    {{ $requestReplacementStaff->fundamentDetailManage->NameValue }}
                </td>
                <td>
                    {{ $requestReplacementStaff->WorkDayValue }}
                </td>
                <td>{{ $requestReplacementStaff->user->FullName }}<br>
                    {{ $requestReplacementStaff->organizationalUnit->name }}
                </td>
                <td class="text-center">
                    @foreach($requestReplacementStaff->RequestSign as $sign)
                        @if($sign->request_status == 'pending' || $sign->request_status == NULL)
                            <i class="fas fa-clock fa-2x" title="{{ $sign->organizationalUnit->name }}"></i>
                        @endif
                        @if($sign->request_status == 'accepted')
                          <span style="color: green;">
                            <i class="fas fa-check-circle fa-2x" title="{{ $sign->organizationalUnit->name }}"></i>
                          </span>
                        @endif
                        @if($sign->request_status == 'rejected')
                          <span style="color: Tomato;">
                            <i class="fas fa-times-circle fa-2x" title="{{ $sign->organizationalUnit->name }}"></i>
                          </span>
                        @endif
                    @endforeach
                    </br>
                    @if($requestReplacementStaff->request_id != NULL)
                        <span class="badge badge-info">Continuidad</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('replacement_staff.request.technical_evaluation.edit', $requestReplacementStaff) }}"
                                class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
                </td>
                <td>
                  @if($requestReplacementStaff->technicalEvaluation)
                    <a href="{{ route('replacement_staff.request.technical_evaluation.create_document', $requestReplacementStaff) }}"
                                class="btn btn-outline-info btn-sm" title="Selección" target="_blank"><i class="fas fa-file"></i></a>
                  @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $requests->links() }}
</div>
--}}
@endsection

@section('custom_js')

@endsection
