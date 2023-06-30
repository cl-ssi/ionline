@extends('layouts.app')

@section('title', 'Módulo de Sumario - Editar Tipo Evento')

@section('content')

    @include('summary.nav')

    <h3 class="mb-3">Editar Tipo Evento</h3>

    <form method="POST" action="{{ route('summary.event-types.update', $eventType) }}">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <label for="for-name" class="col-sm-2 col-form-label">Nombre*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{ $eventType->name }}" autocomplete="off"
                    required>
            </div>
        </div>

        <div class="form-group row">
            <label for="for-description" class="col-sm-2 col-form-label">Descripción</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="description">{{ $eventType->description }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="for-duration" class="col-sm-2 col-form-label">Duración</label>
            <div class="col-sm-2">
                <input type="number" class="form-control" min="0" name="duration"
                    value="{{ $eventType->duration }}">
            </div>
            <label class="col-sm-2 col-form-label">días</label>
        </div>

        <div class="form-group row">
            <legend class="col-form-label col-sm-2">Se repite</legend>
            <div class="col-sm-1">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="repeat" id="for-repeat" value="1"
                        {{ $eventType->repeat ? 'checked' : '' }}>
                    <label class="form-check-label" for="for-repeat">
                        Si
                    </label>
                </div>
            </div>

            <label for="for-num_repeat" class="col-sm-3 col-form-label">Número de repeticiones:</label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="num_repeat" id="num-repeat-input" autocomplete="off"
                    value="{{ $eventType->num_repeat ?? '' }}" {{ $eventType->repeat ? '' : 'disabled' }}>
            </div>

        </div>

        <fieldset class="form-group row">
            <legend class="col-form-label col-sm-2 float-sm-left pt-0">Opciones</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="require_user" id="for-require_user" value="1"
                        {{ $eventType->require_user ? 'checked' : '' }}>
                    <label class="form-check-label" for="for-require_user">
                        Requiere asignar un usuario
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="require_file" id="for-require_file" value="1"
                        {{ $eventType->require_file ? 'checked' : '' }}>
                    <label class="form-check-label" for="for-require_file">
                        Requiere adjuntar uno o más archivos
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="start" id="for-start" value="1"
                        {{ $eventType->start ? 'checked' : '' }}>
                    <label class="form-check-label" for="for-start">
                        Es el primer evento de un sumario
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="end" id="for-end" value="1"
                        {{ $eventType->end ? 'checked' : '' }}>
                    <label class="form-check-label" for="for-end">
                        Es el último evento de un sumario
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="investigator" id="for-investigator" value="1"
                        {{ $eventType->investigator ? 'checked' : '' }}>
                    <label class="form-check-label" for="for-investigator">
                        Este evento asigna al fiscal del sumario
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="actuary" id="for-actuary" value="1"
                        {{ $eventType->actuary ? 'checked' : '' }}>
                    <label class="form-check-label" for="for-actuary">
                        Este evento asigna al actuario del sumario
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sub_event" id="for-sub_event" value="1"
                        {{ $eventType->sub_event ? 'checked' : '' }}>
                    <label class="form-check-label" for="for-sub_event">
                        Este evento corresponde a un subevento
                    </label>
                </div>
            </div>
        </fieldset>

        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th class="align-top">Eventos Anteriores</th>
                        <th class="bg-light align-top">Evento Actual</th>
                        <th>Eventos Posteriores <br>
                            <small>Al terminar este evento, se vincúla con el/los siguientes eventos</small>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="align-middle">
                            <ul>
                                @foreach ($eventType->linksBefore as $linkBefore)
                                    <li>{{ $linkBefore->beforeEvent->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="bg-light align-middle">
                            <ul>
                                <li>
                                    {{ $eventType->name }}
                                </li>
                            </ul>
                        </td>
                        <td class="align-middle;">
                            @foreach ($eventTypes as $type)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$type->id}}"
                                        name="links[{{ $type->id }}]"
                                        {{ $eventType->links->contains('after_event_id', $type->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="for-links">
                                        {{ $type->name }}
                                    </label>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="form-group row mt-3">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-success mr-3">Actualizar</button>
                <a href="{{ route('summary.event-types.index') }}" class="btn btn-outline-secondary">Cancelar</a>
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
