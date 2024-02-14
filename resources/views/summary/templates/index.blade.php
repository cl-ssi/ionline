@extends('layouts.bt5.app')

@section('title', 'Módulo de Plantillas de Tipo de Eventos')

@section('content')
    @include('summary.nav')
    <div class="row">
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
                    <th>Nombre</th>
                    <th>Tipo de Evento</th>
                    <th>Campos</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($templates as $template)
                    <tr>
                        <td>
                            {{ $template->name }}<br>
                            <small>
                                {{ $template->description }}
                            </small>
                        </td>
                        <td>
                            {{ $template->eventType->name }}
                        </td>
                        <td>
                            <ul>
                                @foreach($template->fields as $name => $type)
                                <li>{{ $name }} ({{ $type }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <a href="#">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
