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

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Eventos <small>(apretar en evento para editar o añadir eventos)</small></th>
                    <th>Estado</th>
                    <th>Usuario Creador</th>
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
                                                        <input type="hidden" name="summary_id" value="{{ $summary->id }}">
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
    </tr>
    @endforeach
    </tbody>
    </table>
    </div>
@endsection
