<div>
    <h5>Editar Origen</h5>

    @include('warehouse.origins.partials.form', [
        'store' => $store,
        'origin' => $origin
    ])

    <button wire:click="updateOrigin" class="btn btn-primary">Actualizar</button>
    <a
        href="{{ route('warehouse.origins.index', ['store' => $store, 'nav' => $nav]) }}"
        class="btn btn-outline-primary"
    >
        Cancelar
    </a>
</div>
