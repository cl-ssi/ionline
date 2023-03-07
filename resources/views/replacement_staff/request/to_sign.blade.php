@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col">
        <h4 class="mb-3">Gestión de Solicitudes para aprobación:<br>
        <small>{{ Auth::user()->organizationalUnit->name }}</small></h4>
    </div>
</div>

</div>

<br>

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
                    <th>Cargo</th>
                    <th>Grado</th>
                    <th>Calidad Jurídica</th>
                    <th style="width: 7%">Periodo</th>
                    <th>Fundamento</th>
                    <th>Solicitante</th>
                    <th>Estado</th>
                    <th style="width: 2%"></th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach($pending_requests_to_sign as $requestReplacementStaff)
                <tr>
                    <td>{{ $requestReplacementStaff->id }}<br>
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
                    <td>{{ Carbon\Carbon::parse($requestReplacementStaff->start_date)->format('d-m-Y') }} <br>
                        {{ Carbon\Carbon::parse($requestReplacementStaff->end_date)->format('d-m-Y') }} <br>
                        {{ $requestReplacementStaff->getNumberOfDays() }}
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
                    <td>{{ $requestReplacementStaff->user->FullName }}<br>
                        {{ $requestReplacementStaff->organizationalUnit->name }}
                    </td>
                    <td class="text-center">
                        @foreach($requestReplacementStaff->RequestSign as $sign)
                            @if($sign->request_status == 'pending' || $sign->request_status == NULL)
                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}">
                                <i class="fas fa-clock fa-2x"></i>
                            </span>
                            @endif
                            @if($sign->request_status == 'accepted')
                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}" style="color: green;">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </span>
                            @endif
                            @if($sign->request_status == 'rejected')
                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}" style="color: Tomato;">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </span>
                            @endif
                        @endforeach
                        </br>
                        @if($requestReplacementStaff->request_id != NULL)
                            <span class="badge badge-info">Continuidad</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                            data-target="#exampleModalCenter-req-{{ $requestReplacementStaff->id }}">
                          <i class="fas fa-signature"></i>
                        </button>
                        @include('replacement_staff.modals.modal_to_sign')
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="col">
    <hr>
</div>

<div class="col">
    <h5><i class="fas fa-inbox"></i> Solicitudes Finalizadas</h5>
</div>

<div class="col">
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead class="text-center small">
                <tr>
                    <th>#</th>
                    <th style="width: 8%">Fecha</th>
                    <th>Cargo</th>
                    <th>Grado</th>
                    <th>Calidad Jurídica</th>
                    <th colspan="2">Periodo</th>
                    <th>Fundamento</th>
                    <th>Solicitante</th>
                    <th>Estado</th>
                    <th style="width: 2%"></th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach($requests_to_sign as $requestReplacementStaff)
                <tr class="{{ ($requestReplacementStaff->sirh_contract == 1) ? 'table-success':'' }}" >
                    <td>{{ $requestReplacementStaff->id }}<br>
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
                    <td class="text-center">{{ $requestReplacementStaff->legalQualityManage->NameValue }}</td>
                    <td>{{ Carbon\Carbon::parse($requestReplacementStaff->start_date)->format('d-m-Y') }} <br>
                        {{ Carbon\Carbon::parse($requestReplacementStaff->end_date)->format('d-m-Y') }}
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
                    <td>{{ $requestReplacementStaff->user->FullName }}<br>
                        {{ $requestReplacementStaff->organizationalUnit->name }}
                    </td>
                    <td class="text-center">
                        @foreach($requestReplacementStaff->RequestSign as $sign)
                            @if($sign->request_status == 'pending' || $sign->request_status == NULL)
                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}">
                                <i class="fas fa-clock fa-2x"></i>
                            </span>
                            @endif
                            @if($sign->request_status == 'accepted')
                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}" style="color: green;">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </span>
                            @endif
                            @if($sign->request_status == 'rejected')
                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}" style="color: Tomato;">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </span>
                            @endif
                        @endforeach
                        </br>
                        @if($requestReplacementStaff->request_id != NULL)
                            <span class="badge badge-info">Continuidad</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('replacement_staff.request.technical_evaluation.show', $requestReplacementStaff) }}"
                            class="btn btn-outline-secondary btn-sm" title="Evaluación Técnica"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $requests_to_sign->links() }}
    </div>
</div>

@endsection

@section('custom_js')

<script>
    $('[data-toggle="tooltip"]').tooltip()
</script>

@endsection
