<div>
    @section('title', 'Últimos Ingresos')

    @include('inventory.nav', [
        'establishment' => $establishment
    ])

    <h4 class="mb-3">
        {{ $establishment->name }}: Últimos ingresos a bodega
    </h4>

    <div class="row mb-3">
        <fieldset class="form-group col-md-3">
            <label for="type-reception-id">Tipo de Ingreso</label>
            <select wire:model.live="type_reception_id" id="type-reception-id" class="form-control">
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
                placeholder="Ingresa la orden de compra, origen, producto o descripción técnica"
                wire:model.live.debounce.1500ms="search"
            >
        </fieldset>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Ingreso a bodega</th>
                    <th>Origen/OC</th>
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
                    wire:target="createInventory, discardInventory, search"
                >
                    <td class="text-center" colspan="7">
                        @include('layouts.bt4.partials.spinner')
                    </td>
                </tr>
                @forelse($controlItems as $controlItem)
                    <tr wire:loading.remove>
                        <td class="text-center">
                            {{ $controlItem->control->date->format('Y-m-d') }}
                        </td>
                        <td>
                            @if($controlItem->control->isPurchaseOrder())
                                <span class="text-nowrap">
                                    {{ $controlItem->control->po_code }}
                                </span>
                            @else
                                {{ $controlItem->control->origin?->name }}
                            @endif
                            <br>
                            <small>
                                {{ optional($controlItem->control->typeReception)->name }}
                            </small>
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
                        <td class="text-center" colspan="7">
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
