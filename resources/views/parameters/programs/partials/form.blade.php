<div class="form-row mt-3">
    <fieldset class="form-group col-md-5">
        <label for="name">Nombre</label>
        <input
            type="text"
            class="form-control @error('name') is-invalid @enderror"
            id="name"
            wire:model.debounce.1000ms="name"
            placeholder="Ingresa el nombre"
            value="{{ old('name', optional($program)->name) }}"
            required
        >
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-2">
        <label for="alias">Alias</label>
        <input
            type="text"
            class="form-control @error('alias') is-invalid @enderror"
            id="alias"
            wire:model.debounce.1000ms="alias"
            placeholder="Ingresa el alias o nombre corto"
            value="{{ old('alias', optional($program)->alias) }}"
            required
        >
        @error('alias')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-1">
        <label for="folio">Folio</label>
        <input
            type="text"
            class="form-control @error('folio') is-invalid @enderror"
            id="folio"
            wire:model.debounce.1000ms="folio"
            placeholder="Nº folio"
            value="{{ old('folio', optional($program)->folio) }}"
            required
        >
        @error('folio')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-2">
        <label for="start-date">Fecha Inicio</label>
        <input
            type="date"
            class="form-control @error('start_date') is-invalid @enderror"
            id="start-date"
            wire:model.debounce.1000ms="start_date"
            value="{{ old('start_date', optional($program)->start_date) }}"
            required
        >
        @error('start_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-2">
        <label for="end-date">Fecha Fin</label>
        <input
            type="date"
            class="form-control @error('end_date') is-invalid @enderror"
            id="end-date"
            wire:model.debounce.1000ms="end_date"
            value="{{ old('end_date', optional($program)->end_date) }}"
            required
        >
        @error('end_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col-md-12">
        <label for="description">Descripción</label>
        <input
            type="text"
            class="form-control @error('description') is-invalid @enderror"
            id="description"
            wire:model.debounce.1000ms="description"
            value="{{ old('description', optional($program)->description) }}"
            required
        >
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>
