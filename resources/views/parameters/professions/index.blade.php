@extends('layouts.app')

@section('title', 'Permisos')

@section('content')

@include('parameters/nav')
<h3 class="mb-3">Profesiones</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.professions.create') }}">Crear</a>
<table class="table table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>            
            <th>Estamento</th>            
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($professions as $profession)
        <tr>
            <td>{{ $profession->id }}</td>
            <td>{{ $profession->name }}</td>
            <td>{{ $profession->category }}</td>
            <td>{{ $profession->estamento }}</td>
            <td>
                <a href="{{ route('parameters.professions.edit', $profession )}}">
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