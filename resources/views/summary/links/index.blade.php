@extends('layouts.app')
@section('title', 'Módulo de Vinculos')
@section('content')
    @include('summary.nav')
    <div class="form-row">
        <div class="col">
            <h3 class="mb-3">Listado de Vínculos</h3>
        </div>
        <div class="col text-end">
            <a class="btn btn-success float-right" href="{{ route('summary.links.create') }}">
                <i class="fas fa-plus"></i> Nuevo Vínculo
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Evento Anterior</th>
                    <th>Evento</th>
                    <th>Evento Sucesor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>
                            <ul>
                                @foreach ($event->linksBefore as $linkBefore)
                                    <li>{{ $linkBefore->beforeEvent->name ?? '' }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $event->name ?? '' }}</td>
                        <td>
                            <ul>
                                @foreach ($event->linksAfter as $linkAfter)
                                    <li>{{ $linkAfter->afterEvent->name ?? '' }}</li>
                                @endforeach

                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
