@extends('layouts.bt5.app')

@section('title', 'Módulo de Sumario - Crear Tipo de Eventos')

@section('content')

    @include('summary.nav')
    <h3 class="mb-3">Crear Tipo Evento</h3>
    <form method="POST" class="form-horizontal" action="{{ route('summary.event-types.store') }}">
        @csrf
        @method('POST')
        <div class="form-group row mb-3">
            <label for="for-name" class="col-sm-2 col-form-label">Tipo*</label>
            <div class="col-sm-5">
                <select class="form-select" name="summary_type_id" required>
                    <option value=""></option>
                    @foreach($summaryTypes as $typeId => $typeName)
                        <option value="{{ $typeId }}">{{ $typeName }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="for-name" class="col-sm-2 col-form-label">Nombre*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" autocomplete="off" required>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="for-name" class="col-sm-2 col-form-label">Tipo Actor*</label>
            <div class="col-sm-10">
                <select class="form-select" name="summary_actor_id" required>
                    <option value=""></option>
                    @foreach($summaryActors as $actorId => $actorName)
                        <option value="{{ $actorId }}">{{ $actorName }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="for-description" class="col-sm-2 col-form-label">Descripción</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="description"></textarea>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="for-duration" class="col-sm-2 col-form-label">Duración</label>
            <div class="col-sm-2">
                <input type="number" class="form-control" min="0" name="duration">
            </div>

            <label class="col-sm-2 col-form-label">días</label>
        </div>


        <div class="form-group row mb-3">
            <legend class="col-form-label col-sm-2">Se repite</legend>
            <div class="col-sm-1">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="repeat" id="for-repeat" value="1">
                    <label class="form-check-label" for="for-repeat">
                        Si
                    </label>
                </div>
            </div>

            <label for="for-num_repeat" class="col-sm-4 col-form-label">Número de repeticiones</label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="num_repeat" id="num-repeat-input" autocomplete="off" disabled>
            </div>
        </div>

        <fieldset class="form-group row mb-3">
            <legend class="col-form-label col-sm-2 float-sm-left pt-0">Opciones</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="start" id="for-start" value="1">
                    <label class="form-check-label" for="for-start">
                        <i class="fas fa-caret-right"></i>
                        Es el primer evento de un sumario
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="end" id="for-end" value="1">
                    <label class="form-check-label" for="for-end">
                        Es el último evento de un sumario <i class="fas fa-caret-left"></i>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="require_user" id="for-require_user"
                    value="1">
                    <label class="form-check-label" for="for-require_user">
                        Requiere asignar un usuario
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="investigator" id="for-investigator"
                    value="1">
                    <label class="form-check-label" for="for-investigator">
                        Este evento asigna al fiscal del sumario
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="actuary" id="for-actuary" value="1">
                    <label class="form-check-label" for="for-actuary">
                        Este evento asigna al actuario del sumario
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="require_file" id="for-require_file"
                    value="1">
                    <label class="form-check-label" for="for-require_file">
                        Requiere adjuntar uno o más archivos
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sub_event" id="for-sub_event" value="1">
                    <label class="form-check-label" for="for-sub_event">
                        Este evento corresponde a un subevento
                    </label>
                </div>
            </div>
        </fieldset>

        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-success mr-3">Guardar</button>
                <a href="{{ route('summary.event-types.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>

    </form>
@endsection


@section('custom_js')
    <script>
        $(document).ready(function() {
            var repeatCheckbox = $('#for-repeat');
            var numRepeatInput = $('input[name="num_repeat"]');

            // Desactivar o activar el campo "Num Repet" según el estado del checkbox de repetición
            repeatCheckbox.on('change', function() {
                if ($(this).is(':checked')) {
                    numRepeatInput.prop('disabled', false);
                } else {
                    numRepeatInput.prop('disabled', true);
                }
            });
        });
    </script>
@endsection
