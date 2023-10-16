@extends('layouts.bt4.app')
@section('title', 'Módulo de Sumario - Crear Cuerpo del Sumario')
@section('content')
    @include('summary.nav')

    <div class="card">
        <div class="card-header" style="background-color: #f2f2f2; text-align: center;">
            <h2 style="margin: 0;">Sumario: {{ $summaryEvent->summary->name ?? '' }}</h2>
        </div>
    </div>

    <div class="card-body">
        <h4 style="margin: 0;">Evento: {{ $summaryEvent->event->name ?? '' }}</h4>
        <hr>
        <form method="POST" class="form-horizontal" enctype="multipart/form-data"
            action="{{ route('summary.bodyUpdate', ['summaryEvent' => $summaryEvent->id]) }}">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="for_start_date">Fecha y Hora de Apertura de Evento</label>
                    <input type="datetime-local"" class="form-control" name="start_date"
                        value="{{ optional($summaryEvent->start_date)->format('Y-m-d\TH:i:s') }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="for_start_date">Fecha y Hora de Cierre de Evento <small>(Llenar solo en caso de finalizado
                            el evento)</small></label>
                    <input type="datetime-local"" class="form-control" name="end_date"
                        value="{{ optional($summaryEvent->end_date)->format('Y-m-d\TH:i:s') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-12">
                    <label for="for_body">Cuerpo del Evento {{ $summaryEvent->event->name ?? '' }}</label>
                    <textarea class="form-control" name="body" rows="5">{{ $summaryEvent->body ?? '' }}</textarea>
                </div>
            </div>

            <div class="form-row">
                @if ($summaryEvent->event->file === 1)
                    <hr>
                    <div class="form-group col-12">
                        <label for="file">Cargar Archivos</label>
                        <input type="file" name="files[]" multiple>
                    </div>

                    @if ($summaryEvent->files && count($summaryEvent->files) > 0)
                    <div class="form-group col-12">
                        <label>Listado de Archivos Cargados al Evento</label>
                        <ul>
                            @foreach ($summaryEvent->files as $file)
                                <li>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a
                                            href="{{ route('summary.downloadFile', ['file' => $file->id]) }}">{{ $file->name }}</a>

                                        <a href="{{ route('summary.deleteFile', ['file' => $file->id]) }}"
                                            class="btn btn-sm"
                                            onclick="return confirm('¿Está seguro/a de eliminar este Archivo?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                @endif

                @if ($summaryEvent->event->user === 1)
                    <hr>
                    <div class="form-group col-12">
                        <label for="for_user_allowance_id">Funcionario Asociado al Evento:</label>
                        @livewire('search-select-user', ['selected_id' => 'user[]', 'addUsers' => 'true'])
                    </div>
                @endif

            </div>



            <div class="form-row">
                <div class="mt-3 col-12">
                    <button type="submit" class="btn btn-success">Actualizar</button>
                    <a href="{{ route('summary.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </div>



        </form>

    </div>
@endsection
