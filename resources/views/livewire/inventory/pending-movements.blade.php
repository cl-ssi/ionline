<div>
    @section('title', 'Movimientos pendientes')

    @include('inventory.nav-user')

    <h4 class="mb-3">
        Movimientos pendientes por revisar
    </h4>

    <p class="text-muted">
        Listado de los productos asignados a ud y debe completar el traspaso.
    </p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th nowrap>Nro. Inventario</th>
                <th>Producto/Especie</th>
                <th>Estado</th>
                <th>Ubicación</th>
                <th>Lugar</th>
                <th>Código Arquitectónico</th>
                <th>Responsable</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr
                class="d-none"
                wire:loading.class.remove="d-none"
            >
                <td class="text-center" colspan="2">
                    @include('layouts.bt4.partials.spinner')
                </td>
            </tr>
            @forelse($movements as $movement)
                <tr wire:loading.remove>
                    <td>
                        <small class="text-monospace">
                            {{ $movement->inventory?->number }}
                            <br>
                            {{ $movement->inventory?->old_number }}
                        </small>
                    </td>
                    <td>
                        {{ optional($movement->inventory?->unspscProduct)->name }}
                        <br>
                        <small>
                            @if($movement->inventory?->product)
                                {{ $movement->inventory->product->name }}
                            @else
                                {{ $movement->inventory?->description }}
                            @endif
                        </small>
                    </td>
                    <td>
                        {{ $movement->inventory->estado }}
                    </td>
                    <td>
                        @if($movement->inventory->place)
                            {{ optional($movement->inventory->place)->location->name }}
                        @endif
                    </td>
                    <td>
                        {{ optional($movement->inventory->place)->name }}
                    </td>
                    <td>
                        {{ $movement->inventory->place?->architectural_design_code }}
                    </td>
                    <td>
                        @if($movement->reception_date == null)
                            {{ optional($movement->responsibleUser)->tinyName }}
                        @endif
                    </td>                    
                    <td class="text-center" nowrap>
                        <a
                            class="btn btn-outline-primary"
                            href="{{ route('inventories.check-transfer', $movement) }}"
                        >
                            <i class="fas fa-eye"></i>
                            Completar el traspaso
                        </a>
                    </td>
                </tr>
            @empty
                <tr class="text-center" wire:loading.remove>
                    <td colspan="9">
                        <em>No hay registros</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
        <caption>
            Total de resultados: {{ $movements->total() }}
        </caption>
    </table>

    {{ $movements->links() }}
</div>
