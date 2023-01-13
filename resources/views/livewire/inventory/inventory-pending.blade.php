<div>
    @section('title', 'Bandeja Pendiente')

    @include('inventory.nav', [
        'establishment' => $establishment
    ])

    <h4 class="mb-3">
        {{ $establishment->name }}: Bandeja Pendiente de Inventario
    </h4>

    <div class="form-row">
        <fieldset class="form-group col-md-3">
            <label for="type-reception-id">Tipo de Ingreso</label>
            <select wire:model="type_reception_id" id="type-reception-id" class="form-control">
                <option value="">Todos</option>
                <option value="{{ App\Models\Warehouse\TypeReception::receiving() }}">
                    Ingreso Normal
                </option>
                <option value="{{ App\Models\Warehouse\TypeReception::purchaseOrder() }}">
                    Orden de Compra
                </option>
            </select>
        </fieldset>

        <fieldset class="form-group col-md-9">
            <label for="search">Buscar</label>
            <input
                class="form-control"
                type="text"
                id="search"
                placeholder="Ingresa la orden de compra, origen, código de producto, producto o descripción técnica"
                wire:model.debounce.1500ms="search"
            >
        </fieldset>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Código</th>
                    <th>Producto</th>
                    <th>Origen/OC</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="d-none"
                    wire:loading.class.remove="d-none"
                >
                    <td class="text-center" colspan="5">
                        @include('layouts.partials.spinner')
                    </td>
                </tr>
                @forelse($inventories as $inventory)
                    <tr wire:loading.remove>
                        <td class="text-center">
                            {{ $inventory->id }}
                        </td>
                        <td class="text-center">
                            <small class="text-monospace">
                                {{ $inventory->product->product->code }}
                            </small>
                        </td>
                        <td>
                            {{ $inventory->product->product->name }}
                            <br>
                            <small>
                                {{ $inventory->product->name }}
                            </small>
                        </td>
                        <td>
                            @if($inventory->control->isPurchaseOrder())
                                <span class="text-nowrap">
                                    {{ $inventory->control->po_code }}
                                </span>
                            @else
                                {{ $inventory->control->origin->name }}
                            @endif
                            <br>
                            <small>
                                {{ optional($inventory->control->typeReception)->name }}
                            </small>
                        </td>
                        <td class="text-center">
                            <a
                                class="btn btn-sm btn-primary @cannot('Inventory: edit') disabled @endcannot"
                                href="{{ route('inventories.edit', [
                                    'inventory' => $inventory,
                                    'establishment' => $establishment
                                ]) }}"
                            >
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr wire:loading.remove>
                        <td class="text-center" colspan="5">
                            <em>No hay registros</em>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <caption>
                Total de resultados: {{ $inventories->total() }}
            </caption>
        </table>
    </div>

    {{ $inventories->links() }}
</div>
