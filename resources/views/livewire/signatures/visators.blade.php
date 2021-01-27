<div class="">
    <fieldset class="form-group col-2">
        <label for="">&nbsp;</label>
        <button class="btn text-white btn-info btn-block" wire:click.prevent="add({{$i}})">Agregar</button>
    </fieldset>

@foreach($inputs as $key => $value)
<div class="form-row">
    <fieldset class="form-group col-5">
        <label>Visador - Unidad Organizacional</label>
        <select name="organizationalUnit" wire:model="organizationalUnit.{{ $value }}" class="form-control">
            <option value=''></option>
            @foreach($organizationalUnits as $ou)
                <option value={{ $ou->id }}>{{ $ou->name }}</option>
            @endforeach
        </select>
    </fieldset>
    <fieldset class="form-group col-5">
    @if(count($users) > 0)

        <label>Usuario</label>
        <select name="user" wire:model="user" class="form-control">
            <option value=''></option>
            @foreach($users as $user)
                <option value={{ $user->id }}>{{ $user->fullName }}</option>
            @endforeach
        </select>

    @endif
    </fieldset>
    <fieldset class="form-group col-md-2">
        <label for="">&nbsp;</label>
        <button class="btn btn-danger btn-block" wire:click.prevent="remove({{$key}})">Remover</button>
    </fieldset>
</div>
@endforeach
</div>
