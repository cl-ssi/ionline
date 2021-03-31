<div>
    <select class="selectpicker" name="payment_ready" wire:model="payment_ready" wire:click="save()" @if($payment_ready == '1') data-style="btn-success" @elseif($payment_ready == '0') data-style="btn-danger"  @endif >
        <option value="1">Apto</option>
        <option value="0">Rechazado</option>
        <option value="null">Pendiente</option>
    </select>

    <input class="form-control" type="text" {{$payment_ready != '0' ? 'hidden' : '' }} name="rejection_detail" placeholder="Ingrese motivo" wire:model="rejection_detail" wire:keydown="saveRejectionDetail()" >
</div>

