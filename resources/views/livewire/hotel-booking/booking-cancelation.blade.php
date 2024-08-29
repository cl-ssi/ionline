<div>
    @if ($showForm)
        <div>
            <form method="POST" class="form-horizontal" action="{{ route('hotel_booking.booking_cancelation', $roomBooking) }}" style="display: inline;">
                @csrf
                @method('DELETE')

                    <select wire:model.live="cancelationReason" name="cancelation_observation" class="form-control">
                        <option value="">Seleccione un motivo</option>
                        <option value="No cuenta con el 15% legal para descuento por planilla">No cuenta con el 15% legal para descuento por planilla.</option>
                        <option value="Por mantención de cabaña">Por mantención de cabaña.</option>
                        <option value="Por problemas externos">Por problemas externos.</option>
                        <option value="Ya existe una reserva confirmada para ese rango de fechas">Ya existe una reserva confirmada para ese rango de fechas.</option>
                    </select>

                    <button class="btn btn-primary mt-2" type="submit">Guardar</button>
            </form>
            <button wire:click="hideCancelationForm" class="btn btn-secondary mt-2">Cancelar</button>
        </div>
    @else
        <div style="display: inline;">
            <button wire:click="showCancelationForm" class="btn btn-outline-danger" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
        </div>
    @endif
</div>