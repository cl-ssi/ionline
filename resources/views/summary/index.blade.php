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
                <th>Nº Res.</th>
                <th>Fecha Res.</th>
                <th>Estado/Último Evento</th>
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
                    <td>{{ $summary->resolution_number }}</td>
                    <td>{{ $summary->resolution_date->format('d-m-Y') }}</td>
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
        <li>
            Programar el update de evento:
            <ul>
                <li>Cierre de sumario</li>
                <li>Asignación de fiscal</li>
                <li>Asignación de actuario</li>
            </ul>
        </li>
        <li>
            Columna Estado, mostrar el nombre del tipo del ultimo evento $event->type->name (que no sea subevento)
        </li>
        <li>
            <del>Mostrar el Cuadro verde de "Agregar nuevo evento" sólo si el evento anterior está cerrado ( que no sea de tipo
            sub evento el anterior)</del>
        </li>
        <li>
            Crear controler FileController que se preocupe, de cargar, borrar y descargar los documentos.
        </li>
        <li>
            El index, que muestre los eventos en los que yo soy Fiscal o Actuario o creador
        </li>
        <li>
            Un sumario cerrado, no debe permitir agregar eventos.
        </li>
        <li>
            Si un evento tiene vinculos de sub eventos, mostrar el cuadro verde dentro del card del evento, para poder
            crearle sub eventos sin que se haya cerrado.
            Una vez cerrario, no mostrar el cuadro verde para cargarle sub eventos.
        </li>
        <li>
            Al editar un EventType, mostrar las 3 columnas de vinculos (como la hoja de vinculos),
            previous | current event | next (las dos primeras informativas la ultima es la de los checkbox)
        </li>
        <li>
            Crear modelo Plantilla (template) asociado a EventType, un eventType puede tener 1 a n plantillas
        </li>

        <li><del>Cambiar modelo summaryEvents a Events</del></li>
        <li><del>El modelo evento tiene que tener relación con EventType con el nombre Type solamente ej:
                $event->type->riquire_user</del></li>
        <li>Tablas:
            <ul>

                <li>
                    <del>sum_summaries,</del>
                </li>
                <li>
                    <del>sum_summary_events,</del>
                </li>
                <li>
                    <del>sum_summary_event_files</del>
                </li>
                <li>
                    <del>sum_event_types</del>
                </li>
                <li>
                    <del>sum_event_links</del>
                </li>
            </ul>
        </li>
    </ul>
@endsection
