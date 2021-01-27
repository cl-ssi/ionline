<div class="col-8">
    {{-- @if (session()->has('message'))
        <div class="alert alert-success">
          {{ session('message') }}
        </div>
    @endif --}}

    <label for="for_visators">Agregar visadores en órden</label>

    <div class="form-row">
        <fieldset class="form-group col">
            <select name="visitors[]" class="form-control" wire:model="visators.0" wire:change="getusers">
                <option value=""></option>
                @foreach($organizationalUnits as $organizationalUnit)
                <option value="{{$organizationalUnit->id}}">{{$organizationalUnit->name}}</option>
                @endforeach
            </select>
            @error('visators.0') <span class="text-danger error">{{ $message }}</span>@enderror
        </fieldset>
        @if($users)
            @php print_r($users) @endphp
        @endif
        <fieldset class="form-group col">
            <select name="signers[]" class="form-control" wire:model="signers.0">
                <option value=""></option>
                @foreach((array) $users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('signers.0') <span class="text-danger error">{{ $message }}</span>@enderror
        </fieldset>

        <fieldset class="form-group col-2">
            <button class="btn text-white btn-info btn-block" wire:click.prevent="add({{$i}})">Agregar</button>
        </fieldset>
    </div>

    @foreach($inputs as $key => $value)
        <div class="form-row">
            <fieldset class="form-group col">
                <select name="visitors[]" class="form-control" wire:model="visators.{{ $value }}">
                    <option value=""></option>
                    @foreach($organizationalUnits as $organizationalUnit)
                    <option value="{{$organizationalUnit->id}}">{{$organizationalUnit->name}}</option>
                    @endforeach
                </select>
                @error('visators.'.$value) <span class="text-danger error">{{ $message }}</span>@enderror
            </fieldset>

            <fieldset class="form-group col-md-2">
                <button class="btn btn-danger btn-block" wire:click.prevent="remove({{$key}})">Remover</button>
            </fieldset>

        </div>
    @endforeach
</div>
