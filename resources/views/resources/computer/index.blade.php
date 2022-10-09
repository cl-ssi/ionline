@extends('layouts.app')

@section('title', 'Lista de Computadores')

@section('content')

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
                    <!-- <a href="" class="btn btn-outline-secondary btn-sm">
                    <span class="fas fa-edit" aria-hidden="true"></span></a> -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $inventories->links() }}


<h4> Antiguo módulo de inventario de computadores</h4>

<table class="table table-sm table-bordered text-center">
    <thead>
        <tr>
            <th>Computadores</th>
            <th>Arrendado</th>
            <th>Propio</th>
            <th>Usuario</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Escritorio</th>
            <td>{{ $totales['desktop']['leased'] }}</td>
            <td>{{ $totales['desktop']['own'] }}</td>
            <td>{{ $totales['desktop']['user'] }}</td>
            <td>{{ array_sum($totales['desktop']) }}</td>
        </tr>
        <tr>
            <th>Todo en uno</th>
            <td>{{ $totales['all-in-one']['leased'] }}</td>
            <td>{{ $totales['all-in-one']['own'] }}</td>
            <td>{{ $totales['all-in-one']['user'] }}</td>
            <td>{{ array_sum($totales['all-in-one']) }}</td>
        </tr>
        <tr>
            <th>Portatil</th>
            <td>{{ $totales['notebook']['leased'] }}</td>
            <td>{{ $totales['notebook']['own'] }}</td>
            <td>{{ $totales['notebook']['user'] }}</td>
            <td>{{ array_sum($totales['notebook']) }}</td>
        </tr>
        <tr>
            <th>Otro</th>
            <td>{{ $totales['other']['leased'] }}</td>
            <td>{{ $totales['other']['own'] }}</td>
            <td>{{ $totales['other']['user'] }}</td>
            <td>{{ array_sum($totales['other']) }}</td>
        </tr>
        <tr>
            <th></th>
            <th>
                {{ 
                $totales['desktop']['leased'] + 
                $totales['all-in-one']['leased'] + 
                $totales['notebook']['leased'] +
                $totales['other']['leased']
                }}
            </th>
            <th>
                {{ 
                $totales['desktop']['own'] + 
                $totales['all-in-one']['own'] + 
                $totales['notebook']['own'] +
                $totales['other']['own']
                }}
            </th>
            <th>
                {{ 
                $totales['desktop']['user'] + 
                $totales['all-in-one']['user'] + 
                $totales['notebook']['user'] +
                $totales['other']['user']
                }}
            </th>
            <th>{{ $computers->total() }}</th>
        </tr>
    </tbody>
</table>


<div class="row">
    <div class="col-sm-9">
        <form class="form d-print-none" method="GET" action="{{ route('resources.computer.index') }}">
            <fieldset class="form-group">
                <div class="input-group">

                    <div class="input-group-prepend">
                        <a class="btn btn-primary" href="{{ route('resources.computer.create') }}">
                            <i class="fas fa-plus"></i> Agregar nuevo</a>
                    </div>

                    <input type="text" class="form-control" id="forsearch" onkeyup="filter(3)"
                        placeholder="Marca o Modelo o IP o Serial o Número de Inventario - Filtro por: Serial"
                        name="search">

                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="col-sm-3">
        <a class="btn btn-success float-right" href="{{ route('resources.computer.export') }}">
            <i class="fas fa-file-excel"></i> Exportar Listado
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm" id="TableFilter">
        <thead>
            <tr>
                <th scope="col">Inventario</th>
                <th scope="col">Marca</th>
                <th scope="col">Modelo</th>
                <th scope="col">Serial</th>
                <th scope="col">IP</th>
                <!-- <th scope="col">Comentario</th> -->
                <th scope="col">Asignado a</th>
                <th scope="col">Lugar</th>
                <th scope="col">Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach($computers as $key => $computer)
            <tr>
                <td>{{ $computer->inventory_number }}</td>
                <td>{{ $computer->brand }}</td>
                <td>{{ $computer->model }}</td>
                <td>{{ $computer->serial }}</td>
                <td>{{ $computer->ip }}</td>
                <!-- <td>{{ $computer->comment }}</td> -->
                <td>
                    @foreach($computer->users as $user)
                         {{ $user->tinnyName }}<br>
                    @endforeach
                </td>
                <td>{{ $computer->place ? $computer->place->name : 'Asignar Lugar' }}</td>
                <td>
                    <a href="{{ route('resources.computer.edit', $computer) }}" class="btn btn-outline-secondary btn-sm">
                    <span class="fas fa-edit" aria-hidden="true"></span></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $computers->links() }}

@endsection
