@extends('layouts.app')
@section('title', 'Módulo de Sumario - Eventos')
@section('content')
    @include('summary.nav')
    <div class="form-row">
        <div class="col">
            <h3 class="mb-3">Listado de Tipos de Eventos</h3>
        </div>
        <div class="col text-end">
            <a class="btn btn-success float-right" href="{{ route('summary.events.create') }}">
                <i class="fas fa-plus"></i> Nuevo Tipo de Evento
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Duracción</th>
                    <th>Usuario</th>
                    <th>Archivo</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Investigador</th>
                    <th>Actuario</th>
                    <th>Repetición</th>
                    <th>Num Rep.</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $event->id ?? '' }}</td>
                        <td>{{ $event->name ?? '' }}</td>
                        <td>{{ $event->duration ?? '' }}</td>
                        <td>{{ $event->user_text ?? '' }}</td>
                        <td>{{ $event->file_text ?? '' }}</td>
                        <td>{{ $event->start_text ?? '' }}</td>
                        <td>{{ $event->end_text ?? '' }}</td>
                        <td>{{ $event->investigator_text ?? '' }}</td>
                        <td>{{ $event->actuary_text ?? '' }}</td>
                        <td>{{ $event->repeat_text ?? '' }}</td>
                        <td>{{ $event->num_repeat ?? '' }}</td>
                        <td>
                            <div class="d-flex ">
                                <a class="btn btn-sm btn-primary me-2" href="{{ route('summary.events.edit', $event) }}">
                                    <i class="fas fa-fw fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('summary.events.destroy', $event) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Está seguro que desea eliminar el tipo de evento {{ $event->name }}? ' )">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
