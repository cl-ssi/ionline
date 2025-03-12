@extends('layouts.bt4.app')

@section('title', 'Unidades RSAL')

@section('content')

@include('welfare.nav')

<h3>Unidades RSAL</h3>

<div class="alert alert-info">
    <small>Última actualización: {{ $lastUpdate->last_update ? Carbon\Carbon::parse($lastUpdate->last_update)->format('d/m/Y H:i:s') : 'Sin datos' }}</small>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <form action="{{ url()->current() }}" method="get">
            <div class="input-group">
                <input type="text" class="form-control" name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Buscar por descripción, código o comuna...">
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
            onclick="tableToExcel('tabla_unidades', 'Unidades')">
            <i class="fas fa-download"></i>
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm" id="tabla_unidades">
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Descripción</th>
                <th scope="col">Código DEIS</th>
                <th scope="col">Comuna</th>
                <th scope="col">Código DIPRES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rsalUnidad as $unidad)
            <tr>
                <td>{{ $unidad->unid_codigo }}</td>
                <td>{{ $unidad->unid_descripcion }}</td>
                <td>{{ $unidad->unid_codigo_deis }}</td>
                <td>{{ $unidad->unid_comuna }}</td>
                <td>{{ $unidad->unid_cod_dipres }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $rsalUnidad->links() }}
</div>

@endsection
