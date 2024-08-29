<div class="row g-2 mb-3">
    <fieldset class="col-12 col-md-5">
        <label for="">Responsable*</label>
        @livewire('search-select-user', [
            //'selected_id' => $responsable,
            'user' => $responsable,
            'required' => 'required',
            'emit_name' => 'userResponsible',
        ])
        @error('meeting.responsible_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </fieldset>

    <fieldset class="col-12 col-md-5">
        <label for="for-petitioner">Solicitante*</label>
        <input type="text" wire:model="meeting.petitioner" class="form-control">
        @error('meeting.petitioner')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </fieldset>

    <fieldset class="col-12 col-md-2">
        <label for="for-mecanism">Mecanismo*</label>
        <select class="form-control" wire:model="meeting.mecanism">
            <option value=""></option>
            <option>Videoconferencia</option>
            <option>Presencial</option>
        </select>
        @error('meeting.mecanism')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </fieldset>
</div>

<div class="row g-2 mb-3">
    <fieldset class="col-12 col-md-6">
        <label for="for-subject">Asunto*</label>
        <input type="text" wire:model="meeting.subject"
            class="form-control @error('meeting.subject') is-invalid @enderror">
        @error('meeting.subject')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </fieldset>

    <fieldset class="col-12 col-md-2">
        <label for="for-date">Fecha*</label>
        <input type="date" wire:model="meeting.date" class="form-control">
        @error('meeting.date')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </fieldset>

    <fieldset class="col-12 col-md-2">
        <label for="for-start_at">Hora inicio</label>
        <input type="time" wire:model="meeting.start_at" class="form-control">
        @error('meeting.start_at')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </fieldset>

    <fieldset class="col-12 col-md-2">
        <label for="for-end_at">Hora término</label>
        <input type="time" wire:model="meeting.end_at" class="form-control">
        @error('meeting.end_at')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </fieldset>
</div>

<div class="row g-2 mb-3">
    <fieldset class="col-md-12 col-12">
        <label for="exponents" class="form-label">
            {{ __('Exponentes') }} (Relacionado con el solicitante)
        </label>

        <textarea wire:model="meeting.exponents" 
            rows="6"
            id="exponents"
            class="form-control @error('meeting.exponents') is-invalid @enderror" 
            autocomplete="exponents"></textarea>

        @error('meeting.exponents')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="row g-2 mb-3">
    <fieldset class="col-md-12 col-12">
        <label for="participants" class="form-label">
            {{ __('Participantes') }} (relacionado con el servicio)
        </label>
        @livewire('search-select-user', [
            //            'selected_id' => 'participants',
            'addUsers' => 'true',
            'emit_name' => 'addParticipant',
        ])

        <table class="table table-sm table-bordered">
            <tbody>
                @foreach ($participants as $key => $participant)
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

<div class="row g-2 mb-3">
    <fieldset class="col-md-12 col-12">
        <label for="fot_details" class="form-label">
            {{ __('Detalle') }}
        </label>

        <textarea 
            rows="8"
            id="details" 
            wire:model="meeting.details"
            class="form-control @error('meeting.details') is-invalid @enderror" 
            autocomplete="details"></textarea>

        @error('meeting.details')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="row g-2 mb-3">
    <fieldset class="col-md-12 col-12">
        <label for="compromises" class="form-label">
            {{ __('Compromisos') }}
        </label>
    </fieldset>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Nombre Compromiso</th>
                <th>Fecha compromiso</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($compromises as $key => $compromise)
                <tr>
                    <td>
                        <input type="text" wire:model="compromises.{{ $key }}.name" class="form-control"
                            value="{{ $compromise['name'] }}" required>
                    </td>
                    <td>
                        <input type="date" wire:model="compromises.{{ $key }}.date" class="form-control"
                            value="{{ $compromise['date'] }}" required>
                    </td>
                    <td>
                        <select wire:model="compromises.{{ $key }}.status" class="form-control" required>
                            <option value="">Seleccione estado</option>
                            <option value="pendiente" {{ $compromise['status'] == 'pendiente' ? 'selected' : '' }}>
                                pendiente</option>
                            <option value="en curso" {{ $compromise['status'] == 'en curso' ? 'selected' : '' }}>en
                                curso</option>
                            <option value="terminado" {{ $compromise['status'] == 'terminado' ? 'selected' : '' }}>
                                terminado</option>
                        </select>
                    </td>
                    <td>
                        <button wire:click="removeCompromise({{ $key }})" class="btn btn-danger btn-sm"> <i
                                class="fas fa-trash"></i> </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <fieldset class="col-md-12 col-12">
        <button wire:click="addCompromise" class="btn btn-primary btn-sm">Añadir compromiso</button>
    </fieldset>
</div>


<div class="form-row mb-3">
    <fieldset class="col-md-3 col-4">
        <label for="status" class="form-label">
            {{ __('Estado') }}
        </label>

        <select name="status" id="status" class="form-control @error('meeting.status') is-invalid @enderror">
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
