<div class="mt-3">
    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-4">
            <label for="for_user_responsible_id">Nombre Funcionario responsable:</label>
            @livewire('search-select-user', [
                'selected_id'   => 'user_responsible_id',
                'required'      => 'required',
                'emit_name'     => 'searchedUser',
                'user'          => $meetingToEdit->userResponsible ?? null
            ])
        </fieldset>

        <fieldset class="form-group col-12 col-sm-2">
            <label for="for_date">Fecha Reunión</label>
            <input type="date" class="form-control" wire:model.defer="date" id="for_date">
            @error('from') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_type">Tipo</label>
            <select class="form-select" wire:model.defer="type">
                <option value="">Seleccione</option>
                <option value="extraordinaria">Extraordinaria</option>
                <option value="no extraordinaria">No extraordinaria</option>
                <option value="lobby">Lobby</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_subject">Asunto</label>
            <input class="form-control" type="text" autocomplete="off" wire:model.defer="subject">
        </fieldset>
    </div>
    
    <div class="row g-3 mb-3">
        <fieldset class="col-12 col-md-4">
            <label for="for-mecanism">Medio</label>
            <select class="form-select" wire:model.defer="mechanism" required>
                <option value="">Seleccionar</option>
                <option value="videoconferencia">Videoconferencia</option>
                <option value="presencial">Presencial</option>
            </select>
        </fieldset>

        <fieldset class="col-12 col-md-2">
            <label for="for-start_at">Hora inicio</label>
            <input type="time" class="form-control" wire:model.defer="start_at" >
        </fieldset>

        <fieldset class="col-12 col-md-2">
            <label for="for-end_at">Hora término</label>
            <input type="time" class="form-control" wire:model.defer="end_at">
        </fieldset>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <button wire:click="save" class="btn btn-primary float-end" type="button">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>
</div>
