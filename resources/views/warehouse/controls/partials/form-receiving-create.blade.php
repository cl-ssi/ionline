<div class="form-row">
    <fieldset class="form-group col-md-4">
        <label for="type-receiving">Tipo de Ingreso</label>
        <select class="form-control custom-select-sm @error('type_reception_id') is-invalid @enderror"
            wire:model.live.debounce.1500ms="type_reception_id" id="type-receiving">
            <option value="">Seleccione un tipo</option>
            <option value="1">Ingreso Normal</option>
            <option value="5">Ajuste de Inventario</option>
        </select>
        @error('type_reception_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-4">
        <label for="date">Fecha de Ingreso</label>
        <input type="date" id="date" class="form-control form-control-sm @error('date') is-invalid @enderror"
            value="{{ old('date', optional($control)->date) }}" wire:model.live.debounce.1500ms="date" required>
        @error('date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col-md-3">
        <label for="origin-id">Origen</label>
        <select class="form-control custom-select-sm @error('origin_id') is-invalid @enderror"
            wire:model.live.debounce.1500ms="origin_id" id="origin-id">
            <option value="">Selecciona un origen</option>
            @foreach ($store->origins as $origin)
                <option value="{{ $origin->id }}"
                    {{ old('mobile_id', optional($control)->origin_id) == $origin->id ? 'selected' : '' }}>
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

    <fieldset class="form-group col-md-3">
        <label for="program-id">Programa</label>
        <select class="form-control custom-select-sm @error('program_id') is-invalid @enderror"
            wire:model.live.debounce.1500ms="program_id" id="program-id">
            <option value="">Sin programa</option>
            @foreach ($programs as $program)
                <option value="{{ $program->id }}"
                    {{ old('mobile_id', optional($control)->program_id) == $program->id ? 'selected' : '' }}>
                    {{ $program->period }} - {{ $program->name }}
                </option>
            @endforeach
        </select>
        @error('program_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-6">
        <label for="note">Nota</label>
        <input type="text" id="note" class="form-control form-control-sm @error('note') is-invalid @enderror"
            value="{{ optional($control)->name }}" wire:model.live.debounce.1500ms="note">
        @error('note')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col-md-4">
        <label for="reception-visator">Visador Ingreso Bodega</label>
        <input type="text" id="reception-visator" class="form-control form-control-sm"
            value="{{ auth()->user()->full_name ?? 'No posee Visador Ingreso Bodega' }}" readonly>
    </fieldset>

    <fieldset class="form-group col-md-4">
        <label for="technical-signer-id" class="form-label">Visador Recepción Técnica</label>
        @livewire('users.search-user', [
            'placeholder' => 'Ingrese un nombre',
            'eventName' => 'technicalSignerId',
            'tagId' => 'technical-signer-id',
            'smallInput' => true,
            'bt' => 4,
        ])

        <input class="form-control @error('technical_signer_id') is-invalid @enderror" type="hidden">

        @error('technical_signer_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>


    <fieldset class="form-group col-md-4">
        <div class="form-group">
            <div class="form-row">
                <label for="require-contract-manager-visation">Requiere Visación del Administrador de Contrato</label>
            </div>
            <div class="form-check text-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                        wire:model.live="require_contract_manager_visation"
                        id="require-contract-manager-visation">
                </div>
            </div>
        </div>
    </fieldset>



</div>
