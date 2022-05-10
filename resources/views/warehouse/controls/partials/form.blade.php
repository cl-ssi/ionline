<div class="form-row">
    @if($showInputAdjustInventory)
        <div class="form-group col-md-12">
            <label class="font-weigth-bold mr-2">Tipo de Egreso:</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input"
                    type="radio"
                    wire:model="type_dispatch"
                    id="option-1"
                    value="1"
                >
                <label class="form-check-label" for="option-1">Ajuste Inventario</label>
            </div>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input"
                    type="radio"
                    wire:model="type_dispatch"
                    id="option-2"
                    value="0"
                >
                <label class="form-check-label" for="option-2">Egreso Común</label>
            </div>
        </div>
    @endif

    @if($type == 'dispatch')
        @if($disabledAdjustInventory)
            <fieldset class="form-group col-md-4">
                <label for="type-dispatch">Tipo de Egreso</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ $control->type_dispatch }}"
                    id="type-dispatch"
                    readonly
                >
            </fieldset>
        @endif
    @endif
</div>

<div class="form-row">
    <fieldset class="form-group col-md-2">
        <label for="date">Fecha</label>
        <input
            type="date"
            id="date"
            class="form-control @error('date') is-invalid @enderror"
            value="{{ old('date', optional($control)->date) }}"
            wire:model="date"
            required
        >
        @error('date')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-5">
        <label for="program-id">Programa</label>
        @if($disableProgram)
            <input
                type="text"
                class="form-control"
                value="{{ $control->program_name }}"
                readonly
            >

        @else
            <select
                class="form-control @error('program_id') is-invalid @enderror"
                wire:model="program_id"
                id="program-id"
            >
                <option value="">Sin programa</option>
                @foreach($programs as $program)
                    <option
                        value="{{ $program->id }}"
                        {{ old('mobile_id', optional($control)->program_id) == $program->id ? 'selected' : '' }}
                    >
                        {{ $program->name }}
                    </option>
                @endforeach
            </select>
            @error('program_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        @endif
    </fieldset>

    @if($type == 'receiving')
        <fieldset class="form-group col-md-5">
            <label for="origin-id">Origen</label>
            <select
                class="form-control @error('origin_id') is-invalid @enderror"
                wire:model="origin_id" id="origin-id"
            >
                <option value="">Selecciona un origen</option>
                @foreach($store->origins as $origin)
                    <option
                        value="{{ $origin->id }}"
                        {{ old('mobile_id', optional($control)->origin_id) == $origin->id ? 'selected' : '' }}
                    >
                        {{ $origin->name }}
                    </option>
                @endforeach
            </select>
            @error('origin_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    @else
        @if($type_dispatch == 0)
            <fieldset class="form-group col-md-4">
                <label for="destination-id">Destino</label>
                <select
                    class="form-control @error('destination_id') is-invalid @enderror"
                    wire:model="destination_id"
                    id="destination-id"
                >
                    <option value="">Selecciona un destino</option>
                    @foreach($store->destinations as $destination)
                        <option value="{{ $destination->id }}">{{ $destination->name }}</option>
                    @endforeach
                </select>
                @error('destination_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>
        @endif
    @endif
</div>

<div class="form-row">
    <fieldset class="form-group col-md-12">
        <label for="note">Nota</label>
        <input
            type="text"
            id="note"
            class="form-control @error('note') is-invalid @enderror"
            value="{{ optional($control)->name }}"
            wire:model="note"
            required
        >
        @error('note')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>
