<div id="{{$room->id}}">
    <a href="#" class="btn btn-primary reservar" data-value="{{$room->id}}" wire:click="toggleVisibility">Reservar</a>
    <br><br>
    <div class="card text-left" @if(!$isVisible) hidden @endif>
        <div class="card-header">
            Reserva de Hospedaje
        </div>
        <div class="card-body">
            {{--@livewire('hotel-booking.calendar',['room' => $room, 'start_date' => $start_date, 'end_date' => $end_date])--}}

            <div class="form-row">

                    <fieldset class="form-group col-3">
                        <label>Nombre</label>
                        @if(auth()->user()->can('be god') || auth()->user()->can('welfare: hotel booking administrator'))
                            @livewire('search-select-user', ['selected_id' => 'user_id', 
                                                             'emit_name' => 'loadUserData',
                                                             'required' => 'required',
                                                             'user' => auth()->user()])
                        @else
                            <input type="hidden" wire:model.live="user_id">
                            <input type="text" class="form-control" disabled value="{{auth()->user()->tinyName}}">
                        @endif
                    </fieldset>

                    <fieldset class="form-group col-2">
                        <label for="for_start_date">Ingresando el</label>
                        <input type="date" class="form-control" value="{{$start_date}}" disabled>
                    </fieldset>

                    <fieldset class="form-group col-2">
                        <label for="for_end_date">Saliendo el</label>
                        <input type="text" class="form-control" value="{{$end_date}}" disabled>
                    </fieldset>

                    <fieldset class="form-group col-3">
                        <label>Tipo de pago</label>
                        <select class="form-control" name="" id="payment_type_select" wire:model="payment_type" required>
                            <option value=""></option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Descuento por planilla - 1 cuota">Descuento por planilla - 1 cuota</option>
                            <option value="Descuento por planilla - 2 cuotas">Descuento por planilla - 2 cuotas</option>
                            <option value="Descuento por planilla - 3 cuotas">Descuento por planilla - 3 cuotas</option>
                        </select>
                    </fieldset>

                    <fieldset class="form-group col-2">
                        <label><br></label>
                        <button class="form-control btn btn-primary" wire:click="confirm_reservation()" wire:loading.attr="disabled">
                            <span wire:loading.remove>Confirmar Reserva!</span>
                            <span wire:loading>
                                <i class="fas fa-spinner fa-spin"></i> Cargando...
                            </span>
                        </button>
                    </fieldset>
                
                </div>

                @error('payment_type') <span class="text-danger">{{ $message }}</span> @enderror

                <!-- Mensaje de éxito -->
                @include('layouts.bt4.partials.flash_message')
        </div>
    </div>
</div>
