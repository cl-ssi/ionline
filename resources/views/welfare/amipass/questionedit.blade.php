@extends('layouts.bt4.app')
@section('title', 'Responder Pregunta/Sugerencia Amipass')
@section('content')
@include('welfare.nav')

    <div class="container">
        <h3 class="mb-3">Responder Pregunta/Sugerencia Amipass</h3>

        <form action="{{ route('welfare.amipass.question-update', $doubt->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre Completo Funcionario:*</label>
                <input type="text" class="form-control" id="nombre" name="nombre_completo" value="{{ $doubt->nombre_completo }}"
                    readonly required>
            </div>

            <div class="form-group">
                <label for="rut">Rut *</label>
                <input type="text" class="form-control" id="rut" name="rut" value="{{ $doubt->rut }}"
                    readonly required>
            </div>

            <div class="form-group">
                <label for="correo">Correo Electrónico *</label>
                <input type="email" class="form-control" id="correo" name="correo" value="{{ $doubt->correo }}"
                    required>
            </div>

            <div class="form-group">
                <label for="establecimiento">Establecimiento *</label>
                <input type="text" class="form-control" id="establecimiento" name="establecimiento"
                    value="{{ $doubt->establecimiento }}" readonly required>
            </div>

            <div class="form-group">
                <label for="motivo">Motivo De Consulta y/o Sugerencia *</label>
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="motivo" id="recarga" value="Recarga"
                            required @if($doubt->motivo === 'Recarga') checked @endif>
                        <label class="form-check-label" for="recarga">
                            Recarga
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="motivo" id="saldo" value="Saldo"
                            required @if($doubt->motivo === 'Saldo') checked @endif>
                        <label class="form-check-label" for="saldo">
                            Saldo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="motivo" id="estado_tarjeta"
                            value="Estado Tarjeta" required @if($doubt->motivo === 'Estado Tarjeta') checked @endif>
                        <label class="form-check-label" for="estado_tarjeta">
                            Estado Tarjeta
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="motivo" id="otra" value="Otra"
                            required @if($doubt->motivo === 'Otra') checked @endif>
                        <label class="form-check-label" for="otra">
                            Otra
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="consulta">Especifique Su Consulta y/o Sugerencia *</label>
                <textarea class="form-control" id="consulta" name="consulta" required>{{ $doubt->consulta }}</textarea>
            </div>

            <div class="form-group">
                <label for="respuesta">Respuesta *</label>
                <textarea class="form-control" id="respuesta" name="respuesta" required>{{ $doubt->respuesta }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>

        </form>
    </div>

@endsection
