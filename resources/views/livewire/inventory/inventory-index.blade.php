<div>
    @section('title', 'Inventario')

    @include('inventory.nav')

    <div class="form-row g-2 my-3">
        <fieldset class="form-group col-md-3">
            <label for="products">Productos</label>
            <select
                wire:model.debounce.1500ms="unspsc_product_id"
                id="products"
                class="form-control form-control-sm"
            >
                <option value="">Todos</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="locations">Ubicaciones</label>
            <select
                wire:model.debounce.1500ms="location_id"
                id="locations"
                class="form-control form-control-sm"
            >
                <option value="">Todos</option>
                @foreach($locations as $itemLocation)
                    <option value="{{ $itemLocation->id }}">
                        {{ $itemLocation->name }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="places">Lugares</label>
            <select
                wire:model.debounce.1500ms="place_id"
                id="places"
                class="form-control form-control-sm"
            >
                <option value="">Todos</option>
                @foreach($places as $itemPlace)
                    <option value="{{ $itemPlace->id }}">
                        {{ $itemPlace->name }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="responsibles">Responsables</label>
            <select
                wire:model.debounce.1500ms="user_responsible_id"
                id="responsibles"
                class="form-control form-control-sm"
            >
                <option value="">Todos</option>
                @foreach($responsibles as $itemResponsible)
                    <option value="{{ $itemResponsible->id }}">
                        {{ $itemResponsible->tinny_name }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="users">Usuarios</label>
            <select
                wire:model.debounce.1500ms="user_using_id"
                id="users"
                class="form-control form-control-sm"
            >
                <option value="">Todos</option>
                @foreach($users as $itemUser)
                    <option value="{{ $itemUser->id }}">
                        {{ $itemUser->tinny_name }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-1">
            <label for="">Filtro</label>
            <button
                class="btn btn-sm btn-primary btn-block"
                wire:click="getInventories"
            >
                <i class="fas fa-filter"></i> Filtrar
            </button>
        </fieldset>
    </div>

    <h5>
        Resumen de Filtro
    </h5>

    <div class="table-responsibe">
        <table class="table table-bordered table-sm">
            <tr>
                <th>Producto</th>
                <th>Ubicación</th>
                <th>Lugar</th>
                <th>Responsable</th>
                <th>Usuario</th>
                <th class="text-center">Total</th>
            </tr>
            <tr>
                <td>
                    @if($unspscProduct)
                        {{ $unspscProduct->name }}
                    @endif
                </td>
                <td>
                    @if($location)
                        {{ $location->name }}
                    @endif
                </td>
                <td>
                    @if($place)
                        {{ $place->name }}
                    @endif
                </td>
                <td>
                    @if($userResponsible)
                        {{ $userResponsible->tinny_name }}
                    @endif
                </td>
                <td>
                    @if($userUsing)
                        {{ $userUsing->tinny_name }}
                    @endif
                </td>
                <td class="text-center">
                    {{ $inventories->total() }}
                </td>
            </tr>
        </table>
    </div>

    <h5>
        Inventario
    </h5>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Nro. Inventario</th>
                    <th>Producto</th>
                    <th>Ubicación</th>
                    <th>Lugar</th>
                    <th>Responsable</th>
                    <th>Usuario</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="d-none"
                    wire:loading.class.remove="d-none"
                >
                    <td class="text-center" colspan="7">
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
                        {{ optional($inventory->responsible)->tinny_name }}
                    </td>
                    <td class="text-center">
                        {{ optional($inventory->using)->tinny_name }}
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
                    <td colspan="7">
                        <em>No hay registros</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $inventories->links() }}
    </div>
</div>
