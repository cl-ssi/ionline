<div>
    <div class="row g-2 mb-3">
        <fieldset class="col-md-3">
            <label for="user-responsible-id" class="form-label">Responsable</label>

            @livewire('users.search-user', [
                'smallInput' => true,
                'placeholder' => 'Ingrese un nombre',
                'eventName' => 'myUserResponsibleId',
                'tagId' => 'user-responsible-id',
                'bt' => 5,
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

        {{--
        <fieldset class="col-md-3">
            <label for="user-using-id" class="form-label">Usuario</label>

            @livewire('users.search-user', [
                'smallInput' => true,
                'placeholder' => 'Ingrese un nombre',
                'eventName' => 'myUserUsingId',
                'tagId' => 'user-using-id',
                'bt' => 5,
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
        --}}

        <fieldset class="col-md-3">
            <label for="place-id" class="form-label">
                Ubicación
            </label>

            @livewire('places.find-place', [
                'smallInput' => true,
                'tagId' => 'place-id',
                'placeholder' => 'Ingrese una ubicación o cod. arq.',
                'establishment' => auth()->user()->organizationalUnit->establishment,
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
                Instalación <small>(opcional)</small>
            </label>
            <input
                type="date"
                class="form-control form-control-sm @error('installation_date') is-invalid @enderror"
                id="installation-date"
                wire:model.live.debounce.1500ms="installation_date"
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
                class="btn btn-sm btn-primary form-control"
                title="Agregar"
                wire:click="addMovement"
                wire:loading.attr="disabled"
                wire:target="addMovement"
                @if(($inventory->number == null) || ($inventory->act_number != null) || ($inventory->lastMovement && $inventory->lastMovement->reception_date == null))
                    disabled
                @endif
            >
                <span
                    wire:loading.remove
                    wire:target="addMovement"
                >
                    <i class="fas fa-plus"></i>
                </span>

                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    wire:loading
                    wire:target="addMovement"
                    aria-hidden="true"
                >
                </span>
            </button>
        </div>
    </div>
</div>
