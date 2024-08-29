<div>
    <h5>Reporte Bincard: {{ $store->name }}</h5>

    <div class="form-row">
        <fieldset class="form-group col-md-2">
            <label for="start-date">Desde</label>
            <input class="form-control" type="date" wire:model.live.debounce.1500ms="start_date" id="start-date">
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="end-date">Hasta</label>
            <input class="form-control" type="date" wire:model.live.debounce.1500ms="end_date" id="end-date">
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="product-id">Producto</label>
            <select wire:model.live.debounce.1500ms="product_id" id="product-id" class="form-control">
                <option value="">Todos</option>
                @foreach($store->products as $product)
                    <option value="{{ $product->id }}">
                        {{ optional($product->product)->name }} - {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="program-id">Programa</label>
            <select wire:model.live.debounce.1500ms="program_id" id="program-id" class="form-control">
                <option value="">Todos</option>
                <option value="-1">Sin Programa</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-1">
            <label for="program-id">Tipo</label>
            <select wire:model.live.debounce.1500ms="type" id="type" class="form-control">
                <option value="">Todos</option>
                <option value="1">Ingreso</option>
                <option value="false">Egreso</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="oc">Orden de Compra</label>
            <input class="form-control" type="text" wire:model.debounce.1500ms="oc" id="oc" autocomplete="off">
        </fieldset>
        

        <fieldset class="form-group col-md-1">
            <label for="type-control">
                &nbsp;
                @if($type === "1")
                    Ingreso
                @elseif($type === "false")
                    Egreso
                @endif
            </label>
            <select wire:model.live.debounce.1500ms="type_control" id="type-control" class="form-control">
                <option value="">Todos</option>
                @foreach($typesControl as $typeControl)
                    <option value="{{ $typeControl->id }}">{{ $typeControl->name }}</option>
                @endforeach
            </select>
        </fieldset>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Origen/Destino</th>
                    <th>Producto</th>
                    <th>Programa</th>
                    <th>Ingreso</th>
                    <th>Egreso</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none">
                    <td class="text-center" colspan="9">
                        @include('layouts.bt4.partials.spinner')
                    </td>
                </tr>
                @forelse($controlItems as $controlItem)
                <tr wire:loading.remove>
                    <td class="text-center">
                        <small class="text-monospace">
                            {{ optional($controlItem->control)->id }}
                        </small>
                    </td>
                    <td>
                        {{ $controlItem->control->type_format }}
                        <br>
                        @if($controlItem->control)
                            <small>
                                @if($controlItem->control->isDispatch())
                                    {{ optional($controlItem->control->typeDispatch)->name }}
                                @else                                    
                                    {{ optional($controlItem->control->typeReception)->name }}
                                @endif
                            </small>
                        @endif
                    </td>
                    <td nowrap>
                        {{ $controlItem->control->date_format }}
                    </td>
                    <td>
                        @if($controlItem->control)
                            @if($controlItem->control->isDispatch())
                                @switch($controlItem->control->type_dispatch_id)
                                    @case(\App\Models\Warehouse\TypeDispatch::internal())
                                        {{ optional($controlItem->control->organizationalUnit)->establishment->name }}
                                        <br>
                                        {{ optional($controlItem->control->organizationalUnit)->name }}
                                        @break
                                    @case(\App\Models\Warehouse\TypeDispatch::external())
                                        {{ optional($controlItem->control->destination)->name }}
                                        @break
                                    @case(\App\Models\Warehouse\TypeDispatch::adjustInventory())
                                        {{ optional($controlItem->control->typeDispatch)->name }} - En Negativo
                                        @break
                                    @case(\App\Models\Warehouse\TypeDispatch::sendToStore())
                                        {{ optional($controlItem->control->destinationStore)->name }}
                                        @break
                                @endswitch
                            @else
                                @switch($controlItem->control->type_reception_id)
                                    @case(\App\Models\Warehouse\TypeReception::receiving())
                                        {{ optional($controlItem->control->origin)->name }}
                                        @break
                                    @case(\App\Models\Warehouse\TypeReception::receiveFromStore())
                                        {{ optional($controlItem->control->originStore)->name }}
                                        @break
                                    @case(\App\Models\Warehouse\TypeReception::return())
                                        {{ optional($controlItem->control->originStore)->name }}
                                        @break
                                    @case(\App\Models\Warehouse\TypeReception::purchaseOrder())
                                        {{ $controlItem->control->po_code }}
                                        @break
                                    @case(\App\Models\Warehouse\TypeReception::adjustInventory())
                                        {{ optional($controlItem->control->typeReception)->name }} - En Positivo
                                        @break
                                @endswitch
                            @endif
                        @endif
                    </td>
                    <td>
                        {{ $controlItem->product->product->name }}
                        <br>
                        <small>
                            {{ $controlItem->product->name }}
                        </small>
                    </td>
                    <td>{{ $controlItem->program_name }}</td>
                    <td>
                        @if($controlItem->control->isReceiving())
                            <p class="text-success">
                                {{ $controlItem->quantity }}
                            </p>
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @if($controlItem->control->isReceiving())
                            0
                        @else
                            <p class="text-danger">
                                {{ $controlItem->quantity }}
                            </p>
                        @endif
                    </td>
                    <td>
                        <p class="font-weight-bold">
                            {{ $controlItem->balance }}
                        </p>
                    </td>
                </tr>
                @empty
                <tr wire:loading.remove>
                    <td class="text-center" colspan="9">
                        <em>No hay resultados</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
