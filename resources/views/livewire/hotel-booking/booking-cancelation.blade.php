<div>
    @if ($showForm)
        <div>
            <select wire:model="cancelationReason" class="form-control">
                <option value="">Seleccione un motivo</option>
                <option value="no_15_percent">No cuenta con el 15% legal para descuento por planilla.</option>
                <option value="maintenance">Por mantención de cabaña.</option>
                <option value="external_problems">Por problemas externos.</option>
            </select>
            
            <form method="POST" class="form-horizontal" action="{{ route('hotel_booking.booking_cancelation', $roomBooking) }}" style="display: inline;">
                @csrf
                @method('DELETE')
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