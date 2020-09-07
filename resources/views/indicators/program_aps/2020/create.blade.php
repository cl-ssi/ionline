@extends('layouts.app')

@section('title', 'Nuevo Valor en Programación')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Nuevo Valor en Programación</h3>


<form method="POST" class="form-horizontal" action="{{ route('indicators.program_aps.2020.store') }}">
    @csrf
    @method('POST')

    <div class="row">
        <fieldset class="form-group col-3">
            <label for="for_periodo">Periodo*</label>
            <select name="periodo" id="for_periodo" class="form-control">
                <option value="2020">2020</option>
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_program_aps_glosa_id">Prestación*</label>
            <select name="program_aps_glosa_id" id="for_program_aps_glosa_id" class="form-control">
                @foreach($glosas as $glosa)
                    <option value="{{ $glosa->id }}">{{ $glosa->numero }} - {{ $glosa->prestacion }}</option>
                @endforeach
            </select>
        </fieldset>

    </div>

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_commune_id">Comuna*</label>
            <select name="commune_id" id="for_commune_id" class="form-control">
                @foreach($communes as $commune)
                    <option value="{{ $commune->id }}">{{ $commune->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_establishment_id">Establecimiento</label>
            <select name="establishment_id" id="for_establishment_id" class="form-control">
                <option value=""></option>
                @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_cobertura">Cobertura*</label>
            <div class="input-group">
                <input type="text" class="form-control" id="for_cobertura" name="cobertura" required>
                <div class="input-group-append">
                    <span class="input-group-text" id="inputGroupPrepend">%</span>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_concentracion">Concentración*</label>
            <input type="text" class="form-control" id="for_concentracion" name="concentracion" required>
        </fieldset>

    </div>
    <div class="row">

        <fieldset class="form-group col">
            <label for="for_actividadesProgramadas">Actividades Programadas</label>
            <input type="text" class="form-control" id="for_actividadesProgramadas" placeholder="(opcional)" name="actividadesProgramadas" >
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_observadoAnterior">Observado Anterior</label>
            <input type="text" class="form-control" id="for_observadoAnterior" name="observadoAnterior">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_rendimientoProfesional">Rendimiento Profesional</label>
            <input type="text" class="form-control" id="for_rendimientoProfesional" name="rendimientoProfesional">
        </fieldset>

    </div>
    <div class="row">

        <fieldset class="form-group col">
            <label for="for_observaciones">Observaciones</label>
            <input type="text" class="form-control" id="for_observaciones" name="observaciones">
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary">Crear</button>
    <a class="btn btn-outline-secondary ml-3" href="{{ route('indicators.program_aps.2020.index') }}">Cancelar</a>


</form>


@endsection

@section('custom_js')

@endsection
