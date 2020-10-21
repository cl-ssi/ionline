@extends('layouts.app')

@section('title', 'Lista de Profesionales')

@section('content')

@include('programmings/nav')
<a href="{{ route('programmingitems.create',['programming_id' => Request::get('programming_id')]) }}" class="btn btn-info mb-4 float-right btn-sm">Agregar Item</a>
<h4 class="mb-3"> Programación - Horas Directas</h4>

<table class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover table-responsive  ">
    <thead>
        <tr class="small " style="font-size:55%;">
            @can('Programming: edit')<th class="text-left align-middle" ></th>@endcan
            <th class="text-center align-middle">CICLO</th>
            <th class="text-center align-middle">ACCIÓN</th>
            <!--<th class="text-center align-middle">PROGRAMA MINISTERIAL</th>-->
            <th class="text-center align-middle">PRESTACION O ACTIVIDAD</th>
            <th class="text-center align-middle">DEF. POB. OBJETIVO</th>
            <th class="text-center align-middle">FUENTE POBLACIÓN</th>
            <th class="text-center align-middle">N° POB. OBJETIVO</th>
            <th class="text-center align-middle">PREVALENCIA O TASA</th>
            <th class="text-center align-middle">FUENTE DE PREVALENCIA O TASA</th>
            <th class="text-center align-middle">% COBERTURA</th>
            <th class="text-center align-middle">Poblacion a Atender</th>
            <th class="text-center align-middle">CONCENTRACIÓN</th>
            <th class="text-center align-middle">TOTAL ACTIVIDADES</th>
            <th class="text-center align-middle">FUNCIONARIO  QUE OTORGA LA PRESTACIÓN</th>
            <th class="text-center align-middle">Rendimiento de la Actividad</th>
            <th class="text-center align-middle">Horas Año Requeridas</th>
            <th class="text-center align-middle">Horas Dia requeridas</th>
            <th class="text-center align-middle">Jornadas Directas Año</th>
            <th class="text-center align-middle">Jornadas Horas Directas Diarias</th>
            <th class="text-center align-middle">Fuente Informacion </th>
            <th class="text-center align-middle">FINANCIADA POR PRAP</th>
            <th class="text-center align-middle">OBSERVACIONES</th>

        </tr>
    </thead>
    <tbody style="font-size:65%;">
        @foreach($programmingItems as $programmingitem)
        <tr class="small">
        @can('Programming: edit')
            <td ><a href="{{ route('programmingitems.show', $programmingitem->id) }}" class="btn btb-flat btn-sm btn-light"><i class="fas fa-edit"></i></a></td>
        @endcan
            <td class="text-center align-middle">{{ $programmingitem->cycle }}</td>
            <td class="text-center align-middle">{{ $programmingitem->action_type }}</td>
            <!--<td class="text-center align-middle">{{ $programmingitem->ministerial_program }}</td>-->
            <td class="text-center align-middle">{{ $programmingitem->activity_name }}</td>
            <td class="text-center align-middle">{{ $programmingitem->def_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingitem->source_population }}</td>
            <td class="text-center align-middle">{{ $programmingitem->cant_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingitem->prevalence_rate }}</td>
            <td class="text-center align-middle">{{ $programmingitem->source_prevalence }}</td>
            <td class="text-center align-middle">{{ $programmingitem->coverture }}</td>
            <td class="text-center align-middle">{{ $programmingitem->population_attend }}</td>
            <td class="text-center align-middle">{{ $programmingitem->concentration }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activity_total }}</td>
            <td class="text-center align-middle">{{ $programmingitem->professional }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activity_performance }}</td>
            <td class="text-center align-middle">{{ $programmingitem->hours_required_year }}</td>
            <td class="text-center align-middle">{{ $programmingitem->hours_required_day }}</td>
            <td class="text-center align-middle">{{ $programmingitem->direct_work_year }}</td>
            <td class="text-center align-middle">{{ $programmingitem->direct_work_hour }}</td>
            <td class="text-center align-middle">{{ $programmingitem->information_source }}</td>
            <td class="text-center align-middle">{{ $programmingitem->prap_financed }}</td>
            <td class="text-center align-middle">{{ $programmingitem->observation }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
