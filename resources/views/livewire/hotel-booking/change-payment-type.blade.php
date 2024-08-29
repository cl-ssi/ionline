<div>
    @if($showSelect)
        <div class="d-flex align-items-center">
            <select class="form-control mr-2" id="payment_type_select" wire:model="payment_type">
                <option value=""></option>
                <option value="Transferencia">Transferencia</option>
                <option value="Descuento por planilla - 1 cuota">Descuento por planilla - 1 cuota</option>
                <option value="Descuento por planilla - 2 cuotas">Descuento por planilla - 2 cuotas</option>
                <option value="Descuento por planilla - 3 cuotas">Descuento por planilla - 3 cuotas</option>
            </select>
            <button wire:click="save" class="btn btn-primary">Guardar</button>
        </div>
    @else
        <div class="mb-2">
            <button wire:click="toggleSelect" class="btn btn-link p-0">{{ $roomBooking->payment_type ?? 'Select Payment Type' }}</button>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="alert alert-success mt-2">
            {{ session('message') }}
        </div>
    @endif
</div>
