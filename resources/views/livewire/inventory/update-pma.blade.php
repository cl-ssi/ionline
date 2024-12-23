<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    @section('title', 'Actualización Emplazamiento')
    @include('inventory.nav-user')
    @if($updateCompleted)
        <div class="alert alert-success" role="alert">
            Los elementos seleccionados se han actualizado correctamente.
        </div>
    @endif

    @if(count($inventories) > 0)
    <br><br>
    <div class="row g-2 mb-3">
        <fieldset class="col text-end">
            <button class="btn btn-primary"
                    wire:loading.attr="disabled"
                    wire:click="toggleSelectAll"
                    wire:target="toggleSelectAll"
            >{{ $selectAllText }}</button>
        </fieldset>
    </div>

    {{--
    <div class="row g-3 align-items-center">
        <div class="col-2">
            <label for="searchTerm" class="form-label">Buscar:</label>
        </div>
        <div class="col-10">
            <input type="text" class="form-control" wire:model.live="searchTerm" id="searchTerm" placeholder="Ingrese término de búsqueda">
        </div>
    </div>
    --}}
    <br>


    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Nro. Inv.</th>
                    <th class="text-center">Nro. Ant.</th>
                    <th>Producto/Especie</th>
                    <th>Estado</th>
                    <th>Ubicación</th>
                    <th>Lugar</th>
                    <th>Código interno Arquitectura</th>
                    <th>Responsable</th>
                    <th>Actualizar PMA </th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventories as $inventory)
                    <tr>
                        <td class="text-center" nowrap>
                            <small>
                                <a href="{{ route('inventories.show', ['establishment' => $establishment, 'number' => $inventory->number]) }}">
                                    {{ $inventory->number }}
                                </a>
                            </small>
                        </td>
                        <td nowrap>
                            {{ $inventory->old_number }}
                        </td>
                        <td>
                            @if($inventory->unspscProduct)
                                <b>Std:</b> {{ $inventory->unspscProduct->name }}
                            @endif
                            <br>
                            <small>
                                @if($inventory->product)
                                    <b>Bodega:</b> {{ $inventory->product->name }}
                                @else
                                    <b>Desc:</b> {{ $inventory->description }}
                                @endif
                            </small>
                        </td>
                        <td>
                            {{ $inventory->estado }}
                        </td>
                        <td>
                            {{ $inventory->lastMovement?->place?->location->name }}
                        </td>
                        <td>
                            {{ $inventory->lastMovement?->place?->name }}
                        </td>
                        <td>
                            {{ $inventory->lastMovement?->place?->architectural_design_code }}
                        </td>
                        <td class="text-center">
                            @if($inventory->lastMovement)
                                @if($inventory->lastMovement->reception_date == null)
                                    {{ optional($inventory->lastMovement->responsibleUser)->tinyName }}
                                    <span class="text-danger">
                                        Pendiente
                                    </span>
                                @else
                                    {{ optional($inventory->responsible)->tinyName }}
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            <input type="checkbox" wire:model.live="selectedItems.{{ $inventory->id }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <fieldset class="col-md-6">
        <label for="new-place-id" class="form-label">
            Nueva Ubicación
        </label>

        @livewire('places.find-place', [
            'smallInput' => true,
            'tagId' => 'new-place-id',
            'placeholder' => 'Seleccione la nueva ubicación',
            'establishment' => auth()->user()->organizationalUnit->establishment,
            'key' => 'new'
        ])

        @error('new_place_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <br><br>
    <div class="col-md-3">
        <button class="btn btn-primary" wire:click="updateSelected" wire:loading.attr="disabled">Actualizar Seleccionado</button>
    </div>
    @endif

</div>
