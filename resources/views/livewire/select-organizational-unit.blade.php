<div class="{{ !$mobile ? 'input-group' : '' }} mb-3">
    <select
        class="custom-select form-select"
        id="establishment_id"
        name="establishment_id"
        wire:model.live="establishment_id"
        wire:change="loadOus"
        required
        {{ $readonlyEstablishment ? 'disabled' : '' }}
    >
        <option value="0"></option>
        @foreach ($establishments->sortBy('official_name') as $establishment)
            <option value="{{ $establishment->id }}">
                {{ $establishment->official_name }}
            </option>
        @endforeach
    </select>

    <select
        class="form-control form-select {{ $selectpicker ? 'selectpicker' : '' }}"
        id="{{ $selected_id }}"
        name="{{ $selected_id }}"
        wire:model.live="organizational_unit_id"
        style="font-family:monospace;"
        data-live-search="true"
        id="ou"
        name="to_ou_id"
        data-size="10"
        {{ $required ? 'required' : '' }}
    >
        <option value=""></option>
        @foreach ($ous as $ou)
            <option value="{{ $ou['id'] }}">
                {{ $ou['name'] }}
            </option>
        @endforeach
    </select>

    @if (!$selectpicker)
        <input
            type="text"
            class="form-control"
            placeholder="Filtrar listado de unidades"
            wire:model.blur="filter"
        >
    @endif
</div>
