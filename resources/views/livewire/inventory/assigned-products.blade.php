<div>
    @section('title', 'Mi inventario')

    @include('inventory.nav-user')

    <div class="row">
        <div class="col">
            <h4 class="mb-3">
                Mi inventario
            </h4>
        </div>
        <div class="col text-right">
            <a class="btn btn-primary" href="{{ route('inventories.register', auth()->user()->organizationalUnit->establishment) }}">
                <i class="fas fa-plus"></i> Registrar Inventario
            </a>
        </div>
    </div>

    <p class="text-muted">
        Listado de los productos en donde ud fue asignado como usuario y/o responsable.
    </p>

    <div class="form-row">
        <fieldset class="form-group col-md-3">
            <label for="product-type">Productos donde</label>
            <select
                wire:model.debounce.1500ms="product_type"
                id="product-type"
                class="form-control"
            >
                <option value="">Todos</option>
                <option value="using">Soy Usuario</option>
                <option value="responsible">Soy Responsable</option>
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="search" class="form-label">Buscador</label>
            <input
                type="text"
                id="search"
                class="form-control"
                placeholder="Ingresa un número inventario"
                wire:model.debounce.1500ms="search"
            >
        </fieldset>
    </div>

    <table class="table table-bordered">
        <thead>
            <th>Nro. Inventario</th>
            <th>Producto</th>
            <th>Usuario</th>
            <th>Responsable</th>
            <th>Ubicación</th>
            <th></th>
        </thead>
        <tbody>
            <tr class="d-none" wire:loading.class.remove="d-none">
                <td class="text-center" colspan="6">
                    @include('layouts.bt4.partials.spinner')
                </td>
            </tr>
            @forelse($inventories as $inventory)
                <tr wire:loading.remove>
                    <td>
                        <small class="text-monospace">
                            {{ $inventory->number }}
                        </small>
                    </td>
                    <td>
                        {{ optional($inventory->unspscProduct)->name }}
                        <br>
                        <small>
                            @if($inventory->product)
                                {{ $inventory->product->name }}
                            @else
                                {{ $inventory->description }}
                            @endif
                        </small>
                        <br>

                        @if($inventory->user_using_id == auth()->user()->id)
                            <span class="badge badge-secondary">
                                Usuario
                            </span>
                        @endif

                        @if($inventory->user_responsible_id == auth()->user()->id)
                            <span class="badge badge-secondary">
                                Responsable
                            </span>
                        @endif
                    </td>
                    <td>
                        {{ optional($inventory->using)->tinny_name }}
                    </td>
                    <td>
                        {{ optional($inventory->responsible)->tinny_name }}
                    </td>
                    <td>
                        {{ $inventory->location }}
                    </td>
                    <td class="text-center" nowrap>
                        <a
                            class="btn btn-sm btn-outline-primary"
                            href="{{ route('inventories.create-transfer', $inventory) }}"
                        >
                            <i class="fas fa-sync-alt"></i>
                            Traspaso
                        </a>
                        <a
                            href="{{ route('inventories.act-transfer', $inventory) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-danger"
                            title="Acta de Traspaso"
                        >
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr class="text-center" wire:loading.remove>
                    <td colspan="6">
                        <em>No hay registros</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
        <caption>
            Total de resultados: {{ $inventories->total() }}
        </caption>
    </table>

    {{ $inventories->links() }}
</div>
