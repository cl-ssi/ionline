@extends('layouts.app')

@section('title', 'Nuevo Staff')

@section('content')
<h3 class="mb-3">Nuevo Staff</h3>


<form method="POST" class="form-horizontal" action="">
    @csrf
    @method('POST')

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_name">Nombre Completo</label>
            <input type="text" class="form-control" name="name"
                id="for_name" readonly value="desde clave única">
        </fieldset>
        <fieldset class="form-group col">
            <label for="for_email">Correo Electrónico</label>
            <input type="text" class="form-control" name="email"
                id="for_email" required value="desde clave única">
        </fieldset>
        <fieldset class="form-group col">
            <label for="for_telephone">Teléfono</label>
            <input type="text" class="form-control" name="telephone"
                id="for_telephone" required placeholder="">
        </fieldset>


    </div>
    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_title">Título</label>
            <input type="text" class="form-control" name="title"
                id="for_title" required >
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_capacitation">Capacitaciones</label>
            <input type="text" class="form-control" name="capacitation"
                id="for_capacitation" required placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_reference">Referencia Laboral</label>
            <input type="text" class="form-control" name="reference"
                id="for_reference" required placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_commune_id">Comuna</label>
            <select name="commune_id" id="for_commune_id" class="form-control">
                <option value="">Iquique</option>
                <option value="">Colchane</option>
            </select>
        </fieldset>


    </div>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_profession">Profesión</label>
            <select name="profession" id="for_profession" class="form-control">
                <option value="Enfermera">Enfermera</option>
                <option value="">Informática</option>
            </select>
        </fieldset>

    </div>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_experiencias_anteriores">Esperiencias Anteriores (2*)</label>
            <input type="text" class="form-control" name="experiencias_anteriores"
                id="for_experiencias_anteriores" required placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_funciones_realizada">Funciones Realizadas</label>
            <input type="text" class="form-control" name="funciones_realizada"
                id="for_funciones_realizada" required placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_etamento">Estamento * (revisar si va o no)</label>
            <select name="etamento" id="for_etamento" class="form-control">
                <option value="">Médico</option>
                <option value="">Profesional</option>
                <option value="">Tecnico</option>
                <option value="">Administrativo</option>
                <option value="">Auxilaires</option>
            </select>
        </fieldset>


    </div>


    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
