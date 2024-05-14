@extends('layouts.bt4.app')

@section('title', 'Módulo de Sumario - Editar Tipo Evento')

@section('content')

    @include('summary.nav')

    <h3 class="mb-3">Editar Tipo Evento</h3>

    <form method="POST" action="{{ route('summary.event-types.update', $eventType) }}">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <label for="for-name" class="col-sm-2 col-form-label">Tipo*</label>
            <div class="col-sm-5">
                <select class="form-control" name="summary_type_id" disabled>
                    <option value="{{ $eventType->summary_type_id }}">{{ $eventType->summaryType->name }}</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="for-name" class="col-sm-2 col-form-label">Nombre*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{ $eventType->name }}" autocomplete="off"
                    required>
            </div>
        </div>

        <div class="form-group row">
            <label for="for-name" class="col-sm-2 col-form-label">Tipo Actor*</label>
            <div class="col-sm-10">
                <select class="form-control" name="summary_actor_id" required>
                    <option value=""></option>
                    @foreach($summaryActors as $actorId => $actorName)
                        <option {{ ($actorId == $eventType->summary_actor_id) ? 'selected' : ''}} value="{{ $actorId }}">{{ $actorName }}</option>
                    @endforeach
                </select>
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
                    <input class="form-check-input" type="checkbox" name="start" id="for-start" value="1"
                    {{ $eventType->start ? 'checked' : '' }}>
                    <label class="form-check-label" for="for-start">
                        <i class="fas fa-caret-right"></i>
                        Es el primer evento de un sumario
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="end" id="for-end" value="1"
                    {{ $eventType->end ? 'checked' : '' }}>
                    <label class="form-check-label" for="for-end">
                        Es el último evento de un sumario
                        <i class="fas fa-caret-left"></i>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="require_user" id="for-require_user" value="1"
                    {{ $eventType->require_user ? 'checked' : '' }}>
                    <label class="form-check-label" for="for-require_user">
                        Requiere asignar un usuario
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
                    <input class="form-check-input" type="checkbox" name="require_file" id="for-require_file" value="1"
                    {{ $eventType->require_file ? 'checked' : '' }}>
                    <label class="form-check-label" for="for-require_file">
                        Requiere adjuntar uno o más archivos
                    </label>
                </div>
            </div>
        </fieldset>

        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th class="align-top" rowspan="2">
                            Eventos Anteriores
                        </th>
                        <th class="bg-light align-top">
                            Evento Actual
                        </th>
                        <th rowspan="2">
                            Eventos Posteriores <br>
                            <small>Al terminar este evento, se vincúla con el/los siguientes eventos</small>
                        </th>
                    </tr>
                    <tr>
                        <td class="bg-light text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sub_event" id="for-sub_event" value="1"
                                    {{ $eventType->sub_event ? 'checked' : '' }}>
                                <label class="form-check-label" for="for-sub_event">
                                    Es un subevento
                                </label>
                            </div>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="align-middle">
                            <ul>
                                @foreach ($eventType->linksBefore as $linkBefore)
                                    <li>
                                        @if($linkBefore->beforeEvent->start)
                                            <i class="fas fa-caret-right"></i>
                                        @endif

                                        <a href="{{ route('summary.event-types.edit', $linkBefore->beforeEvent) }}">
                                            @if($linkBefore->beforeEvent->sub_event) &nbsp;&nbsp; @endif
                                            [{{ optional($linkBefore->beforeEvent->actor)->name }}] 
                                            {{ $linkBefore->beforeEvent->name }}
                                        </a>

                                        @if($linkBefore->beforeEvent->end)
                                            <i class="fas fa-caret-left"></i>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="bg-light align-middle text-center">
                            <h4>
                                {{ $eventType->name }}
                            </h4>
                            [{{ $eventType->actor->name }}]
                        </td>
                        <td class="align-middle;">
                            @foreach ($eventTypes as $type)
                                @if($type->id != $eventType->id)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $type->id }}"
                                        name="links[{{ $type->id }}]"
                                        {{ $eventType->linksAfter->contains('after_event_id', $type->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="for-links">
                                        @if($type->start)
                                            <i class="fas fa-caret-right"></i>
                                        @endif

                                        <a href="{{ route('summary.event-types.edit', $type) }}">
                                            @if($type->sub_event) &nbsp;&nbsp; @endif
                                            [{{ optional($type->actor)->name }}] 
                                            {{ $type->name }}
                                        </a>

                                        @if($type->end)
                                            <i class="fas fa-caret-left"></i>
                                        @endif
                                    </label>
                                </div>
                                @else
                                &nbsp;&nbsp;&nbsp;
                                    [{{ optional($type->actor)->name }}] 
                                    {{ $type->name }}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="form-group row mt-3">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-success mr-3">Actualizar</button>
                <a href="{{ route('summary.event-types.index') }}" class="btn btn-outline-secondary">Volver</a>
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
                } else {
                    numRepeatInput.prop('disabled', true);
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
