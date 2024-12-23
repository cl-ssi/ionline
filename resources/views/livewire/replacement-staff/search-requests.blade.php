<div>
    <div class="card card-body small">
        <h5 class="mb-3"><i class="fas fa-search"></i> Buscar:</h5>

        <div class="form-row">
            <fieldset class="form-group col-12 col-md-3">
                <label for="for_profile_search">Tipo de Solicitud</label>
                <select name="status_search" class="form-control" wire:model.live.debounce.500ms="selectedFormType">
                    <option value="">Seleccione...</option>
                    <option value="replacement">Reemplazo</option>
                    <option value="announcement">Convocatoria</option>
                </select>
            </fieldset>

            <fieldset class="form-group col-12 col-md-2">
                <label for="for_profile_search">Estado</label>
                <select name="status_search" class="form-control" wire:model.live.debounce.500ms="selectedStatus">
                    <option value="">Seleccione...</option>
                    <option value="pending">Pendiente</option>
                    <option value="to assign">Sin Seleccionar</option>
                    <option value="finance sign">Seleccionado</option>
                    <option value="complete">Finalizada</option>
                    <option value="rejected">Rechazada</option>
                </select>
            </fieldset>

            <fieldset class="form-group col-12 col-md-1">
                <label for="for_name">ID</label>
                <input class="form-control" type="number" name="id_search" autocomplete="off" 
                    placeholder="001" wire:model.live.debounce.500ms="selectedId">
            </fieldset>

            <fieldset class="form-group col-sm">
                <label for="regiones">Periodo de Creación</label>
                <div class="input-group">
                    <input type="date" class="form-control" name="start_date_search" wire:model.live.debounce.500ms="selectedStartDate" required>
                    <input type="date" class="form-control" name="end_date_search" wire:model.live.debounce.500ms="selectedEndDate" required>
                </div>
            </fieldset>

            <fieldset class="form-group col-sm">
                <label for="for_name">Nombre de Solicitud</label>
                <input class="form-control" type="text" autocomplete="off"
                    name="name_search" wire:model.live.debounce.500ms="selectedName">
            </fieldset>
        </div>
        
        <div class="form-row">
            <fieldset class="form-group col-12 col-md-3">
                <label for="for_legal_quality_manage_id" >Fundamento / Detalle Fundamento</label>
                <div class="input-group">
                    <select name="fundament_search" id="for_fundament_manage_id" class="form-control" wire:model.live.debounce.500ms="selectedFundament" {{ $selectedFundamentInputStatus }}  required>
                        <option value="">Seleccione...</option>
                        @foreach($fundaments as $fundament)
                            <option value="{{ $fundament->id }}"
                                {{-- @if($requestReplacementStaff) {{ ($requestReplacementStaff->fundament_manage_id == $fundamentSelected) ? 'selected' : '' }} @endif --}}>
                                {{ $fundament->NameValue }}
                            </option>
                        @endforeach
                    </select>

                    <select name="fundament_detail_search" id="for_fundament_detail_manage_id" class="form-control" wire:model.live.debounce.500ms="selectedFundamentDetail" onchange="remoteWorking()" {{ $selectedFundamentDetailInputStatus }}>
                        <option value="">Seleccione...</option>
                        @if(!is_null($fundamentsDetail))
                        @foreach($fundamentsDetail as $fundamentDetail)
                            <option value="{{ $fundamentDetail->fundamentDetailManage->id }}"
                                {{-- @if($requestReplacementStaff) {{ ($requestReplacementStaff->fundament_detail_manage_id == $fundamentDetailSelected) ? 'selected' : '' }} @endif --}}>
                                {{ $fundamentDetail->fundamentDetailManage->NameValue }}
                            </option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </fieldset>
        
            <fieldset class="form-group col-12 col-md-3">
                <label for="for_name">Funcionario a Reemplazar</label>
                <input class="form-control" type="text" autocomplete="off" placeholder="RUN o NOMBRE"
                    name="name_to_replace_search" wire:model.live="selectedNameToReplace">
            </fieldset>

            @if($typeIndex == 'assign' || $typeIndex == 'personal' || $typeIndex == 'assigned_to')
            <fieldset class="form-group col-12 col-md-3">
                <label for="for_sub_search">Subdirección</label>
                <select name="sub_search" class="form-control" wire:model.live.debounce.500ms="selectedSub">
                    <option value="">Seleccione...</option>
                    @foreach($subs as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </select>
            </fieldset>
            @endif

            @if($typeIndex == 'assign')
            <fieldset class="form-group col-12 col-md-3">
                <label for="for_sub_search">Asignado</label>
                <select name="sub_search" class="form-control" wire:model.live.debounce.500ms="selectedAssigned">
                    <option value="">Seleccione...</option>
                    <option value="no">Sin asignar</option>
                </select>
            </fieldset>
            @endif
        </div>
    </div>
    <p class="font-weight-lighter">Total de Registros: <b>{{ $requests->total() }}</b></p>

    @if($requests->count() > 0)

    <div class="table-responsive">
        <br>
        {{ $requests->links() }}
        <table class="table table-sm table-striped table-bordered">
            <thead class="text-center small">
                <tr>
                    <th>#</th>
                    <th style="width: 7%">Fecha</th>
                    <th style="width: 15%">Nombre Solicitud</th>
                    <th>Grado / Renta</th>
                    <th>Calidad Jurídica</th>
                    <th width="7%">Periodo</th>
                    <th>Fundamento</th>
                    <th>Jornada</th>
                    <th>Creador / Solicitante</th>
                    <th>Estado</th>
                    <th style="width: 2%"></th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach($requests as $requestReplacementStaff)
                <tr class="{{ ($requestReplacementStaff->sirh_contract == 1) ? 'table-success':'' }}" >
                    <td>{{ $requestReplacementStaff->id }} <br>
                        <span class="badge badge-info">{{ $requestReplacementStaff->FormTypeValue }}</span> <br>
                        @switch($requestReplacementStaff->request_status)
                            @case('pending')
                                <span class="badge badge-warning">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break

                            @case('complete')
                                <span class="badge badge-success">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break

                            @case('rejected')
                                <span class="badge badge-danger">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break
                            
                            @case('to assign')
                                <span class="badge badge-warning">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break

                            @case('finance sign')
                                <span class="badge badge-warning">{{ $requestReplacementStaff->StatusValue }}</span>
                                <span class="badge badge-success"><i class="fas fa-user"></i> Seleccionado</span> <br>
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
                    <td>
                        @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
                            {{ $requestReplacementStaff->legalQualityManage->NameValue ?? '' }} ({{ $requestReplacementStaff->profile_manage->name ?? '' }})
                        @else
                            @foreach($requestReplacementStaff->positions as $position)
                                <span class="badge badge-pill badge-dark">{{ $position->charges_number }}</span>
                                {{ $position->legalQualityManage->NameValue ?? '' }} ({{ $position->profile_manage->name ?? '' }})
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
                            @foreach($requestReplacementStaff->positions as $position)
                                @foreach($position->selectedPositions as $key => $selectedPosition)
                                    {{ $selectedPosition->start_date ? $selectedPosition->start_date->format('d-m-Y') : '' }}
                                    @if($selectedPosition->start_date != NULL)
                                        <span class="badge badge-warning">3 meses: {{ $selectedPosition->start_date ? $selectedPosition->start_date->addMonths(3)->format('d-m-Y') : '' }}</span> 
                                        <span class="badge badge-danger">6 meses: {{ $selectedPosition->start_date ? $selectedPosition->start_date->addMonths(6)->format('d-m-Y') : '' }}</span> 
                                        <hr>
                                    @endif
                                @endforeach
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)   
                            {{ $requestReplacementStaff->fundamentManage->NameValue ?? '' }}<br>
                            {{ $requestReplacementStaff->fundamentDetailManage->NameValue ?? '' }}
                        @else
                            @foreach($requestReplacementStaff->positions as $position)
                                <span class="badge badge-pill badge-dark">{{ $position->charges_number }}</span>
                                {{ $position->fundamentManage->NameValue ?? '' }}
                                {{ $position->fundamentDetailManage->NameValue ?? '' }} <br>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)   
                            {{ $requestReplacementStaff->WorkDayValue }}
                        @else
                            @foreach($requestReplacementStaff->positions as $position)
                                {{ $position->WorkDayValue ?? '' }}
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
                                        title="{{ App\Models\Parameters\Parameter::get('ou','NombreUnidadFinanzas', $requestReplacementStaff->establishment_id) }}">
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
                            <br>
                            <span class="badge badge-info">Continuidad</span>
                        @endif
                    </td>
                    
                    <td>
                        <!-- ACCIONES CON APPROVALS -->
                        @if(count($requestReplacementStaff->approvals) > 0)
                            <!-- PERMITE EDITAR SOLICITUD ANTES DE LA PRIMERA APROBACIÓN -->
                            @if($requestReplacementStaff->approvals->first()->status === null && 
                                ($requestReplacementStaff->user->id == auth()->id() || 
                                $requestReplacementStaff->organizational_unit_id == auth()->user()->organizationalUnit->id ||
                                ($requestReplacementStaff->requesterUser && $requestReplacementStaff->requesterUser->id == auth()->id())))
                                    <a href="{{ route('replacement_staff.request.edit', $requestReplacementStaff) }}"
                                        class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
                            @endif

                            <!-- PERMITE MOSTRAR EL BOTÓN PARA ASIGNAR SOLICITUD -->
                            @if($typeIndex == 'assign' &&
                                $requestReplacementStaff->request_status == "to assign" &&
                                !$requestReplacementStaff->technicalEvaluation &&
                                auth()->user()->hasPermissionTo('Replacement Staff: assign request'))
                                <div class="form-check">
                                    <input class="form-check-input" 
                                        type="checkbox"
                                        wire:model="checkToAssign"
                                        value="{{ $requestReplacementStaff->id }}"
                                        id="for_sign_id">
                                </div>

                                <br />
                                
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                                    data-target="#exampleModal-assign-{{ $requestReplacementStaff->id }}">
                                    <i class="fas fa-user-tag"></i>
                                </button>
                                @if($users_rys)
                                    @include('replacement_staff.modals.modal_to_assign')
                                @endif
                            @endif

                            <!-- PERMITE INGRESAR A LA EVALUACION TÉCNICA -->
                            @if(($typeIndex == 'assign' || $typeIndex == 'assigned_to') 
                                && $requestReplacementStaff->technicalEvaluation)
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Asignado a: {{ $requestReplacementStaff->assignEvaluations->last()->userAssigned->fullName }}">
                                    <a href="{{ route('replacement_staff.request.technical_evaluation.edit', $requestReplacementStaff) }}"
                                    class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                </span>
                                
                            <!-- BOTÓN PARA SEGUIMIENTO DE EVALUACIÓN TÉCNICA -->
                            @else
                                <a href="{{ route('replacement_staff.request.technical_evaluation.show', $requestReplacementStaff) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Evaluación Técnica">
                                    <i class="fas fa-eye fa-fw"></i>
                                </a>
                            @endif
                            
                            <!-- BOTÓN PARA CAMBIAR GRADO (SDGP) -->
                            @if($typeIndex == 'sdgp' && $requestReplacementStaff->degree)
                                <a class="btn btn-outline-secondary btn-sm mt-2"
                                    data-toggle="modal"
                                    title="Cambio Grado"
                                    data-target="#changeDegreeModal-{{ $requestReplacementStaff->id }}">
                                    <i class="fas fa-sort-numeric-up-alt fa-fw"></i>
                                </a>

                                @include('replacement_staff.modals.modal_to_change_degree')
                            @endif

                        <!-- ACCIONES CON APROBACIONES DEL MODULO -->
                        @else
                            @if($requestReplacementStaff->fundament_detail_manage_id != 6 && $requestReplacementStaff->fundament_detail_manage_id != 7)
                                <!-- PERMITE EDITAR SOLICITUD ANTES DE LA PRIMERA APROBACIÓN -->
                                @if(($requestReplacementStaff->user->id == auth()->id() || $requestReplacementStaff->organizational_unit_id == auth()->user()->organizationalUnit->id ||
                                        ($requestReplacementStaff->requesterUser && $requestReplacementStaff->requesterUser->id == auth()->id())) &&
                                            $requestReplacementStaff->requestSign->first()->request_status == 'pending')
                                    @if($requestReplacementStaff->form_type != null)
                                        <a href="{{ route('replacement_staff.request.edit', $requestReplacementStaff) }}"
                                            class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
                                    @else
                                        <a href="{{ route('replacement_staff.request.technical_evaluation.show', $requestReplacementStaff) }}"
                                            class="btn btn-outline-secondary btn-sm" title="Resumen"><i class="fas fa-eye"></i></a>
                                    @endif
                                <!-- PERMITE MOSTRAR EL BOTÓN PARA ASIGNAR SOLICITUD -->
                                @elseif(($requestReplacementStaff->requestSign->last()->request_status == "accepted" ||
                                    $requestReplacementStaff->signaturesFile && $requestReplacementStaff->signaturesFile->signaturesFlows->first()->status == 1) &&
                                        !$requestReplacementStaff->technicalEvaluation &&
                                            auth()->user()->hasPermissionTo('Replacement Staff: assign request'))
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                            type="checkbox"
                                            wire:model="checkToAssign"
                                            value="{{ $requestReplacementStaff->id }}"
                                            id="for_sign_id">
                                    </div>

                                    <br />
                                    
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                                        data-target="#exampleModal-assign-{{ $requestReplacementStaff->id }}">
                                        <i class="fas fa-user-tag"></i>
                                    </button>
                                    @if($users_rys)
                                        @include('replacement_staff.modals.modal_to_assign')
                                    @endif

                                <!-- ACCESO A EVALUACIÓN TÉCNICA -->
                                @else
                                    <!-- BOTÓN PARA GESTIONAR EVALUACIÓN TÉCNICA -->
                                    @if(($typeIndex == 'assign' || $typeIndex == 'assigned_to') && $requestReplacementStaff->technicalEvaluation)
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Asignado a: {{ $requestReplacementStaff->assignEvaluations->last()->userAssigned->fullName }}">
                                            <a href="{{ route('replacement_staff.request.technical_evaluation.edit', $requestReplacementStaff) }}"
                                                class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                        </span>
                                    <!-- BOTÓN PARA SEGUIMIENTO DE EVALUACIÓN TÉCNICA -->
                                    @else
                                        <a href="{{ route('replacement_staff.request.technical_evaluation.show', $requestReplacementStaff) }}"
                                            class="btn btn-outline-secondary btn-sm" title="Evaluación Técnica"><i class="fas fa-eye"></i></a>
                                    @endif
                                @endif
                            
                            @else
                                Registro sin selección
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $requests->links() }}
    </div>

    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <p>Corrige los siguientes errores:</p>
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if($typeIndex == 'assign' && auth()->user()->hasPermissionTo('Replacement Staff: assign request'))
    <div class="card">
        <div class="card-body">
            <h6 class="mb-3"><i class="fas fa-user-tag"></i> Asignar solicitudes a funcionarios</h6>

            <fieldset class="form-group">
                <label for="for_to_user_id">Funcionario</label>
                <select wire:model.live="userToAssign" id="for_to_user_id" class="form-control">
                    <option value="">Seleccione...</option>
                    @foreach($users_rys as $user_rys)
                        <option value="{{ $user_rys->id }}">{{ $user_rys->fullName }}</option>
                    @endforeach
                </select>
            </fieldset>
            
            <button type="button" 
                class="btn btn-primary float-right" 
                {{-- data-toggle="modal"
                data-target="#exampleModal-assign-{{ $requestReplacementStaff->id }}" --}}
                wire:click="assign()">
                    Asignar <i class="fas fa-user-tag"></i>
            </button>

        </div>
    </div>
    @endif

    @else

    <div class="alert alert-info" role="alert">
        <b>Estimado usuario</b>: No se encuentran solicitudes bajo los parámetros consultados.
    </div>

    @endif
</div>
