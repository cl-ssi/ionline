@extends('layouts.app')

@section('title', 'Crear nuevo Permisos')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Crear Nueva Profesión</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.professions.store') }}">
    @csrf
    @method('POST')

    <div class="row">

    <fieldset class="form-group col-12 col-md-3">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name" name="name"required>
        </fieldset>        

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_category">Categoría</label>
            <select class="form-control" name="category" id="for_category" require>
                <option value=""></option>
                <option value="A">A (Medicos, Odontologos, Quimicos)</option>
                <option value="B">B (Profesionales)</option>
                <option value="C">C (Técnicos Nivel Superior)</option>
                <option value="D">D (Técnicos Paramédicos)</option>
                <option value="E">E (Administrativos)</option>
                <option value="F">F (Choferes)</option>
            </select>
        </fieldset>
    </div>
    

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
