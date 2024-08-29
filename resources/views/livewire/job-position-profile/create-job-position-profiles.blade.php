<div>
    @if($action == 'update')
    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle"></i> <b>Información importante</b> <br /><br />

        <b>Estimado Usuario</b>: En caso de editar la Unidad Organizacional el sistema reiniciará
        el proceso de aprobaciones, esto devolverá el Perfil de Cargo al estado guardado.
    </div>
    @endif

    @if($action == 'store')
    <form method="POST" class="form-horizontal" action="{{ route('job_position_profile.store') }}" enctype="multipart/form-data"/>
        @csrf
        @method('POST')
    @else
    <form method="POST" class="form-horizontal" action="{{ route('job_position_profile.update', $jobPositionProfile) }}" enctype="multipart/form-data"/>
        @csrf
        @method('PUT')
    @endif
        <h6 class="small"><b>I.IDENTIFICACIÓN DEL CARGO </b></h6> <br>
        <div class="form-row">
            <fieldset class="form-group col-12 col-md-6">
                <label for="for_name">Nombre de Cargo</label>
                <input type="text" class="form-control" name="name" id="for_name" 
                    @if($jobPositionProfile) value="{{ $jobPositionProfile->name }}" @endif required>
            </fieldset>

            <fieldset class="form-group col-12 col-md-6">
                <label for="for_requester_ou_id">Unidad Organizacional</label>
                @livewire('search-select-organizational-unit', [
                    'selected_id'         => 'jpp_ou_id',
                    'required'            => 'required',
                    'organizationalUnit'  => ($jobPositionProfile) ? $jobPositionProfile->organizationalUnit : ''
                ])
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col-12 col-md-3">
                <label for="for_charges_number">Nº Cargos</label>
                <input type="number" class="form-control" name="charges_number" id="for_charges_number" 
                    @if($jobPositionProfile) value="{{ $jobPositionProfile->charges_number }}" @endif required>
            </fieldset>
            
            <fieldset class="form-group col-12 col-md-3">
                <label for="for_charges_number">Estamento</label>
                <select name="estament_id" id="for_estament_id" class="form-control" wire:model.live.debounce.500ms="selectedEstament" @if($jobPositionProfile) readonly @endif required>
                    <option value="">Seleccione...</option>
                    @foreach($estaments as $estament)
                        <option value="{{ $estament->id }}" {{-- ($jobPositionProfile && $jobPositionProfile->estament_id == $estament->id) ? 'selected' : '' --}}>{{ $estament->name }}</option>
                    @endforeach
                </select>
            </fieldset>

            <fieldset class="form-group col-12 col-md-3">
                <label for="for_charges_number">Familia del Cargo</label>
                <select name="area_id" id="for_area_id" class="form-control" wire:model.live.debounce.500ms="selectedArea" required>
                    <option value="">Seleccione...</option>
                    @if(!is_null($areas))
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}"  {{ ($jobPositionProfile && $jobPositionProfile->area_id == $areaSelected) ? 'selected' : '' }}>{{ $area->name }}</option>
                    @endforeach
                    @endif
                </select>
            </fieldset>

            <fieldset class="form-group col-12 col-md-3">
                <label for="for_calidad_juridica">Subordinados</label>
                <div class="mt-1 text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="subordinates" id="for_subordinates" value="1" 
                            {{ ($jobPositionProfile && $jobPositionProfile->subordinates == 1)?'checked':'' }} required>
                        <label class="form-check-label" for="for_subordinates">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="subordinates" id="for_subordinates" value="0" 
                            {{ ($jobPositionProfile && $jobPositionProfile->subordinates == 0)?'checked':'' }} required>
                        <label class="form-check-label" for="for_subordinates">No</label>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col-12 col-md-3">
                <label for="for_contractual_condition_id">Calidad Contractual</label>
                <select name="contractual_condition_id" id="for_contractual_condition_id" class="form-control" wire:model.live.debounce.500ms="selectedContractualCondition" required>
                    <option value="">Seleccione...</option>
                    @foreach($contractualConditions as $contractualCondition)
                        <option value="{{ $contractualCondition->id }}" >{{ $contractualCondition->name }}</option>
                    @endforeach
                </select>
            </fieldset>

            <fieldset class="form-group col-12 col-md-3">
                <label for="for_law">Ley</label>
                <div class="mt-1">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="law" id="for_law" value="18834" wire:model.live.debounce.500ms="selectedLaw" {{ $lawStateOption }}>
                        <label class="form-check-label" for="for_law">N° 18.834</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="law" id="for_law" value="19664" wire:model.live.debounce.500ms="selectedLaw" {{ $lawStateOption }}>
                        <label class="form-check-label" for="for_law">N° 19.664</label>
                    </div>
                </div>
            </fieldset>

            <fieldset class="form-group col-12 col-md-1">
                <label for="profiles">
                    Grado <i class="fas fa-info-circle" type="button" data-toggle="modal" data-target="#degreesGuideModal"></i>
                </label>
                <input type="degree" class="form-control" name="degree" id="for_degree" {{ $degreeStateInput }} 
                    @if($jobPositionProfile) value="{{ $jobPositionProfile->degree }}" @endif required>
            </fieldset>

            <fieldset class="form-group col-12 col-md-2">
                <label for="for_user_id">Renta</label>
                <input type="number" class="form-control" name="salary" id="for_salary" {{ $salaryStateInput }} 
                    placeholder="$" @if($jobPositionProfile) value="{{ $jobPositionProfile->salary }}" @endif required>
            </fieldset>

            <div class="form-group col-12 col-md-3">
                <label for="name" class="col-form-label">Marco Legal:</label>
                <br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" value="1" id="for_dfl3" name="dfl3" {{ ($jobPositionProfile && $jobPositionProfile->dfl3 == 1)?'checked':'' }}>
                    <label class="form-check-label" for="for_dfl3">
                        DFL N°03/17
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" value="1" id="for_dfl29" name="dfl29" {{ ($jobPositionProfile && $jobPositionProfile->dfl29 == 1)?'checked':'' }}>
                    <label class="form-check-label" for="for_dfl3">
                        DFL N°29
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" value="1" id="for_other_legal_framework" name="other_legal_framework" {{ ($jobPositionProfile && $jobPositionProfile->other_legal_framework == 1)?'checked':'' }}>
                    <label class="form-check-label" for="for_other_legal_framework">
                        Otra
                    </label>
                </div>
            </div>
        </div>

        <div class="form-row">
            <fieldset class="form-group col-12 col-md-3">
                <label for="for_charges_number">Horario de Trabajo</label>
                <select name="working_day" id="for_working_day" class="form-control" wire.debounce.500ms required>
                    <option value="">Seleccione...</option>
                    <option value="44" {{ ($jobPositionProfile && $jobPositionProfile->working_day == 44)?'selected':'' }}>44 horas</option>
                    <option value="33" {{ ($jobPositionProfile && $jobPositionProfile->working_day == 33)?'selected':'' }} {{ $workingDayState }}>33 horas</option>
                    <option value="22" {{ ($jobPositionProfile && $jobPositionProfile->working_day == 22)?'selected':'' }}>22 horas</option>
                    <option value="11" {{ ($jobPositionProfile && $jobPositionProfile->working_day == 11)?'selected':'' }} {{ $workingDayState }}>11 horas</option>
                    <option value="shift" {{ ($jobPositionProfile && $jobPositionProfile->working_day == 'shift')?'selected':'' }}>Turno</option>
                </select>
            </fieldset>
        </div>

        <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
    </form>

    <br>
    <br>
</div>
