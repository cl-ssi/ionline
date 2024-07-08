<div>
    @foreach($inventory->movements as $movement)
    <div class="row g-2 mb-3">
        <fieldset class="col-md-3" wire:ignore>
            <label for="responsible-{{ $movement->id }}" class="form-label">
                Responsable
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="responsible-{{ $movement->id }}"
                value="{{ optional($movement->responsibleUser)->full_name }}"
                readonly
            >
        </fieldset>

        {{--
        <fieldset class="col-md-3">
            <label for="using-{{ $movement->id }}" class="form-label">
                Usuario
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="using-{{ $movement->id }}"
                value="{{ optional($movement->usingUser)->full_name }}"
                readonly
            >
        </fieldset>
        --}}

        <fieldset class="col-md-3">
            <label for="place-{{ $movement->id }}" class="form-label">
                Ubicación
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="place-{{ $movement->id }}"
                value="{{ $movement->place?->location->name }}, {{ $movement->place?->name }}"
                readonly
            >
        </fieldset>

        <fieldset class="col-md-2">
            <label for="reception-confirmation-{{ $movement->id }}" class="form-label">
                Fecha de Recepción
            </label>
            <input
                type="text"
                class="form-control form-control-sm @if($movement->reception_date == null) text-danger @endif"
                id="reception-confirmation-{{ $movement->id }}"
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
                id="{{ $movement->id }}"
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

    
    @can('Inventory: edit act reception confirmation')
        @livewire('inventory.movement-mgr', [
            'inventoryMovement' => $movement
        ], key($movement->id))
    @endcan
    

    @endforeach
</div>
