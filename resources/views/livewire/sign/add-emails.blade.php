<div>
    <div class="input-group">
        <input
            type="text"
            wire:model.debounce.1500ms="email"
            id="add-email"
            class="form-control @error('email') is-invalid @enderror"
            placeholder="Ingresa una direccion de correo"
        >
        <div class="input-group-append">
            <button
                class="btn btn-primary"
                wire:target="addEmail"
                wire:loading.attr="disabled"
                wire:click="addEmail"
            >
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    wire:loading
                    wire:target="addEmail"
                    aria-hidden="true"
                >
                </span>

                <span wire:loading.remove wire:target="addEmail">
                    <i class="fas fa-plus"></i>
                </span>

                Agregar
            </button>
        </div>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    {{-- @json($emails) --}}
</div>
