<div>
    <h5>Editar Bodega</h5>

    @include('warehouse.stores.partials.form', [
        'store' => $store
    ])

    <button class="btn btn-primary" wire:click="updateStore">Actualizar</button>
</div>
