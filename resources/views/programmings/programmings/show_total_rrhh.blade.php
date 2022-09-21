@extends('layouts.app')

@section('title', 'Total RRHH : '.$programming->establishment->type.' '.$programming->establishment->name.' '.$programming->year)

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Total RRHH {{ $programming->establishment->type }} {{ $programming->establishment->name }} {{ $programming->year}} </h3>
<br>
<table class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th class="text-center align-middle table-dark" colspan="5">Desde lo programado</th>
            <th class="text-center align-middle table-dark" colspan="3">Cálculo de FINANCIAMIENTO</th>
        </tr>
        <tr class="small">
            <th class="text-center align-middle table-dark">Funcionario/a</th>
            <th class="text-center align-middle table-dark">Horas/año</th>
            <th class="text-center align-middle table-dark">Horas/día</th>
            <th class="text-center align-middle table-dark">Jornadas directa año</th>
            <th class="text-center align-middle table-dark">Jornada horas directa diarias</th>
            <th class="text-center align-middle table-dark">Valor ($) Total año</th>
            <th class="text-center align-middle table-dark">Actividades Per capitadas</th>
            <th class="text-center align-middle table-dark">Actividades PRAPS</th>
        </tr>
    </thead>
    <tbody>
        @foreach($professionalHours as $professionalHour)
        <tr class="text-right">
            <td>{{ $professionalHour->alias }}</td>
            <td>{{ number_format($programming->getValueAcumSinceScheduled('hours_required_year', $professionalHour->id), 2, ",", ".")}}</td>
            <td>{{ number_format($programming->getValueAcumSinceScheduled('hours_required_day', $professionalHour->id), 2, ",", ".")}}</td>
            <td>{{ number_format($programming->getValueAcumSinceScheduled('direct_work_year', $professionalHour->id), 2, ",", ".")}}</td>
            <td>{{ number_format($programming->getValueAcumSinceScheduled('direct_work_hour', $professionalHour->id), 5, ",", ".")}}</td>
            <td>$ {{ number_format($programming->getValueAcumSinceScheduled('hours_required_year', $professionalHour->id) * $professionalHour->value, 0, ",", ".")}}</td>
            <td>{{ number_format($programming->getCountActivitiesByPrapFinanced('NO', $professionalHour->id), 2, ",", ".")}}</td>
            <td>{{ number_format($programming->getCountActivitiesByPrapFinanced('SI', $professionalHour->id), 2, ",", ".")}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection