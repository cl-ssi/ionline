@extends('layouts.app')

@section('title', 'Lista de Programas')

@section('content')

@include('agreements/nav')

<h3 class="mb-3">Programas</h3>

<table class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th>Id</th>
            <th>Nombre</th>
            <th>Componentes</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($programs as $program)
        <tr class="small">
            <td>{{ $program->id }}</td>
            <td>{{ $program->name }}</td>
            <td>
                <ul>
                    @foreach($program->components as $component)
                        <li>{{ $component->name }}</li>
                    @endforeach
                </ul>
            </td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
