@extends('layouts.app')

@section('title', 'Lista de Profesionales')

@section('content')

@include('programmings/nav')
<a href="{{ route('programmingitems.create') }}" class="btn btn-info mb-4 float-right btn-sm">Agregar Item</a>
<h4 class="mb-3"> Programación - Horas Directas</h4>

<table class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover  ">
    <thead>
        <tr class="small " style="font-size:60%;">
            <th>ID</th>
            <th>TRAZADORA</th>
            <th>TIPO DE ACCIÓN</th>
            <th>ACTIVIDAD</th>
        </tr>
    </thead>
    <tbody style="font-size:65%;">
        @foreach($activityItems as $activityItem)
        <tr class="small">
            <td>{{ $activityItem->id }}</td>
            <td>{{ $activityItem->tracer }}</td>
            <td>{{ $activityItem->action_type }}</td>
            <td>{{ $activityItem->activity_name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
