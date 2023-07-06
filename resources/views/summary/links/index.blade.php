@extends('layouts.app')

@section('title', 'Vinculos entre tipos de eventos')

@section('content')

    @include('summary.nav')
    <div class="form-row">
        <div class="col">
            <h3 class="mb-3">Listado de Vínculos</h3>
        </div>
        <!-- <div class="col text-end">
            <a class="btn btn-success float-right" href="{{ route('summary.links.create') }}">
                <i class="fas fa-plus"></i> Nuevo Vínculo
            </a>
        </div> -->
    </div>

    @foreach($summaryTypes as $summaryType)
        <h5>
            {{ $summaryType->name }}
        </h5>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Evento Anterior</th>
                        <th class="bg-light">Evento</th>
                        <th>Evento Sucesor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summaryType->eventTypes as $eventType)
                        <tr>
                            <td>
                                <ul>
                                    @foreach ($eventType->linksBefore as $linkBefore)
                                        <li>{{ $linkBefore->beforeEvent->name ?? '' }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="bg-light">
                                <a class="btn btn-sm btn-primary" href="{{ route('summary.event-types.edit', $eventType) }}">
                                    <i class="fas fa-fw fa-edit"></i>
                                </a>
                                {{ $eventType->name ?? '' }}
                            </td>
                            <td>
                                <ul>
                                    @foreach ($eventType->linksAfter as $linkAfter)
                                        <li>{{ $linkAfter->afterEvent->name ?? '' }}</li>
                                    @endforeach

                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
@endsection
