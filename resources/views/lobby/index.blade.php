@extends('layouts.bt4.app')
@section('title', 'Listado Reuniones Lobby')
@section('content')

    <div class="form-row">
        <div class="col">
            <h3 class="mb-3">Listado de reuniones</h3>
        </div>
        <div class="col text-end">
            <a class="btn btn-success float-right" href="{{ route('lobby.meeting.create') }}">
                <i class="fas fa-plus"></i> Nueva reunión
            </a>
        </div>
    </div>

    <div class="form-row mb-4">
        <div class="col-6 col-md-3">
            <label for="responsible">Responsable</label>
            <input type="text" wire:model="filter.responsible" class="form-control">
        </div>

        <div class="col-6 col-md-3">
            <label for="subject">Asunto</label>
            <input type="text" wire:model="filter.subject" class="form-control">
        </div>

        <div class="col-6 col-md-2">
            <label for="status">Estado</label>
            <select wire:model="filter.status" class="form-control">
                <option value=""></option>
                <option value="0">Terminado</option>
                <option value="1">Pendiente</option>
            </select>
        </div>

        <div class="col-1">
            <label for="buscar">&nbsp</label>
            <button class="btn btn-primary form-control" wire:click="search">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Responsable</th>
                <th>Solicitante</th>
                <th>Asunto</th>
                <th>Participantes</th>
                <th>Estado</th>
                <th>Finalizar/Añadir Datos</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($meetings as $meeting)
                <tr>
                    <td>{{ $meeting->date }}</td>
                    <td>{{ $meeting->responsible->shortName }}</td>
                    <td>{{ $meeting->petitioner }}</td>
                    <td>{{ $meeting->subject }}</td>
                    <td>
                        @foreach ($meeting->participants as $participant)
                            <li>{{ $participant->shortName }} </li>
                        @endforeach
                    </td>
                    <td>
                        {{ $meeting->status === 0 ? 'Pendiente' : 'Terminado' }}
                    </td>
                    <td>
                        <a class="btn btn-sm btn-outline-primary"
                            href="{{ route('lobby.meeting.edit', $meeting) }}">
                            <i class="fas fa-fw fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-outline-primary" target="_blank"
                            href="{{ route('documents.lobby.show', $meeting) }}">
                            <i class="fas fa-fw fa-file"></i>
                        </a>
                        
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="confirm('¿Está seguro que desea borrar la reunión {{ $meeting->subject }}?') || event.stopImmediatePropagation()"
                            wire:click="delete({{ $meeting }})"><i class="fas fa-fw fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
