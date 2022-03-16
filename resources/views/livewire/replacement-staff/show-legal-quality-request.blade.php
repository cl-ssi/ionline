<fieldset class="form-group col">
    <label for="for_legal_quality_manage_id" >Calidad Jurídica / Renta / Fundamento / Detalle Fundamento</label>
    <div class="input-group">
        <select name="legal_quality_manage_id" id="for_legal_quality_manage_id" class="form-control" wire:model="selectedLegalQuality" required>
          <option value="">Seleccione...</option>
          @foreach($legal_qualities as $legal_quality)
              <option value="{{ $legal_quality->id }}">{{ $legal_quality->NameValue }}</option>
          @endforeach
        </select>

        <input type="number" class="form-control" name="salary"
            id="for_salary" placeholder="$" {{ $salaryStateInput }} @if($requestReplacementStaff) value="{{ $requestReplacementStaff->salary }}" @endif>


        <select name="fundament_manage_id" id="for_fundament_manage_id" class="form-control" wire:model="selectedFundament" required>
            <option value="">Seleccione...</option>
            @if(!is_null($fundamentLegalQualities))
            @foreach($fundamentLegalQualities as $fundamentLegalQuality)
                <option value="{{ $fundamentLegalQuality->rstFundamentManage->id }}">{{ $fundamentLegalQuality->rstFundamentManage->NameValue }}</option>
            @endforeach
            @endif
        </select>

        <select name="fundament_detail_manage_id" id="for_fundament_detail_manage_id" class="form-control" wire:model="selectedFundamentDetail" onchange="remoteWorking()">
            <option value="">Seleccione...</option>
            @if(!is_null($detailFundaments))
            @foreach($detailFundaments as $detailFundament)
                <option value="{{ $detailFundament->fundamentDetailManage->id }}">{{ $detailFundament->fundamentDetailManage->NameValue }}</option>
            @endforeach
            @endif
        </select>

        <input type="text" class="form-control" name="name_to_replace"
            id="for_name_to_replace" placeholder="Nombre de Reemplazo" @if($requestReplacementStaff) value="{{$requestReplacementStaff->name_to_replace}}" @endif>

        <input type="text" class="form-control" name="other_fundament"
            id="for_other_fundament" placeholder="Fundamento..." @if($requestReplacementStaff) value="{{$requestReplacementStaff->other_fundament}}" @endif {{ $otherFundamentInput }}>
    </div>
</fieldset>
