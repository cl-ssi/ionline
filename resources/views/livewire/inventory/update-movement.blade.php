<div>
    @foreach($inventory->movements as $movement)
    <div class="form-row mb-3">
        <fieldset class="col-md-3" wire:ignore>
            <label for="responsible" class="form-label">
                Responsable
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="responsible"
                value="{{ optional($movement->responsibleUser)->full_name }}"
                readonly
            >
        </fieldset>

        <fieldset class="col-md-3">
            <label for="using" class="form-label">
                Usuario
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="using"
                value="{{ optional($movement->usingUser)->full_name }}"
                readonly
            >
        </fieldset>

        <fieldset class="col-md-3">
            <label for="place" class="form-label">
                Ubicación
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="place"
                value="{{ $movement->place->location->name }}, {{ $movement->place->name }}"
                readonly
            >
        </fieldset>

        <fieldset class="col-md-2">
            <label for="reception-confirmation" class="form-label">
                Fecha de Recepción
            </label>
            <input
                type="text"
                class="form-control form-control-sm @if($movement->reception_date == null) text-danger @endif"
                id="reception-confirmation"
                value="{{ ($movement->reception_date) ? $movement->reception_date : 'No Confirmada' }}"
                readonly
            >
        </fieldset>

        <div class="col-md-1">
            <label class="form-label">
                &nbsp;
            </label>
            <br>
            <button
                class="btn btn-sm btn-danger btn-block"
                title="Eliminar"
                wire:click="deleteMovement({{ $movement }})"
                wire:loading.attr="disabled"
                wire:target="deleteMovement"
                @if($movement->reception_date) disabled @endif
            >
                <span
                    wire:loading.remove
                    wire:target="deleteMovement"
                >
                    <i class="fas fa-trash"></i>
                </span>

                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    wire:loading
                    wire:target="deleteMovement"
                    aria-hidden="true"
                >
                </span>
            </button>
        </div>
    </div>
    @livewire('inventory.movement-mgr', ['inventoryMovement' => $movement])
    @endforeach
</div>
