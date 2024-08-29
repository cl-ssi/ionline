<div class="form-row mt-3">
    <fieldset class="form-group col-md-4">
        <label for="module">Módulo</label>
        <input
            type="text"
            class="form-control @error('module') is-invalid @enderror"
            id="module"
            wire:model.live.debounce.1500ms="module"
            placeholder="Ingresa el módulo"
            required
        >
        @error('module')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-4">
        <label for="parameter">Parámetro</label>
        <input
            type="text"
            class="form-control @error('parameter_field') is-invalid @enderror"
            id="parameter"
            wire:model.live.debounce.1500ms="parameter_field"
            placeholder="Ingresa el parámetro"
            required
        >
        @error('parameter_field')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-4">
        <label for="value">Valor</label>
        <input
            type="text"
            class="form-control @error('value') is-invalid @enderror"
            id="value"
            wire:model.live.debounce.1500ms="value"
            placeholder="Ingresa el valor"
            required
        >
        @error('value')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row">

    <fieldset class="form-group col-md-6">
        <label for="establishment_id">Establecimiento</label>
        <!-- <input
            type="text"
            class="form-control @error('establishment_id') is-invalid @enderror"
            id="establishment_id"
            wire:model.live.debounce.1500ms="establishment_id"
            placeholder="Selecciona el establecimiento"
            required
        > -->
        <select class="form-control" wire:model="establishment_id">
            @foreach($establishments as $establishment)
                <option value="{{$establishment->id}}" @selected($establishment->id == $establishment_id) required>{{$establishment->name}}</option>
            @endforeach
        </select>
        @error('establishment_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-6">
        <label for="description">Descripción</label>
        <input
            type="text"
            class="form-control @error('description') is-invalid @enderror"
            id="description"
            wire:model.live.debounce.1500ms="description"
            placeholder="Ingresa el descripción"
            required
        >
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>
