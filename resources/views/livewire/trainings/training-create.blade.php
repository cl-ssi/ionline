<div>
    <h6 class="mb-3"><b>I. Antecedentes del funcionario/a que asiste a la Capacitación.</b></h6>

    <div class="row g-3 mb-3">
        
        <fieldset class="form-group col-12 col-md-1 mt-5">
            1.
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_user_responsible_id">Nombre Funcionario:</label>
            @livewire('search-select-user', [
                'selected_id'   => 'user_responsible_id',
                'required'      => 'required',
                'emit_name'     => 'searchedUser',
                'user'          => $meetingToEdit->userResponsible ?? null
            ])
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
            <select name="estament_id" id="for_estament_id" class="form-select" wire:model.debounce.500ms="selectedEstament" {{-- @if($jobPositionProfile) readonly @endif --}}>
                <option value="">Seleccione...</option>
                @foreach($estaments as $estament)
                    <option value="{{ $estament->id }}">{{ $estament->name }}</option>
                @endforeach
            </select>
            @error('selectedEstament') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="profiles">Grado</label>
            <input type="degree" class="form-control" wire:model.defer="degree" id="for_degree">
            @error('degree') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
            

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_contractual_condition_id">Calidad Contractual</label>
            <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-select" wire:model.debounce.500ms="selectedContractualCondition">
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
            <label for="for_subject">Correo electrónico</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="email">
            @error('email') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_subject">Teléfono</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="telephone">
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
            <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-select" wire:model.debounce.500ms="selectedStrategicAxis">
                <option value="">Seleccione...</option>
                @foreach($strategicAxes as $strategicAxis)
                    <option value="{{ $strategicAxis->id }}" >{{ $strategicAxis->name }}</option>
                @endforeach
            </select>
            @error('selectedStrategicAxis') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-1">
            <button type="button" class="btn btn-info mt-4"data-bs-toggle="modal" data-bs-target="#strategicAxesModal">
                <i class="fas fa-info-circle"></i>
            </button> 
        </fieldset>

        @include('trainings.modals.ejes_estrategicos')
    </div>
    
    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle"></i> Consulte guía para completar <b>Ejes estratégicos</b>.
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
            <select id="for_activity_type" class="form-select" wire:model.debounce.500ms="activityType">
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
            <select id="for_activity_name" class="form-select" wire:model.debounce.500ms="mechanism">
                <option value="">Seleccionar</option>
                <option value="videoconferencia">Videoconferencia</option>
                <option value="presencial">Presencial</option>			
            </select>
            @error('mechanism') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_objective">Actividad Programada:</label>
            <select id="for_activity_name" class="form-select" wire:model.debounce.500ms="schuduled">
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
            <input class="form-control" type="text" autocomplete="off" wire:model.debounce.500ms="totalHours">
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
            <input class="form-control" type="text" autocomplete="off" wire:model.debounce.500ms="place">
            @error('place') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            12.
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_objective">Jornada y Horarios</label>
            <select id="for_activity_name" class="form-select" wire:model.debounce.500ms="workingDay">
                <option value="">Seleccionar</option>
                <option value="completa">Jornada Completa</option>
                <option value="mañana">Jornada Mañana</option>
                <option value="tarde">Jornada Tarde</option>
            </select>
            @error('workingDay') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-5">
        <fieldset class="form-group col-12 col-md-1 mt-5">
            13.
        </fieldset>

        <fieldset class="form-group col-12 col-md-11">
            <label for="for_objective">Fundamento o Razones Técnicas para la asistencia del funcionario</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.debounce.500ms="technicalReasons">
        </fieldset>
        @error('technicalReasons') <span class="text-danger error small">{{ $message }}</span> @enderror
    </div>

    <h6 class="mb-3"><b>IV. Informe de Costos.</b></h6>

    @if($trainingCosts)
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm small">
                <thead>
                    <tr class="text-center">
                        <th width="">#</th>
                        <th width="">Tipo Costo</th>
                        <th width="">Aplica</th>
                        <th width="">Costo</th>
                        <th width=""></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trainingCosts as $key => $trainingCost)
                    <tr>
                        <th class="text-center">{{ $loop->iteration }}</th>
                        <td class="text-center">
                            @switch($trainingCost['type'])
                                @case('matricula')
                                    Matrícula                             
                                    @break
                                
                                @case('pasajes')
                                    Pasajes
                                    @break

                                @case('viaticos')
                                    Viáticos
                                    @break
                                
                                @case('otro')
                                    {{ $trainingCost['other_type'] }}
                                    @break
                            @endswitch
                        </td>
                        <td class="text-center">  
                            @switch($trainingCost['exist'])
                                @case(0)
                                    Sin Costo al Servicio                          
                                    @break
                                @case(1)
                                    Con Costo al Servicio                           
                                    @break
                            @endswitch
                        </td>
                        <td class="text-end">$ {{ number_format($trainingCost['expense'],0,",",".") }}</td>
                        <td class="text-center">
                            <a href="{{-- route('meetings.edit', $meeting) --}}"
                                class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-edit fa-fw"></i> 
                            </a>
                            <a class="btn btn-outline-danger btn-sm"
                                wire:click="deleteTrainingCost({{ $key }})">
                                <i class="fas fa-trash-alt fa-fw"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="row g-3 mb-3">
        <fieldset class="col-12 col-md-2">
            <label for="for_type_training_cost">Tipo Costo</label>
            <select class="form-select" wire:model="typeTrainingCost">
                <option value="">Seleccionar</option>
                <option value="matricula">Matricula</option>
                <option value="pasajes">Pasajes</option>
                <option value="viaticos">Viáticos</option>
                <option value="otro">Otro</option>

            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_place">Especificar costo</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.debounce.500ms="otherTypeTrainingCost" {{ $disabledInputOtherTypeTrainingCost }}>
        </fieldset>

        <fieldset class="col-12 col-md-3">
            <label for="for-mecanism">Con Costo al Servicio?</label>
            <select class="form-select" wire:model="exist">
                <option value="">Seleccionar</option>
                <option value="1">Si</option>
                <option value="0">No</option>

            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2 gap-2 col-6 mx-auto">
            <label for="for_place">$ Costo</label>
            <input class="form-control" type="number" autocomplete="off" wire:model.debounce.500ms="expense">
        </fieldset>

        <div class="d-grid gap-2 col-2 mx-auto">
            <button wire:click="addTrainingCost" class="btn btn-success float-start mt-4" type="button">
                <small><i class="fas fa-plus"></i> Agregar </small>
            </button>
        </div>
    </div>

    @if(count($errors) > 0 && $validateMessage == "training")
        <div class="alert alert-danger">
            <p>Corrige los siguientes errores:</p>
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-3 mt-5">
        <div class="col-12">
            <button wire:click="save" class="btn btn-primary float-end" type="button">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>
</div>
