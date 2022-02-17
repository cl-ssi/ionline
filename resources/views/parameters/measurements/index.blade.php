@extends('layouts.app')

@section('title', 'Ubicaciones')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Unidades de Medida</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.measurements.create') }}">
    Crear
</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Prefijo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($measurements as $measurement)
        <tr>
            <td>{{ $measurement->id }}</td>
            <td>{{ $measurement->name }}</td>
            <td>{{ $measurement->prefix }}</td>
            <td>
                <a href="{{ route('parameters.measurements.edit', $measurement) }}">
                    <i class="fas fa-edit"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection

@section('custom_js')

@endsection
