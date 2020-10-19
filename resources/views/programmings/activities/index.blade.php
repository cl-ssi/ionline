@extends('layouts.app')

@section('title', 'Lista de Programas')

@section('content')

@include('programmings/nav')

<h4 class="mb-3">Parametrización de Actividades y Prestaciones del Año</h4> 
<a href="{{ route('activityprograms.create') }}" class="btn btn-info mb-4">Nueva Parametrización</a>

<table class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th>Id</th>
            <th>Año</th>
            <th>Descripción</th>
            <th class="text-right">Detalle</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activityPrograms as $activityProgram)
        <tr class="small">
            <td>{{ $activityProgram->id }}</td>
            <td>{{ $activityProgram->year }}</td>
            <td>{{ $activityProgram->description }}</td>
            <td class="text-right">

                <a href="{{ route('activityitems.index', ['activityprogram_id' => $activityProgram->id]) }}" class="btn btb-flat btn-sm btn-info" >
                    <i class="fas fa-tasks small"></i> 
                    <span class="small">Actividades</span> 
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
