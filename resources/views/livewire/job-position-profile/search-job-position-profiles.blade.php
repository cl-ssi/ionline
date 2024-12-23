<div>
    @if($index != 'to_sign')
    <div class="card card-body small">
        <h5 class="mb-3"><i class="fas fa-search"></i> Buscar:</h5>
        
        <div class="form-row">
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_profile_search">Estado</label>
                <select name="status_search" class="form-control" wire:model.live.debounce.500ms="selectedStatus">
                    <option value="">Seleccione...</option>
                    <option value="saved">Guardado</option>
                    <option value="sent">Enviado</option>
                    <option value="review">En revisión</option>
                    <option value="pending">Pendiente</option>
                    <option value="complete">Finalizado</option>
                    <option value="rejected">Rechazado</option>
                </select>
            </fieldset>

            <fieldset class="form-group col-12 col-md-2">
                <label for="for_profile_search">Estamento</label>
                <select name="estament_search" id="for_estament_id" class="form-control" wire:model.live.debounce.500ms="selectedEstament" required>
                    <option value="">Seleccione...</option>
                        @foreach($estaments as $estament) 
                            <option value="{{ $estament->id }}">
                                {{ $estament->name }}
                            </option>
                        @endforeach
                </select>
            </fieldset>

            <fieldset class="form-group col-12 col-md-1">
                <label for="for_name">ID</label>
                <input class="form-control" type="number" name="id_search" autocomplete="off" 
                    placeholder="001" wire:model.live.debounce.500ms="selectedId">
            </fieldset>

            <fieldset class="form-group col-12 col-md-2">
                <label for="for_requester">Nombre Perfil de Cargo</label>
                <input class="form-control" type="text" autocomplete="off"
                    name="name_search" wire:model.live.debounce.500ms="selectedName">
            </fieldset>

            <fieldset class="form-group col-12 col-md-2">
                <label for="for_requester">Usuario Creador</label>
                <input class="form-control" type="text" autocomplete="off" placeholder="NOMBRE / APELLIDOS"
                    name="user_creator_search" wire:model.live.debounce.500ms="selectedUserCreator">
            </fieldset>

            @if($index == 'all')
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
        </div>

    </div>
    <br>
    @endif

    @if($jobPositionProfiles->count() > 0)
        @if($index != 'to_sign')
        <div class="row">
            <div class="col">
                <p class="font-weight-lighter">Total de Registros: <b>{{ $jobPositionProfiles->total() }}</b></p>
            </div>
        </div>
        @endif

        @if($index == 'to_sign')
        <h5 class="mb-3"><i class="fas fa-inbox"></i> Pendientes: </h5>
        @endif
        <div class="table-responsive">
            {{ $jobPositionProfiles->links() }}    
            <table class="table table-sm table-bordered table-striped table-hover small">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th style="width: 8%">Fecha Creación</th>
                        <th>Usuario Creador / Unidad Organizacional</th>
                        <th>Nombre de Perfil de Cargo</th>
                        <th>Detalle / Calidad Jurídica</th>
                        <th>Marco Legal</th>
                        <th>Aprobaciones</th>
                        <th colspan="3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobPositionProfiles as $jobPositionProfile)
                    <tr>
                        <th>
                            {{ $jobPositionProfile->id }} <br>
                            @switch($jobPositionProfile->status)
                                @case('saved')
                                    <span class="badge badge-primary">{{ $jobPositionProfile->StatusValue }}</span>
                                    @break

                                @case('sent')
                                    <span class="badge badge-secondary">{{ $jobPositionProfile->StatusValue }}</span>
                                    @break

                                @case('review')
                                    <span class="badge badge-info">{{ $jobPositionProfile->StatusValue }}</span>
                                    @break
                                
                                @case('pending')
                                    <span class="badge badge-warning">{{ $jobPositionProfile->StatusValue }}</span>
                                    @break
                                
                                @case('rejected')
                                    <span class="badge badge-danger">{{ $jobPositionProfile->StatusValue }}</span>
                                    @break

                                @case('complete')
                                    <span class="badge badge-success">{{ $jobPositionProfile->StatusValue }}</span>
                                    @break
                            @endswitch
                        </th>
                        <td>{{ $jobPositionProfile->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>
                            <b>{{ $jobPositionProfile->user->fullName }}</b> <br>
                            {{ ($jobPositionProfile->organizationalUnit) ? $jobPositionProfile->organizationalUnit->name : '' }} <br><br>
                        </td>
                        <td>{{ $jobPositionProfile->name }}</td>
                        <td>
                            <b>Estamento</b>:   {{ $jobPositionProfile->estament->name }} <br>
                            <b>Familia del Cargo</b>:        {{ $jobPositionProfile->area->name }} <br>
                            <b>Condición</b>:   {{ $jobPositionProfile->contractualCondition->name }} - {{ ($jobPositionProfile->degree) ? 'Grado '.$jobPositionProfile->degree : $jobPositionProfile->salary }}
                        </td>
                        <td>
                            <b>Ley</b>:   N°{{ number_format($jobPositionProfile->law, 0, ",", ".") }} <br>
                            @if($jobPositionProfile->dfl3) DFL N°3/17 <br> @endif
                            @if($jobPositionProfile->dfl29) DFL N°29 <br> @endif
                            {{ $jobPositionProfile->working_day == 'shift' ? 'Turno' : $jobPositionProfile->working_day.' Horas' }}
                        </td>
                        <td class="text-center">
                            @if($jobPositionProfile->status == 'saved')
                                <i class="fas fa-save fa-2x"></i>
                            @else
                                @if(!$jobPositionProfile->approvals->isEmpty())
                                    @foreach($jobPositionProfile->approvals as $approval)
                                        @switch($approval->StatusInWords)
                                            @case('Pendiente')
                                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                    <i class="fas fa-clock fa-2x"></i>
                                                </span>
                                                @break
                                            @case('Aprobado')
                                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" style="color: green;" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                    <i class="fas fa-check-circle fa-2x"></i>
                                                </span>
                                                @break
                                            @case('Rechazado')
                                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" style="color: tomato;" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                    <i class="fas fa-times-circle fa-2x"></i>
                                                </span>
                                                @break
                                        @endswitch
                                    @endforeach
                                @else
                                    @foreach($jobPositionProfile->jobPositionProfileSigns as $sign)
                                        @if($sign->status == 'pending' || $sign->status == NULL)
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" 
                                                title="{{ $sign->organizationalUnit->name }}">
                                                <i class="fas fa-clock fa-2x"></i>
                                            </span>
                                        @endif
                                        @if($sign->status == 'accepted')
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" 
                                                style="color: green;"
                                                title="{{ $sign->organizationalUnit->name }}">
                                                <i class="fas fa-check-circle fa-2x"></i>
                                            </span>
                                        @endif
                                        @if($sign->status == 'rejected')
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                style="color: Tomato;"
                                                title="{{ $sign->organizationalUnit->name }}">
                                                <i class="fas fa-times-circle fa-2x"></i>
                                            </span>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            <!-- MIS PERFILES DE CARGO -->
                            @if($index == 'own')
                                @if($jobPositionProfile->status == 'saved' || $jobPositionProfile->status == "review" ||
                                    $jobPositionProfile->status == 'sent')
                                    <a href="{{ route('job_position_profile.edit', $jobPositionProfile) }}"
                                        class="btn btn-outline-secondary btn-sm" title="Editar">
                                        <i class="fas fa-edit fa-fw"></i>
                                    </a>
                                @else
                                    <a href="{{ route('job_position_profile.show', $jobPositionProfile) }}"
                                        class="btn btn-outline-secondary btn-sm" title="">
                                        <i class="fas fa-eye fa-fw"></i>
                                    </a>
                                @endif
                            @endif
                            <!-- PARA ALL -->
                            @if($index == 'all')
                                <a href="{{ route('job_position_profile.show', $jobPositionProfile) }}"
                                    class="btn btn-outline-secondary btn-sm" title="">
                                    <i class="fas fa-eye fa-fw"></i>
                                </a>
                                
                                @if(($jobPositionProfile->status == 'saved' || $jobPositionProfile->status == "review") 
                                    && 	auth()->user()->hasPermissionTo('Job Position Profile: edit'))
                                    <br/><br/>
                                    <a href="{{ route('job_position_profile.edit', $jobPositionProfile) }}"
                                        class="btn btn-outline-secondary btn-sm" title="Editar">
                                        <i class="fas fa-edit fa-fw"></i>
                                    </a>
                                @endif
                                
                            @endif
                            <!-- PARA FIRMAR -->
                            @if($index == 'to_sign')
                                <a href="{{ route('job_position_profile.to_sign', $jobPositionProfile) }}"
                                    class="btn btn-outline-secondary btn-sm" title="">
                                    <i class="fas fa-signature fa-fw"></i>
                                </a>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($jobPositionProfile->status != "saved")
                                <a href="{{ route('job_position_profile.document.create_document', $jobPositionProfile) }}"
                                    class="btn btn-sm btn-outline-secondary" 
                                    target="_blank"
                                    title="Ver documento">
                                    <span class="fas fa-file-pdf fa-fw" aria-hidden="true"></span>
                                </a>
                            @else
                                <a href=""
                                    class="btn btn-sm btn-outline-secondary disabled" 
                                    target="_blank"
                                    title="Ver documento">
                                    <span class="fas fa-file-pdf fa-fw" aria-hidden="true"></span>
                                </a>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(in_array($jobPositionProfile->status, ['saved', 'sent', 'pending']))
                                <form method="POST" style="display:inline-block;"
                                    action="{{ route('job_position_profile.destroy', $jobPositionProfile) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash fa-fw"></i>
                                    </button>
                                </form>
                            @else
                                <button type="submit" class="btn btn-outline-danger btn-sm disabled">
                                    <i class="fas fa-trash fa-fw"></i>
                                </button>
                            @endif
                        </td>
                    <tr>
                    @endforeach
                </tbody>
            </table>
            {{ $jobPositionProfiles->links() }}    
        </div>
    @else
        @if($index == 'to_sign')
        <h5 class="mb-3"><i class="fas fa-inbox"></i> Pendientes: </h5>
        @endif

        <div class="alert alert-info" role="alert">
            <b>Estimado usuario</b>: No se encuentran <b>Perfiles de Cargos</b> según los parámetros consultados.
        </div>

        @if($index == 'to_sign')
        @if($reviewedJobPositionProfiles->count() > 0)
        <br>
        <h5 class="mb-3"><i class="fas fa-inbox"></i> Aprobados / Rechazados: </h5>
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
                        <th>Aprobaciones</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviewedJobPositionProfiles as $jobPositionProfile)
                    <tr>
                        <th>
                            {{ $jobPositionProfile->id }} <br>
                            @switch($jobPositionProfile->status)
                                @case('saved')
                                    <span class="badge badge-primary">{{ $jobPositionProfile->StatusValue }}</span>
                                    @break

                                @case('sent')
                                    <span class="badge badge-secondary">{{ $jobPositionProfile->StatusValue }}</span>
                                    @break

                                @case('pending')
                                    <span class="badge badge-warning">{{ $jobPositionProfile->StatusValue }}</span>
                                    @break

                                @case('rejected')
                                    <span class="badge badge-danger">{{ $jobPositionProfile->StatusValue }}</span>
                                    @break

                                @case('review')
                                    <span class="badge badge-info">{{ $jobPositionProfile->StatusValue }}</span>
                                    @break
                            @endswitch
                        </th>
                        <td>{{ $jobPositionProfile->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>
                            <b>{{ $jobPositionProfile->user->fullName }}</b> <br>
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
                            {{ $jobPositionProfile->working_day == 'shift' ? 'Turno' : $jobPositionProfile->working_day.' Horas' }}
                        </td>
                        <td class="text-center">
                            @if($jobPositionProfile->status == 'saved')
                                <i class="fas fa-save fa-2x"></i>
                            @else
                                @foreach($jobPositionProfile->jobPositionProfileSigns as $sign)
                                    @if($sign->status == 'pending' || $sign->status == NULL)
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" 
                                            title="{{ $sign->organizationalUnit->name }}">
                                            <i class="fas fa-clock fa-2x"></i>
                                        </span>
                                    @endif
                                    @if($sign->status == 'accepted')
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" 
                                            style="color: green;"
                                            title="{{ $sign->organizationalUnit->name }}">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </span>
                                    @endif
                                    @if($sign->status == 'rejected')
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                            style="color: Tomato;"
                                            title="{{ $sign->organizationalUnit->name }}">
                                            <i class="fas fa-times-circle fa-2x"></i>
                                        </span>
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td class="text-center">
                            @if($jobPositionProfile->status == 'saved')
                                <a href="{{ route('job_position_profile.edit', $jobPositionProfile) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Editar"><i class="fas fa-edit"></i>
                                </a>
                            @else
                                <a href="{{ route('job_position_profile.show', $jobPositionProfile) }}"
                                    class="btn btn-outline-secondary btn-sm" title="">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($jobPositionProfile->status == "completed")
                                
                            @else
                                <a href="{{ route('job_position_profile.document.create_document', $jobPositionProfile) }}"
                                    class="btn btn-sm btn-outline-secondary" 
                                    target="_blank"
                                    title="Ver documento">
                                    <span class="fas fa-file-pdf" aria-hidden="true"></span>
                                </a>
                                {{--
                                <a href="{{ route('replacement_staff.request.technical_evaluation.create_document', $requestReplacementStaff) }}"
                                    class="btn btn-info btn-sm float-right" 
                                    title="Selección" 
                                    target="_blank">
                                    Exportar Resumen <i class="fas fa-file"></i>
                                </a>
                                --}}
                            @endif
                        </td>
                    <tr>
                    @endforeach
                </tbody>
            </table>
            {{-- $jobPositionProfiles->links() --}}      
        </div>
        @endif
        @endif
    @endif
</div>
