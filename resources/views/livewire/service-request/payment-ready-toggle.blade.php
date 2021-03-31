<div>
    <div class="form-row">
        <div class="col-10">
            <select class="form-control" name="payment_ready" wire:model="payment_ready">
                <option value="1">Apto</option>
                <option value="0">Rechazado</option>
                <option value="null">Pendiente</option>
            </select>
        </div>
        <div class="col-2 my-auto">
            <button class="btn btn-primary btn-sm "><i class="fas fa-save" wire:click="save()"></i></button>
        </div>
    </div>

    <div class="form-row"{{$payment_ready != '0' ? 'hidden' : '' }}>
        <div class="col-12">
            <input class="form-control" type="text" name="rejection_detail" placeholder="Ingrese motivo"
                   wire:model.lazy="rejection_detail">
        </div>
    </div>
    <div wire:loading wire:target="save">
        <span class="text-muted small">Procesando...</span>
    </div>
</div>

