@extends('layouts.app')

@section('title', 'Nuevo Colegio')

@section('content')

@include('suitability.nav')

<h3 class="mb-3">Nuevo Colegio</h3>

<form method="POST" class="form-horizontal" action="{{ route('suitability.schools.store') }}">
    @csrf
    @method('POST')

    <div class="form-row align-items-end">
        <fieldset class="form-group col-6 col-sm-6 col-md-6 col-lg-6">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name" name="name" autocomplete="off" required>
        </fieldset>

        <fieldset class="form-group col-2 col-sm-2 col-md-1 col-lg-1">
            <label for="for_rbd">RBD*</label>
            <input type="text" class="form-control" id="for_rbd" name="rbd" autocomplete="off" required>
        </fieldset>
    </div>

    <div class="row">
    <fieldset class="form-group col-8 col-sm-8 col-md-8 col-lg-8">
            <label for="for_holder">Dirección*</label>
            <input type="text" class="form-control" id="for_address" name="address" autocomplete="off" required>
        </fieldset>
    </div>

    <div class="row">

    <fieldset class="form-group col-8 col-sm-8 col-md-8 col-lg-8">
            <label for="for_holder">Nombre Sostenedor*</label>
            <input type="text" class="form-control" id="for_holder" name="holder" autocomplete="off" required>
        </fieldset>

    </div>



    <div class="row">
        <fieldset class="form-group col-4">
            <label for="for_commune_id">Comuna*</label>
            <select name="commune_id" id="for_commune_id" class="form-control" required>
                <option value="">Seleccionar Comuna</option>
                @foreach($communes as $commune)
                <option value="{{ $commune->id }}">{{ $commune->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-4">
            <label>Situación Legal*</label>
            <select class="form-control" name="legal" required>
            <option value="">Seleccionar Situación</option>
            <option value="PARTICULAR SUBVENCIONADO">PARTICULAR SUBVENCIONADO</option>
            <option value="PARTICULAR NO SUBVENCIONADO">PARTICULAR NO SUBVENCIONADO</option>
            <option value="MUNICIPAL DAEM">MUNICIPAL DAEM</option>
            <option value="MUNICIPAL CORPORACION">MUNICIPAL CORPORACION</option>
            <option value="ADMINISTRACION DELEGADA">ADMINISTRACION DELEGADA</option>
            </select>
        </fieldset>
    </div>

        <label for="forBrand">Municipal*</label>
        <fieldset class="form-group col-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="municipality" id="RadioType1" value="1" required>
                <label class="form-check-label" for="inlineRadio1">Sí</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="municipality" id="RadioType2" value="0" required>
                <label class="form-check-label" for="inlineRadio2">No</label>
            </div>
        </fieldset>

        <label for="forBrand">Gratuito*</label>
        <fieldset class="form-group col-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="free" id="RadioType1" value="1" required>
                <label class="form-check-label" for="inlineRadio1">Sí</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="free" id="RadioType2" value="0" required>
                <label class="form-check-label" for="inlineRadio2">No</label>
            </div>
        </fieldset>
    


    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection