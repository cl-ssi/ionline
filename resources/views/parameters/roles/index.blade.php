@extends('layouts.bt5.app')

@section('title', 'Roles del sistema')

@section('content')

<h3 class="mb-3">Roles del sistema</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.roles.create') }}">Crear</a>

<table class="table table-sm">
    <thead>
        <tr>
            <th>Rol</th>
            <th>Permisos</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $rol)
        <tr>
            <td>
                {{ $rol->name }} <br>
                <small class="text-muted">{{ $rol->description }}</small>
            </td>
            <td>
                <ul>
                    @foreach($rol->permissions as $permission)
                        <li>{{ $permission->name }}</li>
                    @endforeach
                </ul>
            </td>
            <td>
                <a href="{{ route('parameters.roles.edit', $rol )}}" class="btn btn-primary">
                    <i class="bi bi-pencil-square"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection

@section('custom_js')

@endsection
