@extends('layouts.bt5.app')

@section('title', 'Módulo de Sumario - Tipos de Eventos')

@section('content')

@include('summary.nav')
<div class="row">
    <div class="col">
        <h3 class="mb-3">Listado de Tipos de Eventos</h3>
    </div>
    <div class="col text-end">
        <a class="btn btn-success float-right" href="{{ route('summary.event-types.create') }}">
            <i class="fas fa-plus"></i> Nuevo Tipo de Evento
        </a>
    </div>
</div>

@foreach($summaryTypes as $summaryType)
<h5>{{ $summaryType->name }}</h5>
<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Actor</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Duración</th>
                <th>Repetición</th>
                <th>Num Rep.</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($summaryType->eventTypes as $type)
                <tr>
                    <td>{{ $type->id }}</td>
                    <td>
                        {{ $type->actor->name }}
                    </td>
                    <td>
                        @if($type->start)
                        <i class="fas fa-caret-right"></i>
                        @endif

                        {{ $type->name }}

                        @if(isset($type->actor)) <strong>({{ $type->actor->name }})</strong> @endif

                        @if($type->end)
                            <i class="fas fa-caret-left"></i>
                        @endif

                    </td>
                    <td>
                        @if($type->require_user)
                        <i class="fas fa-user"></i>
                        @endif
                        @if($type->require_file)
                        <i class="fas fa-paperclip"></i>
                        @endif
                        {{ $type->description }}
                    </td>
                    <td>{{ $type->duration }}</td>
                    <td>{{ $type->repeat_text }}</td>
                    <td>{{ $type->num_repeat }}</td>
                    <td>
                        <div class="d-flex">
                            <a class="btn btn-sm btn-primary" href="{{ route('summary.event-types.edit', $type) }}">
                                <i class="fas fa-fw fa-edit"></i>
                            </a>
                            &nbsp;&nbsp;
                            <form method="POST" action="{{ route('summary.event-types.destroy', $type) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Está seguro que desea eliminar el tipo de evento {{ $type->name }}? ' )">
                                    <i class="fas fa-fw fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endforeach
@endsection