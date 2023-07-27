<div id="{{$room->id}}">
    <a href="#" class="btn btn-primary reservar" data-value="{{$room->id}}" wire:click="show()">Reservar</a>
    <br><br>
    <div class="card text-left" @if(!$show) hidden @endif>
            <div class="card-header">
                Reserva de Hospedaje
            </div>
            <div class="card-body">
                @livewire('hotel-booking.calendar',['configurations' => $room->bookingConfigurations, 'start_date' => $start_date, 'end_date' => $end_date])

                <div class="form-row">

                    <fieldset class="form-group col">
                        <label>Nombre</label>
                        <input type="text" class="form-control" disabled value="{{Auth::user()->getFullNameUpperAttribute()}}">
                    </fieldset>

                    <fieldset class="form-group col">
                        <label for="for_start_date">Ingreso</label>
                        <input type="date" class="form-control" value="{{$start_date}}" disabled>
                    </fieldset>

                    <fieldset class="form-group col">
                        <label for="for_end_date">Salida</label>
                        <input type="text" class="form-control" value="{{$end_date}}" disabled>
                    </fieldset>

                    <fieldset class="form-group col">
                        <label><br></label>
                        <button class="form-control btn btn-primary" wire:click="confirm_reservation()"
                        onclick="confirm('¿Está seguro de reservar este hospedaje?') || event.stopImmediatePropagation()">Confirmar Reserva!</button>
                    </fieldset>

                </div>

                <!-- Mensaje de éxito -->
                @include('layouts.partials.flash_message')
            </div>

        </div>
</div>
