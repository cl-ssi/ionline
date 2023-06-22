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
                    <td>{{ $summary->id ?? '' }}</td>
                    <td>{{ $summary->subject ?? '' }}</td>
                    <td>{{ $summary->status ?? '' }}</td>
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
        <li>Agrear creador de evento</li>
        <li>Cambiar modelo summaryEvents a Events</li>
        <li>Cambiar model Events a EventType</li>
        <li>El event type agrega opcion: Se repite? si / no / numero de veces</li>
        <li>Cambiar atributos al tipo de evento, require_user, require_files</li>
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
        <li>
            Agregar boolean: inicio, fin, acutario, fiscal
        </li>
    </ul>
    <hr>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Eventos <small>(apretar en evento para editar o añadir eventos)</small></th>
                    <th>Estado</th>
                    <th>Usuario Creador</th>
                    <th>Finalizar Sumario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($summaries as $summary)
                    <tr>
                        <td>{{ $summary->id ?? '' }}</td>
                        <td>{{ $summary->name ?? '' }}</td>
                        <td>
                            <ul>
                                @foreach ($summary->summaryEvents as $summaryEvent)
                                    <li>
                                        <a href="{{ route('summary.body', ['summaryEvent' => $summaryEvent->id]) }}">
                                            {{ $summaryEvent->event->name ?? '' }}
                                        </a>
                                        @if ($summaryEvent->end_date)
                                            <a href="#" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                                data-target="#exampleModal{{ $summaryEvent->id }}">
                                                Agregar Evento
                                            </a>
                                        @endif
                                        {{-- Modal --}}
                                        <div class="modal fade" id="exampleModal{{ $summaryEvent->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel{{ $summaryEvent->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <form method="POST" class="form-horizontal"
                                                        action="{{ route('summary.nextEventStore') }}">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="summary_id"
                                                            value="{{ $summary->id }}">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="exampleModalLabel{{ $summaryEvent->id }}">Evento Actual
                                                                -
                                                                Evento Que Continua</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-row mb-3">
                                                                <div class="col-12 col-md-4">
                                                                    <label for="for-name">Evento Actual</label>
                                                                    <input type="text" class="form-control"
                                                                        name="name" autocomplete="off"
                                                                        value="{{ $summaryEvent->event->name ?? '' }}"
                                                                        readonly required>
                                                                </div>

                                                                <div class="col-12 col-md-4">
                                                                    <label for="for-name">Evento Que Continua</label>
                                                                    <select id="for_after_event_id" name="event_id"
                                                                        class="form-control" required>
                                                                        <option value="">Seleccionar Evento Posterior
                                                                        </option>
                                                                        @foreach ($summaryEvent->event->linksAfter as $linkAfter)
                                                                            <option
                                                                                value="{{ $linkAfter->afterEvent->id }}">
                                                                                {{ $linkAfter->afterEvent->name ?? '' }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-row mb-3">
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Guardar</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Cerrar</button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
    </div>
    {{-- Fin del modal --}}
    </li>
    @endforeach
    </ul>
    </td>
    <td>{{ $summary->status ?? '' }}</td>
    <td>{{ $summary->creator->fullname ?? '' }}</td>

    <td>
        @if (!$summary->end_date)
            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#closeSummaryModal{{ $summary->id }}">
                <i class="fas fa-times"></i> Cerrar Sumario
            </button>
        @endif
    </td>

    <!-- Modal -->
    <div class="modal fade" id="closeSummaryModal{{ $summary->id }}" tabindex="-1" role="dialog"
        aria-labelledby="closeSummaryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="closeSummaryModalLabel{{ $summary->id }}">Cerrar Sumario
                        {{ $summary->name ?? '' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('summary.closeSummary', ['summaryId' => $summary->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="closeDate">Fecha y Hora de Cierre</label>
                            <input type="datetime-local" class="form-control" id="closeDate" name="closeDate" required>
                        </div>
                        <div class="form-group">
                            <label for="observation">Observación</label>
                            <textarea class="form-control" id="observation" name="observation" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Cerrar Sumario</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </tr>
    @endforeach
    </tbody>
    </table>
    </div>
@endsection
