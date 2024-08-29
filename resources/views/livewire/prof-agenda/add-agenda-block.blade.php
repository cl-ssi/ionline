<div>
    <div class="row">

    <fieldset class="form-group col col-md">
        <label for="for_id_deis">Día</label>
        <input type="date" class="form-control" wire:model="date" required>
        @error('date') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_id_deis">Hora de inicio</label>
        <input type="time" class="form-control" wire:model="start_hour" value="" step="3600000" required>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_id_deis">Hora de término</label>
        <input type="time" class="form-control" wire:model="end_hour" value="" step="3600000" required>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_duration">Duración</label>
        <select name="duration" wire:model="duration" class="form-control" id="" required>
            <option value=""></option>
            <option value="60">60</option>
            <option value="40">40</option>
            <option value="30">30</option>
            <option value="20">20</option>
        </select>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_activity_type_id">Tipo de actividad</label>
        <select wire:model="activity_type_id" class="form-control" id="" required>
            <option value=""></option>
            @foreach($activity_types as $activity_type)
                <option value="{{$activity_type->id}}">{{$activity_type->name}}</option>
            @endforeach
        </select>
    </fieldset>

    <fieldset class="form-group col col-md-2">
        <label for="for_id_deis"><br></label>
        <button type="submit" class="btn btn-primary form-control" wire:click="save()">Guardar</button>
    </fieldset>

    </div>
</div>
