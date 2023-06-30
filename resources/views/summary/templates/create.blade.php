@extends('layouts.app')

@section('title', 'Módulo de Plantillas de Tipo de Eventos')

@section('content')

@include('summary.nav')

<div class="container">
    <h3 class="mb-3">Crear nueva plantilla</h3>

    <form>
        <div class="form-group row">
            <label for="for-name" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" placeholder="sin espacios y en minuscula" id="for-name">
            </div>
        </div>

        <div class="form-group row">
            <label for="for-description" class="col-sm-2 col-form-label">Descripción</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="for-description">
            </div>
        </div>

        <fieldset class="form-group row">
            <legend class="col-form-label col-sm-2 float-sm-left pt-0">Campos</legend>
            <div class="col-sm-8">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="for-description">
                    <div class="input-group-append">
                        <button class="btn btn-danger" type="button" id="button-addon2"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="for-description">
                    <div class="input-group-append">
                        <button class="btn btn-danger" type="button" id="button-addon2"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="for-description">
                    <div class="input-group-append">
                        <button class="btn btn-danger" type="button" id="button-addon2"><i class="fas fa-trash"></i></button>
                    </div>
                </div>

            </div>
        </fieldset>
        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
            <button type="submit" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Agregar</button>
            </div>
        </div>
        <div class="form-group row float-right">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
    


    <!-- <div class="form-row">
        
        <div class="col-md-6">
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
    </div> -->
</div>


@endsection
