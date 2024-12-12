<div>
    <h6 class="mb-3"><b>I. Antecedentes del funcionario/a que asiste a la Capacitación.</b></h6>

    <div class="row g-3 mb-3">
        
        <fieldset class="form-group col-12 col-md-1 mt-5">
            1.
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_user_responsible_id">Nombre Funcionario:</label>
            @if(auth()->guard('external')->check() == true)
                <input class="form-control" type="text" autocomplete="off" wire:model="searchedUserName" {{ $disabledSearchedUserNameInput }}>
            @else
                @livewire('search-select-user', [
                    'selected_id'   => 'user_responsible_id',
                    'required'      => 'required',
                    'emit_name'     => 'searchedUser',
                    'user'          => $trainingToEdit->userTraining ?? null
                ])
            @endif
            @error('searchedUser') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_subject">Run</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="run" {{ $disabledUserInputs }}>
        </fieldset>

        <fieldset class="form-group col-12 col-md-1">
            <label for="for_subject">DV</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="dv" {{ $disabledUserInputs }}>
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            2.
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_charges_number">Estamento</label>
            @if($bootstrap == 'v4')
                <select name="estament_id" id="for_estament_id" class="form-control" wire:model="selectedEstament" {{-- @if($jobPositionProfile) readonly @endif --}}>
            @else
                <select name="estament_id" id="for_estament_id" class="form-select" wire:model.live.debounce.500ms="selectedEstament" {{-- @if($jobPositionProfile) readonly @endif --}}>
            @endif        
                    <option value="">Seleccione...</option>
                    @foreach($estaments as $estament)
                        <option value="{{ $estament->id }}">{{ $estament->name }}</option>
                    @endforeach
                </select>
                @error('selectedEstament') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_contractual_condition_id">Calidad Contractual</label>
            @if($bootstrap == 'v4')
                <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-control" wire:model="selectedContractualCondition">
            @else
                <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-select" wire:model.live.debounce.500ms="selectedContractualCondition">
            @endif
                    <option value="">Seleccione...</option>
                    @foreach($contractualConditions as $contractualCondition)
                        <option value="{{ $contractualCondition->id }}" >{{ $contractualCondition->name }}</option>
                    @endforeach
                </select>
            @error('selectedContractualCondition') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_law">Ley</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="law" id="for_law" value="18834" wire:model.live="selectedLaw" {{-- $lawStateOption --}}>
                    <label class="form-check-label" for="for_law">N° 18.834</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="law" id="for_law" value="19664" wire:model.live="selectedLaw" {{-- $lawStateOption --}}>
                    <label class="form-check-label" for="for_law">N° 19.664</label>
                </div>
            </div>
            @error('selectedLaw') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="profiles">Grado</label>
            <input type="text" class="form-control" wire:model="degree" id="for_degree" {{ $degreeStateInput }}>
            @error('degree') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_work_hours">Horas de Desempeño</label>
            <input type="text" class="form-control" wire:model="workHours" id="for_work_hours" {{ $workHoursStateInput }}>
            @error('workHours') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            3.
        </fieldset>

        <fieldset class="form-group col-12 col-md-7">
            <label for="for_subject">Servicio/Unidad</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="organizationalUnitUser" {{ $disabledUserInputs }}>
        </fieldset>
        
        @if(auth()->guard('external')->check() == true)
            <fieldset class="form-group col-12 col-md-4">
                <label for="for_subject">Establecimiento</label>
                <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-control" wire:model="establishmentUser">
                    <option value="">Seleccione...</option>
                    @foreach($establishments as $establishment)
                        <option value="{{ $establishment->id }}" >{{ $establishment->type }} {{ $establishment->name }}</option>
                    @endforeach
                </select>
            </fieldset>
        @else
            <fieldset class="form-group col-12 col-md-4">
                <label for="for_subject">Establecimiento</label>
                <input class="form-control" type="text" autocomplete="off" wire:model="establishmentUser" {{ $disabledUserInputs }}>
            </fieldset>
        @endif
    </div>

    <div class="row g-3 mb-5">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            4.
        </fieldset>

        <fieldset class="form-group col-12 col-md-7">
            <label for="for_email">Correo electrónico</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="email" id="for_email">
            @error('email') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_telephone">Teléfono</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="telephone" id="for_telephone">
            @error('telephone') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <h6 class="mb-3"><b>II. Antecedentes de la Actividad.</b></h6>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            5.
        </fieldset>

        <fieldset class="form-group col-12 col-md-5">
            <label for="for_subject">Eje estratégico asociados a la Actividad</label>
            @if($bootstrap == 'v4')
                <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-control" wire:model="selectedStrategicAxis">
            @else
                <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-select" wire:model.live.debounce.500ms="selectedStrategicAxis">
            @endif        
                    <option value="">Seleccione...</option>
                    @foreach($strategicAxes as $strategicAxis)
                        <option value="{{ $strategicAxis->id }}" >{{ $strategicAxis->name }}</option>
                    @endforeach
                </select>
            @error('selectedStrategicAxis') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-5">
            <label for="for_subject">Objetivo de Impacto</label>
            @if($bootstrap == 'v4')
                <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-control" wire:model="selectedImpactObjective">
            @else
                <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-select" wire:model.live.debounce.500ms="selectedImpactObjective">
            @endif        
                    <option value="">Seleccione...</option>
                    @if(!is_null($impactObjectives))
                    @foreach($impactObjectives as $impactObjective)
                        <option value="{{ $impactObjective->id }}" >{{ $impactObjective->description }}</option>
                    @endforeach
                    @endif
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
            <input class="form-control" type="text" autocomplete="off" wire:model="objective">
            @error('objective') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            7.
        </fieldset>

        <fieldset class="form-group col-12 col-md-11">
            <label for="for_objective">Nombre de la Actividad</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="activityName">
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
                <select id="for_activity_type" class="form-control" wire:model.live="activityType">
            @else
                <select id="for_activity_type" class="form-select" wire:model.live.debounce.500ms="activityType">
            @endif
                    <option value="">Seleccione...</option>
                    <option value="curso">Curso</option>
                    <option value="taller">Taller</option>
                    <option value="jornada">Jornada</option>
                    <option value="estadia pasantia">Estadía Pasantía</option>
                    <option value="perfeccionamiento diplomado">Perfeccionamiento Diplomado</option>
                    <option value="otro">Otro</option>				
                </select>
                @error('activityType') <span class="text-danger error small">{{ $message }}</span> @enderror
            
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_other_activity_type">Nombre de Otro Tipo Actividad</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.live="otherActivityType" {{ $disabledInputOtherActivityType }}>
            @error('otherActivityType') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_activity_type">Nacional / Internacional</label>
            @if($bootstrap == 'v4')
                <select id="for_activity_type" class="form-control" wire:model.live="activityIn">
            @else
                <select id="for_activity_type" class="form-select" wire:model.live.debounce.500ms="activityIn">
            @endif
                    <option value="">Seleccione...</option>
                    <option value="national">Nacional</option>
                    <option value="international">Internacional</option>
                </select>
                @error('activityIn') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
        
        @if($hiddenSearchedCommuneInput != "hidden")
            <fieldset class="form-group col-12 col-md-3">
                <label for="for_requester_id">Comuna:</label>
                @livewire('search-select-commune', [
                    'selected_id'           => 'origin_commune_id',
                    'required'              => 'required',
                    'commune'               => ($trainingToEdit) ? $trainingToEdit->clCommune : null
                    
                ])
                @error('searchedCommune') <span class="text-danger error small">{{ $message }}</span> @enderror
            </fieldset>
            
        @endif

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_law">Viático</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="allowance" id="for_allowance" value="1" wire:model.live="selectedAllowance" {{-- $lawStateOption --}}>
                    <label class="form-check-label" for="for_allowance">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="allowance" id="for_allowance" value="0" wire:model.live="selectedAllowance" {{-- $lawStateOption --}}>
                    <label class="form-check-label" for="for_allowance">No</label>
                </div>
            </div>
            @error('selectedAllowance') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>
    
    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            9.
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_objective">Modalidad de aprendizaje:</label>
            @if($bootstrap == 'v4')
                <select id="for_activity_name" class="form-control" wire:model.live="mechanism">
            @else
                <select id="for_activity_name" class="form-select" wire:model.live.debounce.500ms="mechanism">
            @endif        
                    <option value="">Seleccionar</option>
                    <option value="online">Online</option>
                    <option value="presencial">Presencial</option>	
                    <option value="semipresencial">Semipresencial</option>			
                </select>
                @error('mechanism') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_objective">Modalidad Online:</label>
            @if($bootstrap == 'v4')
                <select id="for_activity_name" class="form-control" wire:model="onlineTypeMechanism" {{ $onlineTypeMechanismStateInput }}>
            @else
                <select id="for_activity_name" class="form-select" wire:model.live.debounce.500ms="onlineTypeMechanism" {{ $onlineTypeMechanismStateInput }}>
            @endif        
                    <option value="">Seleccionar</option>
                    <option value="sincronico">Sincrónico</option>
                    <option value="asincronico">Asincrónico</option>	
                    <option value="mixta">Mixta</option>			
                </select>
                @error('onlineTypeMechanism') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_objective">Actividad Programada:</label>
            @if($bootstrap == 'v4')
                <select id="for_activity_name" class="form-control" wire:model="schuduled">
            @else
                <select id="for_activity_name" class="form-select" wire:model.live.debounce.500ms="schuduled">
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
            <input type="date" class="form-control" wire:model="activityDateStartAt">
            @error('activityDateStartAt') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_activity_date_end_at">Fecha Termino de Actividad</label>
            <input type="date" class="form-control" wire:model="activityDateEndAt">
            @error('activityDateEndAt') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
        
        <fieldset class="form-group col-12 col-md-4">
            <label for="for_total_hours">Total Horas Pedagógicas</label>
            <input class="form-control" type="number" min="1" autocomplete="off" wire:model="totalHours">
            @error('totalHours') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>	

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            11.
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_permission_date_start_at">Solicita Permiso Desde</label>
            <input type="date" class="form-control" wire:model="permissionDateStartAt">
            @error('permissionDateStartAt') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_permission_date_end_at">Solicita Permiso Hasta</label>
            <input type="date" class="form-control" wire:model="permissionDateEndAt">
            @error('permissionDateEndAt') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
        
        <fieldset class="form-group col-12 col-md-4">
            <label for="for_place">Lugar</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="place">
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
                <select id="for_activity_name" class="form-control" wire:model="workingDay">
            @else
                <select id="for_activity_name" class="form-select" wire:model.live.debounce.500ms="workingDay">
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
            <input class="form-control" type="text" autocomplete="off" wire:model="technicalReasons">
            @error('technicalReasons') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            14.
        </fieldset>

        <fieldset class="form-group col-12 col-md-5">
            <label for="forPermissionFile" class="form-label">Permiso</label>
            <input class="form-control" type="file" wire:model="permissionFile" id="upload({{ $iterationFileClean }})">
            <div wire:loading wire:target="permissionFile">Cargando archivo...</div>
            @error('permissionFile') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        @if($currentPermissionFile && Auth::guard('web')->check() == true)
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_permission_file" class="form-label">&nbsp</label><br>
                <a href="{{ route('trainings.show_file', ['training' => $training, 'type' => 'permission_file']) }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-paperclip fa-fw"></i> Ver adjunto
                </a>
            </fieldset>
        @endif
        @if($currentPermissionFile && Auth::guard('external')->check() == true)
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_permission_file" class="form-label">&nbsp</label><br>
                <a href="{{ route('external_trainings.show_file', ['training' => $training, 'type' => 'permission_file']) }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-paperclip fa-fw"></i> Ver adjunto
                </a>
            </fieldset>
        @endif

        @if($currentPermissionFile)
            <fieldset class="form-group col-12 col-md-1">
                <label for="for_permission_file" class="form-label">&nbsp</label><br>
                <button type="button" class="btn btn-danger" wire:click="deleteFile('permission_file')"><i class="fas fa-trash-alt"></i></button>
            </fieldset>
        @endif
            
        <fieldset class="form-group col-12 col-md-3">
            <label for="for_municipal_profile">Perfil de Funcionario</label>
            <select id="for_municipal_profile" class='form-control @if(auth()->guard("external")->check() == false) mt-2 @endif' wire:model="municipalProfile">
                <option value="">Seleccionar</option>
                <option value="edf">Médico EDF</option>
            </select>
            @error('municipalProfile') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            15.
        </fieldset>

        <fieldset class="form-group col-12 col-md-5">
            <label for="forRejoinderFile" class="form-label">Contrato Replica</label>
            <input class="form-control" type="file" wire:model="rejoinderFile" id="upload({{ $iterationFileClean }})">
            <div wire:loading wire:target="rejoinderFile">Cargando archivo...</div>
            @error('rejoinderFile') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
        
        <fieldset class="form-group col-12 col-md-2">
            @if($currentRejoinderFile && Auth::guard('web')->check() == true)
                <label for="for_rejoinder_file" class="form-label">&nbsp</label><br>
                <a href="{{ route('trainings.show_file', ['training' => $training, 'type' => 'rejoinder_file']) }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-paperclip fa-fw"></i> Ver adjunto
                </a>
            @endif
            @if($currentRejoinderFile && Auth::guard('external')->check() == true)
                <label for="for_rejoinder_file" class="form-label">&nbsp</label><br>
                <a href="{{ route('external_trainings.show_file', ['training' => $training, 'type' => 'rejoinder_file']) }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-paperclip fa-fw"></i> Ver adjunto
                </a>
            @endif
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            16.
        </fieldset>

        <fieldset class="form-group col-12 col-md-5">
            <label for="forProgramFile" class="form-label">Programa</label>
            <input class="form-control" type="file" wire:model="programFile" id="upload({{ $iterationFileClean }})">
            <div wire:loading wire:target="programFile">Cargando archivo...</div>
            @error('programFile') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
        
        
        <fieldset class="form-group col-12 col-md-2">
            @if($currentProgramFile && Auth::guard('web')->check() == true)
                <label for="for_program_file" class="form-label">&nbsp</label><br>
                <a class="btn btn-primary" href="{{ route('trainings.show_file', ['training' => $training, 'type' => 'program_file']) }}" target="_blank">
                    <i class="fas fa-paperclip fa-fw"></i> Ver adjunto
                </a>
            @endif
            @if($currentProgramFile && Auth::guard('external')->check() == true)
                <label for="for_program_file" class="form-label">&nbsp</label><br>
                <a class="btn btn-primary" href="{{ route('external_trainings.show_file', ['training' => $training, 'type' => 'program_file']) }}" target="_blank">
                    <i class="fas fa-paperclip fa-fw"></i> Ver adjunto
                </a>
            @endif
        </fieldset>

        @if($currentProgramFile)
            <fieldset class="form-group col-12 col-md-1">
                <label for="for_permission_file" class="form-label">&nbsp</label><br>
                <button type="button" class="btn btn-danger" wire:click="deleteFile('program_file')"><i class="fas fa-trash-alt"></i></button>
            </fieldset>
        @endif
    </div>

    <div class="row g-3 mb-5">
        <div class="col-12">
            <button wire:click="save" wire:loading.attr="disabled" wire:target="permissionFile, rejoinderFile ,programFile" class="btn btn-primary {{ ($bootstrap == 'v4') ? 'float-right' : 'float-end' }}" type="button">
                <i class="fas fa-save"></i> Guardar
            </button>
            <!-- Agrega este pequeño bloque para mostrar un mensaje de carga si lo deseas -->
            <div wire:loading wire:target="save">
                Guardando, por favor espera...
            </div>

            @if($form == 'edit' && $training->approvals->count() == 0)
                <button wire:click="sentToApproval" wire:loading.attr="disabled" wire:target="file" class="btn btn-success {{ ($bootstrap == 'v4') ? 'float-right mr-3' : 'float-end me-3' }}" type="button">
                    <i class="fas fa-paper-plane"></i> Enviar Capacitación
                </button>
            @endif
        </div>
    </div>
</div>
