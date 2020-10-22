@extends('layouts.app')

@section('title', 'Lista de Actividades')

@section('content')

@include('programmings/nav')
<a href="{{ route('activityitems.create',['activityprogram_id' => Request::get('activityprogram_id')]) }}" class="btn btn-info mb-4 float-right btn-sm">Agregar Item</a>
<h4 class="mb-3"> Listado de Actividades y Prestaciones</h4>
<span style="font-size:60%;"><i class="fas fa-thumbtack"></i> Trazadora</span>

<table class="table table-striped  table-sm table-bordered table-condensed fixed_headers   ">
    <thead>
        <tr class="small " style="font-size:60%;">
            <th class="text-center align-middle table-dark">ID</th>
            <th class="text-center align-middle table-dark">TRAZADORA</th>
            <th class="text-center align-middle table-dark">CICLO VITAL</th>
            <th class="text-center align-middle table-dark">TIPO DE ACCIÓN</th>
            <th class="text-center align-middle table-dark">ACTIVIDAD</th>
            <th class="text-center align-middle table-dark">POBLACION</th>
            <th class="text-center align-middle table-dark">REM</th>
            <th class="text-center align-middle table-dark">PROFESIONAL</th>
        </tr>
    </thead>
    <tbody style="font-size:65%;">
        @foreach($activityItems as $activityItem)
        <tr class="small">
            <td>{{ $activityItem->id }}</td>
            @if($activityItem->tracer =='Y')     
                <td class="text-center"><i class="fas fa-thumbtack text-info"></i></td>
            @else
                <td></td>        
            @endif
            <td>{{ $activityItem->vital_cycle }}</td>
            <td>{{ $activityItem->action_type }}</td>
            <td>{{ $activityItem->activity_name }}</td>
            <td>{{ $activityItem->def_target_population }}</td>
            <td>{{ $activityItem->verification_rem }}</td>
            <td>{{ $activityItem->professional }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
