<div>
    <div class="form-row mb-3">
        <fieldset class="col-md-2">
            <label for="discharge-date" class="form-label">
                Fecha de baja
            </label>
            <input
                type="date"
                class="form-control @error('discharge_date') is-invalid @enderror"
                id="discharge-date"
                wire:model.debounce.1500ms="discharge_date"
            >
            @error('discharge_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-2">
            <label for="act-number" class="form-label">
                Nº de acta
            </label>
            <input
                type="text"
                class="form-control @error('act_number') is-invalid @enderror"
                id="act-number"
                wire:model.debounce.1500ms="act_number"
            >
            @error('act_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <div class="col-md-1">
            <label class="form-label">
                &nbsp;
            </label>
            <button
                class="btn btn-danger form-control"
                title="Guardar"
                wire:click="save"
                wire:loading.attr="disabled"
                @if($inventory->act_number != null)
                    disabled
                @endif
            >
                <span
                    wire:loading.remove
                    wire:target="save"
                >
                    <i class="fas fa-save"></i>
                </span>

                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    wire:loading
                    wire:target="save"
                    aria-hidden="true"
                >
                </span>
            </button>
        </div>
    </div>
</div>
