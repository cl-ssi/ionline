<div>
    <div class="row my-2">
        <div class="col">
            <h5>Destinos: {{ $store->name }}</h5>
        </div>
        <div class="col text-right">
            <a
                href="{{ route('warehouse.destinations.create', ['store' => $store, 'nav' => $nav]) }}"
                class="btn btn-sm btn-primary"
            >
                <i class="fa fa-plus"></i> Crear Destino
            </a>
        </div>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Buscar</span>
        </div>
        <input
            type="text"
            class="form-control"
            wire:model.live.debounce.1500ms="search"
            placeholder="Buscar por nombre"
        >
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Id</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="d-none"
                    wire:loading.class.remove="d-none"
                    wire:target="search, deleteDestination"
                >
                    <td class="text-center" colspan="3">
                        @include('layouts.bt4.partials.spinner')
                    </td>
                </tr>
                @forelse($destinations as $destination)
                <tr wire:loading.remove>
                    <td class="text-center">
                        <a
                            href="{{ route('warehouse.destinations.edit', [
                                'store' => $store,
                                'destination' => $destination,
                                'nav' => $nav,
                            ]) }}"
                            class="btn btn-sm btn-outline-secondary"
                        >
                            <i class="fas fa-edit"></i>
                            {{ $destination->id }}
                        </a>
                    </td>
                    <td>{{ $destination->name }}</td>
                    <td class="text-center">
                        <button
                            class="btn btn-sm btn-outline-danger"
                            wire:click="deleteDestination({{ $destination }})"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr wire:loading.remove>
                    <td class="text-center" colspan="3">
                        <em>
                            No hay resultados
                        </em>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <caption>
                Total de Resultados: {{ $destinations->total() }}
            </caption>
        </table>
        {{ $destinations->links() }}
    </div>
</div>
