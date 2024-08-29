<div>
    <div class="row my-2">
        <div class="col">
            <h5>Bodegas</h5>
        </div>
        <div class="col text-right">
            <a href="{{ route('warehouse.stores.create') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> Crear Bodega
            </a>
        </div>
    </div>

    <div class="input-group my-2">
        <div class="input-group-prepend">
            <span class="input-group-text">Buscar</span>
        </div>
        <input type="text" class="form-control" wire:model.live.debounce.1500ms="search">
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th>Nombre</th>
                    <th class="text-center"># Usuarios</th>
                    <th class="text-center"># Categorías</th>
                    <th class="text-center"># Productos</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none" wire:target="search">
                    <td class="text-center" colspan="7">
                        @include('layouts.bt4.partials.spinner')
                    </td>
                </tr>
                @forelse($stores as $store)
                <tr wire:loading.remove wire:target="search">
                    <td class="text-center">
                        <a
                            href="{{ route('warehouse.stores.edit', $store) }}"
                            class="btn btn-sm btn-outline-secondary"
                        >
                            <i class="fas fa-edit"></i>
                            {{ $store->id }}
                        </a>
                    </td>
                    <td>{{ $store->name }}</td>
                    <td class="text-center">
                        <a
                            href="{{ route('warehouse.stores.users',
                                ['store' => $store,
                                'nav' => 'nav-admin'])
                            }}"
                        >
                            {{ $store->users->count() }} usuarios
                        </a>
                    </td>
                    <td class="text-center">
                        <a
                            href="{{ route('warehouse.categories.index', [
                                'store' => $store,
                                'nav' => 'nav-admin'
                            ]) }}"
                        >
                            {{ $store->categories->count() }} categorías
                        </a>
                    </td>
                    <td class="text-center">
                        <a
                            href="{{ route('warehouse.products.index', [
                                'store' => $store,
                                'nav' => 'nav-admin'
                            ]) }}"
                        >
                            {{ $store->products->count() }} productos
                        </a>
                    </td>
                    <td class="text-center">
                        <a
                            class="btn btn-sm btn-outline-secondary"
                            href="{{ route('warehouse.store.report', [
                                'store' => $store,
                                'nav' => 'nav-admin'
                            ]) }}"
                            title="Reporte Bincard"
                        >
                            <i class="fas fa-file-alt"></i>
                        </a>
                        <div class="btn-group" role="group">
                            <a
                                class="btn btn-sm btn-outline-secondary"
                                href="{{ route('warehouse.origins.index', [
                                    'store' => $store,
                                    'nav' => 'nav-admin'
                                ]) }}"
                                title="Origenes"
                            >
                                <i class="fas fa-download"></i>
                            </a>
                            <a
                                class="btn btn-sm btn-outline-secondary"
                                href="{{ route('warehouse.destinations.index', [
                                    'store' => $store,
                                    'nav' => 'nav-admin'
                                ]) }}"
                                title="Destinos"
                            >
                                <i class="fas fa-upload"></i>
                            </a>
                        </div>

                        <div class="btn-group" role="group">
                            <a
                                class="btn btn-sm btn-outline-secondary"
                                href="{{ route('warehouse.controls.index', [
                                    'store' => $store,
                                    'type' => 'receiving',
                                    'nav' => 'nav-admin',
                                ]) }}"
                                title="Ingresos"
                            >
                                <i class="fas fa-shopping-basket"></i>
                            </a>
                            <a
                                class="btn btn-sm btn-outline-secondary"
                                href="{{ route('warehouse.controls.index', [
                                    'store' => $store,
                                    'type' => 'dispatch',
                                    'nav' => 'nav-admin',
                                ]) }}"
                                title="Egresos"
                            >
                                <i class="fas fa-shipping-fast"></i>
                            </a>
                        </div>

                        <button
                            class="btn btn-sm btn-outline-danger"
                            wire:click="delete({{ $store }})"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="7">
                        <em>No hay resultados</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <caption>
                Total resultados: {{ $stores->total() }}
            </caption>
        </table>
        {{ $stores->links() }}
    </div>
</div>
