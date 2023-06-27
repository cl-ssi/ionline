@extends('layouts.app')

@section('title', 'Módulo de Sumario')

@section('content')

@include('summary.nav')

<div class="form-row">
    <div class="col">
        <h3 class="mb-3">Listado de Mis Sumarios</h3>
    </div>
    <div class="col text-end">
        <a class="btn btn-success float-right" href="{{ route('summary.create') }}">
            <i class="fas fa-plus"></i> Nuevo Sumario
        </a>
    </div>
</div>


<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Asunto</th>
            <th>Estado</th>
            <th>Duración</th>
            <th>Fiscal</th>
            <th>Actuario</th>
            <th width="60"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($summaries as $summary)
            <tr>
                <td>{{ $summary->id }}</td>
                <td>{{ $summary->subject }}</td>
                <td>{{ $summary->status }}</td>
                <td>{{ $summary->start_at->diffInDays(now()) }}</td>
                <td>{{ optional($summary->investigator)->tinnyName }}</td>
                <td>{{ optional($summary->actuary)->tinnyName }}</td>
                <td>
                    <a href="{{ route('summary.edit', $summary) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<ul>        
    <del><li>Cambiar modelo summaryEvents a Events</li></del>
    <li>El modelo evento tiene que tener relación con EventType con el nombre Type solamente ej:
        $event->type->riquire_user</li>
    <li>Tablas:
        <ul>

            <li>
                sum_summaries,
            </li>
            <li>
                sum_summary_events,
            </li>
            <li>
                sum_summary_event_files
            </li>
            <li>
                sum_event_types,
            </li>
            <li>
                sum_event_links,
            </li>
        </ul>
    </li>
</ul>
 @endsection
