@extends('layouts.app')

@section('title', 'Listado de Mis Solicitudes de Idoneidad')

@section('content')

@include('suitability.nav')

<h3 class="mb-3">Listado de mis Solicitudes de Idoneidad</h3>

<table class="table">
    <thead>
        <tr>
            <th>Nombre Completo</th>
            <th>Run</th>
            <th>Cargo</th>
            <th>Número contacto</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Nombre ApellidoP ApellidM</td>
            <td>12346578-9</td>
            <td>Fonoaudiologo</td>
            <td>Teléfono</td>
            <td>Por Aprobar Director</td>
            <td>
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>Nombre ApellidoP ApellidM</td>
            <td>16055586-6</td>
            <td>Informático</td>
            <td>Teléfono</td>
            <td>Pendiente de Videollamada</td>
            <td>
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        </tr>
    </tbody>

</table>


@endsection

@section('custom_js')

@endsection