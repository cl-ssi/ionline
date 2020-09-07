@extends('layouts.app')

@section('title', 'Lugar')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Lugar</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.places.create') }}">
    Crear
</a>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Ubicación</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($places as $place)
        <tr>
            <td>{{ $place->name }}</td>
            <td>{{ $place->description }}</td>
            <td>{{ $place->location->name }}</td>
            <td>
                <a href="{{ route('parameters.places.edit', $place) }}">
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
