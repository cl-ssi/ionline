@extends('layouts.app')

@section('title', 'Lista de Profesionales')

@section('content')

@include('programmings/nav')

<h3 class="mb-3"> Tipos de Acciones</h3>

<table class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th>ID</th>
            <th>NOMBRE</th>
            <th>ALIAS</th>
        </tr>
    </thead>
    <tbody>
        @foreach($actionTypes as $actiontype)
        <tr class="small">
            <td>{{ $actiontype->id }}</td>
            <td>{{ $actiontype->name }}</td>
            <td>{{ $actiontype->alias }}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
