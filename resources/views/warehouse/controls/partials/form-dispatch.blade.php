<div class="form-row">
    @if($mode == 'create')
        <div class="form-group col-md-12">
            <label class="font-weigth-bold mr-2">Tipo de Egreso:</label>
            @foreach($typeDispatches as $type)
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input"
                    type="radio"
                    wire:model.live.debounce.800ms="type_dispatch_id"
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
                class="form-control form-control-sm"
                value="{{ optional($control->typeDispatch)->name }}"
                id="type-dispatch"
                readonly
            >
        </fieldset>
    @endif
</div>

<div class="form-row">
    <fieldset class="form-group col-md-2">
        <label for="date">Fecha Egreso</label>
        <input
            type="date"
            id="date"
            class="form-control form-control-sm @error('date') is-invalid @enderror"
            value="{{ old('date', optional($control)->date) }}"
            wire:model.live.debounce.1500ms="date"
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
                class="form-control form-control-sm @error('program_id') is-invalid @enderror"
                wire:model.live.debounce.1500ms="program_id"
                id="program-id"
            >
                <option value="">Sin programa</option>
                @foreach($programs as $program)
                    <option
                        value="{{ $program->id }}"
                        {{ old('mobile_id', optional($control)->program_id) == $program->id ? 'selected' : '' }}
                    >
                        {{ $program->period }} - {{ $program->name }}
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
                class="form-control form-control-sm"
                value="{{ $control->program_name }}"
                readonly
            >
        @endif
    </fieldset>
</div>

@if($type_dispatch_id == \App\Models\Warehouse\TypeDispatch::internal())
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="establishment-id">Establecimiento</label>
            @livewire('establishment-search', [
                'tagId'         => 'establishment-id',
                'placeholder'   => 'Ingrese un establecimiento',
                'smallInput'    => true,
            ])
        </div>

        <div class="form-group col-md-7">
            <label for="organizational-unit-id">Unidad Organizacional</label>
            @livewire('organizational-unit-search', [
                'tagId'         => 'organizational-unit-id',
                'placeholder'   => 'Ingrese una unidad organizacional',
                'component'     => ($mode == 'create') ? 'warehouse.control.control-create' : 'warehouse.control.control-edit',
                'event'         => 'organizationalId',
                'smallInput'    => true,
            ])
            <input
                class="form-control @error('organizational_unit_id') is-invalid @enderror"
                type="hidden"
            >
            @error('organizational_unit_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
@endif

<div class="form-row">
    @switch($type_dispatch_id)
        @case(\App\Models\Warehouse\TypeDispatch::external())
            <fieldset class="form-group col-md-4">
                <label for="destination-id">Destino</label>
                <select
                    class="form-control form-control-sm @error('destination_id') is-invalid @enderror"
                    wire:model.live.debounce.1500ms="destination_id"
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
                        class="form-control form-control-sm @error('store_destination_id') is-invalid @enderror"
                        wire:model.live.debounce.1500ms="store_destination_id"
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
                        class="form-control form-control-sm"
                        id="store-destination-id"
                        value="{{ optional($control->destinationStore)->name }}"
                        readonly
                    >
                @endif
            </fieldset>
            @break
        @default
    @endswitch

    <fieldset class="form-group col-md-8">
        <label for="note">Nota</label>
        <input
            type="text"
            id="note"
            class="form-control form-control-sm @error('note') is-invalid @enderror"
            value="{{ optional($control)->name }}"
            wire:model.live.debounce.1500ms="note"
            required
        >
        @error('note')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>
