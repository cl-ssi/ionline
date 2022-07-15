<div>
    @section('title', 'Asignaciones pendientes')

    @include('inventory.nav')

    <h4 class="mb-3">
        Listado de las asignaciones pendientes
    </h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr
                class="d-none"
                wire:loading.class.remove="d-none"
            >
                <td class="text-center" colspan="2">
                    @include('layouts.partials.spinner')
                </td>
            </tr>
            @forelse($movements as $movement)
                <tr wire:loading.remove>
                    <td>
                        Ud. fue asignado como responsable del producto
                        <b>
                            {{ $movement->inventory->product->product->name }} -
                            {{ $movement->inventory->product->name }}
                        </b>
                            bajo el número de inventario
                        <b>
                            {{ $movement->inventory->number }}
                        </b>
                    </td>
                    <td nowrap>
                        <a
                            class="btn btn-sm btn-primary"
                            href="{{ route('inventories.check-transfer', $movement) }}"
                            >
                            Revisar traspaso
                        </a>
                    </td>
                </tr>
            @empty
                <tr class="text-center" wire:loading.remove>
                    <td colspan="2">
                        <em>No hay registros</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4 class="mb-3">
        Productos asignados a ud.
    </h4>

    <table class="table table-bordered">
        <thead>
            <th>Nro Inventario</th>
            <th>Producto</th>
            <th>Fecha de Recepción</th>
            <th></th>
        </thead>
        <tbody>
            @forelse($inventories as $inventory)
            <tr>
                <td>
                    {{ $inventory->number }}
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
    </table>
</div>
