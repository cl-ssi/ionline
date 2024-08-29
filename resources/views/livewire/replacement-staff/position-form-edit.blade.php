<div>
    <h6 class="small"><b>3. Descripción de cargo(s)</b></h6> <br>

    <div class="form-row">
        <fieldset class="form-group col-sm">
            <label><b>Listado de cargos registrados:</b></label>
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                    <thead class="text-center small">
                        <tr>
                            <th>ID</th>
                            <th>Estamento</th>
                            <th>Grado / Renta</th>
                            <th>Calidad Jurídica</th>
                            <th>Fundamento</th>
                            <th>Jornada</th>
                            <th style="width: 8%"></th>
                        </tr>
                    </thead>
                    <tbody class="text-center small">
                        @foreach($requestReplacementStaff->positions as $position)
                        <tr @if($editMode && $position->id == $positionEdit->id) class="table-warning" @endif>
                            <td>{{ $position->id }}</td>
                            <td>{{ $position->profile_manage->name ?? '' }}</td>
                            <td>{{ $position->degree ?? number_format($position->salary, 0, ",", ".") }}</td>
                            <td>{{ $position->legalQualityManage->NameValue ?? '' }}</td>
                            <td>{{ $position->fundamentManage->NameValue ?? '' }}<br>
                                {{ $position->fundamentDetailManage->NameValue ?? '' }}</td>
                            <td>{{ $position->WorkDayValue ?? '' }}</td>
                            <td><a onclick="return confirm('¿Está seguro de eliminar cargo ID {{$position->id}}?') || event.stopImmediatePropagation()" wire:click="destroy({{$position->id}})"
                                    class="btn btn-link btn-sm float-right" title="Eliminar"><i class="far fa-trash-alt" style="color:red"></i></a> 
                                <a wire:click="edit({{$position->id}})"
                                    class="btn btn-link btn-sm float-right" title="Editar"><i class="far fa-edit"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>

        </fieldset>
    </div>

    <label><b>
    @if($editMode) Editar cargo 
    @else 
    ¿Crear nuevo cargo? 
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model.live="createNewPosition" name="create_new_position" id="inlineRadio1" value="yes">
        <label class="form-check-label" for="inlineRadio1">Sí</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model.live="createNewPosition" name="create_new_position" id="inlineRadio2" value="no">
        <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
    @endif</b></label><br>

    <input type="hidden" name="position_id" wire:model.live="position_id">

    @livewire('replacement-staff.show-legal-quality-request', [
        'formType'  => 'announcement',
        'isDisabled' => 'disabled'
    ])

    <div class="form-row">
        <fieldset class="form-group col-6">
            <label for="for_calidad_juridica">Jornada</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_diurnal" value="diurnal"
                        {{ ($positionEdit && $positionEdit->work_day == "diurnal")?'checked':''}} required {{ $createNewPosition == 'no' && !$editMode ? 'disabled' : '' }}>
                    <label class="form-check-label" for="for_work_day_diurnal">Diurno</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_third_shift" value="third shift"
                        {{ ($positionEdit && $positionEdit->work_day == "third shift")?'checked':''}} required {{ $createNewPosition == 'no' && !$editMode ? 'disabled' : '' }}>
                    <label class="form-check-label" for="for_work_day_third_shift">Tercer Turno</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_fourth_shift" value="fourth shift"
                        {{ ($positionEdit && $positionEdit->work_day == "fourth shift")?'checked':''}} required {{ $createNewPosition == 'no' && !$editMode ? 'disabled' : '' }}>
                    <label class="form-check-label" for="for_work_day_fourth_shift">Cuarto Turno</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_other" value="other"
                        {{ ($positionEdit && $positionEdit->work_day == "other")?'checked':''}} required {{ $createNewPosition == 'no' && !$editMode ? 'disabled' : '' }}>
                    <label class="form-check-label" for="for_work_day_other">Otro</label>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_name">Otra Jornada</label>
            <input type="text" class="form-control" name="other_work_day" id="for_other_work_day" placeholder="Otro"
                value="{{ $positionEdit->other_work_day ?? '' }}" {{$positionEdit && $positionEdit->work_day != 'other' ? 'readonly' : ''}} {{ $createNewPosition == 'no' && !$editMode ? 'disabled' : '' }}>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_charges_number">Nº Cargos</label>
            <input type="number" class="form-control" name="charges_number" id="for_charges_number"
                value="{{ $positionEdit->charges_number ?? 1 }}" {{ $createNewPosition == 'no' && !$editMode ? 'disabled' : '' }}>
        </fieldset>
    </div>

    <div class="form-row">
        @if($positionEdit && $positionEdit->job_profile_file)
        <fieldset class="form-group col-1">
            <div>
                <label for="" class="form-label">&nbsp;</label>
                <a class="btn btn-outline-secondary form-control"
                    href="{{ route('replacement_staff.request.show_file_position', $positionEdit) }}"
                    target="_blank"> <i class="fas fa-paperclip"></i>
                </a>
            </div>
        </fieldset>
        @endif
        <fieldset class="form-group col-md-6">
            <label for="for_job_profile_file" class="form-label">Perfil de Cargo</label>
            <input class="form-control" type="file" name="job_profile_file" accept="application/pdf" {{$editMode ? '' : 'required' }} {{ $createNewPosition == 'no' && !$editMode ? 'disabled' : '' }}>
        </fieldset>
    </div>
</div>