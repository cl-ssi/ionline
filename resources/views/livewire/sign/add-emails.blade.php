<div>
    <div class="input-group">
        <div class="input-group-prepend">
            <select
                class="custom-select"
                id="select-option"
                wire:model="typeDestination"
            >
                <option value="email">Correo</option>
                <option value="department">Otro</option>
            </select>
        </div>
        <input
            type="text"
            wire:model.debounce.1500ms="destination"
            id="add-email"
            class="form-control @error('destination') is-invalid @enderror"
            placeholder="Ingresa un destino"
        >
        <div class="input-group-append">
            <button
                class="btn btn-primary"
                wire:target="addEmail"
                wire:loading.attr="disabled"
                wire:click="addEmail"
                title="Agregar"
            >
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    wire:loading
                    wire:target="addEmail"
                    aria-hidden="true"
                >
                </span>

                <span
                    wire:loading.remove
                    wire:target="addEmail"
                >
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </div>
        @error('destination')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
