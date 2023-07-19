@extends('layouts.app')

@section('title', 'Módulo de Plantillas de Tipo de Eventos')

@section('content')

    @include('summary.nav')

    <div class="container">
        <h3 class="mb-3">Crear nueva plantilla</h3>
        <form method="POST" class="form-horizontal" action="{{ route('summary.templates.store') }}"
            enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="form-group row">
                <label for="event_type" class="col-sm-2 col-form-label">Tipo de Evento</label>
                <div class="col-sm-10">
                    <select name="event_type_id" id="event_type" class="form-control">
                        <option value="">Seleccionar Tipo de Evento</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name">
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="description" name="description">
                </div>
            </div>

            <div class="form-group row">
                <label for="template_file" class="col-sm-2 col-form-label">Archivo de Plantilla</label>
                <div class="col-sm-10">
                    <input type="file" name="template_file" id="template_file" class="form-control-file">
                </div>
            </div>



            <fieldset class="form-group row">
                <legend class="col-form-label col-sm-2 float-sm-left pt-0">Campos</legend>
                <div class="col-sm-10">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="fields[{{ $i }}][nombre]" placeholder="Nombre del campo ej: direccion">
                            <div class="input-group-append">
                                <select class="custom-select" name="fields[{{ $i }}][tipo]" required>
                                    <option selected value=""> Seleccionar Opción</option>
                                    <option value="string">String</option>
                                    <option value="text">Text</option>
                                </select>
                                <button class="btn btn-danger" type="button"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    @endfor
                </div>
            </fieldset>



            <div class="form-group row">
                <div class="col-sm-12 text-right">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Agregar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
@endsection
