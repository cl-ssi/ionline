<div>
    <div class="card card-body small">
        <h5 class="mb-3"><i class="fas fa-search"></i> Buscar:</h5>
        
        <div class="form-row">
            {{--
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
            --}}
        </div>

    </div>

    {{-- dd($jobPositionProfiles->first()) --}}

    @if($jobPositionProfiles->count() > 0)
        <div class="row">
            <div class="col">
                <p class="font-weight-lighter">Total de Registros: <b>{{ $jobPositionProfiles->total() }}</b></p>
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
                        <th>Usuario Creador / Unidad Organizacional</th>
                        <th>Nombre de Perfil de Cargo</th>
                        <th>Detalle / Calidad Jurídica</th>
                        <th>Marco Legal</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobPositionProfiles as $jobPositionProfile)
                    <tr>
                        <th>
                            {{ $jobPositionProfile->id }} <br>
                            @switch($jobPositionProfile->status)
                            @case('pending')
                                <span class="badge badge-warning">Pendiente</span>
                                @break

                            @case('complete')
                                <span class="badge badge-success">Finalizado</span>
                                @break

                            @case('rejected')
                                <span class="badge badge-danger">Rechazado</span>
                                @break
                            @case('review')
                                <span class="badge badge-info">En revisión</span>
                                @break
                        @endswitch    
                        </th>
                        <td>{{ $jobPositionProfile->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>
                            <b>{{ $jobPositionProfile->user->FullName }}</b> <br>
                            {{ $jobPositionProfile->organizationalUnit->name }} <br><br>
                        </td>
                        <td>{{ $jobPositionProfile->name }}</td>
                        <td>
                            <b>Estamento</b>:   {{ $jobPositionProfile->estament->name }} <br>
                            <b>Área</b>:        {{ $jobPositionProfile->area->name }} <br>
                            <b>Condición</b>:   {{ $jobPositionProfile->contractualCondition->name }} - {{ ($jobPositionProfile->degree) ? 'Grado '.$jobPositionProfile->degree : $jobPositionProfile->salary }}
                        </td>
                        <td>
                            <b>Ley</b>:   N°{{ number_format($jobPositionProfile->law, 0, ",", ".") }} <br>
                            @if($jobPositionProfile->dfl3) DFL N°3/17 <br> @endif
                            @if($jobPositionProfile->dfl29) DFL N°29 <br> @endif
                            {{ $jobPositionProfile->working_day }} Horas
                        </td>
                        <td class="text-center">    
                            @if($index == 'own')
                                @if($jobPositionProfile->status == 'pending')
                                    <a href="{{ route('job_position_profile.edit', $jobPositionProfile) }}"
                                        class="btn btn-outline-secondary btn-sm" title="Editar"><i class="fas fa-edit"></i>
                                    </a>
                                @else
                                    <a href="{{-- route('allowances.show', $allowance) --}}"
                                        class="btn btn-outline-secondary btn-sm" title="Ver Viático">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            @endif
                        </td>
                    <tr>
                    @endforeach
                </tbody>
            </table>    
        </div>
    @else
        <div class="row">
            <div class="col">
                <p class="font-weight-lighter">Total de Registros: <b>{{ $jobPositionProfiles->total() }}</b></p>
            </div>
        </div>

        <div class="alert alert-info" role="alert">
            <b>Estimado usuario</b>: No se encuentran <b>Perfiles de Cargos</b> según los parámetros consultados.
        </div>
    @endif
</div>
