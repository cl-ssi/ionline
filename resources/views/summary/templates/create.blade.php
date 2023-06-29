@extends('layouts.app')
@section('title', 'Módulo de Plantillas de Tipo de Eventos')
@section('content')
    @include('summary.nav')

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h3>Subir Plantilla</h3>
                <form action="{{ route('summary.templates.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="event_type">Tipo de Evento</label>
                        <select name="event_type_id" id="event_type" class="form-control">
                        <option value="">Seleccionar Tipo de Evento</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="template_file">Archivo de Plantilla</label>
                        <input type="file" name="template_file" id="template_file" class="form-control-file" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
