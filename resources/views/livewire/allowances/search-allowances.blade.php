<div>
    <div class="card card-body small">
        <h5 class="mb-3"><i class="fas fa-search"></i> Buscar:</h5>
        
        <div class="form-row">
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_status_search">Estado Viático</label>
                <select name="status_search" class="form-control form-control-sm" wire:model.live.debounce.500ms="selectedStatus">
                    <option value="">Seleccione...</option>
                    <option value="pending">Pendiente</option>
                    <option value="completed">Finalizado</option>
                    <option value="rejected">Rechazado</option>
                </select>
            </fieldset>  

            <fieldset class="form-group col-12 col-md-1">
                <label for="for_id">ID</label>
                <input class="form-control form-control-sm" type="number" name="id_search" autocomplete="off" 
                    placeholder="001" wire:model.live.debounce.500ms="selectedId">
            </fieldset>

            <fieldset class="form-group col-12 col-md-3">
                <label for="for_requester">Funcionario</label>
                <input class="form-control form-control-sm" type="text" autocomplete="off" placeholder="NOMBRE / APELLIDOS"
                    name="user_allowance_search" wire:model.live.debounce.500ms="selectedUserAllowance">
            </fieldset>

            @if($index == 'sign' && auth()->user()->hasPermissionTo('Allowances: sirh'))
                <fieldset class="form-group col-12 col-md-2">
                    <label for="for_status_search">Estado Revisión SIRH</label>
                    <select name="status_sirh_search" class="form-control form-control-sm" wire:model.live.debounce.500ms="selectedStatusSirh">
                        <option value="">Seleccione...</option>
                        <option value="pending">Pendiente</option>
                        <option value="accepted">Aprobado</option>
                        <option value="rejected">Rechazado</option>
                    </select>
                </fieldset>
            @endif

            @if(auth()->user()->hasPermissionTo('Allowances: all establishment') && $index == 'all')
                <fieldset class="form-group col-12 col-md-2">
                    <label for="for_status_search">Establecimiento</label>
                    <select name="establishment_search" class="form-control form-control-sm" wire:model.live.debounce.500ms="selectedEstablishment">
                        <option value="">Seleccione...</option>
                        <option value="{{ App\Models\Parameters\Parameter::get('establishment', 'SSTarapaca') }}">Servicio de Salud Tarápaca</option>
                        <option value="{{ App\Models\Parameters\Parameter::get('establishment', 'HospitalAltoHospicio') }}">Hospital Alto Hospicio</option>
                    </select>
                </fieldset>
            @endif
        </div>

    </div>

    <br>

    @if($allowances->count() > 0)
        <div class="row">
            <div class="col">
                <p class="font-weight-lighter">Total de Registros: <b>{{ $allowances->total() }}</b></p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover small">
                <thead>
                    <tr class="text-center">
                        <th rowspan="2" style="width: 3%">ID</th>
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
                            {{ ($allowance->correlative) ? $allowance->correlative : $allowance->id }} <br>

                            @if($allowance->status != 'manual')
                                @foreach($allowance->allowanceSigns as $sign)

                                    @if($sign->event_type == 'contabilidad' && $sign->status == 'accepted' && $allowance->establishment_id == App\Models\Parameters\Parameter::get('establishment', 'HospitalAltoHospicio'))
                                        <span class="badge badge-info">Contabilidad <i class="fas fa-check-circle"></i></span> <br>
                                    @endif
                                    @if($sign->event_type == 'sirh' && $sign->status == 'accepted')
                                        <span class="badge badge-success">SIRH <i class="fas fa-check-circle"></i></span> <br>
                                    @endif
                                @endforeach
                            @endif

                            @if($allowance->status == 'pending')
                                <span class="badge badge-warning">Pendiente</span>
                            @endif

                            @if($allowance->status == 'rejected')
                                <span class="badge badge-danger">Rechazado</span>
                            @endif

                            @if($allowance->status == 'complete')
                                <span class="badge badge-success">Finalizado</span>
                            @endif

                            @if($allowance->status == 'manual')
                                <span class="badge badge-info">Manual</span>
                            @endif
                        </th>
                        <td>{{ $allowance->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>
                            <b>{{ $allowance->userAllowance->fullName }}</b> <br>
                            <small>{{ ($allowance->organizationalUnitAllowance) ? $allowance->organizationalUnitAllowance->name : '' }}</small> <br>
                            <small><b>{{ $allowance->allowanceEstablishment->name }}</b></small> <br><br>
                            <b>Creado por</b>: {{ $allowance->userCreator->tinyName }}
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
                        </td>
                        <td class="text-center">
                            @if($index == 'sign' || $index == 'contabilidad')
                                <a href="{{ route('allowances.show', $allowance) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Ingresar folio SIRH">
                                    <i class="fas fa-keyboard"></i>
                                </a>

                                @if($allowance->status == 'complete' || $allowance->status == 'rejected' || $allowance->status == 'manual')
                                    <button class="btn btn-outline-success btn-sm mt-2" 
                                        wire:click="archive( '{{ addslashes(get_class($allowance)) }}', {{ $allowance->id }})">
                                        <i class="fas fa-archive"></i>
                                    </button>
                                @endif
                            @endif

                            @if($index == 'archived')
                                <a href="{{ route('allowances.show', $allowance) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Ingresar folio SIRH">
                                    <i class="fas fa-keyboard"></i>
                                </a>

                                <button class="btn btn-outline-danger btn-sm mt-2" 
                                    wire:click="unarchive( '{{ addslashes(get_class($allowance)) }}', {{ $allowance->id }})">
                                    <i class="fas fa-archive"></i>
                                </button>
                            @endif
                
                            @if($index == 'own' || $index == 'director')
                                @if($allowance->allowanceSigns && $allowance->status != 'manual')
                                    @if($allowance->allowanceSigns->first()->status == 'pending')
                                        <a href="{{ route('allowances.edit', $allowance) }}"
                                            class="btn btn-outline-secondary btn-sm" title="Editar"><i class="fas fa-edit fa-fw"></i>
                                        </a>
                                        <br>
                                    @endif

                                    {{--
                                    @if($allowance->status == 'rejected')
                                        <a href="{{ route('allowances.create_to_replicate', $allowance) }}"
                                            class="btn btn-outline-success btn-sm" title="Crear Viático"><i class="fas fa-plus fa-fw"></i>
                                        </a>
                                        <br>
                                    @endif
                                    --}}
                                @endif
                                
                                <a href="{{ route('allowances.show', $allowance) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Ver Viático">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endif

                            @if($index == 'all')
                                <a href="{{ route('allowances.show', $allowance) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Ver Viático">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(count($allowance->approvals) > 0 && $allowance->approvals->last()->status == 1)
                                <a href="{{ route('allowances.download_resol_pdf', $allowance) }}"
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
