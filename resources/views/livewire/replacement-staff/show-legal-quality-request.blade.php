{{--
<fieldset class="form-group col">
    <label for="for_legal_quality_manage_id" > /  /  / </label>
    <div class="input-group">
        <select name="legal_quality_manage_id" id="for_legal_quality_manage_id" class="form-control" wire:model="selectedLegalQuality" required>
          <option value="">Seleccione...</option>
          @foreach($legal_qualities as $legal_quality)
              <option value="{{ $legal_quality->id }}" @if($requestReplacementStaff) {{ ($requestReplacementStaff->legal_quality_manage_id == $legalQualitySelected) ? 'selected' : '' }} @endif>{{ $legal_quality->NameValue }}</option>
          @endforeach
        </select>

        <input type="number" class="form-control" name="salary"
            id="for_salary" placeholder="$" {{ $salaryStateInput }} @if($requestReplacementStaff) value="{{ $requestReplacementStaff->salary }}" @endif>

        <select name="fundament_manage_id" id="for_fundament_manage_id" class="form-control" wire:model="selectedFundament" required>
            <option value="">Seleccione...</option>
            @if(!is_null($fundamentLegalQualities))
            @foreach($fundamentLegalQualities as $fundamentLegalQuality)
                <option value="{{ $fundamentLegalQuality->rstFundamentManage->id }}"
                    @if($requestReplacementStaff) {{ ($requestReplacementStaff->fundament_manage_id == $fundamentSelected) ? 'selected' : '' }} @endif>
                    {{ $fundamentLegalQuality->rstFundamentManage->NameValue }}
                </option>
            @endforeach
            @endif
        </select>

        <select name="fundament_detail_manage_id" id="for_fundament_detail_manage_id" class="form-control" wire:model="selectedFundamentDetail" onchange="remoteWorking()">
            <option value="">Seleccione...</option>
            @if(!is_null($detailFundaments))
            @foreach($detailFundaments as $detailFundament)
                <option value="{{ $detailFundament->fundamentDetailManage->id }}"
                      @if($requestReplacementStaff) {{ ($requestReplacementStaff->fundament_detail_manage_id == $fundamentDetailSelected) ? 'selected' : '' }} @endif>
                      {{ $detailFundament->fundamentDetailManage->NameValue }}
                </option>
            @endforeach
            @endif
        </select>

        <input type="text" class="form-control" name="other_fundament"
            id="for_other_fundament" placeholder="Fundamento..." @if($requestReplacementStaff) value="{{$requestReplacementStaff->other_fundament}}" @endif {{ $otherFundamentInput }}>
    </div>
</fieldset> --}}

<div>
    <div class="form-row">
        <fieldset class="form-group col-12 col-md-3">
            <label for="for_user_id">Calidad Jurídica</label>
            <select name="legal_quality_manage_id" id="for_legal_quality_manage_id" class="form-control" wire:model="selectedLegalQuality" required>
                <option value="">Seleccione...</option>
                @foreach($legal_qualities as $legal_quality)
                    <option value="{{ $legal_quality->id }}" @if($requestReplacementStaff) {{ ($requestReplacementStaff->legal_quality_manage_id == $legalQualitySelected) ? 'selected' : '' }} @endif>{{ $legal_quality->NameValue }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_user_id">Renta</label>
            <input type="number" class="form-control" name="salary"
                id="for_salary" placeholder="$" {{ $salaryStateInput }} @if($requestReplacementStaff) value="{{ $requestReplacementStaff->salary }}" @endif>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_user_id">Fundamento</label>
            <select name="fundament_manage_id" id="for_fundament_manage_id" class="form-control" wire:model="selectedFundament" required>
                <option value="">Seleccione...</option>
                @if(!is_null($fundamentLegalQualities))
                @foreach($fundamentLegalQualities as $fundamentLegalQuality)
                    <option value="{{ $fundamentLegalQuality->rstFundamentManage->id }}"
                        @if($requestReplacementStaff) {{ ($requestReplacementStaff->fundament_manage_id == $fundamentSelected) ? 'selected' : '' }} @endif>
                        {{ $fundamentLegalQuality->rstFundamentManage->NameValue }}
                    </option>
                @endforeach
                @endif
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_user_id">Detalle Fundamento</label>
            <select name="fundament_detail_manage_id" id="for_fundament_detail_manage_id" class="form-control" wire:model="selectedFundamentDetail" onchange="remoteWorking()" @if($selectedLegalQuality == 1 && $formType == 'announcement') disabled @endif>
                <option value="">Seleccione...</option>
                @if(!is_null($detailFundaments))
                @foreach($detailFundaments as $detailFundament)
                    <option value="{{ $detailFundament->fundamentDetailManage->id }}"
                        @if($requestReplacementStaff) {{ ($requestReplacementStaff->fundament_detail_manage_id == $fundamentDetailSelected) ? 'selected' : '' }} @endif>
                        {{ $detailFundament->fundamentDetailManage->NameValue }}
                    </option>
                @endforeach
                @endif
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_user_id">Otro Fundamento</label>
            <input type="text" class="form-control" name="other_fundament"
                id="for_other_fundament" placeholder="Fundamento..." @if($requestReplacementStaff) value="{{$requestReplacementStaff->other_fundament}}" @endif {{ $otherFundamentInput }}>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="profiles">Estamento</label>
            <select name="profile_manage_id" id="for_profile_manage_id" class="form-control" wire:model="selectedProfile" required>
                <option value="">Seleccione...</option>
                @foreach($profiles as $profile)
                    <option value="{{ $profile->id }}" @if($requestReplacementStaff) {{ ($requestReplacementStaff->profile_manage_id == $profileSelected) ? 'selected' : '' }} @endif >{{ $profile->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-1">
            <label for="profiles">Grado</label>
            <input type="degree" class="form-control" name="degree" id="for_degree" value="{{ $degree }}" readonly>
        </fieldset>
            
    </div>
</div>
