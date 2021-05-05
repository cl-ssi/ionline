@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<div class="row">
  <div class="col-sm-3">
      <h4 class="mb-3">Mis Solicitudes</h4>
  </div>

  <div class="col-sm-3">
    <p>
        <a class="btn btn-primary" href="{{ route('replacement_staff.request.create') }}">
            <i class="fas fa-plus"></i> Nueva</a>
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

<h5><i class="fas fa-inbox"></i> Solicitudes Pendientes</h5>

<br>
<div class="table-responsive">
  <table class="table small table-striped table-bordered">
      <thead class="text-center">
          <tr>
              <th>#</th>
              <th>Cargo</th>
              <th>Grado</th>
              <th>Calidad Jurídica</th>
              <th>Periodo</th>
              <th>Fundamento</th>
              <th>Solicitante</th>
              <th>Estado</th>
              <th></th>
          </tr>
      </thead>
      <tbody>
          @foreach($my_pending_requests as $request)
          <tr>
              <td>{{ $request->id }}<br>
                  @if($request->TechnicalEvaluation)
                      <i class="fas fa-clock" title="Evaluación Técnica: {{ $request->TechnicalEvaluation->StatusValue }}"></i>
                  @else
                      <i class="fas fa-clock" title="Evaluación Técnica: Pendiente"></i>
                  @endif
              </td>
              <td>{{ $request->name }}</td>
              <td class="text-center">{{ $request->degree }}</td>
              <td class="text-center">{{ $request->LegalQualityValue }}</td>
              <td>{{ Carbon\Carbon::parse($request->start_date)->format('d-m-Y') }} <br>
                  {{ Carbon\Carbon::parse($request->end_date)->format('d-m-Y') }}
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
                  @if($request->RequestSign->first()->request_status == 'pending')
                  <a href="{{ route('replacement_staff.request.edit', $request) }}"
                      class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
                  @else
                  <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                      data-target="#exampleModalCenter-req-{{ $request->id }}">
                    <i class="fas fa-eye"></i>
                  </button>
                  @include('replacement_staff.modals.modal_to_view_request')
                  @endif
              </td>
          </tr>
          @endforeach
      </tbody>
  </table>
</div>
<br>
<hr>

<h5><i class="fas fa-inbox"></i> Solicitudes Finalizadas</h5>

<div class="table-responsive">
  <table class="table small table-striped table-bordered">
      <thead class="text-center">
          <tr>
              <th>#</th>
              <th>Cargo</th>
              <th>Grado</th>
              <th>Calidad Jurídica</th>
              <th>Periodo</th>
              <th>Fundamento</th>
              <th>Solicitante</th>
              <th>Aprobación</th>
              <th></th>
          </tr>
      </thead>
      <tbody>
          @foreach($my_request as $request)
          <tr>
              <td>{{ $request->id }} <br>
                @if($request->TechnicalEvaluation)
                  @if($request->TechnicalEvaluation->technical_evaluation_status == 'complete')
                      <i class="fas fa-check-circle" title="Evaluación Técnica: {{ $request->TechnicalEvaluation->StatusValue }}"></i>
                  @endif
                  @if($request->TechnicalEvaluation->technical_evaluation_status == 'rejected')
                      <i class="fas fa-times-circle" title="Evaluación Técnica: {{ $request->TechnicalEvaluation->StatusValue }}"></i>
                  @endif
                @endif
              </td>
              <td>{{ $request->name }}</td>
              <td class="text-center">{{ $request->degree }}</td>
              <td class="text-center">{{ $request->LegalQualityValue }}</td>
              <td>{{ Carbon\Carbon::parse($request->start_date)->format('d-m-Y') }} <br>
                  {{ Carbon\Carbon::parse($request->end_date)->format('d-m-Y') }}
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
                  @if($request->RequestSign->first()->request_status != 'pending')
                  <a href="{{ route('replacement_staff.request.edit', $request) }}"
                      class="btn btn-outline-secondary btn-sm disabled" title="Selección"><i class="fas fa-edit"></i></a>
                  @else
                  <a href="{{ route('replacement_staff.request.edit', $request) }}"
                      class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
                  @endif
              </td>
          </tr>
          @endforeach
      </tbody>
  </table>
</div>
@endsection

@section('custom_js')

@endsection
