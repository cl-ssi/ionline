@extends('layouts.bt4.app')

@section('title', 'Lista de Computadores')

@section('content')

<div class="row">
    <div class="col">
        <h3 class="mb-3">Computadores</h3>
    </div>
    <div class="col-md-4 text-right">
        <a
            class="btn btn-primary mx-1"
            href="{{ route('resources.computer.create') }}"
        >
            <i class="fas fa-plus"></i> Agregar nuevo
        </a>

        <a
            class="btn btn-success float-right"
            href="{{ route('resources.computer.export') }}"
        >
            <i class="fas fa-file-excel"></i> Exportar Listado
        </a>
    </div>
</div>

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
        <tr>
            <th></th>
            <th>Fusionados</th>
            <th>
                {{ $totalMerged["merged"]}}
            </th>
            <th>No Fusionados</th>
            <th>
                {{ $totalMerged["not_merged"]}}
            </th>
        </tr>
    </tbody>
</table>

@livewire('resources.computer-index')

@endsection
