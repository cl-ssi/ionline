@extends('layouts.app')

@section('title', 'Nuevo Staff')

@section('content')

@include('replacement_staff.nav')

<h3 class="mb-3">Nuevo Staff</h3>


<form method="POST" class="form-horizontal" action="">
    @csrf
    @method('POST')

    <div class="form-row">
            <legend>ANTECEDENTES PERSONALES:</legend>
            <fieldset class="form-group col">
                <label for="for_name">RUT</label>
                <input type="text" class="form-control" name="name" id="for_name" readonly value="desde clave única">
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_name">Nombre Completo</label>
                <input type="text" class="form-control" name="name" id="for_name" readonly value="desde clave única">
            </fieldset>
            <fieldset class="form-group col">
                <label for="for_email">Correo Electrónico</label>
                <input type="text" class="form-control" name="email" id="for_email" required value="desde clave única">
            </fieldset>
            <fieldset class="form-group col">
                <label for="for_telephone">Teléfono</label>
                <input type="text" class="form-control" name="telephone" id="for_telephone" required placeholder="">
            </fieldset>



    </div>
    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_title">Título</label>
            <input type="text" class="form-control" name="title" id="for_title" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_commune_id">Comuna</label>
            <select name="commune_id" id="for_commune_id" class="form-control">
                <option value="">Iquique</option>
                <option value="">Colchane</option>
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_reference">Dirección</label>
            <input type="text" class="form-control" name="direccion" id="for_direccion" required placeholder="">
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

        <fieldset class="form-group col">
            <label for="for_profession">Adjuntar Título Profesional*</label>
            <input type="file" class="form-control" name="direccion" id="for_direccion" required placeholder="">
        </fieldset>
    </div>



    <hr>
    <legend>EXPERIENCIA:<i class="fas fa-plus"></i></legend>
    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_experiencias_anteriores">Experiencias Anteriores (2*)</label>
            <input type="text" class="form-control" name="experiencias_anteriores" id="for_experiencias_anteriores" required placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_funciones_realizada">Funciones Realizadas</label>
            <input type="text" class="form-control" name="funciones_realizada" id="for_funciones_realizada" required placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_funciones_realizada">Referencia</label>
            <input type="text" class="form-control" name="referencia" id="for_funciones_realizada" required placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_profession">Certificado de Experiencia Laboral</label>
            <input type="file" class="form-control" name="direccion" id="for_direccion" required placeholder="">
        </fieldset>
    </div>

    <hr>
    <legend>PERFECCIONAMIENTO/CAPACITACIONES: <i class="fas fa-plus"></i></legend>
    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_experiencias_anteriores">Nombre Capacitación</label>
            <input type="text" class="form-control" name="experiencias_anteriores" id="for_experiencias_anteriores" required placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_funciones_realizada">Número de horas</label>
            <input type="text" class="form-control" name="funciones_realizada" id="for_funciones_realizada" required placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_funciones_realizada">Certificado</label>
            <input type="file" class="form-control"  placeholder="">
        </fieldset>
    </div>
    <hr>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_experiencias_anteriores">Otra Observación</label>
            <textarea class="form-control"></textarea>            
        </fieldset>        
    </div>

    <fieldset class="form-group col">
            <label for="for_etamento">Idioma</label>
            <select name="etamento" id="for_etamento" class="form-control">
                <option value=""></option>
                <option value="">Inglés</option>
                <option value="">Frances</option>
                <option value="">Aleman</option>                
            </select>
        </fieldset>



    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
