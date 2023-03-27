@extends('layouts.app')

@section('title', 'Editar actividad de participación '.$programming->establishment->type.' '.$programming->establishment->name.' '.$programming->year)

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Editar actividad de participación {{ $programming->establishment->type }} {{ $programming->establishment->name }} {{ $programming->year}} </h3>
<br>

<form method="POST" class="form-horizontal" action="{{ route('participation.update', $value) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="programming_id" value="{{$programming->id}}">
    <div class="form-row">
        <fieldset class="form-group col-sm-8">
            <label for="for_activity_name">Nombre de la actividad</label>
            <input type="text" class="form-control" id="for_activity_name" name="activity_name" value="{{$value->activity_name}}" required>
        </fieldset>

        <fieldset class="form-group col-sm">
            <label for="for_value">N° veces que se realizará la actividad en el año</label>
            <input type="number" min="1" class="form-control" id="for_value" value="{{$value->value}}" readonly>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('participation.show', $programming->id) }}">Volver</a>

</form>
<hr>
<h3 class="mb-3">Tareas asociadas a la actividad @if($value->tasks->count() < $value->value) <button type="button" class="btn btn-info mb-4 float-right btn-sm" data-toggle="modal" data-target="#exampleModal">Agregar tarea</a>@endif</h3>
@if($value->tasks->count() < $value->value)
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" class="form-horizontal" action="{{ route('participation.tasks.store') }}">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="activity_id" value="{{$value->id}}">
                        <div class="form-row">
                            <fieldset class="form-group col-sm-9">
                                <label for="for_name">Nombre de la tarea</label>
                                <input type="text" class="form-control" id="for_name" name="name" required>
                            </fieldset>

                            <fieldset class="form-group col-sm">
                                <label for="for_date">Fecha ejecución</label>
                                <input type="date" class="form-control" id="for_date" name="date" required>
                            </fieldset>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<table id="tasks-table" class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th class="text-center align-middle table-dark" rowspan="2">#</th>
            <th class="text-center align-middle table-dark" rowspan="2">Nombre</th>
            <th class="text-center align-middle table-dark" rowspan="2">Fecha ejecución</th>
            <th class="text-center align-middle table-dark" colspan="3">Reprogramaciones</th>
            @if($programming->status == 'active')
            <th class="text-center align-middle table-dark" rowspan="2"></th>
            @endif
        </tr>
        <tr class="small">
            <th class="text-center align-middle table-dark">#</th>
            <th class="text-center align-middle table-dark">Motivo</th>
            <th class="text-center align-middle table-dark">Fecha</th>
        </tr>
    </thead>
    <tbody>
        @forelse($value->tasks as $task)
        <tr class="small">
            <td class="text-left" style="width:20px;" rowspan="{{$task->rowspanCount }}">{{$loop->iteration}}</td>
            <td class="text-left" rowspan="{{$task->rowspanCount }}">{{$task->name}}</td>
            <td class="text-center" rowspan="{{$task->rowspanCount }}">{{$task->date->format('d-m-Y')}}</td>
            <td class="text-center" >{{$task->reschedulings->first() ? 1 : ''}}</td>
            <td class="text-left" >{{$task->reschedulings->first()->reason ?? ''}}</td>
            <td class="text-center">{{$task->reschedulings->first() ? $task->reschedulings->first()->date->format('d-m-Y') : ''}}</td>
            @if($programming->status == 'active')
            <td class="text-right" rowspan="{{$task->rowspanCount }}">
                <a href="{{ route('participation.tasks.edit', $task) }}" class="btn btb-flat btn-xs  btn-light btn-sm">
                    <i class="fas fa-edit"></i></a>
                <form method="POST" action="{{ route('participation.tasks.destroy', $task) }}" class="d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Desea eliminar esta tarea?')"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
            @endif
        </tr>
        @foreach($task->reschedulings as $reschedulings)
        @if(!$loop->first)
        <tr class="small">
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-left">{{$reschedulings->reason}}</td>
            <td class="text-center">{{$reschedulings->date->format('d-m-Y')}}</td>
        </tr>
        @endif
        @endforeach
        @empty
        <tr>
            <td colspan="4" class="text-center">No hay registros de tareas asociadas a esta actividad.</td>
        </tr>
        @endforelse
    </tbody>
</table>

    @endsection