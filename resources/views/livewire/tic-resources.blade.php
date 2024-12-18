<div>

@section('title', 'Lista de Computadores')

<h3 class="mb-3">Recursos TIC</h3>

<h4>Desde nuevo módulo de inventario</h4>

<div class="form-row">
    <fieldset class="form-group col-md-3">
        <label for="type-resource">Tipo Recurso</label>
        <select
            wire:model.live.debounce.1500ms="type_resource"
            id="type-resource"
            class="form-control"
        >
            <option value="">Todos</option>
            <option value="for-merge">
                Mostrar por fusionar
            </option>
            <option value="for-creating">
                Mostrar por crear
            </option>
        </select>
    </fieldset>
    <fieldset class="form-group col-md-9">
        <label for="search">Buscador</label>
        <input
            type="text"
            class="form-control"
            id="search"
            wire:model.live.debounce.1500ms="search"
            placeholder="Ingrese una marca, modelo, número de inventario o serial"
        >
    </fieldset>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm" id="TableFilter">
        <thead>
            <tr>
                <th scope="col">Inventario</th>
                <!-- <th scope="col">Producto</th> -->
                <th scope="col">Marca</th>
                <th scope="col">Modelo</th>
                <th scope="col">Serial</th>
                <!-- <th scope="col">Observación</th> -->
                <th scope="col">Usuario</th>
                <th scope="col">Responsable</th>
                <th scope="col">Lugar</th>
                <th scope="col">Estado</th>
                <th class="text-center" scope="col">Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr
                class="d-none"
                wire:loading.class.remove="d-none"
            >
                <td class="text-center" colspan="9">
                    @include('layouts.bt4.partials.spinner')
                </td>
            </tr>
            @forelse($inventories as $inventory)
            <tr wire:loading.remove>
                <td scope="row">{{ $inventory->number }} </td>
                <!-- <td>{{ $inventory->unspscProduct->name }}</td> -->
                <td>{{ $inventory->brand }}</td>
                <td>{{ $inventory->model }}</td>
                <td>{{ $inventory->serial_number }}</td>
                <!-- <td>{{ $inventory->observations }}</td> -->
                <td>{{ $inventory->using->tinyName }}</td>
                <td>{{ $inventory->responsible->tinyName }}</td>
                <td>{{ $inventory->place->name }}</td>
                <td>{{ $inventory->estado }}</td>
                <td class="text-center" nowrap>
                    <!-- TODO: #109 Agregar action, permitir editar inventory + computer -->
					<!-- Si tiene existe un Computer con el numero de inventario -->

                    @if($inventory->isComputer())
                        <a
                            href="{{ route('resources.computer.fusion', [
                                'computer' => $inventory->my_computer,
                                'inventory' => $inventory
                            ]) }}"
                            class="btn btn-outline-secondary btn-sm"
                        >
                            <span class="fas fa-fire" aria-hidden="true"></span>
                            Fusionar
                        </a>
                    @else
                        <a
                            href="{{ route('resources.computer.new', [
                                'inventory' => $inventory
                            ]) }}"
                            class="btn btn-outline-secondary btn-sm"
                        >
                            <span class="fas fa-plus" aria-hidden="true"></span> Crear
                        </a>
                    @endif
                </td>
            </tr>
            @empty
            <tr wire:loading.remove>
                <td class="text-center" colspan="9">
                    <em>No hay registros</em>
                </td>
            </tr>
            @endforelse
        </tbody>
        <caption>
            Total de resultados: {{ $inventories->total() }}
        </caption>
    </table>
</div>

{{ $inventories->links() }}

</div>
