@extends('layouts.bt4.app')

@section('title', 'Lista de Tipos de Establecimientos')

@section('content')

<h3 class="mb-3">Tipos de Establecimientos</h3>


<a class="btn btn-primary mb-3" href="{{ route('parameters.establishment_types.create') }}">Crear</a>


<table class="table table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($establishmentTypes as $establishmentType)
        <tr>
            <td>{{ $establishmentType->id??'' }}</td>
            <td>{{ $establishmentType->name??'' }}</td>            
            <td>
                <a href="{{ route('parameters.establishment_types.edit', $establishmentType )}}">
                <i class="fas fa-edit"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection