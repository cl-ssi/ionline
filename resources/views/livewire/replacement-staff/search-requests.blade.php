<div>
    <div class="card card-body small">
        <h5 class="mb-3"><i class="fas fa-search"></i> Buscar:</h5>

        <div class="form-row">
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_profile_search">Estado</label>
                <select name="status_search" class="form-control" wire:model.debounce.500ms="selectedStatus">
                    <option value="">Seleccione...</option>
                    <option value="pending">Pendiente</option>
                    <option value="complete">Finalizada</option>
                    <option value="rejected">Rechazada</option>
                </select>
            </fieldset>

            <fieldset class="form-group col-12 col-md-1">
                <label for="for_name">ID</label>
                <input class="form-control" type="number" name="id_search" autocomplete="off" 
                    placeholder="001" wire:model.debounce.500ms="selectedId">
            </fieldset>

            <fieldset class="form-group col-sm">
                <label for="regiones">Periodo de Creación</label>
                <div class="input-group">
                    <input type="date" class="form-control" name="start_date_search" wire:model.debounce.500ms="selectedStartDate" required>
                    <input type="date" class="form-control" name="end_date_search" wire:model.debounce.500ms="selectedEndDate" required>
                </div>
            </fieldset>

            <fieldset class="form-group col-sm">
                <label for="for_name">Nombre de Solicitud</label>
                <input class="form-control" type="text" autocomplete="off"
                    name="name_search" wire:model.debounce.500ms="selectedName">
            </fieldset>

            <fieldset class="form-group col-sm">
                <label for="for_legal_quality_manage_id" >Fundamento / Detalle Fundamento</label>
                <div class="input-group">
                    <select name="fundament_search" id="for_fundament_manage_id" class="form-control" wire:model.debounce.500ms="selectedFundament" required>
                        <option value="">Seleccione...</option>
                        @foreach($fundaments as $fundament)
                            <option value="{{ $fundament->id }}"
                                {{-- @if($requestReplacementStaff) {{ ($requestReplacementStaff->fundament_manage_id == $fundamentSelected) ? 'selected' : '' }} @endif --}}>
                                {{ $fundament->NameValue }}
                            </option>
                        @endforeach
                    </select>

                    <select name="fundament_detail_search" id="for_fundament_detail_manage_id" class="form-control" wire:model.debounce.500ms="selectedFundamentDetail" onchange="remoteWorking()">
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
        </div>
        
        <div class="form-row">
            <fieldset class="form-group col-12 col-md-3">
                <label for="for_name">Funcionario a Reemplazar</label>
                <input class="form-control" type="text" autocomplete="off" placeholder="RUN o NOMBRE"
                    name="name_to_replace_search" wire:model="selectedNameToReplace">
            </fieldset>

            @if($typeIndex == 'assign' || $typeIndex == 'personal' || $typeIndex == 'assigned_to')
            <fieldset class="form-group col-12 col-md-3">
                <label for="for_sub_search">Subdirección</label>
                <select name="sub_search" class="form-control" wire:model.debounce.500ms="selectedSub">
                    <option value="">Seleccione...</option>
                    @foreach($subs as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </select>
            </fieldset>
            @endif
        </div>
    </div>
    <p class="font-weight-lighter">Total de Registros: <b>{{ $requests->total() }}</b></p>

    @if($requests->count() > 0)
    <div class="table-responsive">
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
                    <td>
                        {{ $requestReplacementStaff->name }}
                    </td>
                    <td class="text-center">
                        @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
                            {{ $requestReplacementStaff->degree }}
                        @else
                            @foreach($requestReplacementStaff->positions as $position)
                                ${{ number_format($position->salary, 0, ",", ".") ?? '' }}
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
                            {{ $requestReplacementStaff->legalQualityManage->NameValue ?? '' }} ({{ $requestReplacementStaff->profile_manage->name ?? '' }})
                        @else
                            @foreach($requestReplacementStaff->positions as $position)
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
                        @if($requestReplacementStaff->fundament_detail_manage_id != 6 && $requestReplacementStaff->fundament_detail_manage_id != 7)
                            <!-- PERMITE EDITAR SOLICITUD ANTES DE LA PRIMERA APROBACIÓN -->
                            @if(($requestReplacementStaff->user->id == Auth::user()->id || $requestReplacementStaff->organizational_unit_id == Auth::user()->organizationalUnit->id ||
                                    ($requestReplacementStaff->requesterUser && $requestReplacementStaff->requesterUser->id == Auth::user()->id)) &&
                                        $requestReplacementStaff->requestSign->first()->request_status == 'pending')
                                @if($requestReplacementStaff->form_type != null)
                                    <a href="{{ route('replacement_staff.request.edit', $requestReplacementStaff) }}"
                                        class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
                                @else
                                    <a href="{{ route('replacement_staff.request.technical_evaluation.show', $requestReplacementStaff) }}"
                                        class="btn btn-outline-secondary btn-sm" title="Resumen"><i class="fas fa-eye"></i></a>
                                @endif
                            <!-- PERMITE MOSTRAR EL BOTÓN PARA ASIGNAR SOLICITUD -->
                            @elseif($requestReplacementStaff->RequestSign->last()->request_status == "accepted" &&
                                    !$requestReplacementStaff->technicalEvaluation &&
                                        Auth::user()->hasPermissionTo('Replacement Staff: assign request'))
                                
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
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Asignado a: {{ $requestReplacementStaff->assignEvaluations->last()->userAssigned->FullName }}">
                                        <a href="{{ route('replacement_staff.request.technical_evaluation.edit', $requestReplacementStaff) }}"
                                            class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                    </span>
                                <!-- BOTÓN PARA SEGUIMIENTO DE EVALUACIÓN TÉCNICA -->
                                @else
                                    <a href="{{ route('replacement_staff.request.technical_evaluation.show', $requestReplacementStaff) }}"
                                        class="btn btn-outline-secondary btn-sm" title="Evaluación Técnica"><i class="fas fa-eye"></i></a>
                                @endif
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $requests->links() }}
    </div>

    @else

    <div class="alert alert-info" role="alert">
        <b>Estimado usuario</b>: No se encuentran solicitudes bajo los parámetros consultados.
    </div>

    @endif
</div>
