<div>
    {{-- Stop trying to control. --}}    
    @section('title', 'Transferir entre usuarios')
    @include('inventory.nav', [
        'establishment' => auth()->user()->organizationalUnit->establishment
    ])
    <div class="row g-2 mb-3">
        <fieldset class="col-md-3">
            <label for="old-responsible-id" class="form-label">Antiguo Responsable  de Producto</label>

            @livewire('users.search-user', [
                'smallInput' => true,
                'placeholder' => 'Ingrese un nombre',
                'eventName' => 'myOldUserResponsibleId',
                'tagId' => 'old-responsible-id',
                'bt' => 5,
            ])

            <input
                class="form-control @error('old_responsible_id') is-invalid @enderror"
                type="hidden"
            >

            @error('old_responsible_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        @if($old_user_responsible_id)
            <h4>
                Total de Cantidad de Inventario de Responsable {{$inventories->total()}}
            </h4>
        @endif
    </div>

    @if($old_user_responsible_id)

    <div class="row g-2 mb-3">
        <fieldset class="col text-end">
            <button class="btn btn-primary"
                    wire:loading.attr="disabled"
                    wire:click="toggleSelectAll"
                    wire:target="toggleSelectAll"
            >{{ $selectAllText }}</button>
        </fieldset>
    </div>

    <div class="row g-3 align-items-center">
        <div class="col-2">
            <label for="searchTerm" class="form-label">Buscar:</label>
        </div>
        <div class="col-10">
            <input type="text" class="form-control" wire:model.live="searchTerm" id="searchTerm" placeholder="Ingrese término de búsqueda">
        </div>
    </div>
    <br>


        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Nro. Inv.</th>
                    <th class="text-center">Nro. Ant.</th>
                    <th>Producto/Especie</th>
                    <th>Ubicación</th>
                    <th>Lugar</th>
                    <th>Responsable</th>
                    <th>Usuario(s)</th>
                    <th>Traspasar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventories as $inventory)
                    <tr>
                        <td class="text-center" nowrap>
                            <small>
                                    {{ $inventory->number }}
                            </small>
                        </td>
                        <td nowrap>
                            {{ $inventory->old_number }}
                        </td>
                        <td>
                            @if($inventory->unspscProduct)
                                {{ $inventory->unspscProduct->name }}
                            @endif
                        </td>
                        <td>
                            @if($inventory->place?->location)
                                {{ $inventory->place->location->name }}
                            @endif
                        </td>
                        <td>
                            @if($inventory->place)
                                {{ $inventory->place->name }}
                            @endif
                        </td>
                        <td>
                            @if($inventory->responsible)
                                {{ $inventory->responsible->tinyName }}
                            @endif
                        </td>
                        <td>
                        @if($inventory->inventoryUsers)
                            <ul>
                                @foreach($inventory->inventoryUsers as $inventoryuser)
                                    <li>
                                        {{ $inventoryuser->user->tinyName }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                            <!-- @if($inventory->using)
                                {{ $inventory->using->tinyName }}
                            @endif -->
                        </td>
                        <td class="text-center" nowrap>
                            <input type="checkbox" wire:model.live="selectedInventories.{{ $inventory->id }}">
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" align="center">No hay Productos asociado a este usuario</td>
                    </tr>

                @endforelse
            </tbody>
        </table>

        {{ $inventories->links() }}

        <div class="row g-2 mb-3">
            @if($old_user_responsible_id && !$inventories->isEmpty())
                <fieldset class="col-md-3">
                    
                        <label for="new-user-using-id" class="form-label">Nuevo Responsable de productos</label>
                        @livewire('users.search-user', [
                            'smallInput' => true,
                            'placeholder' => 'Ingrese un nombre',
                            'eventName' => 'myUserResponsibleId',
                            'tagId' => 'user-responsible-id',
                            'bt' => 5,
                        ])
                    
                </fieldset>

                {{-- 
                    <fieldset class="col-md-3">
                        <label for="user-using-id" class="form-label">Usuario <small>(Vacio = se mantiene el Usuario)</small></label>

                        @livewire('users.search-user', [
                            'smallInput' => true,
                            'placeholder' => 'En caso de no ingresar se mantiene el Usuario anterior',
                            'eventName' => 'myUserUsingId',
                            'tagId' => 'user-using-id',
                            'bt' => 5,
                        ])

                        <input
                            class="form-control @error('user_using_id') is-invalid @enderror"
                            type="hidden"
                        >

                        @error('user_using_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                 --}}


                <fieldset class="col-md-3">
                    <label for="place-id" class="form-label">
                        Ubicación <small>(Vacio = se mantiene la Ubicación)</small>
                    </label>

                    @livewire('places.find-place', [
                        'smallInput' => true,
                        'tagId' => 'place-id',
                        'placeholder' => 'En caso de no ingresar se mantiene la ubicación anterior',
                        'establishment' => auth()->user()->organizationalUnit->establishment,
                    ])

                    <input
                        class="form-control @error('place_id') is-invalid @enderror"
                        type="hidden"
                    >

                    @error('place_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </fieldset>

                <fieldset class="col text-end">
                        <button class="btn btn-primary"
                        wire:loading.attr="disabled"
                        wire:click="transfer"
                        wire:target="transfer"
                        @if(($user_responsible_id = null) || ($user_using_id = null) || $new_user_responsible_id = null || $place_id = null)
                        disabled
                        @endif
                        >Transferir
                        </button>
                </fieldset>
            @endif
                
        </div>

            
        </div>

    @endif




    

</div>
