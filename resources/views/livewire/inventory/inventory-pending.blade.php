<div>
    @section('title', 'Bandeja Pendiente')

    @include('inventory.nav', [
        'establishment' => $establishment
    ])

    <h4 class="mb-3">
        {{ $establishment->name }}: Pendientes de Inventariar
    </h4>

    <div class="mb-3">
        <button class="btn btn-success" wire:click="generateCodesForAll">
            Generar Código de Inventario Masivamente
        </button>
    </div>

    <div class="row g-2 mb-3">
        <fieldset class="form-group col-md-3">
            <label for="type-reception-id">Tipo de Ingreso</label>
            <select wire:model.live="type_reception_id" id="type-reception-id" class="form-select">
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
                wire:model.live.debounce.1500ms="search"
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
                        @include('layouts.bt5.partials.spinner')
                    </td>
                </tr>
                @forelse($inventories as $inventory)
                    <tr wire:loading.remove>
                        <td class="text-center">
                            {{ $inventory->id }}
                        </td>
                        <td class="text-center">
                            <small class="text-monospace">
                                {{ $inventory->product?->product?->code }}
                            </small>
                        </td>
                        <td>
                            @if($inventory->unspscProduct)
                                <b>Std:</b> {{ $inventory->unspscProduct->name }}
                            @endif
                            <br>
                            <small>
                                @if($inventory->product)
                                    <b>Bodega:</b> {{ $inventory->product->name }}
                                @else
                                    <b>Desc:</b> {{ $inventory->description }}
                                @endif
                            </small>
                        </td>
                        <td>
                            @if(isset($inventory->control))
                                @if($inventory->control->isPurchaseOrder())
                                    <span class="text-nowrap">
                                        {{ $inventory->control->po_code }}
                                    </span>
                                @else
                                    {{ $inventory->control->origin?->name }}
                                @endif
                                <br>
                                <small>
                                    {{ optional($inventory->control->typeReception)->name }}
                                </small>
                            @else
                                <small>
                                    No posee Origen/OC
                                </small>
                            @endif
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
