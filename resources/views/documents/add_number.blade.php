@extends('layouts.bt4.app')

@section('title', 'Agregar Número a Documento')

@section('content')

@include('documents.partes.partials.nav')

<h3 class="mb-3">Agregar Número a Documento</h3>

<form class="form-inline" method="POST" action="{{ route('documents.find')}}">
    @csrf
    <div class="form-group mr-3 mb-2">
        <label for="for_id" class="sr-only">ID</label>
        <input type="text" class="form-control" name="id" id="for_id"
            value="{{ isset($document) ? $document->id:'' }}" placeholder="ID">
    </div>
    <button type="submit" class="btn btn-primary mb-2 mr-3"><i class="fas fa-search" aria-hidden="true"></i></button>
    <a href="{{ route('documents.add_number') }}" class="btn btn-outline-secondary mb-2 mr-3"> Limpiar </a>
</form>

<br>

@if(isset($document))

    <div class="form-row">
        <div class="col-12">
            <label for="for-number"><strong>Número </strong></label>
            @livewire('documents.enumerate',['document' => $document, 'delete' => true])
        </div>
        <div class="col">
            <p> <strong>De:</strong> {!! $document->fromHtml !!} </p>
        </div>
        <div class="col">
            <p> <strong>Tipo:</strong> {{ optional($document->type)->name }}<br>
            <strong>Propietario:</strong> {{ $document->user->fullName }} </p>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <p> <strong>Para:</strong> {!! $document->forHtml !!} </p>
        </div>
        <div class="col">
            <p> <strong>Materia:</strong> {{ $document->subject }} </p>
        </div>
    </div>

    @if($document->file)
        <div class="form-row">
            <div class="col">
                <strong>Distribución:</strong>
                <pre>{{ $document->distribution }} </pre>
            </div>
        </div>
        <strong>Número</strong> {{ $document->number }} -
        <strong>Fecha:</strong> {{ $document->date ? $document->date->format('d-m-Y'):'' }} -
        <strong>Archivo:</strong>
            @if($document->file)
                @if((int) $document->updated_at->diffInDays('now') <= 7)
                    <a href="{{ route('documents.download', $document) }}" target="_blank">
                        <i class="fas fa-file-pdf fa-lg"></i>
                    </a>
                    <form action="{{ route('documents.delete_file', $document) }}" method="POST" class="form-inline">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-sm btn-outline-danger" >
                            <i class="fas fa-trash fa-lg"></i> Eliminar archivo
                        </button>
                    </form>
                @else
                    <strong class="text-danger">No se puede borrar, tiene más de 7 días de antiguedad</strong>
                @endif
            @endif

    @else

        <form method="POST" class="form-horizontal" enctype="multipart/form-data"
            action="{{ route('documents.store_number', $document) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <fieldset class="form-group col">
                    <label for="for-distribution"><strong>Distribución:</strong></label>
                    <textarea name="distribution" rows="10" class="form-control">{{ $document->distribution }}</textarea>
                </fieldset>
            </div>

            <div class="form-row">

                <fieldset class="form-group col-2">
                    <label for="for_number">Número</label>
                    <input type="text" class="form-control" id="for_number"
                        value="{{ $document->number }}" name="number"
                        required>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for_date">Fecha</label>
                    <input type="date" class="form-control" id="for_date" name="date"
                        value="{{ $document->date ? $document->date->format('Y-m-d') : '' }}"
                        required="required">
                </fieldset>

                <fieldset class="form-group col">
                    <label for="for_file">Archivo</label>
                    <input type="file" class="form-control-file" id="for_file"
                        name="file" required>
                    <small class="form-text text-muted">Tamaño máximo 32 MB</small>
                </fieldset>

                <div class="form-check form-check-inline col">
                    <input class="form-check-input" name="sendMail" type="checkbox"
                        id="for_sendMail" value="true" checked disabled>
                    <label class="form-check-label" for="for_sendMail">Enviar mail a distribución</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mr-4">Guardar</button>

        </form>
    @endif

@else
<p>
    No se ha encontrado un documento con el ID indicado
</p>
@endif


@endsection

@section('custom_js')

@endsection
