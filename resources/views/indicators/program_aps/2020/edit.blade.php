@extends('layouts.app')

@section('title', 'Nuevo Valor en Programación')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Editar Valor en Programación 2020</h3>


<form method="POST" class="form-horizontal" action="{{ route('indicators.program_aps.2020.update', $programApsValue->id) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <fieldset class="form-group col-3">
            <label for="for_periodo">Periodo*</label>
            <input type="text" class="form-control" id="for_periodo"
            name="periodo" value="{{ $programApsValue->periodo }}" readonly>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_program_aps_glosa_id">Prestación*</label>
            <select name="program_aps_glosa_id" id="for_program_aps_glosa_id" class="form-control" disabled>
                @foreach($glosas as $glosa)
                    <option value="{{ $glosa->id }}"
                        {{  $programApsValue->program_aps_glosa_id == $glosa->id ? "selected":"" }}>
                        {{ $glosa->id }} - {{ $glosa->prestacion }}
                    </option>
                @endforeach
            </select>
        </fieldset>

    </div>

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_commune_id">Comuna*</label>
            <select name="commune_id" id="for_commune_id" class="form-control" disabled>
                @foreach($communes as $commune)
                    <option value="{{ $commune->id }}"
                        {{ $programApsValue->commune_id == $commune->id ? "selected":"" }}>
                        {{ $commune->name }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_establishment_id">Establecimiento</label>
            <select name="establishment_id" id="for_establishment_id"
            class="form-control" disabled>
                <option value=""></option>
                @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}"
                        {{ $programApsValue->establishment_id == $establishment->id ? "selected":"" }}>
                        {{ $establishment->name }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_cobertura">Cobertura*</label>
            <div class="input-group">
                <input type="text" class="form-control" id="for_cobertura"
                name="cobertura" value="{{ $programApsValue->cobertura }}" required>
                <div class="input-group-append">
                    <span class="input-group-text" id="inputGroupPrepend">%</span>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_concentracion">Concentración*</label>
            <input type="text" class="form-control" id="for_concentracion"
            name="concentracion" value="{{ $programApsValue->concentracion }}" required>
        </fieldset>

    </div>
    <div class="row">

        <fieldset class="form-group col">
            <label for="for_actividadesProgramadas">Actividades Programadas</label>
            <input type="text" class="form-control" id="for_actividadesProgramadas"
            value="{{ $programApsValue->actividadesProgramadas }}"
            placeholder="(opcional)" name="actividadesProgramadas">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_observadoAnterior">Observado Anterior</label>
            <input type="text" class="form-control" id="for_observadoAnterior"
            name="observadoAnterior" value="{{ $programApsValue->observadoAnterior }}">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_rendimientoProfesional">Rendimiento Profesional</label>
            <input type="text" class="form-control" id="for_rendimientoProfesional"
            name="rendimientoProfesional" value="{{ $programApsValue->rendimientoProfesional }}">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_poblacion">Población (Reemplaza Percapita)</label>
            <input type="text" class="form-control" id="for_poblacion"
            name="poblacion" value="{{ $programApsValue->poblacion }}">
            <small class="form-text text-muted">
                {{ $glosas->find($programApsValue->program_aps_glosa_id)->poblacion }}
            </small>
        </fieldset>

    </div>
    <div class="row">

        <fieldset class="form-group col">
            <label for="for_observaciones">Observaciones</label>
            <input type="text" class="form-control" id="for_observaciones"
            name="observaciones" value="{{ $programApsValue->observaciones }}">
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a class="btn btn-outline-secondary ml-3" href="{{ route('indicators.program_aps.2020.index', $commune->id) }}">Cancelar</a>


</form>


@endsection

@section('custom_js')

@endsection
