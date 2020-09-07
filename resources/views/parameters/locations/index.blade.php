@extends('layouts.app')

@section('title', 'Ubicaciones')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Ubicaciones</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.locations.create') }}">
    Crear
</a>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($locations as $location)
        <tr>
            <td>{{ $location->name }}</td>
            <td>{{ $location->address }}</td>
            <td>
                <a href="{{ route('parameters.locations.edit', $location) }}">
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
