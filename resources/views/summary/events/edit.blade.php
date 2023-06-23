@extends('layouts.app')
@section('title', 'Módulo de Sumario - Editar Tipo Evento')
@section('content')
    @include('summary.nav')
    <h3>Editar Tipo Evento</h3>
    <form method="POST" class="form-horizontal" action="{{ route('summary.events.update', $event) }}">
        @csrf
        @method('PUT')
        <div class="form-row mb-3">
            <div class="col-12 col-md-4">
                <label for="for-name">Nombre*</label>
                <input type="text" class="form-control" name="name" value="{{ $event->name }}" autocomplete="off"
                    required>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-duration">Duración</label>
                <input type="number" class="form-control" min="0" name="duration" value="{{ $event->duration }}">
            </div>

            <div class="col-12 col-md-3">
                <label for="for-user">Usuario</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="require_user" value="1"
                        {{ $event->require_user ? 'checked' : '' }}>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <label for="for-file">Archivo</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="require_file" value="1"
                        {{ $event->require_file ? 'checked' : '' }}>
                </div>
            </div>
        </div>

        <div class="form-row mb-3">
            <div class="col-12 col-md-2">
                <label for="for-file">Inicio</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="start" value="1"
                        {{ $event->start ? 'checked' : '' }}>
                </div>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-file">Fin</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="end" value="1"
                        {{ $event->end ? 'checked' : '' }}>
                </div>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-file">Investigador</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="investigator" value="1"
                        {{ $event->investigator ? 'checked' : '' }}>
                </div>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-file">Actuario</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="actuary" value="1"
                        {{ $event->actuary ? 'checked' : '' }}>
                </div>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-file">Repetición</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="repeat" value="1"
                        {{ $event->repeat ? 'checked' : '' }}>
                </div>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-name">Num Repet</label>
                <input type="number" class="form-control" name="num_repeat" id="num-repeat-input" autocomplete="off"
                    value="{{ $event->num_repeat ?? '' }}" {{ $event->repeat ? '' : 'disabled' }}>

            </div>


        </div>


        <br>
        <hr>
        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('summary.events.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>
    </form>
@endsection



@section('custom_js')
    <script>
        $(document).ready(function() {
            var repeatCheckbox = $('[name="repeat"]');
            var numRepeatInput = $('#num-repeat-input');

            // Habilitar o deshabilitar el campo "Num Repet" según el estado del checkbox de repetición
            function toggleNumRepeatInput() {
                if (repeatCheckbox.is(':checked')) {
                    numRepeatInput.prop('disabled', false);
                    numRepeatInput.prop('required', true);
                } else {
                    numRepeatInput.prop('disabled', true);
                    numRepeatInput.prop('required', false);
                }
            }

            // Llamar a la función inicialmente para configurar el estado del campo "Num Repet"
            toggleNumRepeatInput();

            // Agregar un evento de escucha al cambio del checkbox de repetición
            repeatCheckbox.on('change', function() {
                toggleNumRepeatInput();
            });
        });
    </script>
@endsection
