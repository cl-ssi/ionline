@extends('layouts.app')

@section('title', 'Lista de Profesionales')

@section('content')

@include('programmings/nav')
<a href="{{ route('programmingitems.create') }}" class="btn btn-info mb-4 float-right btn-sm">Agregar Item</a>
<h4 class="mb-3"> Programación - Horas Directas</h4>

<table class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover table-responsive  ">
    <thead>
        <tr class="small " style="font-size:60%;">
            <th>CICLO</th>
            <th>ACCIÓN</th>
            <th>PROGRAMA MINISTERIAL</th>
            <th>PRESTACION O ACTIVIDAD</th>
            <th>DEF. POB. OBJETIVO</th>
            <th>FUENTE POBLACIÓN</th>
            <th>N° POB. OBJETIVO</th>
            <th>PREVALENCIA O TASA</th>
            <th>FUENTE DE PREVALENCIA O TASA</th>
            <th>% COBERTURA</th>
            <th>Poblacion a Atender</th>
            <th>CONCENTRACIÓN</th>
            <th>TOTAL ACTIVIDADES</th>
            <th>FUNCIONARIO  QUE OTORGA LA PRESTACIÓN</th>
            <th>Horas Año Requeridas</th>
            <th>Horas Dia requeridas</th>
            <th>Jornadas Directas Año</th>
            <th>Jornadas Horas Directas Diarias</th>
            <th>Fuente Informacion </th>
            <th>FINANCIADA POR PRAP</th>
            <th>OBSERVACIONES</th>

        </tr>
    </thead>
    <tbody style="font-size:65%;">
        @foreach($programmingItems as $programmingitem)
        <tr class="small">
            <td>{{ $programmingitem->cycle }}</td>
            <td>{{ $programmingitem->action_type }}</td>
            <td>{{ $programmingitem->ministerial_program }}</td>
            <td>{{ $programmingitem->activity_name }}</td>
            <td>{{ $programmingitem->def_target_population }}</td>
            <td>{{ $programmingitem->source_population }}</td>
            <td>{{ $programmingitem->cant_target_population }}</td>
            <td>{{ $programmingitem->prevalence_rate }}</td>
            <td>{{ $programmingitem->source_prevalence }}</td>
            <td>{{ $programmingitem->coverture }}</td>
            <td>{{ $programmingitem->population_attend }}</td>
            <td>{{ $programmingitem->concentration }}</td>
            <td>{{ $programmingitem->activity_total }}</td>
            <td>{{ $programmingitem->professional }}</td>
            <td>{{ $programmingitem->activity_performance }}</td>
            <td>{{ $programmingitem->hours_required_year }}</td>
            <td>{{ $programmingitem->hours_required_day }}</td>
            <td>{{ $programmingitem->direct_work_year }}</td>
            <td>{{ $programmingitem->direct_work_hour }}</td>
            <td>{{ $programmingitem->information_source }}</td>
            <td>{{ $programmingitem->prap_financed }}</td>
            <td>{{ $programmingitem->observation }}</td>
            <td>{{ $programmingitem->programming_id }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
