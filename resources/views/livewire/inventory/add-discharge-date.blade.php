<div>
    <div class="row g-2 mb-3">
        <fieldset class="col-md-2">
            <label for="discharge-date" class="form-label">
                Fecha de baja
            </label>
            @if(isset($inventory->discharge_date))
                <input
                    type="text"
                    class="form-control @error('discharge_date') is-invalid @enderror"
                    id="discharge-date"
                    value="{{ $inventory->discharge_date->format('d/m/Y') }}"
                    readonly
                >
            @else
                <input
                    type="date"
                    class="form-control @error('discharge_date') is-invalid @enderror"
                    id="discharge-date"
                    wire:model.live.debounce.1500ms="discharge_date"
                >
                @error('discharge_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            @endif
        </fieldset>

        <fieldset class="col-md-2">
            <label for="act-number" class="form-label">
                Nº de acta
            </label>
            @if(isset($inventory->act_number))
                <input
                    type="text"
                    class="form-control @error('act_number') is-invalid @enderror"
                    id="act-number"
                    value="{{ $inventory->act_number }}"
                    readonly
                >
            @else
                <input
                    type="text"
                    class="form-control @error('act_number') is-invalid @enderror"
                    id="act-number"
                    wire:model.live.debounce.1500ms="act_number"
                >
                @error('act_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            @endif
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
