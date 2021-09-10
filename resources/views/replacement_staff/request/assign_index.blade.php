@extends('layouts.app')

@section('title', 'Listado de Solicitudes')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col-sm-3">
        <h4 class="mb-3">Listado de Solicitudes: </h4>
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
                <th>Periodo</th>
                <th>Fundamento</th>
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
                    @if($requestReplacementStaff->TechnicalEvaluation)
                      @if($requestReplacementStaff->TechnicalEvaluation->technical_evaluation_status == 'complete')
                        <span style="color: green;">
                          <i class="fas fa-check-circle " title="Evaluación Técnica: {{ $request->TechnicalEvaluation->StatusValue }}"></i>
                        </span>
                      @else
                        <i class="fas fa-clock" title="Evaluación Técnica: Pendiente"></i>
                      @endif
                    @else
                        <i class="fas fa-clock" title="Evaluación Técnica: Pendiente"></i>
                    @endif
                </td>
                <td>{{ $requestReplacementStaff->created_at->format('d-m-Y H:i:s') }}</td>
                <td>{{ $requestReplacementStaff->name }}</td>
                <td class="text-center">{{ $requestReplacementStaff->degree }}</td>
                <td class="text-center">{{ $requestReplacementStaff->LegalQualityValue }}</td>
                <td>{{ $requestReplacementStaff->start_date->format('d-m-Y') }} <br>
                    {{ $requestReplacementStaff->end_date->format('d-m-Y') }}
                </td>
                <td>{{ $requestReplacementStaff->FundamentValue }}</td>
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
                </td>
                <td>
                    @if($requestReplacementStaff->RequestSign->last()->request_status == "accepted" &&
                      !$requestReplacementStaff->technicalEvaluation &&
                      Auth::user()->hasPermissionTo('Replacement Staff: assign request'))
                        <!-- <a href="{{ route('replacement_staff.request.technical_evaluation.store', $requestReplacementStaff) }}"
                                onclick="return confirm('¿Está seguro de iniciar el proceso de selección?')"
                                class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a> -->

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                          data-target="#exampleModal-assign-{{ $requestReplacementStaff->id }}">
                            <i class="fas fa-user-tag"></i>
                        </button>

                        @include('replacement_staff.modals.modal_to_assign')

                    @elseif($sign->request_status == "accepted" && $requestReplacementStaff->technicalEvaluation)
                        Asignado a:
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
                <th>Periodo</th>
                <th>Fundamento</th>
                <th>Solicitante</th>
                <th>Estado</th>
                <th style="width: 2%"></th>
            </tr>
        </thead>
        <tbody class="small">
          @if($requests != NULL)
            @foreach($requests as $requestReplacementStaff)
            <tr>
                <td>
                    {{ $requestReplacementStaff->id }} <br>
                    @if($requestReplacementStaff->TechnicalEvaluation)
                      @if($requestReplacementStaff->TechnicalEvaluation->technical_evaluation_status == 'complete')
                        <span style="color: green;">
                          <i class="fas fa-check-circle " title="Evaluación Técnica: {{ $requestReplacementStaff->TechnicalEvaluation->StatusValue }}"></i>
                        </span>
                      {{-- @else --}}
                        <!-- <i class="fas fa-clock" title="Evaluación Técnica: Pendiente"></i> -->
                      @endif
                    {{-- @else --}}
                        <!-- <i class="fas fa-clock" title="Evaluación Técnica: Pendiente"></i> -->
                    @endif

                </td>
                <td>{{ $requestReplacementStaff->created_at->format('d-m-Y H:i:s') }}</td>
                <td>{{ $requestReplacementStaff->name }}</td>
                <td class="text-center">{{ $requestReplacementStaff->degree }}</td>
                <td class="text-center">{{ $requestReplacementStaff->LegalQualityValue }}</td>
                <td>{{ $requestReplacementStaff->start_date->format('d-m-Y') }} <br>
                    {{ $requestReplacementStaff->end_date->format('d-m-Y') }}
                </td>
                <td>{{ $requestReplacementStaff->FundamentValue }}</td>
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
                </td>
                <td>
                    @foreach($requestReplacementStaff->RequestSign as $sign)
                        @if($sign->position == 3 && $sign->request_status == "accepted" && !$request->technicalEvaluation)
                            <a href="{{ route('replacement_staff.request.technical_evaluation.store', $requestReplacementStaff) }}"
                                onclick="return confirm('¿Está seguro de iniciar el proceso de selección?')"
                                class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
                        @elseif($sign->position == 3 && $sign->request_status == "accepted" && $request->technicalEvaluation)
                            <a href="{{ route('replacement_staff.request.technical_evaluation.edit', $request->technicalEvaluation) }}"
                                class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
                        @endif
                    @endforeach
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

    {{ $requests->links() }}
</div>
@endsection

@section('custom_js')

@endsection
