<div>
    <h5>Crear Origen</h5>

    @include('warehouse.origins.partials.form', [
        'store' => $store,
        'origin' => null
    ])

    <button wire:click="createOrigin" class="btn btn-primary">Crear</button>
    <a
        href="{{ route('warehouse.origins.index', ['store' => $store, 'nav' => $nav]) }}"
        class="btn btn-outline-primary"
    >
        Cancelar
    </a>
</div>
