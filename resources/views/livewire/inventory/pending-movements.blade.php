<div>
    @section('title', 'Movimientos pendientes')

    @include('inventory.nav-user')

    <h4 class="mb-3">
        Movimientos pendientes por revisar
    </h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th nowrap>Nro. Inventario</th>
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
                    @include('layouts.bt4.partials.spinner')
                </td>
            </tr>
            @forelse($movements as $movement)
                <tr wire:loading.remove>
                    <td>
                        <small class="text-monospace">
                            {{ $movement->inventory->number }}
                        </small>
                    </td>
                    <td>
                        {{ optional($movement->inventory->unspscProduct)->name }}
                        <br>
                        <small>
                            @if($movement->inventory->product)
                                {{ $movement->inventory->product->name }}
                            @else
                                {{ $movement->inventory->description }}
                            @endif
                        </small>

                        {{-- {{ $movement->inventory->product->product->name }} - --}}
                        {{-- {{ $movement->inventory->product->name }} --}}
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
                    <td colspan="2">
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
