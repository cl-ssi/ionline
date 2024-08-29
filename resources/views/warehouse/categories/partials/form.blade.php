<div class="form-row mt-3">
    <fieldset class="form-group col-md-4">
        <label for="store-id">Bodega</label>
        <input
            type="text"
            id="store-id"
            class="form-control"
            value="{{ optional($store)->name }}"
            disabled
        >
    </fieldset>

    <fieldset class="form-group col-md-4">
        <label for="name">Nombre</label>
        <input
            type="text"
            class="form-control @error('name') is-invalid @enderror"
            id="name"
            wire:model.live.debounce.1500ms="name"
            placeholder="Ingresa el nombre"
            value="{{ old('name', optional($category)->name) }}"
            required
        >
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>
