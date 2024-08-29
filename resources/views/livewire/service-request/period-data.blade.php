<div>
    <div class="form-row">
        <fieldset class="form-group col-3 col-md-3">
            <label for="for_type">Período</label>
            <select name="type" class="form-control" required="" wire:model.live="fulfillment.type">
                <option value=""></option>
                <option value="Horas">Horas</option>
                <option value="Mensual">Mensual</option>
                <option value="Parcial">Parcial</option>
                <option value="Horas Médicas">Horas Médicas</option>
                <option value="Horas No Médicas">Horas No Médicas</option>
                <option value="Hora Médica">Hora Médica</option>
            </select>
        </fieldset>
        <fieldset class="form-group col-2 col-md-2">
            <label for="for_start_date">Inicio</label>
            <input type="date" class="form-control" required="" wire:model.live="fulfillment.start_date">
        </fieldset>
        <fieldset class="form-group col-2 col-md-2">
            <label for="for_end_date">Término</label>
            <input type="date" class="form-control" required="" wire:model.live="fulfillment.end_date">
        </fieldset>
        <fieldset class="form-group col-4 col-md-4">
            <label for="for_observation">Observación</label>
            <input type="text" class="form-control" wire:model.live="fulfillment.observation">
        </fieldset>
        
        <fieldset class="form-group col-1 col-md-1">
            <label for="for_submit"><br></label>
            <button type="submit" class="btn btn-primary form-control" wire:click="save()">
                <i class="fas fa-save"></i>
            </button>
        </fieldset>

        <!-- <fieldset class="form-group col-1">
            <label for="for_submit"><br></label>
            <button type="submit" class="btn btn-danger form-control" wire:click="delete()" onclick="confirm('¿Está seguro de eliminar este período?') || event.stopImmediatePropagation()">
                <i class="fas fa-trash"></i>
            </button>
        </fieldset> -->
    </div>

    @include('layouts.bt4.partials.errors')
    @include('layouts.bt4.partials.flash_message_custom',[
        'name' => 'period-data',  // debe ser único
        'type' => 'primary' // optional: 'primary' (default), 'danger', 'warning', 'success', 'info'
    ])
</div>