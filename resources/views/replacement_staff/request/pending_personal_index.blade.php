@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<!-- <div class="row">
  <div class="col-sm-3">
      <h4 class="mb-3">Mis Solicitudes: </h4>
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

<br> -->

</div>

<div class="col">
    <h5><i class="fas fa-inbox"></i> Solicitudes Pendientes</h5>
</div>

<div class="col">
    <div class="table-responsive">
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
              @foreach($requests as $requestReplacementStaff)
              <tr>
                  <td>{{ $requestReplacementStaff->id }} <br>
                    @switch($requestReplacementStaff->request_status)
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
                  <td>{{ $requestReplacementStaff->created_at->format('d-m-Y H:i:s') }}</td>
                  <td>{{ $requestReplacementStaff->name }}</td>
                  <td class="text-center">{{ $requestReplacementStaff->degree }}</td>
                  <td>{{ $requestReplacementStaff->legalQualityManage->NameValue }}</td>
                  <td>{{ Carbon\Carbon::parse($requestReplacementStaff->start_date)->format('d-m-Y') }} <br>
                      {{ Carbon\Carbon::parse($requestReplacementStaff->end_date)->format('d-m-Y') }}
                  </td>
                  <td>
                    {{ $requestReplacementStaff->fundamentManage->NameValue }}<br>
                    {{ $requestReplacementStaff->fundamentDetailManage->NameValue }}
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
                  </td>
                  <td>
                      <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                          data-target="#exampleModalCenter-req-{{ $requestReplacementStaff->id }}">
                        <i class="fas fa-eye"></i>
                      </button>
                      @include('replacement_staff.modals.modal_to_view_request')
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
    </div>
</div>

@endsection

@section('custom_js')

@endsection
