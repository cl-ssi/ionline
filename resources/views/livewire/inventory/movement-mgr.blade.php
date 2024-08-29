<div>
    <div class="row g-2 mb-3">
        <div class="col-3">
            <strong class="text-danger">Utilizar con precaución</strong>
        </div>
        <div class="col-2">
            <select class="form-select" wire:model="inventoryMovement.reception_confirmation">
                <option value="">Seleccionar</option>
                <option value="1">Recepcionado</option>
            </select>
        </div>
        <div class="col-4">
            <input type="datetime-local" class="form-control" wire:model="inventoryMovement.reception_date">
        </div>
        <div class="col-2">
            <button class="btn btn-danger" wire:click="save">Guardar</button>
            @if($message)
            <i class="fas fa-check text-success"></i>
            @endif
        </div>

    </div>
</div>
