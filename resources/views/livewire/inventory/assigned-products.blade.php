<div>
    @section('title', 'Mis Productos Asignados')

    @include('inventory.nav-user')

    <h4 class="mb-3">
        Mis Productos Asignados
    </h4>

    <p class="text-muted">
        Listado de los productos en donde fue asignado como responsable.
    </p>

    <table class="table table-bordered">
        <thead>
            <th>Nro. Inventario</th>
            <th>Producto</th>
            <th>Fecha de Recepción</th>
            <th></th>
        </thead>
        <tbody>
            <tr
                class="d-none"
                wire:loading.class.remove="d-none"
            >
                <td class="text-center" colspan="4">
                    @include('layouts.partials.spinner')
                </td>
            </tr>
            @forelse($inventories as $inventory)
                <tr>
                    <td>
                        <small class="text-monospace">
                            {{ $inventory->number }}
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
                        {{ $inventory->lastMovement->reception_date }}
                    </td>
                    <td>
                        <a
                            class="btn btn-sm btn-primary"
                            href="{{ route('inventories.create-transfer', $inventory)}}"
                        >
                            Generar Traspaso
                    </a>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="4">
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
