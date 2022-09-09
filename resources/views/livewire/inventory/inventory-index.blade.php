<div>
    @section('title', 'Inventario')

    @include('inventory.nav')

    <div class="form-row my-3">
        <fieldset class="col">
            <label for="search" class="form-label">Buscador</label>
            <input
                type="text"
                id="search"
                class="form-control"
                placeholder="Ingresa un número inventario, producto, ubicación, lugar o responsable"
                wire:model.debounce.1500ms="search"
            >
        </fieldset>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Nro. Inventario</th>
                    <th>Producto</th>
                    <th>Ubicación</th>
                    <th>Lugar</th>
                    <th>Fecha Entrega</th>
                    <th>Usuario</th>
                    <th class="text-center">Valor</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="d-none"
                    wire:loading.class.remove="d-none"
                >
                    <td class="text-center" colspan="8">
                        @include('layouts.partials.spinner')
                    </td>
                </tr>
                @forelse($inventories as $inventory)
                <tr wire:loading.remove>
                    <td class="text-center">
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
                    </td>
                    <td>
                        @if($inventory->place)
                        {{ optional($inventory->place)->location->name }}
                        @endif
                    </td>
                    <td>
                        {{ optional($inventory->place)->name }}
                    </td>
                    <td class="text-center">
                        @if($inventory->deliver_date)
                            {{ $inventory->deliver_date->format('Y-m-d') }}
                        @endif
                    </td>
                    <td>
                        {{ optional($inventory->using)->full_name }}
                    </td>
                    <td class="text-center">
                        ${{ $inventory->price }}
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
                <tr class="text-center" wire:loading.remove>
                    <td colspan="8">
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
</div>
