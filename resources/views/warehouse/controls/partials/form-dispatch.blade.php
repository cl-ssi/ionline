<div class="form-row">
    @if($mode == 'create')
        <div class="form-group col-md-12">
            <label class="font-weigth-bold mr-2">Tipo de Egreso:</label>
            @foreach($typeDispatches as $type)
            <div class="form-check form-check-inline">
                <input class="form-check-input"
                    type="radio"
                    wire:model="type_dispatch_id"
                    id="option-{{ $type->id }}"
                    value="{{ $type->id }}"
                >
                <label class="form-check-label" for="option-{{ $type->id }}">
                    {{ $type->name }}
                </label>
            </div>
            @endforeach
        </div>
    @endif

    @if($mode == 'edit')
        <fieldset class="form-group col-md-4">
            <label for="type-dispatch">Tipo de Egreso</label>
            <input
                type="text"
                class="form-control"
                value="{{ optional($control->typeDispatch)->name }}"
                id="type-dispatch"
                readonly
            >
        </fieldset>
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
        @if($mode == 'create')
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
        @else
            <input
                type="text"
                class="form-control"
                value="{{ $control->program_name }}"
                readonly
            >
        @endif
    </fieldset>

    @switch($type_dispatch_id)
        @case(\App\Models\Warehouse\TypeDispatch::dispatch())
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
            @break
        @case(\App\Models\Warehouse\TypeDispatch::sendToStore())
            <fieldset class="form-group col-md-4">
                <label for="store-destination-id">Bodega Destino</label>
                @if($mode == 'create')
                    <select
                        class="form-control @error('store_destination_id') is-invalid @enderror"
                        wire:model="store_destination_id"
                        id="store-destination-id"
                    >
                        <option value="">Selecciona una bodega destino</option>
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                        @endforeach
                    </select>
                    @error('store_destination_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                @else
                    <input
                        type="text"
                        class="form-control"
                        id="store-destination-id"
                        value="{{ optional($control->destinationStore)->name }}"
                        readonly
                    >
                @endif
            </fieldset>
            @break
        @default
    @endswitch
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
