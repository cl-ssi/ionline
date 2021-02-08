<div class="form-row">
    <fieldset class="form-group col-6">
        <label>Firmante - Unidad Organizacional</label>
        <select name="ou_id_signer" for="for_ou_id_signer" wire:model="organizationalUnit" class="form-control" required>
            <option value=''></option>
            @foreach($organizationalUnits as $ou)
                <option value={{ $ou->id }}>{{ $ou->name }}</option>
            @endforeach
        </select>
    </fieldset>
    @if(count($users) > 0)
        <fieldset class="form-group col-6">
            <label>Usuario</label>
            <select name="user_signer" wire:model="user" class="form-control">
                <option value=''></option>
                @foreach($users as $user)
                    <option value={{ $user->id }}>{{ $user->fullName }}</option>
                @endforeach
            </select>
        </fieldset>
    @endif
</div>
