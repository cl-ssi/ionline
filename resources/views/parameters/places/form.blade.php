<div class="row g-2 mb-3">
    <fieldset class="form-group col-md-3 col-sm-12">
        <label for="for_name">Nombre*</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="for_name"
            placeholder="Ej. Oficina 211" wire:model.live.debounce.1500ms="name" required>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-3 col-sm-12">
        <label for="for_description">Descripción</label>
        <input type="text" class="form-control @error('description') is-invalid @enderror" id="for_description"
            placeholder="Opcional" wire:model.live.debounce.1500ms="description">
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-3 col-sm-12">
        <label for="for_location_id">Edificio</label>
        <select id="for_location_id" class="form-control @error('location_id') is-invalid @enderror"
            wire:model.live.debounce.1500ms="location_id" required>
            <option value="">Selecciona un edificio</option>
            @foreach ($locations as $location)
                <option value="{{ $location->id }}">{{ $location->name }}</option>
            @endforeach
        </select>
        @error('location_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
    <fieldset class="form-group col-md-3 col-sm-12">
        <label for="for_architectural_design_code">Código Diseño Arquitectura</label>
        <input type="text" class="form-control @error('architectural_design_code') is-invalid @enderror" id="for_architectural_design_code"
            placeholder="Opcional" wire:model.live.debounce.1500ms="architectural_design_code">
        @error('architectural_design_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>
