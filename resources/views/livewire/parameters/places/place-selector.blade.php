<div class="form-row">
    <div class="col-4">
        <label for="estab">Establecimiento</label>
        <select wire:model="selectedEstablishment" wire:change="clearInputs" class="form-control">
            <option value=""></option>
            @foreach ($establishments as $est)
            <option value="{{ $est->id }}">{{ $est->official_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-4">
        <label for="estab">Ubicación/Edificio</label>
        <select wire:model="selectedLocation" class="form-control">
            <option value=""></option>
            @foreach ($locations as $location)
                <option value="{{ $location->id }}">{{ $location->name }}</option>
            @endforeach
        </select>    
    </div>

    <div class="col-4">
        <label for="estab">Lugar/Oficina/Box</label>
        <select wire:model="selectedPlace" class="form-control" name="place_id">
            <option value=""></option>
            @foreach ($places as $place)
                <option value="{{ $place->id }}">{{ $place->name }} {{ $place->description }} {{ $place->architectural_design_code }}</option>
            @endforeach
        </select>
    </div>

</div>
