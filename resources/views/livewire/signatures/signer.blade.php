<div class="form-row">
    <fieldset class="form-group col-6">
        <label>Firmante - Unidad Organizacional</label>
        <select name="organizationalUnit" wire:model="organizationalUnit" class="form-control">
            <option value=''></option>
            @foreach($organizationalUnits as $ou)
                <option value={{ $ou->id }}>{{ $ou->name }}</option>
            @endforeach
        </select>
    </fieldset>
    @if(count($users) > 0)
        <fieldset class="form-group col-6">
            <label>Usuario</label>
            <select name="user" wire:model="user" class="form-control">
                <option value=''></option>
                @foreach($users as $user)
                    <option value={{ $user->id }}>{{ $user->fullName }}</option>
                @endforeach
            </select>
        </fieldset>
    @endif
</div>
