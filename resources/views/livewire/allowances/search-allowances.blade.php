<div>
    <div class="card card-body small">
        <h5 class="mb-3"><i class="fas fa-search"></i> Buscar:</h5>
        
        <div class="form-row">
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_status_search">Estado Viático</label>
                <select name="status_search" class="form-control form-control-sm" wire:model.debounce.500ms="selectedStatus">
                    <option value="">Seleccione...</option>
                    <option value="pending">Pendiente</option>
                    <option value="completed">Finalizado</option>
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
                        <th rowspan="2" style="width: 3%">ID <br> <span class="badge badge-secondary">Folio sirh</span></th>
                        <th rowspan="2" style="width: 7%">Fecha Creación</th>
                        <th rowspan="2">Funcionario</th>
                        <th rowspan="2">Calidad</th>
                        <th colspan="2" style="width: 27%">Lugar</th>
                        <th rowspan="2" style="width: 15%">Motivo</th>
                        <th rowspan="2" style="width: 9%">Periodo</th>
                        <th rowspan="2" colspan="2"></th>
                    </tr>
                    <tr class="text-center">
                        <th>Origen</th>
                        <th>Destino</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allowances as $allowance)
                    <tr>
                        <th>
                            {{ $allowance->id }} <br>

                            @if($allowance->folio_sirh)
                                <span class="badge badge-secondary">{{ $allowance->folio_sirh }}</span> <br>
                            @endif

                            @if($allowance->status == 'pending')
                                <span class="badge badge-warning">Pendiente</span>
                            @endif

                            @if($allowance->status == 'rejected')
                                <span class="badge badge-danger">Rechazado</span>
                            @endif

                            @if($allowance->status == 'manual')
                                <span class="badge badge-info">Carga Manual</span>
                            @endif
                        </th>
                        <td>{{ $allowance->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>
                            <b>{{ $allowance->userAllowance->FullName }}</b> <br>
                            {{ ($allowance->organizationalUnitAllowance) ? $allowance->organizationalUnitAllowance->name : '' }} <br><br>
                            <b>Creado por</b>: {{ $allowance->userCreator->TinnyName }}
                        </td>
                        <td class="text-center">{{ ($allowance->ContractualCondition) ? $allowance->ContractualCondition->name : '' }}</td>
                        <td class="text-center">{{ $allowance->originCommune->name }}</td>
                        <td class="text-center">
                            @foreach($allowance->destinations as $destination)
                                <b>Comuna</b>: {{ $destination->commune->name }} - <b>Localidad</b>:  {{ ($destination->locality) ? $destination->locality->name : '' }} <br>
                            @endforeach
                        </td>
                        <td>{{ $allowance->reason }}</td>
                        <td class="text-left">
                            {{ $allowance->FromFormat }}<br>
                            {{ $allowance->ToFormat }}
                            
                            {{--
                            <br>
                            @if($allowance->total_days)
                                <br>
                                <b>Diario</b>: {{ intval($allowance->total_days) }} @if($allowance->total_days > 1) días @else día @endif
                            @endif
                            @if($allowance->total_half_days)
                                <br>
                                <b>Parcial</b>: @if($allowance->total_half_days == 1) Medio día @else {{ intval($allowance->total_half_days) }} medios días @endif 
                            @endif
                            --}}
                        </td>
                        {{--
                        <td class="text-center">
                            {{ number_format($allowance->total_days, 1, ",", ".") }} <br>
                            @if($allowance->total_days > 1 && $allowance->half_days_only == 0)
                                días
                            @elseif($allowance->total_days > 1 && $allowance->half_days_only == 1)
                                medios días
                            @else
                                día
                            @endif
                        </td>
                        --}}
                        <td class="text-center">
                            @if($index == 'sign')
                                <a href="{{ route('allowances.show', $allowance) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Ingresar folio SIRH">
                                    <i class="fas fa-keyboard"></i>
                                </a>
                            @endif
                
                            @if($index == 'own' && $allowance->status != 'manual')
                                {{-- @if($allowance->allowanceSigns->first()->status == 'pending' && Auth::user()->hasPermissionTo('Allowances: create')) --}}
                                    <a href="{{ route('allowances.edit', $allowance) }}"
                                        class="btn btn-outline-secondary btn-sm" title="Editar"><i class="fas fa-edit"></i>
                                    </a>
                                {{-- @else --}}
                                    <a href="{{ route('allowances.show', $allowance) }}"
                                        class="btn btn-outline-secondary btn-sm" title="Ver Viático">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                {{-- @endif --}}
                            @else
                                Aprobaciones No Disponibles
                            @endif

                            @if($index == 'all' && $allowance->status != 'manual')
                                <a href="{{ route('allowances.show', $allowance) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Ver Viático">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($allowance->allowanceSignature && $allowance->allowanceSignature->status == "completed")
                                <a href="{{ route('documents.signatures.showPdf',[$allowance->allowanceSignature->signaturesFileDocument->id, time()])}}"
                                    class="btn btn-sm btn-outline-primary " target="_blank"
                                    title="Ver documento">
                                    <span class="fas fa-file-pdf" aria-hidden="true"></span>
                                </a>
                            @else
                                <a href=""
                                    class="btn btn-sm btn-outline-secondary disabled" target="_blank"
                                    title="Ver documento">
                                    <span class="fas fa-file-pdf" aria-hidden="true"></span>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $allowances->links() }}
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
