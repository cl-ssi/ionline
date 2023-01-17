<div>
    <h5>Crear Bodega</h5>

    @include('warehouse.stores.partials.form', [
        'store' => null
    ])

    <button wire:click="createStore" class="btn btn-primary">
        Guardar
    </button>
</div>
