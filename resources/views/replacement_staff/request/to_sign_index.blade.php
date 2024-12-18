@extends('layouts.bt4.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col">
        <h4 class="mb-3">Gestión de Solicitudes para aprobación:<br>
        <small>{{ auth()->user()->organizationalUnit->name }}</small></h4>
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
                                <b>Creado por</b>: {{ $requestReplacementStaff->user->tinyName}} <br>
                                ({{ $requestReplacementStaff->organizationalUnit->name }}) <br>
                                <b>Solicitado por</b>: {{($requestReplacementStaff->requesterUser) ?  $requestReplacementStaff->requesterUser->tinyName : '' }}
                            </p>
                        </td>
                        <td class="text-center">
                            @if(count($requestReplacementStaff->approvals) > 0)
                                @foreach($requestReplacementStaff->approvals as $approval)
                                    <!-- APPROVALS DE JEFATURA DIRECTA -->
                                    @if($approval->subject == "Solicitud de Aprobación Jefatura Depto. o Unidad")
                                        @switch($approval->StatusInWords)
                                            @case('Pendiente')
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}">
                                                    <i class="fas fa-clock fa-2x"></i>
                                                </span>
                                                @break
                                            @case('Aprobado')
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}" style="color: green;">
                                                    <i class="fas fa-check-circle fa-2x"></i>
                                                </span>
                                            @break
                                            @case('Rechazado')
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}" style="color: tomato;">
                                                    <i class="fas fa-times-circle fa-2x"></i>
                                                </span>
                                            @break
                                        @endswitch
                                    @endif
                                @endforeach

                                <!-- APROBACION DE PERSONAL -->
                                @if($requestReplacementStaff->form_type == 'replacement')
                                    @if(count($requestReplacementStaff->requestSign) > 0)
                                        @foreach($requestReplacementStaff->requestSign as $sign)
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
                                    @else
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ App\Models\Parameters\Parameter::get('ou','NombreUnidadPersonal', $requestReplacementStaff->establishment_id) }}">
                                            <i class="fas fa-clock fa-2x"></i>
                                        </span>
                                    @endif
                                @endif

                                <!-- APPROVALS DE PLANIFICACION - SDGP -->
                                @php $flagPostPersonal = array(); @endphp
                                @foreach($requestReplacementStaff->approvals as $approval)
                                    @if($approval->subject == 'Solicitud de Aprobación Planificación' || 
                                        $approval->subject == 'Solicitud de Aprobación SDGP')
                                        @switch($approval->StatusInWords)
                                            @case('Pendiente')
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}">
                                                    <i class="fas fa-clock fa-2x"></i>
                                                </span>
                                                @break
                                            @case('Aprobado')
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}" style="color: green;">
                                                    <i class="fas fa-check-circle fa-2x"></i>
                                                </span>
                                            @break
                                            @case('Rechazado')
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}" style="color: tomato;">
                                                    <i class="fas fa-times-circle fa-2x"></i>
                                                </span>
                                            @break
                                        @endswitch

                                        @php $flagPostPersonal[] = 1 @endphp
                                    @else
                                        @php $flagPostPersonal[] = 0; @endphp
                                    @endif
                                @endforeach

                                @if(!in_array(1, $flagPostPersonal))
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-placement="top" title="{{ App\Models\Parameters\Parameter::get('ou','NombrePlanificaciónRRHH', $requestReplacementStaff->establishment_id) }}">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </span>
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-placement="top" title="{{ App\Models\Parameters\Parameter::get('ou','NombreSubRRHH', $requestReplacementStaff->establishment_id) }}">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </span>
                                @endif

                                <!-- APPROVALS DE FINANZAS FIRMA ELECTRÓNICA -->
                                @php $flagPostRrhh = array(); @endphp
                                @if($requestReplacementStaff->form_type == 'replacement')
                                    @foreach($requestReplacementStaff->approvals as $approval)
                                        @if(str_contains($approval->subject, 'Certificado de disponibilidad presupuestaria'))
                                            @switch($approval->StatusInWords)
                                                @case('Pendiente')
                                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}">
                                                        <i class="fas fa-signature fa-2x"></i>
                                                    </span>
                                                    @break
                                                @case('Aprobado')
                                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}" style="color: green;">
                                                        <i class="fas fa-signature fa-2x"></i>
                                                    </span>
                                                @break
                                                @case('Rechazado')
                                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}" style="color: tomato;">
                                                        <i class="fas fa-times-circle fa-2x"></i>
                                                    </span>
                                                @break
                                            @endswitch

                                            @php $flagPostRrhh[] = 1 @endphp
                                        @else
                                            @php $flagPostRrhh[] = 0; @endphp
                                        @endif
                                    @endforeach
                                

                                    @if(!in_array(1, $flagPostRrhh))
                                        <span class="d-inline-block" 
                                            tabindex="0" 
                                            data-toggle="tooltip" 
                                            data-placement="top" 
                                            title="{{ App\Models\Parameters\Parameter::get('ou', 'NombreUnidadFinanzas', $requestReplacementStaff->establishment_id) }}">
                                            <i class="fas fa-signature fa-2x"></i>
                                        </span>
                                    @endif
                                @endif

                            @else
                                <!-- Antiguo Modelo Interno de Aprobaciones -->
                                @foreach($requestReplacementStaff->requestSign as $sign)
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
                                        @if($requestReplacementStaff->signaturesFile)
                                            @foreach($requestReplacementStaff->signaturesFile->signaturesFlows as $flow)
                                                @if($flow->status == 1)
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}" style="color: green;">
                                                    <i class="fas fa-signature fa-2x"></i>
                                                </span>
                                                @elseif($flow->status === 0)
                                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}" style="color: tomato;">
                                                    <i class="fas fa-times-circle fa-2x"></i>
                                                </span>
                                                @else
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}">
                                                    <i class="fas fa-clock fa-2x"></i>
                                                </span>
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}">
                                                <i class="fas fa-clock fa-2x"></i>
                                            </span>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                            
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

                            @if(count($requestReplacementStaff->approvals) > 0)
                                @if($requestReplacementStaff->approvals->last()->subject == "Solicitud de Aprobación Jefatura Depto. o Unidad")
                                    <a class="btn btn-outline-secondary btn-sm" 
                                        href="{{ route('replacement_staff.request.to_sign', $requestReplacementStaff) }}">
                                        <i class="fas fa-signature"></i>
                                    </a>
                                    <br>
                                @endif
                            @else
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
                            @endif
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
                            <b>Creado por</b>: {{ $requestReplacementStaff->user->tinyName}} <br>
                            ({{ $requestReplacementStaff->organizationalUnit->name }}) <br>
                            <b>Solicitado por</b>: {{($requestReplacementStaff->requesterUser) ?  $requestReplacementStaff->requesterUser->tinyName : '' }}
                        </p>
                    </td>
                    <td class="text-center">
                        @if(count($requestReplacementStaff->approvals) > 0)
                            @foreach($requestReplacementStaff->approvals as $approval)
                                <!-- APPROVALS DE JEFATURA DIRECTA -->
                                @if($approval->subject == "Solicitud de Aprobación Jefatura Depto. o Unidad")
                                    @switch($approval->StatusInWords)
                                        @case('Pendiente')
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}">
                                                <i class="fas fa-clock fa-2x"></i>
                                            </span>
                                            @break
                                        @case('Aprobado')
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}" style="color: green;">
                                                <i class="fas fa-check-circle fa-2x"></i>
                                            </span>
                                        @break
                                        @case('Rechazado')
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}" style="color: tomato;">
                                                <i class="fas fa-times-circle fa-2x"></i>
                                            </span>
                                        @break
                                    @endswitch
                                @endif
                            @endforeach

                            <!-- APROBACION DE PERSONAL -->
                            @if($requestReplacementStaff->form_type == 'replacement')
                                @if(count($requestReplacementStaff->requestSign) > 0)
                                    @foreach($requestReplacementStaff->requestSign as $sign)
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
                                @else
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ App\Models\Parameters\Parameter::get('ou','NombrePersonal') }}">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </span>
                                @endif
                            @endif

                            <!-- APPROVALS DE PLANIFICACION - SDGP -->
                            @php $flagPostPersonal = array(); @endphp
                            @foreach($requestReplacementStaff->approvals as $approval)
                                @if($approval->subject == 'Solicitud de Aprobación Planificación' || 
                                    $approval->subject == 'Solicitud de Aprobación SDGP')
                                    @switch($approval->StatusInWords)
                                        @case('Pendiente')
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}">
                                                <i class="fas fa-clock fa-2x"></i>
                                            </span>
                                            @break
                                        @case('Aprobado')
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}" style="color: green;">
                                                <i class="fas fa-check-circle fa-2x"></i>
                                            </span>
                                        @break
                                        @case('Rechazado')
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}" style="color: tomato;">
                                                <i class="fas fa-times-circle fa-2x"></i>
                                            </span>
                                        @break
                                    @endswitch

                                    @php $flagPostPersonal[] = 1 @endphp
                                @else
                                    @php $flagPostPersonal[] = 0; @endphp
                                @endif
                            @endforeach

                            @if(!in_array(1, $flagPostPersonal))
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-placement="top" title="{{ App\Models\Parameters\Parameter::get('ou','NombrePlanificaciónRRHH', $requestReplacementStaff->establishment_id) }}">
                                    <i class="fas fa-clock fa-2x"></i>
                                </span>
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-placement="top" title="{{ App\Models\Parameters\Parameter::get('ou','NombreSubRRHH', $requestReplacementStaff->establishment_id) }}">
                                    <i class="fas fa-clock fa-2x"></i>
                                </span>
                            @endif

                            <!-- APPROVALS DE FINANZAS FIRMA ELECTRÓNICA -->
                            @php $flagPostRrhh = array(); @endphp
                            @if($requestReplacementStaff->form_type == 'replacement')
                                @foreach($requestReplacementStaff->approvals as $approval)
                                    @if(str_contains($approval->subject, 'Certificado de disponibilidad presupuestaria'))
                                        @switch($approval->StatusInWords)
                                            @case('Pendiente')
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}">
                                                    <i class="fas fa-signature fa-2x"></i>
                                                </span>
                                                @break
                                            @case('Aprobado')
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}" style="color: green;">
                                                    <i class="fas fa-signature fa-2x"></i>
                                                </span>
                                            @break
                                            @case('Rechazado')
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $approval->sentToOu->name }}" style="color: tomato;">
                                                    <i class="fas fa-times-circle fa-2x"></i>
                                                </span>
                                            @break
                                        @endswitch

                                        @php $flagPostRrhh[] = 1 @endphp
                                    @else
                                        @php $flagPostRrhh[] = 0; @endphp
                                    @endif
                                @endforeach
                            

                                @if(!in_array(1, $flagPostRrhh))
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-placement="top" title="{{ App\Models\Parameters\Parameter::get('ou', 'NombreUnidadFinanzas', $requestReplacementStaff->establishment_id) }}">
                                        <i class="fas fa-signature fa-2x"></i>
                                    </span>
                                @endif
                            @endif

                        @else
                            <!-- Antiguo Modelo Interno de Aprobaciones -->
                            @foreach($requestReplacementStaff->requestSign as $sign)
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
                                    @if($requestReplacementStaff->signaturesFile)
                                        @foreach($requestReplacementStaff->signaturesFile->signaturesFlows as $flow)
                                            @if($flow->status == 1)
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}" style="color: green;">
                                                <i class="fas fa-signature fa-2x"></i>
                                            </span>
                                            @elseif($flow->status === 0)
                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}" style="color: tomato;">
                                                <i class="fas fa-times-circle fa-2x"></i>
                                            </span>
                                            @else
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}">
                                                <i class="fas fa-clock fa-2x"></i>
                                            </span>
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $sign->organizationalUnit->name }}">
                                            <i class="fas fa-clock fa-2x"></i>
                                        </span>
                                    @endif
                                @endif
                            @endforeach
                        @endif

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
