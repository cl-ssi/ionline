<div>
    <div class="form-row">

        <fieldset class="form-group col-3">
            <label for="for_hotel_id">Hotel</label>
            <select class="form-control" name="hotel_id" id="for_hotel_id" wire:model.live="hotel_id" wire:change="hotel_change">
                <option value=""></option>
                @foreach($hotels as $hotel)
                    <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_hotel_id">Hospedaje</label>
            <select class="form-control" name="room_id" id="for_room_id" wire:model.live="room_id" wire:change="room_change">
                <option value=""></option>
                @if($rooms)
                    @foreach($rooms as $room_item)
                        <option value="{{$room_item->id}}">{{$room_item->identifier}}</option>
                    @endforeach
                @endif
            </select>
        </fieldset>

    </div>

    @if($room)
        <hr>

        @livewire('hotel-booking.room-booking-configuration',['room' => $room])

        @foreach($room->bookingConfigurations as $configuration)
            @livewire('hotel-booking.room-booking-configuration',['configuration' => $configuration])
        @endforeach

        <hr>

        @livewire('hotel-booking.calendar',['room' => $room])

        <hr>

        @livewire('hotel-booking.hotel-room-lock',['room' => $room])

    @endif

    

</div>
