<div>
    <div class="form-row">
        @if($formType == 'replacement')
        <fieldset class="form-group col-12 col-sm-3">
            <label for="for_start_date">Desde</label>
            <input type="date" class="form-control" name="start_date" id="for_start_date" required>
        </fieldset>

        <fieldset class="form-group col-12 col-sm-3">
            <label for="for_end_date">Hasta</label>
            <input type="date" class="form-control" name="end_date" id="for_end_date" required>
        </fieldset>
        @endif
    </div>

    @livewire('replacement-staff.show-legal-quality-request', [
        'formType'  => $formType
    ])

    <div class="form-row">
        <fieldset class="form-group col-6">
            <label for="for_calidad_juridica">Jornada</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_diurnal" value="diurnal" required>
                    <label class="form-check-label" for="for_work_day_diurnal">Diurno</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_third_shift" value="third shift" required>
                    <label class="form-check-label" for="for_work_day_third_shift">Tercer Turno</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_fourth_shift" value="fourth shift" required>
                    <label class="form-check-label" for="for_work_day_fourth_shift">Cuarto Turno</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_other" value="other" required>
                    <label class="form-check-label" for="for_work_day_other">Otro</label>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_name">Otra Jornada</label>
            <input type="text" class="form-control" name="other_work_day" id="for_other_work_day" placeholder="Otro">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_charges_number">Nº Cargos</label>
            <input type="number" class="form-control" name="charges_number" value="1" id="for_charges_number" readonly>
        </fieldset>
    </div>

    @if($formType == 'replacement')
    <hr>

    <h6 class="small"><b>3. Descripción de Funcionario a Reemplazar</b></h6> <br>

    <div class="form-row">
        @livewire('calculate-dv')

        <fieldset class="form-group col-sm">
            <label for="for_end_date">Funcionario a Reemplazar</label>
            <input type="text" class="form-control" name="name_to_replace" id="for_name_to_replace"
                placeholder="Nombre de Reemplazo"
                required>
        </fieldset>
    </div>
    @endif

    <hr>

    <h6 class="small"><b>{{ $formType == 'replacement' ? 4 : 3 }}. Archivos Adjuntos</b></h6> <br>

    <div class="form-row">
        <fieldset class="form-group col-md-6">
            <div class="mb-3">
                <label for="for_job_profile_file" class="form-label">Perfil de Cargo @if($formType == 'replacement') (Opcional) @endif</label>
                <input class="form-control" type="file" name="job_profile_file" accept="application/pdf" @if($formType == 'announcement') required @endif>
            </div>
        </fieldset>

        <fieldset class="form-group col-md-6">
            <div class="mb-3">
                <label for="for_request_verification_file" class="form-label">Correo (Verificación Solicitud)</label>
                <input class="form-control" type="file" name="request_verification_file" accept="application/pdf" required>
            </div>
        </fieldset>
    </div>
</div>
