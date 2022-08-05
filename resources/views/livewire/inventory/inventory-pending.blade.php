<div>
    @section('title', 'Bandeja Pendiente')

    @include('inventory.nav')

    <h3 class="mb-3">
        Bandeja Pendiente de Inventario
    </h3>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Código</th>
                    <th>Producto</th>
                    <th>Proveedor/OC</th>
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
                <tr>
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
                    </td>
                    <td class="text-center">
                        <a
                            class="btn btn-sm btn-primary"
                            href="{{ route('inventories.edit', $inventory) }}"
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
