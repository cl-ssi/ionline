<div class="input-group mb-3">
    <select class="custom-select" id="establishment_id" wire:model="establishment_id" wire:change="loadOus">
        <option></option>
        @foreach($establishments->sortBy('name') as $establishment)
            <option value="{{ $establishment->id }}"> {{ $establishment->name }}</option>
        @endforeach
    </select>

    <select class="custom-select"
        id="{{ $selected_id }}" 
        name="{{ $selected_id }}"
        wire:model="organizational_unit_id"
        style="font-family:monospace;"
        required>
        
        <option></option>
        @foreach($ous as $ou)
            <option value="{{ $ou['id'] }}">{{ $ou['name'] }}</option>
        @endforeach
    </select>
    
    <input type="text" class="form-control" placeholder="Filtrar por nombre" wire:model.debounce400ms="filter">
</div>