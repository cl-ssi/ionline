@extends('layouts.bt5.app')

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
                                        @if($linkBefore->beforeEvent)
                                            <li>
                                                @if($linkBefore->beforeEvent->start)
                                                    <i class="fas fa-caret-right"></i>
                                                @endif

                                                <a class="text-link" href="{{ route('summary.event-types.edit', $linkBefore->beforeEvent) }}">
                                                [{{ $linkBefore->beforeEvent->actor->name }}] 
                                                {{ $linkBefore->beforeEvent->name ?? '' }}
                                                </a>

                                                @if($linkBefore->beforeEvent->end)
                                                    <i class="fas fa-caret-left"></i>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </td>
                            <td class="bg-light">
                                @if($eventType->start)
                                    <i class="fas fa-caret-right"></i>
                                @endif

                                <a class="text-link" href="{{ route('summary.event-types.edit', $eventType) }}">
                                    [{{ $eventType->actor->name }}] 
                                    {{ $eventType->name ?? '' }}
                                </a>

                                @if($eventType->end)
                                    <i class="fas fa-caret-left"></i>
                                @endif
                            </td>
                            <td>
                                <ul>
                                    @foreach ($eventType->linksAfter as $linkAfter)
                                        <li>
                                            @if($linkAfter->afterEvent)
                                                @if($linkAfter->afterEvent?->start)
                                                    <i class="fas fa-caret-right"></i>
                                                @endif

                                                @if($linkAfter->afterEvent?->sub_event) &nbsp;&nbsp; @endif
                                                <a class="text-link" href="{{ route('summary.event-types.edit', $linkAfter->afterEvent) }}">
                                                [{{ $linkAfter->afterEvent->actor->name }}] 
                                                {{ $linkAfter->afterEvent->name ?? '' }}
                                                </a>

                                                @if($linkAfter->afterEvent->end)
                                                    <i class="fas fa-caret-left"></i>
                                                @endif
                                            @endif
                                        </li>
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
