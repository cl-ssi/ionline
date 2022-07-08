<div>
    <div class="form-row mb-3">
        <fieldset class="col-md-3">
            <label class="form-label">Responsable</label>

            @livewire('users.search-user', [
                'smallInput' => true,
                'placeholder' => 'Ingrese un nombre',
                'eventName' => 'myUserResponsibleId'
            ])

            <input
                class="form-control @error('user_responsible_id') is-invalid @enderror"
                type="hidden"
            >

            @error('user_responsible_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-3">
            <label class="form-label">Usuario</label>

            @livewire('users.search-user', [
                'smallInput' => true,
                'placeholder' => 'Ingrese un nombre',
                'eventName' => 'myUserUsingId'
            ])

            <input
                class="form-control @error('user_using_id') is-invalid @enderror"
                type="hidden"
            >

            @error('user_using_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-3">
            <label class="form-label">
                Ubicación
            </label>

            @livewire('places.find-place', [
                'smallInput' => true,
                'placeholder' => 'Ingrese una ubicación'
            ])

            <input
                class="form-control @error('place_id') is-invalid @enderror"
                type="hidden"
            >
            @error('place_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-2">
            <label for="installation-date" class="form-label">
                Instalación
            </label>
            <input
                type="date"
                class="form-control form-control-sm @error('installation_date') is-invalid @enderror"
                id="installation-date"
                wire:model="installation_date"
            >
            @error('installation_date')
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
                class="btn btn-sm btn-primary btn-block"
                title="Agregar"
                wire:click="addMovement"
            >
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
</div>
