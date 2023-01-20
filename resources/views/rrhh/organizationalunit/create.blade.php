@extends('layouts.app')

@section('title', 'Crear Unidad Organizacional')

@section('content')

<h3>Crear nueva unidad organizacional</h3>

<form method="POST" class="form-horizontal" action="{{ route('rrhh.organizational-units.store') }}">
    {{ csrf_field() }}

    <div class="form-row">
        <fieldset class="form-group col-12">
            <label for="forName">Nombre</label>
            <input type="text" class="form-control" id="forName"
                placeholder="Nombre de la unidad organizacional" name="name" required="required">
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12">
            <label for="forFather">Depende de</label>
            @livewire('select-organizational-unit', [
                'establishment_id' => auth()->user()->organizationalUnit->establishment->id,
            ])
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-4">
            <label for="forName">Id Función (SIRH)</label>
            <input type="number" class="form-control" id="forsirh_function"
                placeholder="Código SIRH de la función" name="sirh_function">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="forName">Id Unid.Org. (SIRH)</label>
            <input type="number" class="form-control" id="forsirh_ou_id"
                placeholder="Código SIRH de la unidad organizacional" name="sirh_ou_id">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="forName">C.Costos (SIRH)</label>
            <input type="number" class="form-control" id="forsirh_cost_center"
                placeholder="Código SIRH de la unidad organizacional" name="sirh_cost_center">
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Crear</button>

    <a href="{{ route('rrhh.organizational-units.index') }}" class="btn btn-outline-dark">Cancelar</a>

</form>

@endsection
