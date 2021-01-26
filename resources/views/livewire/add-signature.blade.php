<div>
    {{-- @if (session()->has('message'))
        <div class="alert alert-success">
          {{ session('message') }}
        </div>
    @endif --}}

    <label for="for_visators">Agregar visadores en órden</label>

    <div class="form-row">
        <fieldset class="form-group col">
            <select name="visitors[]" class="form-control" wire:model="visators.0">
                @foreach($organizationalUnits as $organizationalUnit)
                <option value="{{$organizationalUnit->id}}">{{$organizationalUnit->name}}</option>
                @endforeach
            </select>
            @error('visators.0') <span class="text-danger error">{{ $message }}</span>@enderror
        </fieldset>

        <fieldset class="form-group col-2">
            <button class="btn text-white btn-info" wire:click.prevent="add({{$i}})">Agregar</button>
        </fieldset>
    </div>

    @foreach($inputs as $key => $value)
        <div class="form-row">
            <fieldset class="form-group col">
                <select name="visitors[]" class="form-control" wire:model="visators.{{ $value }}">
                    @foreach($organizationalUnits as $organizationalUnit)
                    <option value="{{$organizationalUnit->id}}">{{$organizationalUnit->name}}</option>
                    @endforeach
                </select>
                @error('visators.'.$value) <span class="text-danger error">{{ $message }}</span>@enderror
            </fieldset>

            <fieldset class="form-group col-md-2">
                <button class="btn btn-danger" wire:click.prevent="remove({{$key}})">Remover</button>
            </fieldset>

        </div>
    @endforeach
</div>
