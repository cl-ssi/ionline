<div>
    @section('title', 'Mi inventario')

    @include('inventory.nav-user')

    <div class="row">
        <div class="col">
            <h4 class="mb-3">
                Mi inventario
            </h4>
        </div>
        <div class="col text-right">
            <a
                class="btn btn-primary"
                href="{{ route('inventories.register', auth()->user()->organizationalUnit->establishment) }}"
            >
                <i class="fas fa-plus"></i>
                Registrar Inventario
            </a>
        </div>
    </div>

    <p class="text-muted">
        Listado de los productos en donde ud fue asignado como usuario y/o responsable.
    </p>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        
        @if (session()->has('message-success-inventory'))
            <div class="alert alert-success">
                {{ session('message-success-inventory') }}
            </div>
        @endif

        @if (session()->has('message-warning-inventory'))
            <div class="alert alert-warning">
                {{ session('message-warning-inventory') }}
            </div>
        @endif
    <br>




    <div class="row g-2">
        <fieldset class="form-group col-md-3">
            <label for="product-type" class="form-label">Productos donde</label>
            <select
                wire:model.live.debounce.1500ms="product_type"
                id="product-type"
                class="form-select"
            >
                <option value="">Todos</option>
                <option value="using">Soy Usuario</option>
                <option value="responsible">Soy Responsable</option>
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="search" class="form-label">Buscador</label>
            <input
                type="text"
                id="search"
                class="form-control"
                placeholder="Ingresa un número inventario (nuevo o antiguo) o nombre de producto o nombre unspc o ubicación o Código Arquitectónico"
                wire:model.live.debounce.1500ms="search"
                autocomplete="off"
            >
        </fieldset>
    </div>
    <br>

    <table class="table table-bordered">
        <thead>
            <th>Nro. Inventario</th>
            <th>Nro. Antiguo</th>
            <th>Producto</th>
            <th>Estado</th>
            <th>Ubicación</th>
            <th>Lugar</th>
            <th>Código Arquitectónico</th>
            <th>Responsable</th>
            <!-- <th>Usuario</th> -->
            <th>Usuario(s)</th>            
            <th></th>
        </thead>
        <tbody>
            <tr class="d-none" wire:loading.class.remove="d-none">
                <td class="text-center" colspan="6">
                    @include('layouts.bt4.partials.spinner')
                </td>
            </tr>
            @forelse($inventories as $inventory)
                <tr wire:loading.remove>
                    <td>
                        <small class="text-monospace">
                            {{ $inventory->number }}
                        </small>
                    </td>
                    <td class="small">
                        {{ $inventory->old_number }}
                    </td>
                    <td>
                        @if($inventory->product)
                            {{ $inventory->product->name }}
                        @else
                            {{ $inventory->description }}
                        @endif
                        
                        <br>

                        @if($inventory->user_responsible_id == auth()->user()->id)
                            <span class="badge badge-secondary">
                                Responsable
                            </span>
                        @endif
                    </td>
                    <td>
                        {{ $inventory->estado }}
                    </td>
                    <td>
                        {{ $inventory->place?->location->name }}
                    </td>
                    <td>
                        {{ $inventory->place?->name }}
                    </td>
                    <td>
                        {{ $inventory->place?->architectural_design_code }}
                    </td>
                    <td>
                        {{ optional($inventory->responsible)->tinyName }}
                    </td>
                    <td>
                        @if($inventory->inventoryUsers)
                            <ul>
                                @foreach($inventory->inventoryUsers as $inventoryuser)
                                    <li>
                                        {{ $inventoryuser->user->tinyName }}
                                        @if($inventory->user_responsible_id == auth()->user()->id)
                                            <button class="btn btn-danger btn-sm" title="Eliminar Usuario" wire:click="removeInventoryUser({{ $inventoryuser->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    </li>
                                    @if($loop->last)
                                        <hr>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                        @if($inventory->user_responsible_id == auth()->user()->id)
                            <div class="text-center mt-3">
                                <a href="{{ route('inventories.assign-user', ['userType' => 'user', 'inventory' => $inventory->id]) }}" title="Asignar usuario a inventario" class="btn btn-primary btn-sm">
                                    <i class="fas fa-user-plus"></i>
                                </a>
                            </div>
                        @endif
                    </td>                    
                    <td class="text-center" nowrap>
                        <a
                            class="btn btn-sm btn-outline-primary"
                            href="{{ route('inventories.create-transfer', $inventory) }}"
                        >
                            <i class="fas fa-sync-alt"></i>
                            Traspaso
                        </a>
                        @if($inventory->lastMovement)
                        <a
                            href="{{ route('inventories.act-transfer', $inventory->lastMovement) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-danger"
                            title="Acta de Traspaso"
                        >
                            <i class="fas fa-file-pdf"></i>
                        </a>
                        @endif

                        <br>
                        @if($inventory->pendingMovements->isNotEmpty())
                        <span class="badge bg-danger">En traspaso</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr class="text-center" wire:loading.remove>
                    <td colspan="6">
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
