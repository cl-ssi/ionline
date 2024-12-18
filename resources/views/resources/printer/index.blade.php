@extends('layouts.bt4.app')

@section('title', 'Lista de Impresoras')

@section('content')

<h3 class="mb-3">Impresoras</h3>

<table class="table table-sm table-bordered text-center">
    <thead>
        <tr>
            <th></th>
            <th>Arrendado</th>
            <th>Propio</th>
            <th>Usuario</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Impresoras</th>
            <td>{{ $totales['printer']['leased'] }}</td>
            <td>{{ $totales['printer']['own'] }}</td>
            <td>{{ $totales['printer']['user'] }}</td>
            <td>{{ array_sum($totales['printer']) }}</td>
        </tr>
        <tr>
            <th>Scanners</th>
            <td>{{ $totales['scanner']['leased'] }}</td>
            <td>{{ $totales['scanner']['own'] }}</td>
            <td>{{ $totales['scanner']['user'] }}</td>
            <td>{{ array_sum($totales['scanner']) }}</td>
        </tr>
        <tr>
            <th>Plotters</th>
            <td>{{ $totales['plotter']['leased'] }}</td>
            <td>{{ $totales['plotter']['own'] }}</td>
            <td>{{ $totales['plotter']['user'] }}</td>
            <td>{{ array_sum($totales['plotter']) }}</td>
        </tr>

        <tr>
            <th></th>
            <th>
                {{
                $totales['printer']['leased'] +
                $totales['scanner']['leased'] +
                $totales['plotter']['leased']
                }}
            </th>
            <th>
                {{
                $totales['printer']['own'] +
                $totales['scanner']['own'] +
                $totales['plotter']['own']
                }}
            </th>
            <th>
                {{
                $totales['printer']['user'] +
                $totales['scanner']['user'] +
                $totales['plotter']['user']
                }}
            </th>
            <th>{{ $printers->total() }}</th>
        </tr>
    </tbody>
</table>


<form class="form d-print-none" method="GET" action="{{ route('resources.printer.index') }}">
    <fieldset class="form-group">
        <div class="input-group">

            <div class="input-group-prepend">
                <a class="btn btn-primary" href="{{ route('resources.printer.create') }}">
                    <i class="fas fa-plus"></i> Agregar nuevo
                </a>
            </div>

            <input type="text" class="form-control" id="forsearch" onkeyup="filter(3)"
                placeholder="Busqueda por: Tipo, Marca, Modelo, Serial, IP o MAC." name="search">

            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </fieldset>
</form>


<div class="table-responsive">
    <table class="table table-striped table-sm" id="TableFilter">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Tipo</th>
                <th scope="col">Marca</th>
                <th scope="col">Modelo</th>
                <th scope="col">N°Serie</th>
                <th scope="col">IP</th>
                <th scope="col">Lugar</th>
                <th scope="col">Usuario</th>
                <th scope="col">Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach($printers as $key => $printer)
            <tr>
                <td scope="row">{{ ++$key }} </td>
                <td>{{ $printer->type }}</td>
                <td>{{ $printer->brand }}</td>
                <td>{{ $printer->model }}</td>
                <td>{{ $printer->serial }}</td>
                <td>{{ $printer->ip }}</td>
                <td>@if($printer->place <> null) {{ $printer->place->name }} @endif</td>
                <td>@if($printer->users->first() <> null) {{ $printer->users->first()->fullName }} @endif
                </td>
                <td>
                    <a
                        href="{{ route('resources.printer.edit', $printer->id) }}"
                        class="btn btn-outline-secondary btn-sm"
                    >
                        <span class="fas fa-edit" aria-hidden="true"></span>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $printers->links() }}

@endsection