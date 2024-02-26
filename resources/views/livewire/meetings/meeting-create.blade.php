<div class="mt-3">
    <h6 class="mt-3"><b>1- Descripción reunión</b></h6>

    <div class="row g-3 mb-3">
        {{--
        <fieldset class="form-group col-12 col-md-4">
            <label for="for_user_responsible_id">Nombre Funcionario responsable:</label>
            @livewire('search-select-user', [
                'selected_id'   => 'user_responsible_id',
                'required'      => 'required',
                'emit_name'     => 'searchedUser',
                'user'          => $meetingToEdit->userResponsible ?? null
            ])
        </fieldset>
        --}}

        <fieldset class="form-group col-12 col-sm-2">
            <label for="for_date">Fecha Reunión</label>
            <input type="date" class="form-control" wire:model.defer="date" id="for_date">
            @error('from') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_type">Tipo</label>
            <select class="form-select" wire:model.defer="type">
                <option value="">Seleccione</option>
                <option value="extraordinaria">Extraordinaria</option>
                <option value="no extraordinaria">No extraordinaria</option>
                <option value="lobby">Lobby</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-8">
            <label for="for_subject">Asunto</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="subject">
        </fieldset>
    </div>
    
    <div class="row g-3 mb-3">
        <fieldset class="col-12 col-md-4">
            <label for="for-mecanism">Medio</label>
            <select class="form-select" wire:model.defer="mechanism" required>
                <option value="">Seleccionar</option>
                <option value="videoconferencia">Videoconferencia</option>
                <option value="presencial">Presencial</option>
            </select>
        </fieldset>

        <fieldset class="col-12 col-md-2">
            <label for="for-start_at">Hora inicio</label>
            <input type="time" class="form-control" wire:model.defer="start_at" >
        </fieldset>

        <fieldset class="col-12 col-md-2">
            <label for="for-end_at">Hora término</label>
            <input type="time" class="form-control" wire:model.defer="end_at">
        </fieldset>
    </div>

    <hr>

    <h6 class="mt-5"><b>2- Asociaciones de Funcionarios / Federaciones Regionales / Reunión Mesas y Comités de Trabajos</b></h6>

    <div class="row g-3 mb-5">
        <fieldset class="col-12 col-md-4">
            <label for="for-mecanism">Tipo</label>
            <select class="form-select" wire:model.defer="typeGrouping">
                <option value="">Seleccionar</option>
                <option value="asociaciones funcionarios">Asociaciones de Funcionarios</option>
                <option value="federaciones regionales">Federaciones Regionales</option>
                <option value="mesas comites de trabajo">Reunión Mesas y Comités de Trabajos</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_subject">Nombre</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="nameGrouping">
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <button wire:click="addGrouping" class="btn btn-success float-start mt-4" type="button">
                <i class="fas fa-plus"></i> Agregar
            </button>
        </fieldset>
    </div>

    @if($groupings)
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm small">
                <thead>
                    <tr class="text-center">
                        <th width="10%">#</th>
                        <th width="40%">Tipo</th>
                        <th width="40%">Nombre</th>
                        <th width="30%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groupings as $key => $grouping)
                    <tr>
                        <th class="text-center">{{ $loop->iteration }}</th>
                        <td class="text-center">
                            @switch($grouping['type'])
                                @case('asociaciones funcionarios')
                                    Asociaciones de Funcionarios                              
                                    @break
                                
                                @case('federaciones regionales')
                                    Federaciones Regionales
                                    @break

                                @case('mesas comites de trabajo')
                                    Reunión Mesas y Comités de Trabajos
                                    @break
                            @endswitch
                        </td>
                        <td>{{ $grouping['name'] }}</td>
                        <td class="text-center">
                            <a class="btn btn-outline-danger btn-sm"
                                wire:click="deleteGrouping({{ $key }})">
                                <i class="fas fa-trash-alt fa-fw"></i>
                            </a>
                            <a href="{{-- route('meetings.edit', $meeting) --}}"
                                class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-edit fa-fw"></i> 
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <hr>

    <h6 class="mt-5"><b>3- Compromisos</b></h6>
    
    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-12">
            <label for="for_subject">Responsabilidad</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="commitment">
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="col-12 col-md-3">
            <label for="for-mecanism">Tipo</label>
            <select class="form-select" wire:model="typeResponsible">
                <option value="">Seleccionar</option>
                <option value="individual">Personal</option>
                <option value="ou">Unidad Organizacional</option>
            </select>
        </fieldset>

        <fieldset class="col-12 col-md-4">
            @if($typeResponsible == 'individual')
                <label for="for_user_commitment_id">Nombre Funcionario responsable:</label>
                @livewire('search-select-user', [
                    'selected_id'   => 'user_commitment_id',
                    'required'      => 'required',
                    'emit_name'     => 'searchedCommitmentUser',
                    'user'          => ''
                ])
            @endif

            @if($typeResponsible == 'ou')
                <label for="for_requester_ou_id">Unidad Organizacional</label>
                @livewire('search-select-organizational-unit', [
                    'selected_id'         => 'compromise_ou_id',
                    'required'            => 'required',
                    'organizationalUnit'  => ''
                ])
            @endif
            
            @if($typeResponsible == '' || $typeResponsible == NULL)
                <div class="alert alert-info alert-sm small mt-2" role="alert">
                    A simple info alert—check it out!
                </div>
            @endif
        </fieldset>

        <fieldset class="form-group col-12 col-sm-2">
            <label for="for_date">Fecha Termino</label>
            <input type="date" class="form-control" wire:model.defer="closingDate" id="for_date">
        </fieldset>

        <fieldset class="col-12 col-md-3">
            <label for="for-mecanism">Estado</label>
            <select class="form-select" wire:model="status">
                <option value="">Seleccionar</option>
                <option value="derived">Derivado</option>
            </select>
        </fieldset>
    </div>
    
    <div class="row g-3"> 
        <fieldset class="form-group col-12 col-md-12">
            <button wire:click="addGrouping" class="btn btn-success float-end" type="button">
                <i class="fas fa-plus"></i> Agregar
            </button>
        </fieldset>
    </div>
    
    <hr>

    <div class="row g-3 mt-5">
        <div class="col-12">
            <button wire:click="save" class="btn btn-primary float-end" type="button">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>
</div>
