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
        

        
        
        

    </div>

    @if($old_user_responsible_id)
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Producto/Especie</th>
                    <th>Ubicación</th>
                    <th>Lugar</th>
                    <th>Responsable</th>
                    <th>Usuario</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventories as $inventory)
                    <tr>
                        <td>
                            @if($inventory->unspscProduct)
                                {{ $inventory->unspscProduct->name }}
                            @endif
                        </td>
                        <td>
                            @if($inventory->place->location)
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
                                {{ $inventory->responsible->tinny_name }}
                            @endif
                        </td>
                        <td>
                            @if($inventory->using)
                                {{ $inventory->using->tinny_name }}
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $inventories->total() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" align="center">No hay Productos asociado a este usuario</td>
                    </tr>

                @endforelse
            </tbody>
        </table>

        <div class="row g-2 mb-3">
            @if($old_user_responsible_id and $has_product >=1)
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

                <fieldset class="col-md-3">
                    <label for="user-using-id" class="form-label">Usuario</label>

                    @livewire('users.search-user', [
                        'smallInput' => true,
                        'placeholder' => 'Ingrese un nombre',
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


                <fieldset class="col-md-3">
                    <label for="place-id" class="form-label">
                        Ubicación
                    </label>

                    @livewire('places.find-place', [
                        'smallInput' => true,
                        'tagId' => 'place-id',
                        'placeholder' => 'Ingrese una ubicación',
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
