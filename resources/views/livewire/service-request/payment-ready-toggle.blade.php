<div>
    <div class="form-row">
        <div class="col-10">
            <select class="form-control {{ $bg_color }}" name="payment_ready" wire:model="payment_ready">
                <option value="1">Aceptado</option>
                <option value="0">Rechazado</option>
                <option value="null"></option>
            </select>
        </div>
        <div class="col-2 my-auto">
            <button class="btn btn-primary btn-sm" wire:click="save()" title="Guardar">
                <i class="fas fa-save"></i>
            </button>
        </div>
    </div>

    <div class="form-row"{{ $payment_ready == '1' ? 'hidden' : '' }}>
        <div class="col-12">
            <input class="form-control" type="text" name="rejection_detail" wire:model.lazy="rejection_detail_input" placeholder="Ingrese motivo">
        </div>
    </div>

    {!!$rejection_detail!!}

    <div wire:loading wire:target="save">
        <span class="text-muted small">Procesando...</span>
    </div>
</div>
