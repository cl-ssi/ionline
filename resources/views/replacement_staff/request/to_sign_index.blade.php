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
    <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.sign.massive_update') }}">
        @csrf
        @method('PUT')
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
                <thead class="text-center small">
                    <tr>
                        <th>#</th>
                        <th style="width: 7%">Fecha</th>
                        <th style="width: 15%">Nombre Solicitud</th>
                        <th>Grado / Renta</th>
                        <th>Calidad Jurídica</th>
                        <th style="width: 7%">Periodo</th>
                        <th>Fundamento</th>
                        <th>Creador / Solicitante</th>
                        <th>Estado</th>
                        <th style="width: 2%"></th>
                    </tr>
                </thead>
                <tbody class="small">
                    @php $flagButton = 0; @endphp
                    @foreach($pending_requests_to_sign as $requestReplacementStaff)
                    <tr>
                        <td>{{ $requestReplacementStaff->id }}<br>
                            <span class="badge badge-info">{{ $requestReplacementStaff->FormTypeValue }}</span> <br>
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
                        <td>
                            {{ $requestReplacementStaff->name }}
                        </td>
                        <td class="text-center">
                            @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
                                {{ $requestReplacementStaff->degree }}
                            @else
                                @foreach($requestReplacementStaff->positions as $position)
                                    @if($position->salary)
                                        ${{ number_format($position->salary, 0, ",", ".") ?? '' }}
                                    @else
                                        {{ $position->degree }}
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td nowrap>
                            @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
                                {{ $requestReplacementStaff->legalQualityManage->NameValue ?? '' }} ({{ $requestReplacementStaff->profile_manage->name ?? '' }})
                            @else
                                @foreach($requestReplacementStaff->positions as $position)
                                    {{ $position->legalQualityManage->NameValue ?? '' }} ({{ $position->profile_manage->name ?? '' }})<br>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
                                {{ Carbon\Carbon::parse($requestReplacementStaff->start_date)->format('d-m-Y') }} <br>
                                {{ Carbon\Carbon::parse($requestReplacementStaff->end_date)->format('d-m-Y') }} <br>
                                {{ $requestReplacementStaff->getNumberOfDays() }}
                                @if($requestReplacementStaff->getNumberOfDays() > 1)
                                    días
                                @else
                                    dia
                                @endif
                            @else
                                
                            @endif
                        </td>
                        <td nowrap>
                            @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)   
                                {{ $requestReplacementStaff->fundamentManage->NameValue ?? '' }} -
                                {{ $requestReplacementStaff->fundamentDetailManage->NameValue ?? '' }} <br>
                            @else
                                @foreach($requestReplacementStaff->positions as $position)
                                    <span class="badge badge-pill badge-dark">{{ $position->charges_number }}</span>
                                    {{ $position->fundamentManage->NameValue ?? '' }} -
                                    {{ $position->fundamentDetailManage->NameValue ?? '' }} <br>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <p>
                                <b>Creado por</b>: {{ $requestReplacementStaff->user->TinnyName}} <br>
                                ({{ $requestReplacementStaff->organizationalUnit->name }}) <br>
                                <b>Solicitado por</b>: {{($requestReplacementStaff->requesterUser) ?  $requestReplacementStaff->requesterUser->TinnyName : '' }}
                            </p>
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
                            {{--
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                                data-target="#exampleModalCenter-req-{{ $requestReplacementStaff->id }}">
                            <i class="fas fa-signature"></i>
                            </button>
                            @include('replacement_staff.modals.modal_to_sign')
                            --}}

                            @if($requestReplacementStaff->signatures_file_id != null)
                                <span class="d-inline-block" 
                                    tabindex="0" 
                                    data-toggle="tooltip" 
                                    title="La aprobación de Departamento de Gestión Financiera se trasladó al módulo Solicitud de Firmas">
                                    <i class="fas fa-info-circle fa-2x"></i>
                                </span>
                            @else
                                <a class="btn btn-outline-secondary btn-sm" 
                                    href="{{ route('replacement_staff.request.to_sign', $requestReplacementStaff) }}">
                                    <i class="fas fa-signature"></i>
                                </a>
                                <br>
                            @endif

                            
                            @foreach($requestReplacementStaff->RequestSign as $sign)
                                @if($sign->ou_alias == 'sub_rrhh' && $sign->request_status == "pending")
                                    @php $flagButton = 1; @endphp
                                    @if($requestReplacementStaff->form_type == "replacement")
                                        <div class="form-check float-right">
                                            <input class="form-check-input" type="checkbox" name="sign_id[]" value="{{ $sign->id }}" onclick="myFunction()" id="for_sign_id">
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($flagButton == 1)
            <button type="submit" 
                class="btn btn-primary float-right" 
                id="approve_btn"
                onclick="return confirm('¿Está seguro que desea aprobar estas solicitudes?')">
                <i class="fas fa-save"></i> Aprobación
            </button>
            <br><br>
        @endif
    </form>
