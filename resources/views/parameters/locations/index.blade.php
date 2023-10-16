@extends('layouts.bt4.app')

@section('title', 'Ubicaciones')

@section('content')

<div class="row">
    <div class="col">
        <h3 class="mb-3">Ubicaciones</h3>
    </div>
    <div class="col text-right">
        <a
            class="btn btn-primary mb-3"
            href="{{ route('parameters.locations.create', $establishment) }}"
        >
            Crear
        </a>
    </div>
</div>

<table class="table">
    <thead>
        <tr>
            <th class="text-center">ID</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($locations as $location)
        <tr>
            <td class="text-center">{{ $location->id }}</td>
            <td>{{ $location->name }}</td>
            <td>{{ $location->address }}</td>
            <td>
                <a
                    href="{{ route('parameters.locations.edit', [
                        'establishment' => $establishment,
                        'location' => $location,
                    ]) }}"
                >
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
