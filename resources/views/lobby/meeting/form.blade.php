<div class="form-row mb-3">
    <fieldset class="col-12 col-md-5">
        <label for="">Responsable*</label>
        @livewire('search-select-user', ['selected_id' => 'responsible_id', 'required' => 'required'])
        @error('meeting.responsible_id') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="col-12 col-md-5">
        <label for="for-petitioner">Solicitante*</label>
        <input type="text" wire:model.defer="meeting.petitioner" class="form-control">
        @error('meeting.petitioner') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="col-12 col-md-2">
        <label for="for-mecanism">Mecanismo*</label>
        <select class="form-control" wire:model.defer="meeting.mecanism">
            <option value=""></option>
            <option>Videoconferencia</option>
            <option>Precencial</option>
        </select>
        @error('meeting.mecanism') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
</div>

<div class="form-row mb-3">
    <fieldset class="col-12 col-md-6">
        <label for="for-subject">Asunto*</label>
        <input type="text" wire:model.defer="meeting.subject" class="form-control @error('meeting.subject') is-invalid @enderror">
        @error('meeting.subject') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="col-12 col-md-2">
        <label for="for-date">Fecha*</label>
        <input type="date" wire:model.defer="meeting.date" class="form-control">
        @error('meeting.date') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="col-12 col-md-2">
        <label for="for-start_at">Hora inicio</label>
        <input type="time" wire:model.defer="meeting.start_at" class="form-control">
        @error('meeting.start_at') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="col-12 col-md-2">
        <label for="for-end_at">Hora término</label>
        <input type="time" wire:model.defer="meeting.end_at" class="form-control">
        @error('meeting.end_at') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
</div>

<div class="form-row mb-3">
    <fieldset class="col-md-12 col-12">
        <label for="exponents" class="form-label">
            {{ __('Exponentes') }} (Relacionado con el solicitante)
        </label>
        
        <textarea wire:model.defer="meeting.exponents" id="exponents" 
            class="form-control @error('meeting.exponents') is-invalid @enderror"
            autocomplete="exponents"></textarea>
        
        @error('meeting.exponents')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row mb-3">
    <fieldset class="col-md-12 col-12">
        <label for="participants" class="form-label">
            {{ __('Participantes') }} (relacionado con el servicio)
        </label>
        @livewire('search-select-user', ['selected_id' => 'participants', 'addUsers' => 'true'])

        <table class="table table-sm table-bordered">
            <tbody>
                @foreach($participants as $key => $participant)                    
                <tr>
                    <td>{{ $participant['name'] }}</td>
                    <td>{{ $participant['position'] }}</td>
                    <td>{{ $participant['organizationalUnit'] }}</td>
                    <td>{{ $participant['establishment'] }}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" wire:click="removeParticipant({{ $key }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @error('meeting.participants')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row mb-3">
    <fieldset class="col-md-12 col-12">
        <label for="fot_details" class="form-label">
            {{ __('Detalle') }}
        </label>
        
        <textarea id="details" wire:model.defer="meeting.details" 
            class="form-control @error('meeting.details') is-invalid @enderror"
            autocomplete="details"></textarea>
        
        @error('meeting.details')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row mb-3">
    <fieldset class="col-md-2 col-4">
        <label for="status" class="form-label">
            {{ __('Estado') }}
        </label>
        
        <select name="status" id="status"
            class="form-control @error('meeting.status') is-invalid @enderror">
            <option value="0">Pendiente</option>
            <option value="1">Terminada</option>

        </select>
        
        @error('meeting.status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

</div>