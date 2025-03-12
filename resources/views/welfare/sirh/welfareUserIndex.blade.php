@extends('layouts.bt4.app')

@section('title', 'Usuarios de Bienestar')

@section('content')

@include('welfare.nav')

<h3>Usuarios de Bienestar</h3>

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
            onclick="tableToExcel('tabla_welfare', 'Usuarios')">
            <i class="fas fa-download"></i>
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm" id="tabla_welfare">
        <thead>
            <tr>
                <th scope="col">RUT</th>
                <th scope="col">Nombre</th>
                <th scope="col">Fecha Nac.</th>
                <th scope="col">Edad</th>
                <th scope="col">Tipo Afiliación</th>
                <th scope="col">Unidad</th>
                <th scope="col">Establecimiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($welfareUsers as $user)
            <tr>
                <td>{{ $user->rut }}-{{ $user->dv }}</td>
                <td>{{ $user->nombre }}</td>
                <td>{{ Carbon\Carbon::parse($user->fecha_nac)->format('d/m/Y')}}</td>
                <td>{{ $user->edad }}</td>
                <td>{{ $user->tipo_afilia }}</td>
                <td>{{ $user->unidad }}</td>
                <td>{{ $user->establ }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $welfareUsers->links() }}
</div>

@endsection