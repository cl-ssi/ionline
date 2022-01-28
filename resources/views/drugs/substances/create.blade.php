@extends('layouts.app')

@section('title', 'Sustancias')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Agregar Sustancias</h3>

<form method="POST" class="form-horizontal" action="{{ route('drugs.substances.store') }}">
    {{ csrf_field() }} <!-- input hidden contra ataques CSRF -->

    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="for_presumend"
                name="presumed" aria-describedby="presumend_help">
            <label class="form-check-label" for="for_presumend">Sustancia Presunta</label>
            <small id="presumend_help" class="form-text text-muted">
                La sustancia presunta se utiliza en una recepción,
                de lo contrario es una sustancia determinada por el resultado de
                un laboratorio.</small>
        </div>
    </div>

    <fieldset class="form-group">
        <label for="forname">Nombre*</label>
        <input type="text" class="form-control" id="forname"
        placeholder="Ingrese el nombre de la sustancia" name="name" required="">
    </fieldset>

    <fieldset class="form-group">
        <label for="forcategory">Rama*</label>
        <select class="form-control" id="forrama" name="rama"  required="">
            <option disabled selected value></option>
            <option value="Alucinógenos">Alucinógenos</option>
            <option value="Estimulantes">Estimulantes</option>
            <option value="Depresores">Depresores</option>
        </select>
    </fieldset>

    <fieldset class="form-group">
        <label for="forunit">Unidad*</label>
        <select class="form-control" id="forunit" name="unit" required="">
            <option disabled selected value></option>
            <option value="Ampollas">Ampollas</option>
            <option value="Gramos">Gramos</option>
            <option value="Mililitros">Mililitros</option>
            <option value="Unidades">Unidades</option>
        </select>
    </fieldset>

    <fieldset class="form-group">
        <label for="forlaboratory">Laboratorio</label>
        <select class="form-control" id="forlaboratory" name="laboratory">
            <option></option>
            <option value="SEREMI">SEREMI</option>
            <option value="ISP">ISP</option>
        </select>
    </fieldset>

    <!--
    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="forisp" name="isp" value="1">
            <label class="form-check-label" for="forisp">ISP</label>
        </div>
    </div>
    -->

    <div class="float-right">
        <a href="{{ route('drugs.substances.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Crear</button>
    </div>

</form>


@endsection

@section('custom_js')

@endsection
