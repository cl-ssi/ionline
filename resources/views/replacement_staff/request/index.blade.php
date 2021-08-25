@extends('layouts.app')

@section('title', 'Listado de Solicitudes')

@section('content')

@include('replacement_staff.nav')

<h4 class="mb-3">Listado de Solicitudes: </h4>

<p>
    <a class="btn btn-primary" href="{{ route('replacement_staff.request.create') }}">
        <i class="fas fa-plus"></i> Agregar nuevo</a>
    <a class="btn btn-primary disabled" data-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseExample">
        <i class="fas fa-filter"></i> Filtros
    </a>
</p>

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
    <table class="table small table-striped table-bordered">
        <thead class="text-center">
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
        <tbody>
          @if($pending_requests != NULL)
            @foreach($pending_requests as $request)
            <tr>
                <td>
                    {{ $request->id }} <br>
                    @if($request->TechnicalEvaluation)
                      @if($request->TechnicalEvaluation->technical_evaluation_status == 'complete')
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
                <td>{{ $request->created_at->format('d-m-Y H:i:s') }}</td>
                <td>{{ $request->name }}</td>
                <td class="text-center">{{ $request->degree }}</td>
                <td class="text-center">{{ $request->LegalQualityValue }}</td>
                <td>{{ $request->start_date->format('d-m-Y') }} <br>
                    {{ $request->end_date->format('d-m-Y') }}
                </td>
                <td>{{ $request->FundamentValue }}</td>
                <td>{{ $request->user->FullName }}<br>
                    {{ $request->organizationalUnit->name }}
                </td>
                <td class="text-center">
                    @foreach($request->RequestSign as $sign)
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
                    @foreach($request->RequestSign as $sign)
                        @if($sign->position == 3 && $sign->request_status == "accepted" && !$request->technicalEvaluation)
                            <a href="{{ route('replacement_staff.request.technical_evaluation.store', $request) }}"
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
</div>

<div class="col">
    <hr>
</div>

<div class="col">
    <h5><i class="fas fa-inbox"></i> Solicitudes Finalizadas</h5>
</div>

<div class="col">
    <table class="table small table-striped table-bordered">
        <thead class="text-center">
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
        <tbody>
          @if($requests != NULL)
            @foreach($requests as $request)
            <tr>
                <td>
                    {{ $request->id }} <br>
                    @if($request->TechnicalEvaluation)
                      @if($request->TechnicalEvaluation->technical_evaluation_status == 'complete')
                        <span style="color: green;">
                          <i class="fas fa-check-circle " title="Evaluación Técnica: {{ $request->TechnicalEvaluation->StatusValue }}"></i>
                        </span>
                      {{-- @else --}}
                        <!-- <i class="fas fa-clock" title="Evaluación Técnica: Pendiente"></i> -->
                      @endif
                    {{-- @else --}}
                        <!-- <i class="fas fa-clock" title="Evaluación Técnica: Pendiente"></i> -->
                    @endif

                </td>
                <td>{{ $request->created_at->format('d-m-Y H:i:s') }}</td>
                <td>{{ $request->name }}</td>
                <td class="text-center">{{ $request->degree }}</td>
                <td class="text-center">{{ $request->LegalQualityValue }}</td>
                <td>{{ $request->start_date->format('d-m-Y') }} <br>
                    {{ $request->end_date->format('d-m-Y') }}
                </td>
                <td>{{ $request->FundamentValue }}</td>
                <td>{{ $request->user->FullName }}<br>
                    {{ $request->organizationalUnit->name }}
                </td>
                <td class="text-center">
                    @foreach($request->RequestSign as $sign)
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
                    @foreach($request->RequestSign as $sign)
                        @if($sign->position == 3 && $sign->request_status == "accepted" && !$request->technicalEvaluation)
                            <a href="{{ route('replacement_staff.request.technical_evaluation.store', $request) }}"
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
