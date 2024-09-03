@extends('layouts.bt5.app')

@section('title', 'Módulo de Plantillas de Tipo de Eventos')

@section('content')

    @include('summary.nav')

    <div class="container">
        <h3 class="mb-3">Crear nueva plantilla</h3>
        <form method="POST" class="form-horizontal" action="{{ route('summary.templates.store') }}">
            @csrf
            @method('POST')

            <div class="mb-3 row">
                <label for="event_type" class="col-sm-2 col-form-label">Tipo de Evento</label>
                <div class="col-sm-10">
                    <select name="event_type_id" id="event_type" class="form-select" required>
                        <option value="">Seleccionar Tipo de Evento</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="name" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" required autocomplete="off">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="description" class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="description" name="description">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="template_file" class="col-sm-2 col-form-label">Archivo de Plantilla</label>
                <div class="col-sm-10">
                    <input type="file" name="template_file" id="template_file" class="form-control">
                </div>
            </div>

            <fieldset class="mb-3 row" id="campos">
                <legend class="col-form-label col-sm-2 pt-0">Campos</legend>
                <div class="col-sm-10">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="fields[{{ $i }}][nombre]"
                                placeholder="Nombre del campo ej: direccion">
                            <div class="input-group-append">
                                <select class="form-select" name="fields[{{ $i }}][tipo]">
                                    <option selected value=""> Seleccionar Opción</option>
                                    <option value="string">String</option>
                                    <option value="text">Text</option>
                                </select>
                                <button class="btn btn-danger" type="button" onclick="eliminarCampo(this)"><i
                                        class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    @endfor
                </div>
            </fieldset>

            <div class="mb-3 row">
                <div class="col-sm-12 text-end">
                    <button type="button" class="btn btn-sm btn-success" id="btnAgregarCampo">
                        <i class="fas fa-plus"></i> Agregar
                    </button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('custom_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let contadorCampos = 3; // Inicializar el contador en el último valor (3 en este caso)

            function agregarCampo() {
                contadorCampos++; // Incrementar el contador
                const nuevoCampo = `
    <div class="input-group mb-2"> <!-- Agrega la clase "input-group mb-2" aquí -->
        <input type="text" class="form-control" name="fields[${contadorCampos}][nombre]" placeholder="Nombre del campo ej: direccion">
        <div class="input-group-append">
            <select class="form-select" name="fields[${contadorCampos}][tipo]">
                <option selected value=""> Seleccionar Opción</option>
                <option value="string">String</option>
                <option value="text">Text</option>
            </select>
            <button class="btn btn-danger" type="button" onclick="eliminarCampo(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    `;
                $('#campos').append(nuevoCampo);
            }

            function eliminarCampo(boton) {
                if (contadorCampos > 3) { // Asegurarse de que haya al menos 1 campo
                    contadorCampos--; // Decrementar el contador
                    $(boton).closest('.input-group').remove(); // Eliminar el campo correspondiente
                }
            }

            // Asignar los eventos a los botones usando jQuery
            $('#btnAgregarCampo').on('click', agregarCampo);
            $('.btn-danger').on('click', function() {
                eliminarCampo(this);
            });
        });
    </script>
@endsection