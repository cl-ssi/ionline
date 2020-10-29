@extends('layouts.app')

@section('title', 'Lista de Programas')

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Programación Númerica</h3> 
@can('Programming: create')
    <a href="{{ route('programmings.create') }}" class="btn btn-info mb-4">Comenzar Nueva Programación</a>
 @endcan


<table class="table table-sm  ">
    <thead>
        <tr class="small ">
            @can('Programming: edit')<th class="text-left align-middle table-dark" ></th>@endcan
            <th class="text-left align-middle table-dark" >Id</th> 
            <th class="text-left align-middle table-dark" >Comuna</th>
            <th class="text-left align-middle table-dark" >Establecimiento</th>
            <th class="text-left align-middle table-dark" >Año</th>
            <!--<th class="text-left align-middle table-dark" >Descripción</th>-->
            <th class="text-right align-middle table-dark">Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($programmings as $programming)
        <tr class="small">
        @can('Programming: edit')
            <td ><a href="{{ route('programmings.show', $programming->id) }}" class="btn btb-flat btn-sm btn-light"><i class="fas fa-edit"></i></a></td>
        @endcan
            <td >{{ $programming->id }}</td>
            <td>{{ $programming->commune }}</td>
            <td>{{ $programming->establishment_type }} {{ $programming->establishment }}</td>
            <td>{{ $programming->year }}</td>
            <!--<td>{{ $programming->description }}</td>-->
            <td class="text-right">

                <a href="{{ route('professionalhours.index', ['programming_id' => $programming->id]) }}" class="btn btb-flat btn-sm btn-secondary">
                    <i class="fas fa-user-tag small"></i>
                    <span class="small">Profesionales</span> 
                </a>

                <a href="{{ route('programmingdays.index',['programming_id' => $programming->id]) }}"  class="btn btb-flat btn-sm btn-secondary" >
                    <i class="fas fa-calendar-alt small"></i> 
                    <span class="small">Días a Programar</span> 
                </a>

                <a href="{{ route('programmingitems.index', ['programming_id' => $programming->id]) }}" class="btn btb-flat btn-sm btn-info" >
                    <i class="fas fa-tasks small"></i> 
                    <span class="small">Actividades</span> 
                </a>

                <a href="{{ route('trainingitems.index', ['programming_id' => $programming->id]) }}" class="btn btb-flat btn-sm btn-light" >
                    <i class="fas fa-chalkboard-teacher small"></i> 
                    <span class="small">Capacitaciones</span> 
                </a>
                
            </td> 
        </tr>
        @endforeach
    </tbody>
</table>


@endsection
