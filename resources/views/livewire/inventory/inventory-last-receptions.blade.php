<div>
    @section('title', 'Últimos Ingresos')

    @include('inventory.nav')

    <h3 class="mb-3">
        Últimos ingresos a bodega
    </h3>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Ingreso a bodega</th>
                    <th>Proveedor</th>
                    <th class="text-center">OC</th>
                    <th class="text-center">Cantidad</th>
                    <th>Producto</th>
                    <th class="text-center">Valor</th>
                    <th class="text-center">Formulario</th>
                    <th class="text-center" nowrap>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="d-none"
                    wire:loading.class.remove="d-none"
                    wire:target="createInventory, discardInventory"
                >
                    <td class="text-center" colspan="8">
                        @include('layouts.partials.spinner')
                    </td>
                </tr>
                @forelse($controlItems as $controlItem)
                    <tr wire:loading.remove>
                        <td class="text-center">
                            {{ $controlItem->control->date->format('Y-m-d') }}
                        </td>
                        <td>
                            @if($controlItem->control->isPurchaseOrder())
                                {{ $controlItem->control->purchaseOrder->supplier_name }}
                            @endif

                            @if($controlItem->control->origin)
                                {{ $controlItem->control->origin->name }}
                            @endif
                        </td>
                        <td class="text-center" nowrap>
                            {{ $controlItem->control->po_code }}
                        </td>
                        <td class="text-center">
                            {{ $controlItem->quantity }}
                        </td>
                        <td>
                            {{ $controlItem->product->product->name }}
                            <br>
                            <small>
                                {{ $controlItem->product->name }}
                            </small>
                        </td>
                        <td class="text-center">
                            ${{ money($controlItem->unit_price) }}
                        </td>
                        <td class="text-center" nowrap>
                            @if($controlItem->control->requestForm)
                                <a
                                    class="link-primary"
                                    href="{{ route('request_forms.show', $controlItem->control->requestForm) }}"
                                    target="_blank"
                                >
                                    # {{ $controlItem->control->requestForm->id }}
                                </a>
                            @endif
                        </td>
                        <td class="text-center" nowrap>
                            <button
                                wire:click="createInventory({{ $controlItem }})"
                                class="btn btn-sm btn-primary"
                            >
                                Inventariar
                            </button>
                            <button
                                class="btn btn-sm btn-secondary"
                                wire:click="discardInventory({{ $controlItem }})"
                            >
                                No Inventariar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr wire:loading.remove>
                        <td class="text-center" colspan="8">
                            <em>No hay registros</em>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <caption>
                Total de resultados: {{ $controlItems->total() }}
            </caption>
        </table>

        {{ $controlItems->links() }}
    </div>

</div>
