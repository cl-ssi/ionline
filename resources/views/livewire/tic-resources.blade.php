<div>

@section('title', 'Lista de Computadores')

<h3 class="mb-3">Computadores</h3>

<h4>Desde nuevo módulo de inventario</h4>

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
                <th scope="col">Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $inventory)
            <tr>
                <td scope="row">{{ $inventory->number }} </td>
                <!-- <td>{{ $inventory->unspscProduct->name }}</td> -->
                <td>{{ $inventory->brand }}</td>
                <td>{{ $inventory->model }}</td>
                <td>{{ $inventory->serial_number }}</td>
                <!-- <td>{{ $inventory->observations }}</td> -->
                <td>{{ $inventory->using->tinnyName }}</td>
                <td>{{ $inventory->responsible->tinnyName }}</td>
                <td>{{ $inventory->place->name }}</td>
                <td>{{ $inventory->estado }}</td>
                <td>
                    <!-- TODO: #109 Agregar action, permitir editar inventory + computer -->
					<!-- Si tiene existe un Computer con el numero de inventario -->
                    <a href="" class="btn btn-outline-primary btn-sm">
                    <span class="fas fa-fire" aria-hidden="true"></span> Fusionar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- $inventories->links() --}}
</div>