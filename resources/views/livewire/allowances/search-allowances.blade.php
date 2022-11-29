<div>
    <div class="card card-body small">
        <h5 class="mb-3"><i class="fas fa-search"></i> Buscar:</h5>
        
        <div class="form-row">
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_status_search">Estado Viático</label>
                <select name="status_search" class="form-control form-control-sm" wire:model.debounce.500ms="selectedStatus">
                    <option value="">Seleccione...</option>
                    <option value="pending">Pendiente</option>
                    <option value="complete">Finalizado</option>
                    <option value="rejected">Rechazado</option>
                </select>
            </fieldset>  

            <fieldset class="form-group col-12 col-md-1">
                <label for="for_id">ID</label>
                <input class="form-control form-control-sm" type="number" name="id_search" autocomplete="off" 
                    placeholder="001" wire:model.debounce.500ms="selectedId">
            </fieldset>

            <fieldset class="form-group col-12 col-md-3">
                <label for="for_requester">Funcionario</label>
                <input class="form-control form-control-sm" type="text" autocomplete="off" placeholder="NOMBRE / APELLIDOS"
                    name="user_allowance_search" wire:model.debounce.500ms="selectedUserAllowance">
            </fieldset>
        </div>

    </div>

    <br>
    <!-- TODOS LOS FORMULARIOS -->
    @if($allowances->count() > 0)
        <div class="row">
            <div class="col">
                <p class="font-weight-lighter">Total de Registros: <b>{{ $allowances->total() }}</b></p>
            </div>
            {{-- 
            <div class="col">
                <a class="btn btn-success btn-sm mb-1 float-right disabled" wire:click="export"><i class="fas fa-file-excel"></i> Exportar formularios</a></h6>
            </div>
            --}}
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover small">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th style="width: 8%">Fecha Creación</th>
                        <th>Funcionario</th>
                        <th>Calidad</th>
                        <th>Lugar</th>
                        <th>Motivo</th>
                        <th>Detalle</th>
                        <th colspan="2">Periodo</th>
                        <th>Gestión</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allowances as $allowance)
                    <tr>
                        <th>
                            {{ $allowance->id }} <br>
                            @switch($allowance->status)
                            @case('pending')
                                <span class="badge badge-warning">Pendiente</span>
                                @break

                            @case('complete')
                                <span class="badge badge-success">Finalizado</span>
                                @break

                            @case('rejected')
                                <span class="badge badge-danger">Rechazado</span>
                                @break

                            @default
                                Default case...
                        @endswitch    
                        </th>
                        <td>{{ $allowance->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>
                            <b>{{ $allowance->userAllowance->FullName }}</b> <br>
                            {{ $allowance->organizationalUnitAllowance->name }} <br><br>
                            <b>Creado por</b>: {{ $allowance->userCreator->TinnyName }}
                        </td>
                        <td>{{ $allowance->ContractualConditionValue }}</td>
                        <td>{{ $allowance->place }}</td>
                        <td>{{ $allowance->reason }}</td>
                        <td>
                            @if($allowance->round_trip == 'round trip')
                                {{ $allowance->originCommune->name }} - {{ $allowance->destinationCommune->name }} - {{ $allowance->originCommune->name }} <br>
                            @endif
                            {{ $allowance->RoundTripValue }}
                        </td>
                        <td>
                            {{ $allowance->from->format('d-m-Y') }} {{ ($allowance->from_half_day) ?  'medio día' : '' }}<br>
                            {{ $allowance->to->format('d-m-Y') }} {{ ($allowance->to_half_day) ?  'medio día' : '' }}
                            {{-- <span class="badge badge-warning">Medio día</span> --}}
                        </td>
                        <td class="text-center">
                            {{ $allowance->TotalDays }}
                            @if($allowance->TotalDays > 1)
                                días
                            @else
                                día
                            @endif
                        </td>
                        <td class="text-center">
                            @foreach($allowance->allowanceSigns as $allowanceSign)
                                @if($allowanceSign->status == 'pending' || $allowanceSign->status == NULL)
                                    <i class="fas fa-clock fa-2x" title="{{ $allowanceSign->organizationalUnit->name }}"></i>
                                @endif
                                @if($allowanceSign->status == 'accepted')
                                    <span style="color: green;">
                                        <i class="fas fa-check-circle fa-2x" title="{{ $allowanceSign->organizationalUnit->name }}"></i>
                                    </span>
                                @endif
                                @if($allowanceSign->status == 'rejected')
                                    <span style="color: Tomato;">
                                        <i class="fas fa-times-circle fa-2x" title="{{ $allowanceSign->organizationalUnit->name }}"></i>
                                    </span>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @if($index == 'sign')
                                <a href="{{ route('allowances.show', $allowance) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Aceptar o Declinar">
                                    <i class="fas fa-signature"></i>
                                </a>
                            @endif
                            @if($index == 'own')
                                @if($allowance->allowanceSigns->first()->status == 'pending')
                                    <a href="{{ route('allowances.edit', $allowance) }}"
                                        class="btn btn-outline-secondary btn-sm" title="Editar"><i class="fas fa-edit"></i>
                                    </a>
                                @else
                                    <a href="{{ route('allowances.show', $allowance) }}"
                                        class="btn btn-outline-secondary btn-sm" title="Ver Viático">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            @endif
                            @if($index == 'all')
                                <a href="{{ route('allowances.show', $allowance) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Ver Viático">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endif
                        </td>
                        <td>
                            @if($allowance->signatures_file_id)
                                <a class="btn btn-outline-primary btn-sm" title="Ver viático firmado" 
                                    href="{{ route('allowances.file.show_file', $allowance) }}" target="_blank">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            @else
                                <a class="btn btn-outline-primary btn-sm disabled" title="Ver viático firmado">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="row">
            <div class="col">
                <p class="font-weight-lighter">Total de Registros: <b>{{ $allowances->total() }}</b></p>
            </div>
        </div>

        <div class="alert alert-info" role="alert">
            <b>Estimado usuario</b>: No se encuentran solicitudes de viaticos según los parámetros consultados.
        </div>
    @endif
</div>
