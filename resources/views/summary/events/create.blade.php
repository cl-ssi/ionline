@extends('layouts.app')
@section('title', 'Módulo de Sumario - Crear Tipo de Eventos')
@section('content')
    @include('summary.nav')
    <h3>Crear Tipo de Eventos</h3>
    <form method="POST" class="form-horizontal" action="{{ route('summary.events.store') }}">
        @csrf
        @method('POST')
        <div class="form-row mb-3">
            <div class="col-12 col-md-4">
                <label for="for-name">Nombre*</label>
                <input type="text" class="form-control" name="name" autocomplete="off" required>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-duration">Duración</label>
                <input type="number" class="form-control" min="0" name="duration">
            </div>

            <div class="col-12 col-md-3">
                <label for="for-user">Usuario</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="require_user" value="1">
                </div>
            </div>

            <div class="col-12 col-md-3">
                <label for="for-file">Archivo</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="require_file" value="1">
                </div>
            </div>
        </div>

        <div class="form-row mb-3">
            <div class="col-12 col-md-2">
                <label for="for-file">Inicio</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="start" value="1">
                </div>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-file">Fin</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="end" value="1">
                </div>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-file">Investigador</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="investigator" value="1">
                </div>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-file">Actuario</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="actuary" value="1">
                </div>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-file">Repetición</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="repeat" value="1" id="repeat-checkbox">
                </div>
            </div>

            

            <div class="col-12 col-md-2">
                <label for="for-name">Num. Repet.</label>
                <input type="number" class="form-control" name="num_repeat" autocomplete="off" disabled>
            </div>
        </div>

        <br>
        <hr>

        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('summary.events.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>
    </form>
@endsection


@section('custom_js')
<script>
    $(document).ready(function() {
        var repeatCheckbox = $('#repeat-checkbox');
        var numRepeatInput = $('input[name="num_repeat"]');

        // Desactivar o activar el campo "Num Repet" según el estado del checkbox de repetición
        repeatCheckbox.on('change', function() {
            if ($(this).is(':checked')) {
                numRepeatInput.prop('disabled', false);
                numRepeatInput.prop('required', true);
            } else {
                numRepeatInput.prop('disabled', true);
                numRepeatInput.prop('required', false);
            }
        });
    });
</script>
@endsection
