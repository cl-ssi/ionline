@extends('layouts.bt4.app')

@section('title', 'Crear nuevo Permisos')

@section('content')

<h3 class="mb-3">Crear Nueva Profesión</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.professions.store') }}">
    @csrf
    @method('POST')

    <div class="form-row">

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name" name="name"required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_category">Categoría*</label>
            <select class="form-control" name="category" id="for_category" required>
                <option value=""></option>
                <option value="A">A (Medicos, Odontologos, Quimicos)</option>
                <option value="B">B (Profesionales)</option>
                <option value="C">C (Técnicos Nivel Superior)</option>
                <option value="D">D (Técnicos Nivel Medio)</option>
                <option value="E">E (Administrativos)</option>
                <option value="F">F (Auxiliares, Choferes)</option>
            </select>
        </fieldset>


        <fieldset class="form-group col-12 col-md-4">
            <label for="for_estamento">Estamento*</label>
            <select name="estamento" class="form-control" id="for_estamento" required>
                <option value=""></option>
                <option value="Ley 19.664">Ley 19.664 Médico/Farmacéutico/Odontólogo</option>
                <option value="Profesional">Profesional</option>
                <option value="Técnico">Técnico</option>
                <option value="Administrativo">Administrativo</option>
                <option value="Auxiliar">Auxiliar</option>
            </select>
        </fieldset>

    </div>

    <div class="form-row">

        <fieldset class="form-group col-12 col-md-6">
            <label for="for_name">Planta (SIRH)*</label>
            <input type="number" class="form-control" id="for_sirh_plant" name="sirh_plant"required>
        </fieldset>

        <!-- <fieldset class="form-group col-12 col-md-4">
            <label for="for_name">Función (SIRH)*</label>
            <input type="text" class="form-control" id="for_sirh_function" name="sirh_function"required>
        </fieldset> -->

        <fieldset class="form-group col-12 col-md-6">
            <label for="for_name">Profesión (SIRH)*</label>
            <input type="number" class="form-control" id="for_sirh_profession" name="sirh_profession"required>
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.professions.index') }}">Volver</a>


</form>

@endsection

@section('custom_js')

@endsection
