@extends('layouts.app')

@section('title', 'Permisos')

@section('content')

@include('parameters/nav')

@if ($guard == 'web')
<h3 class="mb-3">Permisos Internos</h3>
@else
<h3 class="mb-3">Permisos Externos</h3>
@endif


<a class="btn btn-primary mb-3" href="{{ route('parameters.permissions.create', $guard) }}">Crear</a>

<table class="table table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Guard</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($permissions as $permission)
        <tr>
            <td>{{ $permission->id }}</td>
            <td>{{ $permission->name }}</td>
            <td>{{ $permission->descripcion }}</td>
            <td>{{ $permission->guard_name }}</td>
            <td>
                <a href="{{ route('parameters.permissions.edit', $permission->id )}}">
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
