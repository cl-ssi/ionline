@extends('layouts.app')

@section('title', 'Roles del sistema')

@section('content')

@include('parameters/nav')

<h3 class="mb-3">Roles del sistema</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.roles.create') }}">Crear</a>

<table class="table table-sm">
    <thead>
        <tr>
            <th>Id</th>
            <th>Rol</th>
            <th>Permisos</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $rol)
        <tr>
            <td>{{ $rol->id }}</td>
            <td>{{ $rol->name }}</td>
            <td>
                <ul>
                    @foreach($rol->permissions as $permission)
                        <li>{{ $permission->name }}</li>
                    @endforeach
                </ul>
            </td>
            <td>
                <a href="{{ route('parameters.roles.edit', $rol )}}">
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
