@extends('layouts.bt4.app')
@section('title', 'Detalles de Pregunta/Sugerencia Amipass')
@section('content')

    <div class="container">
        <h3 class="mb-3">Detalles de Pregunta/Sugerencia Amipass</h3>

        <div class="form-group">
            <label for="nombre">Nombre Completo Funcionario:</label>
            <input type="text" class="form-control" id="nombre" name="nombre_completo" value="{{ $doubt->nombre_completo }}"
                readonly>
        </div>

        <div class="form-group">
            <label for="rut">Rut:</label>
            <input type="text" class="form-control" id="rut" name="rut" value="{{ $doubt->rut }}"
                readonly>
        </div>

        <div class="form-group">
            <label for="correo">Correo Electrónico:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="{{ $doubt->correo }}"
                readonly>
        </div>

        <div class="form-group">
            <label for="establecimiento">Establecimiento:</label>
            <input type="text" class="form-control" id="establecimiento" name="establecimiento"
                value="{{ $doubt->establecimiento }}" readonly>
        </div>

        <div class="form-group">
            <label for="motivo">Motivo De Consulta y/o Sugerencia:</label>
            <input type="text" class="form-control" id="motivo" name="motivo" value="{{ $doubt->motivo }}"
                readonly>
        </div>

        <div class="form-group">
            <label for="consulta">Consulta y/o Sugerencia:</label>
            <textarea class="form-control" id="consulta" name="consulta" readonly>{{ $doubt->consulta }}</textarea>
        </div>

        <div class="form-group">
            <label for="respuesta">Respuesta:</label>
            <textarea class="form-control" id="respuesta" name="respuesta" readonly>{{ $doubt->respuesta }}</textarea>
        </div>

    </div>

@endsection
