@extends('layouts.bt4.app')
@section('title', 'Nueva Preguntas/Sugerencias Amipass')
@section('content')

    <div class="container">
        <h3 class="mb-3">Nueva Pregunta Amipass</h3>

        <form action="{{route('welfare.amipass.question-store')}}" method="POST">
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="nombre">Nombre Completo Funcionario:*</label>
                <input type="text" class="form-control" id="nombre" name="nombre_completo" value="{{ $user->full_name }}" readonly
                    required>
            </div>

            <div class="form-group">
                <label for="rut">Rut *</label>
                <input type="text" class="form-control" id="rut" name="rut" value="{{ $user->runFormat }}"
                    readonly required>
            </div>

            <div class="form-group">
                <label for="correo">Correo Electrónico *</label>
                <input type="email" class="form-control" id="correo" name="correo" value="{{ $user->email }}"
                    required>
            </div>

            <div class="form-group">
                <label for="establecimiento">Establecimiento *</label>
                <input type="text" class="form-control" id="establecimiento" name="establecimiento"
                    value="{{ $user->organizationalunit->establishment->name }}" readonly required>
            </div>

            <div class="form-group">
                <label for="motivo">Motivo De Consulta y/o Sugerencia *</label>
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="motivo" id="recarga" value="Recarga"
                            required>
                        <label class="form-check-label" for="recarga">
                            Recarga
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="motivo" id="saldo" value="Saldo"
                            required>
                        <label class="form-check-label" for="saldo">
                            Saldo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="motivo" id="estado_tarjeta"
                            value="Estado Tarjeta" required>
                        <label class="form-check-label" for="estado_tarjeta">
                            Estado Tarjeta
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="motivo" id="otra" value="Otra"
                            required>
                        <label class="form-check-label" for="otra">
                            Otra
                        </label>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="consulta">Especifique Su Consulta y/o Sugerencia *</label>
                <textarea class="form-control" id="consulta" name="consulta" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

@endsection
