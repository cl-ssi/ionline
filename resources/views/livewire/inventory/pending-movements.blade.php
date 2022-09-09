<div>
    @section('title', 'Inventarios pendientes')

    @include('inventory.nav-user')

    <h4 class="mb-3">
        Inventarios pendientes
    </h4>
    <p class="text-muted">
        Listado de inventarios pendientes por revisar.
    </p>

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
                    @include('layouts.partials.spinner')
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
        <caption>
            Total de resultados: {{ $movements->total() }}
        </caption>
    </table>

    {{ $movements->links() }}
</div>
