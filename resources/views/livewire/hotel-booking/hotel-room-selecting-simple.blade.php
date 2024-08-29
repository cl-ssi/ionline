<div>
    <div class="form-row">
        <fieldset class="form-group col-3">
            <label for="for_hotel_id">Recinto</label>
            <select class="form-control" name="hotel_id" id="for_hotel_id" wire:model.live="hotel_id" wire:change="hotel_change">
                <option value="">Seleccionar recinto</option>
                @foreach($hotels as $hotel)
                    <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_room_id">Hospedaje</label>
            <select class="form-control" name="room_id" id="for_room_id" wire:model.live="room_id">
                <option value="">Seleccionar hospedaje</option>
                @foreach($rooms as $room_item)
                    <option value="{{$room_item->id}}">{{$room_item->identifier}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="submit_button"><br></label>
            <button type="submit" class="form-control btn-primary" id="submit_button">Buscar</button>
        </fieldset>
    </div>
</div>
