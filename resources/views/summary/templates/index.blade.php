@extends('layouts.app')
@section('title', 'Módulo de Plantillas de Tipo de Eventos')
@section('content')
    @include('summary.nav')
    <div class="form-row">
        <div class="col">
            <h3 class="mb-3">Listado de Plantillas para Tipos de Eventos</h3>
        </div>
        <div class="col text-end">
            <a class="btn btn-success float-right" href="{{ route('summary.templates.create') }}">
                <i class="fas fa-plus"></i> Nueva Plantilla para Tipo de Evento
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Tipo de Evento</th>
                    <th>Plantillas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eventTypes as $eventType)
                    <tr>
                        <td>{{ $eventType->name }}</td>
                        <td>
                            <ul>
                                @foreach ($eventType->templates as $template)
                                    <li>
                                        <a href="{{ route('summary.templates.download', ['file' => $template->id]) }}"><i
                                                class="fas fa-paperclip"></i> {{ $template->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
