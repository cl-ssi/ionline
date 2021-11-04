<fieldset class="form-group col">
    <label for="for_legal_quality" >Calidad Jurídica / Renta / Fundamento / Detalle Fundamento</label>
    <div class="input-group">
        <select name="legal_quality" id="for_legal_quality" class="form-control" wire:model="selectedLegalQuality" required>
            <option value="">Seleccione...</option>
            <option value="to hire" @if($requestReplacementStaff) {{ ($requestReplacementStaff->legal_quality == $legalQualitySelected) ? 'selected' : '' }} @endif>Contrata</option>
            <option value="fee" @if($requestReplacementStaff) {{ ($requestReplacementStaff->legal_quality == $legalQualitySelected) ? 'selected' : '' }} @endif>Honorarios</option>
        </select>

        <input type="number" class="form-control" name="salary"
            id="for_salary" placeholder="$" {{ $salaryStateInput }} @if($requestReplacementStaff) value="{{ $requestReplacementStaff->salary }}" @endif>

        <select name="fundament" id="for_fundament" class="form-control" wire:model="selectedFundament" {{ $fundamentSelectState }}>
            <option value="">Seleccione...</option>
            <option value="replacement" @if($requestReplacementStaff) {{ ($requestReplacementStaff->fundament == $legalQualitySelected) ? 'selected' : '' }} @endif
                                        @if($fundamentOptionState == 'disabled') disabled @endif>Reemplazo</option>
            <option value="quit" @if($requestReplacementStaff) {{ ($requestReplacementStaff->fundament == $legalQualitySelected) ? 'selected' : '' }} @endif >Renuncia</option>
            <option value="expand work position" @if($requestReplacementStaff) {{ ($requestReplacementStaff->fundament == $legalQualitySelected) ? 'selected' : '' }} @endif >Cargo expansión</option>
            <option value="other" @if($requestReplacementStaff) {{ ($requestReplacementStaff->fundament == $legalQualitySelected) ? 'selected' : '' }} @endif >Otro</option>
        </select>

        <select name="fundament_detail" id="for_fundament_detail" class="form-control" wire:model="selectedFundamentDetail" {{ $fundamentDetailSelectState }}>
            <option value="">Seleccione...</option>
            <option value="quit" @if($requestReplacementStaff) {{-- ($requestReplacementStaff->fundament == $legalQualitySelected) ? 'selected' : '' --}} @endif {{-- $fundamentOptionStateDisabled --}}>Renuncia</option>
            <option value="allowance without payment" @if($requestReplacementStaff) {{-- ($requestReplacementStaff->fundament == $legalQualitySelected) ? 'selected' : '' --}} @endif {{-- $fundamentOptionState --}}>Permiso sin goce de sueldo</option>
            <option value="vacations" @if($requestReplacementStaff) {{-- ($requestReplacementStaff->fundament == $legalQualitySelected) ? 'selected' : '' --}} @endif {{-- $fundamentOptionState --}}>Feriado legal</option>
            <option value="medical license" @if($requestReplacementStaff) {{-- ($requestReplacementStaff->fundament == $legalQualitySelected) ? 'selected' : '' --}} @endif {{-- $fundamentOptionState --}}>Licencia médica</option>

            <option value="medical license" @if($requestReplacementStaff) {{-- ($requestReplacementStaff->fundament == $legalQualitySelected) ? 'selected' : '' --}} @endif {{-- $fundamentOptionState --}}>(2) Reemplazo previa convocatoria</option>
            <option value="medical license" @if($requestReplacementStaff) {{-- ($requestReplacementStaff->fundament == $legalQualitySelected) ? 'selected' : '' --}} @endif {{-- $fundamentOptionState --}}>(2) Convocatoria interna.</option>
            <option value="medical license" @if($requestReplacementStaff) {{-- ($requestReplacementStaff->fundament == $legalQualitySelected) ? 'selected' : '' --}} @endif {{-- $fundamentOptionState --}}>(2) Convocatoria mixta</option>
        </select>

        <input type="text" class="form-control" name="name_to_replace"
            id="for_name_to_replace" placeholder="Nombre de Reemplazo" @if($requestReplacementStaff) value="{{$requestReplacementStaff->name_to_replace}}" @endif {{-- $nameToReplaceInput --}}>

        <input type="text" class="form-control" name="other_fundament"
            id="for_other_fundament" placeholder="Fundamento..." @if($requestReplacementStaff) value="{{$requestReplacementStaff->other_fundament}}" @endif {{-- $nameOtherFundament --}}>
    </div>
</fieldset>
