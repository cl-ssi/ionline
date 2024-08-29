<fieldset class="form-group col-sm-4">
    <label for="profiles">Estamento / Grado</label>
    <div class="input-group">
        <select name="profile_manage_id" id="for_profile_manage_id" class="form-control" wire:model.live="selectedProfile" required>
            <option value="">Seleccione...</option>
            @foreach($profiles as $profile)
              <option value="{{ $profile->id }}" @if($requestReplacementStaff) {{ ($requestReplacementStaff->profile_manage_id == $profileSelected) ? 'selected' : '' }} @endif >{{ $profile->name }}</option>
            @endforeach
        </select>

        <input type="degree" class="form-control" name="degree" id="for_degree" value="{{ $degree }}" readonly>
    </div>
</fieldset>
