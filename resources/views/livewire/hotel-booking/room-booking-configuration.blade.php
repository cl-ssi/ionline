<div>
    <div class="form-row">

        <fieldset class="form-group col-2">
            <label for="for_hotel_id">F.Desde</label>
            <input type="date" class="form-control" id="for_start_date" name="start_date" wire:model.live="start_date">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_hotel_id">F.Hasta</label>
            <input type="date" class="form-control" id="for_end_date" name="end_date" wire:model.live="end_date">
        </fieldset>

        <fieldset class="form-group col-1">
            <label for="for_hotel_id">Lu</label>
            <input type="checkbox" class="form-control" id="for_monday" name="monday" wire:model.live="monday">
        </fieldset>

        <fieldset class="form-group col-1">
            <label for="for_hotel_id">Ma</label>
            <input type="checkbox" class="form-control" id="for_tuesday" name="tuesday" wire:model.live="tuesday">
        </fieldset>

        <fieldset class="form-group col-1">
            <label for="for_hotel_id">Mi</label>
            <input type="checkbox" class="form-control" id="for_wednesday" name="wednesday" wire:model.live="wednesday">
        </fieldset>

        <fieldset class="form-group col-1">
            <label for="for_hotel_id">Ju</label>
            <input type="checkbox" class="form-control" id="for_thursday" name="thursday" wire:model.live="thursday">
        </fieldset>

        <fieldset class="form-group col-1">
            <label for="for_hotel_id">Vi</label>
            <input type="checkbox" class="form-control" id="for_friday" name="friday" wire:model.live="friday">
        </fieldset>

        <fieldset class="form-group col-1">
            <label for="for_hotel_id">Sa</label>
            <input type="checkbox" class="form-control" id="for_saturday" name="saturday" wire:model.live="saturday">
        </fieldset>

        <fieldset class="form-group col-1">
            <label for="for_hotel_id">Do</label>
            <input type="checkbox" class="form-control" id="for_sunday" name="sunday" wire:model.live="sunday">
        </fieldset>

        <!-- solo si viene el parametro 'configuration' se realiza esa carga -->
        @if($configuration)
            <fieldset class="form-group col-1">
                <label for="for_hotel_id"><br></label>
                <button class="form-control btn btn-primary" wire:click="update({{$configuration}})">Guardar</button>
            </fieldset>
        @else
            <fieldset class="form-group col-1">
                <label for="for_hotel_id"><br></label>
                <button class="form-control btn btn-primary" wire:click="save()">Guardar</button>
            </fieldset>
        @endif

    </div>

    <!-- Mensaje de éxito -->
    @include('layouts.bt4.partials.flash_message')

</div>
