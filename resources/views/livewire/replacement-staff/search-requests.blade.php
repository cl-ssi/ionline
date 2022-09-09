<div>
    <div class="card card-body small">
        <h5 class="mb-3"><i class="fas fa-search"></i> Buscar:</h5>

        <div class="form-row">
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_profile_search">Estado</label>
                <select name="status_search" class="form-control" wire:model="selectedStatus">
                    <option value="">Seleccione...</option>
                    <option value="pending">Pendiente</option>
                    <option value="complete">Finalizada</option>
                    <option value="rejected">Rechazada</option>
                </select>
            </fieldset>

            <fieldset class="form-group col-12 col-md-1">
                <label for="for_name">ID</label>
                <input class="form-control" type="number" name="id_search" autocomplete="off" 
                    placeholder="001" wire:model="selectedId">
            </fieldset>

            <fieldset class="form-group col-sm">
                <label for="regiones">Periodo de Creación</label>
                <div class="input-group">
                    <input type="date" class="form-control" name="start_date_search" wire:model="selectedStartDate" required>
                    <input type="date" class="form-control" name="end_date_search" wire:model="selectedEndDate" required>
                </div>
            </fieldset>

            <fieldset class="form-group col-sm">
                <label for="for_name">Nombre de Solicitud</label>
                <input class="form-control" type="text" autocomplete="off"
                    name="name_search" wire:model="selectedName">
            </fieldset>

            <fieldset class="form-group col-sm">
                <label for="for_legal_quality_manage_id" >Fundamento / Detalle Fundamento</label>
                <div class="input-group">
                    <select name="fundament_search" id="for_fundament_manage_id" class="form-control" wire:model="selectedFundament" required>
                        <option value="">Seleccione...</option>
                        @foreach($fundaments as $fundament)
                            <option value="{{ $fundament->id }}"
                                {{-- @if($requestReplacementStaff) {{ ($requestReplacementStaff->fundament_manage_id == $fundamentSelected) ? 'selected' : '' }} @endif --}}>
                                {{ $fundament->NameValue }}
                            </option>
                        @endforeach
                    </select>

                    <select name="fundament_detail_search" id="for_fundament_detail_manage_id" class="form-control" wire:model="selectedFundamentDetail" onchange="remoteWorking()">
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
        </div>
    </div>

    <br>

    @if($requests->count() > 0)
    <div class="table-responsive">
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
                @foreach($requests as $requestReplacementStaff)
                <tr class="{{ ($requestReplacementStaff->sirh_contract == 1) ? 'table-success':'' }}" >
                    <td>{{ $requestReplacementStaff->id }} <br>
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
                        <!-- <a href="{{ route('replacement_staff.request.technical_evaluation.show', $requestReplacementStaff) }}"
                            class="btn btn-outline-secondary btn-sm" title="Evaluación Técnica"><i class="fas fa-eye"></i></a> -->
                        @if($requestReplacementStaff->fundament_detail_manage_id != 6 && $requestReplacementStaff->fundament_detail_manage_id != 7)
                        @if($requestReplacementStaff->requestSign->first()->request_status == 'pending')
                            <a href="{{ route('replacement_staff.request.edit', $requestReplacementStaff) }}"
                                class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
                        @else
                            <a href="{{ route('replacement_staff.request.technical_evaluation.show', $requestReplacementStaff) }}"
                                class="btn btn-outline-secondary btn-sm" title="Evaluación Técnica"><i class="fas fa-eye"></i></a>
                        @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info" role="alert">
        <b>Estimado usuario</b>: No se encuentran solicitudes bajo los parámetros consultados.
    </div>
    @endif
</div>