</div>

<div class="col">
    <hr>
</div>

<div class="col">
    <h5><i class="fas fa-inbox"></i> Solicitudes Aprobadas / Rechazadas</h5>
</div>

<div class="col">
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead class="text-center small">
                <tr>
                    <th>#</th>
                    <th style="width: 7%">Fecha</th>
                    <th style="width: 15%">Nombre Solicitud</th>
                    <th>Grado / Renta</th>
                    <th>Calidad Jurídica</th>
                    <th style="width: 7%">Periodo</th>
                    <th>Fundamento</th>
                    <th>Creador / Solicitante</th>
                    <th>Estado</th>
                    <th style="width: 2%"></th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach($requests_to_sign as $requestReplacementStaff)
                <tr class="{{ ($requestReplacementStaff->sirh_contract == 1) ? 'table-success':'' }}" >
                    <td>
                        {{ $requestReplacementStaff->id }}<br>
                        <span class="badge badge-info">{{ $requestReplacementStaff->FormTypeValue }}</span> <br>
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
                    <td class="text-center">
                        @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
                            {{ $requestReplacementStaff->degree }}
                        @else
                            @foreach($requestReplacementStaff->positions as $position)
                                @if($position->salary)
                                    ${{ number_format($position->salary, 0, ",", ".") ?? '' }}
                                @else
                                    {{ $position->degree }}
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td nowrap>
                        @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
                            {{ $requestReplacementStaff->legalQualityManage->NameValue ?? '' }} ({{ $requestReplacementStaff->profile_manage->name ?? '' }})
                        @else
                            @foreach($requestReplacementStaff->positions as $position)
                                {{ $position->legalQualityManage->NameValue ?? '' }} ({{ $position->profile_manage->name ?? '' }})<br>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
                            {{ Carbon\Carbon::parse($requestReplacementStaff->start_date)->format('d-m-Y') }} <br>
                            {{ Carbon\Carbon::parse($requestReplacementStaff->end_date)->format('d-m-Y') }} <br>
                            {{ $requestReplacementStaff->getNumberOfDays() }}
                            @if($requestReplacementStaff->getNumberOfDays() > 1)
                                días
                            @else
                                dia
                            @endif
                        @else
                            
                        @endif
                    </td>
                    <td>
                        @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)   
                            {{ $requestReplacementStaff->fundamentManage->NameValue ?? '' }} -
                            {{ $requestReplacementStaff->fundamentDetailManage->NameValue ?? '' }} <br>
                        @else
                            @foreach($requestReplacementStaff->positions as $position)
                                <span class="badge badge-pill badge-dark">{{ $position->charges_number }}</span>
                                {{ $position->fundamentManage->NameValue ?? '' }} -
                                {{ $position->fundamentDetailManage->NameValue ?? '' }} <br>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <p>
                            <b>Creado por</b>: {{ $requestReplacementStaff->user->TinnyName}} <br>
                            ({{ $requestReplacementStaff->organizationalUnit->name }}) <br>
                            <b>Solicitado por</b>: {{($requestReplacementStaff->requesterUser) ?  $requestReplacementStaff->requesterUser->TinnyName : '' }}
                        </p>
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
                            @if($sign->request_status == 'not valid')
                                @foreach($requestReplacementStaff->signaturesFile->signaturesFlows as $flow)
                                    @if($flow->status == NULL)
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}">
                                            <i class="fas fa-clock fa-2x"></i>
                                        </span>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        </br>
                        @if($requestReplacementStaff->request_id != NULL)
                            <span class="badge badge-info">Continuidad</span>
                        @endif
                    </td>
                    <td>
                        @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
                            <a href="{{ route('replacement_staff.request.technical_evaluation.show', $requestReplacementStaff) }}"
                                class="btn btn-outline-secondary btn-sm" title="Evaluación Técnica"><i class="fas fa-eye"></i></a>
                        @else
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                                data-target="#exampleModalCenter-req-{{ $requestReplacementStaff->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            @include('replacement_staff.modals.modal_to_sign')
                        @endif
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

<script type="text/javascript">

    document.getElementById("approve_btn").disabled = true;

    function myFunction() {
        // Get the checkbox
        var checkBox = document.getElementById("approve_btn");

        // If the checkbox is checked, display the output text
        if (document.querySelectorAll('input[type="checkbox"]:checked').length > 0){
            document.getElementById("approve_btn").disabled = false;
        } else {
            document.getElementById("approve_btn").disabled = true;
        }
    }   
</script>

@endsection
