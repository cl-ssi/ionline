<div>
    <h4>Reporte de Producto</h4>

    <div class="form-row">
        <fieldset class="form-group col-md-2">
            <label for="start-date">Desde</label>
            <input class="form-control" type="date" wire:model="start_date" id="start-date">
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="end-date">Hasta</label>
            <input class="form-control" type="date" wire:model="end_date" id="end-date">
        </fieldset>

        <fieldset class="form-group col-md-4">
            <label for="product-id">Producto</label>
            <select wire:model="product_id" id="product-id" class="form-control">
                <option value="">Todos</option>
                @foreach($store->products as $product)
                    <option value="{{ $product->id }}">
                        {{ optional($product->product)->name }} - {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-4">
            <label for="program-id">Programa</label>
            <select wire:model="program_id" id="program-id" class="form-control">
                <option value="">Todos</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                @endforeach
            </select>
        </fieldset>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
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
                    <td class="text-center" colspan="8">
                        @include('layouts.partials.spinner')
                    </td>
                </tr>
                @forelse($controlItems as $controlItem)
                <tr wire:loading.remove>
                    <td>
                        {{ $controlItem->control->type_format }}
                        @if($controlItem->control->type)
                            {{ $controlItem->control_id }}
                        @else
                            {{ $controlItem->control_id }}
                        @endif
                    </td>
                    <td>{{ $controlItem->control->date_format }}</td>
                    <td>
                        @if($controlItem->control)
                            @if($controlItem->control->isReceiving())
                                {{ optional($controlItem->control->origin)->name }}
                            @else
                                @if($controlItem->control->isAdjustInventory())
                                    {{ $controlItem->control->adjust_inventory_format }}
                                @else
                                    {{ optional($controlItem->control->destination)->name }}
                                @endif
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
                        @if($controlItem->control->type)
                            <p class="text-success">
                                {{ $controlItem->quantity }}
                            </p>
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @if($controlItem->control->type)
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
                    <td class="text-center" colspan="8">
                        <em>No hay resultados</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
