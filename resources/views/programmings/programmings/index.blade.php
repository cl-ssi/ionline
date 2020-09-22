@extends('layouts.app')

@section('title', 'Lista de Programas')

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Programas</h3> 
<a href="{{ route('programmings.create') }}" class="btn btn-info mb-4">Comenzar Nueva Programación</a>

<table class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th>Id</th>
            <th>Año</th>
            <th>Establecimiento</th>
            <th>Descripción</th>
            <th class="text-right">Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($programmings as $programming)
        <tr class="small">
            <td>{{ $programming->id }}</td>
            <td>{{ $programming->year }}</td>
            <td>{{ $programming->establishment_id }}</td>
            <td>{{ $programming->description }}</td>
            <td class="text-right">
                <a  class="btn btb-flat btn-sm btn-secondary" href="">
                    <i class="fas fa-user-tag small"></i>
                    <span class="small">Profesionales Hora</span> 
                </a>

                <a class="btn btb-flat btn-sm btn-info" href="">
                    <i class="fas fa-users small"></i> 
                    <span class="small">Población</span> 
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
