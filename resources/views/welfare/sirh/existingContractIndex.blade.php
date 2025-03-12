@extends('layouts.bt4.app')

@section('title', 'Contratos Existentes')

@section('content')

@include('welfare.nav')

<h3>Contratos Existentes</h3>

<div class="alert alert-info">
    <small>Última actualización: {{ $lastUpdate->last_update ? Carbon\Carbon::parse($lastUpdate->last_update)->format('d/m/Y H:i:s') : 'Sin datos' }}</small>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <form action="{{ url()->current() }}" method="get">
            <div class="input-group">
                <input type="text" class="form-control" name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Buscar por nombre, RUT o unidad...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6 text-right">
        <button type="button" class="btn btn-outline-primary"
            onclick="tableToExcel('tabla_contracts', 'Contratos')">
            <i class="fas fa-download"></i>
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm" id="tabla_contracts">
        <thead>
            <tr>
                <th scope="col">RUT</th>
                <th scope="col">Nombres</th>
                <th scope="col">Calidad Jurídica</th>
                <th scope="col">Unidad</th>
                <th scope="col">Grado</th>
                <th scope="col">Establecimiento</th>
                <th scope="col">Fecha Inicio</th>
                <th scope="col">Fecha Fin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($existingContract as $contract)
            <tr>
                <td>{{ $contract->rut }}-{{ $contract->dv }}</td>
                <td>{{ $contract->nombres }}</td>
                <td>{{ $contract->calidad_juridica }}</td>
                <td>{{ $contract->unid_descripcion }}</td>
                <td>{{ $contract->grado }}</td>
                <td>{{ $contract->esta_nombre }}</td>
                <td>{{ Carbon\Carbon::parse($contract->fecha_ini)->format('d/m/Y')}}</td>
                <td>{{ Carbon\Carbon::parse($contract->fecha_fin)->format('d/m/Y')}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $existingContract->links() }}
</div>

@endsection