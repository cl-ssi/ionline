@extends('layouts.bt5.app')

@section('title', 'Lista de Unidades Organizacionales')

@section('content')

    <h3 class="mb-3">Unidades Organizacionales</h3>
    <h4 class="mb-3">{{ auth()->user()->organizationalUnit->establishment->name }}</h4>

    <form class="row"
        action="{{ route('rrhh.organizational-units.index') }}"
        method="GET">

        <div class="col-10">
            <div class="input-group">
                <input type="text"
                    class="form-control"
                    id="forsearch"
                    placeholder="Ingrese Nombre"
                    name="search"
                    value="{{ request('search') }}"
                    autocomplete="off">
                <button type="submit"
                    class="btn btn-secondary"><i class="fas fa-search"></i> Buscar</button>
            </div>
        </div>
        <div class="col-2">
            @can('OrganizationalUnits: create')
            <a class="btn btn-primary"
                href="{{ route('rrhh.organizational-units.create') }}">
                <i class="fas fa-plus"></i> Crear
            </a>
            @endcan
        </div>
    </form>



    <div class="table-responsive">
        <table class="table table-striped table-sm"
            id="TableFilter">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ouTree as $id => $ou)
                    <tr style="font-family:monospace;">
                        <td></td>
                        <td>{{ $ou }}</td>
                        <td>
                            <a href="{{ route('rrhh.organizational-units.edit', $id) }}"
                                class="btn btn-outline-secondary btn-sm">
                                <span class="fas fa-edit"
                                    aria-hidden="true"></span></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
