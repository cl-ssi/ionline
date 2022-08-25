<div>
    <h5>Crear Destino</h5>

    @include('warehouse.destinations.partials.form', [
        'store' => $store,
        'destination' => null
    ])

    <button wire:click="createDestination" class="btn btn-primary">Crear</button>
    <a
        href="{{ route('warehouse.destinations.index', ['store' => $store, 'nav' => $nav]) }}"
        class="btn btn-outline-primary"
    >
        Cancelar
    </a>
</div>
