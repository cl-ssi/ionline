<div>
    <h5>Editar Destino</h5>

    @include('warehouse.destinations.partials.form', [
        'store' => $store,
        'destination' => $destination,
    ])

    <button wire:click="updateDestination" class="btn btn-primary">Actualizar</button>
    <a
        href="{{ route('warehouse.destinations.index', ['store' => $store, 'nav' => $nav]) }}"
        class="btn btn-outline-primary"
    >
        Cancelar
    </a>
</div>
