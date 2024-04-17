<div>
    <h6 class="mb-3"><b>I. Antecedentes del funcionario/a que asiste a la Capacitación.</b></h6>

    <div class="row g-3 mb-3">
        
        <fieldset class="form-group col-12 col-md-1 mt-5">
            1.
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_user_responsible_id">Nombre Funcionario:</label>
            @if(auth()->guard('external')->check() == true)
                <input class="form-control" type="text" autocomplete="off" wire:model.defer="searchedUserName" {{ $disabledSearchedUserNameInput }}>
            @else
                @livewire('search-select-user', [
                    'selected_id'   => 'user_responsible_id',
                    'required'      => 'required',
                    'emit_name'     => 'searchedUser',
                    'user'          => $meetingToEdit->userResponsible ?? null
                ])
            @endif
            @error('searchedUser') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_subject">Run</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="run" {{ $disabledUserInputs }}>
        </fieldset>

        <fieldset class="form-group col-12 col-md-1">
            <label for="for_subject">DV</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="dv" {{ $disabledUserInputs }}>
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            2.
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_charges_number">Estamento</label>
            @if($bootstrap == 'v4')
                <select name="estament_id" id="for_estament_id" class="form-control" wire:model.defer="selectedEstament" {{-- @if($jobPositionProfile) readonly @endif --}}>
            @else
                <select name="estament_id" id="for_estament_id" class="form-select" wire:model.debounce.500ms="selectedEstament" {{-- @if($jobPositionProfile) readonly @endif --}}>
            @endif        
                    <option value="">Seleccione...</option>
                    @foreach($estaments as $estament)
                        <option value="{{ $estament->id }}">{{ $estament->name }}</option>
                    @endforeach
                </select>
                @error('selectedEstament') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="profiles">Grado</label>
            <input type="text" class="form-control" wire:model.defer="degree" id="for_degree">
            @error('degree') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_contractual_condition_id">Calidad Contractual</label>
            @if($bootstrap == 'v4')
                <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-control" wire:model.defer="selectedContractualCondition">
            @else
                <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-select" wire:model.debounce.500ms="selectedContractualCondition">
            @endif
                    <option value="">Seleccione...</option>
                    @foreach($contractualConditions as $contractualCondition)
                        <option value="{{ $contractualCondition->id }}" >{{ $contractualCondition->name }}</option>
                    @endforeach
                </select>
            @error('selectedContractualCondition') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            3.
        </fieldset>

        <fieldset class="form-group col-12 col-md-7">
            <label for="for_subject">Servicio/Unidad</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="organizationalUnitUser" {{ $disabledUserInputs }}>
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_subject">Establecimiento</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="establishmentUser" {{ $disabledUserInputs }}>
        </fieldset>
    </div>

    <div class="row g-3 mb-5">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            4.
        </fieldset>

        <fieldset class="form-group col-12 col-md-7">
            <label for="for_email">Correo electrónico</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="email" id="for_email">
            @error('email') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_telephone">Teléfono</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="telephone" id="for_telephone">
            @error('telephone') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <h6 class="mb-3"><b>II. Antecedentes de la Actividad.</b></h6>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            5.
        </fieldset>

        <fieldset class="form-group col-12 col-md-10">
            <label for="for_subject">Eje estratégico asociados a la Actividad</label>
            @if($bootstrap == 'v4')
                <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-control" wire:model.defer="selectedStrategicAxis">
            @else
                <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-select" wire:model.debounce.500ms="selectedStrategicAxis">
            @endif        
                    <option value="">Seleccione...</option>
                    @foreach($strategicAxes as $strategicAxis)
                        <option value="{{ $strategicAxis->id }}" >{{ $strategicAxis->name }}</option>
                    @endforeach
                </select>
            @error('selectedStrategicAxis') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
        
        @if($bootstrap == 'v4')
            <fieldset class="form-group col-12 col-md-1">
                <label for="for_subject">&nbsp</label>
                <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#strategicAxesModal">
                    <i class="fas fa-info-circle"></i>
                </button>
            </fieldset>
        @else
            <fieldset class="form-group col-12 col-md-1">
                <button type="button" class="btn btn-info mt-4"data-bs-toggle="modal" data-bs-target="#strategicAxesModal">
                    <i class="fas fa-info-circle"></i>
                </button> 
            </fieldset>
        @endif

        @include('trainings.modals.ejes_estrategicos')
    </div>
    
    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle"></i> Consulte guía para completar Ejes estratégicos.
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            6.
        </fieldset>

        <fieldset class="form-group col-12 col-md-11">
            <label for="for_objective">Objetivo</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="objective">
            @error('objective') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            7.
        </fieldset>

        <fieldset class="form-group col-12 col-md-11">
            <label for="for_objective">Nombre de la Actividad</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="activityName">
            @error('activityName') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            8.
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_activity_type">Tipo de Actividad</label>
            @if($bootstrap == 'v4')
                <select id="for_activity_type" class="form-control" wire:model.defer="activityType">
            @else
                <select id="for_activity_type" class="form-select" wire:model.debounce.500ms="activityType">
            @endif
                    <option value="">Seleccione...</option>
                    <option value="curso">Curso</option>
                    <option value="taller">Taller</option>
                    <option value="jornada">Jornada</option>
                    <option value="estadía pasantía">Estadía Pasantía</option>
                    <option value="perfeccionamiento diplomado">Perfeccionamiento Diplomado</option>
                    <option value="otro">Otro</option>				
                </select>
                @error('activityType') <span class="text-danger error small">{{ $message }}</span> @enderror
            
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_other_activity_type">Nombre de la Actividad</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="otherActivityType" {{ $disabledInputOtherActivityType }}>
            @error('otherActivityType') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>
    
    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            9.
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_objective">Modalidad de aprendizaje:</label>
            @if($bootstrap == 'v4')
                <select id="for_activity_name" class="form-control" wire:model.defer="mechanism">
            @else
                <select id="for_activity_name" class="form-select" wire:model.debounce.500ms="mechanism">
            @endif        
                    <option value="">Seleccionar</option>
                    <option value="videoconferencia">Videoconferencia</option>
                    <option value="presencial">Presencial</option>			
                </select>
                @error('mechanism') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_objective">Actividad Programada:</label>
            @if($bootstrap == 'v4')
                <select id="for_activity_name" class="form-control" wire:model.defer="schuduled">
            @else
                <select id="for_activity_name" class="form-select" wire:model.debounce.500ms="schuduled">
            @endif
                    <option value="">Seleccionar</option>
                    <option value="pac">Programada en PAC</option>
                    <option value="no planificada">No planificada</option>			
                </select>
                @error('schuduled') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>	

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            10.
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_activity_date_start_at">Fecha Inicio de Actividad</label>
            <input type="date" class="form-control" wire:model.defer="activityDateStartAt">
            @error('activityDateStartAt') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_activity_date_end_at">Fecha Termino de Actividad</label>
            <input type="date" class="form-control" wire:model.defer="activityDateEndAt">
            @error('activityDateEndAt') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_total_hours">Total Horas Cronológicas</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="totalHours">
            @error('totalHours') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>	

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            11.
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_permission_date_start_at">Solicita Permiso Desde</label>
            <input type="date" class="form-control" wire:model.defer="permissionDateStartAt">
            @error('permissionDateStartAt') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_permission_date_end_at">Solicita Permiso Hasta</label>
            <input type="date" class="form-control" wire:model.defer="permissionDateEndAt">
            @error('permissionDateEndAt') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
        
        <fieldset class="form-group col-12 col-md-4">
            <label for="for_place">Lugar</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="place">
            @error('place') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            12.
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_objective">Jornada y Horarios</label>
            @if($bootstrap == 'v4')
                <select id="for_activity_name" class="form-control" wire:model.defer="workingDay">
            @else
                <select id="for_activity_name" class="form-select" wire:model.debounce.500ms="workingDay">
            @endif
                    <option value="">Seleccionar</option>
                    <option value="completa">Jornada Completa</option>
                    <option value="mañana">Jornada Mañana</option>
                    <option value="tarde">Jornada Tarde</option>
                </select>
            @error('workingDay') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            13.
        </fieldset>

        <fieldset class="form-group col-12 col-md-11">
            <label for="for_objective">Fundamento o Razones Técnicas para la asistencia del funcionario</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="technicalReasons">
            @error('technicalReasons') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    @if(auth()->guard('external')->check() == true)
        <div class="row g-3 mb-3">
            <fieldset class="form-group col-12 col-md-1 mt-5">
                14.
            </fieldset>

            <fieldset class="form-group col-12 col-md-5">
                <label for="forFileAttached" class="form-label">Medio de verificación comunal</label>
                <input class="form-control" type="file" wire:model.defer="file" id="upload({{ $iterationFileClean }})">
                <div wire:loading wire:target="file">Cargando archivo...</div>
                @error('file') <span class="text-danger error small">{{ $message }}</span> @enderror
            </fieldset>
            
            
            <fieldset class="form-group col-12 col-md-2">
                @if(Route::is('trainings.external_edit'))
                    <a class="btn btn-primary mt-4" href="{{ route('trainings.show_file', $training) }}" target="_blank">
                        <i class="fas fa-paperclip fa-fw"></i> Ver adjunto
                    </a>
                @endif
            </fieldset>
            
            <fieldset class="form-group col-12 col-md-4">
                <label for="for_municipal_profile">Perfil de Funcionario</label>
                <select id="for_municipal_profile" class="form-control" wire:model.defer="municipalProfile">
                    <option value="">Seleccionar</option>
                    <option value="edf">Médico EDF</option>
                </select>
            </fieldset>
        </div>
    @endif

    <div class="row g-3 mb-5">
        <div class="col-12">
            <button wire:click="save" wire:loading.attr="disabled" wire:target="file" class="btn btn-primary {{ ($bootstrap == 'v4') ? 'float-right' : 'float-end' }}" type="button">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>
</div>
