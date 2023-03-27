@extends('layouts.app')

@section('title', 'Editar tarea de actividad '.$task->activity->name)

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Editar tarea de actividad {{ $task->activity->name}} </h3>
<br>

<form method="POST" class="form-horizontal" action="{{ route('participation.tasks.update', $task) }}">
    @csrf
    @method('PUT')
    <div class="form-row">
        <fieldset class="form-group col-sm-8">
            <label for="for_task_name">Nombre de la tarea</label>
            <input type="text" class="form-control" id="for_task_name" name="name" value="{{$task->name}}" required>
        </fieldset>

        <fieldset class="form-group col-sm">
            <label for="for_date">Fecha de ejecución</label>
            <input type="date" class="form-control" id="for_date" name="date" value="{{$task->date->format('Y-m-d')}}" readonly>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ url()->previous() }}">Volver</a>

</form>
<hr>
<h3 class="mb-3">Reprogramaciones asociadas a la tarea <button type="button" class="btn btn-info mb-4 float-right btn-sm" data-toggle="modal" data-target="#exampleModal">Reprogramar tarea</a></h3>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reprogramar tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" class="form-horizontal" action="{{ route('participation.tasks.rescheduling.store') }}">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="task_id" value="{{$task->id}}">
                    <div class="form-row">
                        <fieldset class="form-group col-sm-9">
                            <label for="for_reason">Motivo</label>
                            <input type="text" class="form-control" id="for_reason" name="reason" required>
                        </fieldset>

                        <fieldset class="form-group col-sm">
                            <label for="for_date">Fecha reprogramación</label>
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

<table id="rescheduling-table" class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th class="text-center align-middle table-dark">#</th>
            <th class="text-center align-middle table-dark">Motivo</th>
            <th class="text-center align-middle table-dark">Fecha reprogramación</th>
            {{--@if($programming->status == 'active')--}}
            <th class="text-center align-middle table-dark"></th>
            {{--@endif--}}
        </tr>
    </thead>
    <tbody>
        @forelse($task->reschedulings as $rescheduling)
        <tr class="small">
            <td class="text-left" style="width:20px;">{{$loop->iteration}}</td>
            <td class="text-left">{{$rescheduling->reason}}</td>
            <td class="text-center">{{$rescheduling->date->format('d-m-Y')}}</td>
            {{--@if($programming->status == 'active')--}}
            <td class="text-right">
                <a href="{{ route('participation.tasks.rescheduling.edit', $rescheduling) }}" class="btn btb-flat btn-xs  btn-light bt-sm">
                    <i class="fas fa-edit"></i></a>
                <form method="POST" action="{{ route('participation.tasks.rescheduling.destroy', $rescheduling) }}" class="d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Desea eliminar esta reprogramación?')"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
            {{--@endif--}}
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No hay registros de reprogramaciones asociadas a esta tarea.</td>
        </tr>
        @endforelse
    </tbody>
</table>

    @endsection