<div>
    @section('title', 'Inventario')

    @include('inventory.nav', [
        'establishment' => $establishment
    ])

    <div class="row">
        <div class="col">
            <h4 class="mb-3">
                {{ $establishment->name }}: Inventario
            </h4>
        </div>
        <div class="col text-end">
            <a class="btn btn-primary" href="{{ route('inventories.register', $establishment) }}">
                <i class="fas fa-plus"></i> Registrar Inventario
            </a>
        </div>
    </div>

    {{--
    @livewire('parameters.parameter.single-manager',[
        'module' => 'inventory',
        'parameterName' => 'Encargado de inventario',
        'type' => 'user'
    ])
    --}}

    <div class="row g-2 d-print-none mb-3">
        <fieldset class="form-group col-md-2">
            <label for="locations">Ubicaciones</label>
            <select
                wire:model="location_id"
                id="locations"
                class="form-control form-select"
            >
                <option value="">Todos</option>
                @foreach($locations as $itemLocation)
                    <option value="{{ $itemLocation->id }}">
                        {{ $itemLocation->name }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-3">
            <label for="places">Lugares</label>
            <select
                wire:model="place_id"
                id="places"
                class="form-select"
            >
                <option value="">Todos</option>
                @foreach($places as $itemPlace)
                    <option value="{{ $itemPlace->id }}">
                        {{ $itemPlace->name }}
                        {{ $itemPlace->description }}
                        {{ $itemPlace->architectural_design_code }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-1">
            <label for="pending">En Traspaso</label>
            <select
                wire:model.defer="pending"
                wire:change="updateResponsible"
                id="pending"
                class="form-select"
            >
                <option value="">Todos</option>
                <option value="pending">Pendientes</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="number">Cod. Int. Arq.</label>
            <input
                wire:model.defer="architectural_design_code"
                id="architectural_design_code"
                class="form-control"
            >
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="oc">OC</label>
            <input
                wire:model.defer="oc"
                id="oc"
                class="form-control"
            >
        </fieldset>

        <fieldset class="form-group col-md-1">
            <label for="classifications">Clasificación</label>
            <select
                wire:model="classification_id"
                id="classifications"
                class="form-control form-select"
            >
                <option value="">Todas</option>
                @foreach($classifications as $classification)
                    <option value="{{ $classification->id }}">
                        {{ $classification->name }}
                    </option>
                @endforeach
            </select>
        </fieldset>
    </div>

    <div class="row g-2 d-print-none mb-3">

        <fieldset class="form-group col-md-4">
            <label for="products">Productos</label>
            <select
                wire:model="unspsc_product_id"
                id="products"
                class="form-control form-select"
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
            <label for="responsibles">Responsables</label>
            <select
                wire:model="user_responsible_id"
                id="responsibles"
                class="form-control form-control-sm form-select"
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
                wire:model="user_using_id"
                id="users"
                class="form-control form-control-sm form-select"
            >
                <option value="">Todos</option>
                @foreach($users as $itemUser)
                    <option value="{{ $itemUser->id }}">
                        {{ $itemUser->tinny_name }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="number">Nro. Invt<small> (ant o nuevo)</small></label>
            <input
                wire:model.defer="number"
                id="number"
                class="form-control"
            >
        </fieldset>

        <fieldset class="form-group col-md-1">
            <label for="inv_id">ID</label>
            <input
                wire:model.defer="inv_id"
                id="inv_id"
                class="form-control"
            >
        </fieldset>

        <fieldset class="form-group col-md-1">
            <label for="">&nbsp;</label>
            <button
                class="btn btn-primary form-control"
                wire:click="getInventories"
            >
                <i class="fas fa-filter"></i>
            </button>
        </fieldset>
    </div>

    <h5 class="d-print-none">
        Resumen de Filtro
    </h5>

    <div class="table-responsibe d-print-none">
        <table class="table table-bordered table-sm">
            <tr>
                <th>Producto/Especie</th>
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


    @if($place)
    <table class="mb-3 d-none d-print-block" align="right">
        <tr>
            <td>Folio:</td>
            <td class="font-weight-bold text-right" style="font-size: 24px;">
                @if($place)
                    {{ $place->id }}
                @endif
            </td>
        </tr>
        <tr>
            <td>Fecha: &nbsp;</td>
            <td class="font-weight-bold">
            {{ now()->format('M Y') }}
            </td>
        </tr>
    </table>
    @endif

    <h5 class="mt-3">
        Inventario
    </h5>

    @if($place)
    <table class="table table-sm table-bordered">
        <tr>
            <td>Establecimiento:</td>
            <th>
                @if($location)
                    {{ $location->name }}
                @endif
            </th>
        </tr>
        <tr>
            <td>Dirección:</td>
            <th>
                @if($location)
                    {{ $location->address }}
                @endif
            </th>
        </tr>
        <tr>
            <td>Lugar o Dependencia:</td>
            <th>
                @if($place)
                    {{ $place->name }}
                @endif
            </th>
            <td>Código interno Arquitectura:</td>
            <th>
                @if($place)
                    {{ $place->architectural_design_code }}
                @endif
            </th>
        </tr>
    </table>
    @endif


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
                    <th>QR</th>
                    <th class="d-print-none"></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="d-none"
                    wire:loading.class.remove="d-none"
                >
                    <td class="text-center" colspan="7">
                        @include('layouts.bt5.partials.spinner')
                    </td>
                </tr>
                @forelse($inventories as $inventory)
                <tr wire:loading.remove>
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
                                {{ optional($inventory->lastMovement->responsibleUser)->tinny_name }}
                                <span class="text-danger">
                                    Pendiente
                                </span>
                            @else
                                {{ optional($inventory->responsible)->tinny_name }}
                            @endif
                        @endif
                    </td>
                    <td>
                        @livewire('inventory.toggle-print',['inventory' => $inventory],key($inventory->id))
                    </td>
                    <td class="text-center d-print-none">
                        <a
                            class="btn btn-sm btn-primary @cannot('Inventory: edit') disabled @endcannot"
                            href="{{ route('inventories.edit', [
                                'inventory' => $inventory,
                                'establishment' => $establishment,
                            ]) }}"
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


<div class="row text-center mt-3">
    <div class="col">
        Responsable<br>
        @if($userResponsible)
            {{ $userResponsible->fullName }}
        @else
            No se ha seleccionado un responsable en el filtro.
        @endif
    </div>
    <div class="col">
        Control Inventario y Activo Fijo<br>
        @if($managerInventory)
            {{ $managerInventory->fullName }}
        @else
            No se ha definido el encardo de inventario.
        @endif
    </div>
</div>

</div>
